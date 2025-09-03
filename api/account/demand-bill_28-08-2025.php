<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
include '../../sql/config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Only POST Method Allowed']);
        exit;
    }

    $input = $_POST;

    if (!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF Token']);
        exit;
    }

    $class = trim($input['class'] ?? '');
    $section = trim($input['section'] ?? '');
    $demand_month = trim($input['demand_month'] ?? '');

    if (empty($class) || empty($demand_month)) {
        echo json_encode(['success' => false, 'message' => 'Class or Demand Month missing']);
        exit;
    }

    $dateandtime = date('Y-m-d H:i:s');
    $status = 0;

    // Current session (e.g., 2025-26)
    $month = date('n');
    $year = date('Y');
    if ($month >= 4) {
        $current_session = $year . '-' . substr($year + 1, -2);
    } else {
        $current_session = ($year - 1) . '-' . substr($year, -2);
    }

    // Process common other fees if given
    $common_other_fees = [];
    $other_total = 0;
    if (isset($input['title'], $input['fees']) && is_array($input['title']) && is_array($input['fees'])) {
        $titles = $input['title'];
        $fees = $input['fees'];
        for ($i = 0; $i < count($titles); $i++) {
            $title = trim($titles[$i]);
            $fee = trim($fees[$i]);
            if ($title !== '' && is_numeric($fee)) {
                $common_other_fees[] = $title . ' ' . $fee;
                $other_total += floatval($fee);
            }
        }
    }

    // Fetch students
    if ($class == 'all' && $section != 'all') {
        $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE section = ? AND session = ?");
        $student_query->bind_param('ss', $section, $current_session);
    } elseif ($class != 'all' && ($section == 'all' || empty($section))) {
        $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE class = ? AND session = ?");
        $student_query->bind_param('ss', $class, $current_session);
    } elseif ($class == 'all' && ($section == 'all' || empty($section))) {
        $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE session = ?");
        $student_query->bind_param('s', $current_session);
    } elseif ($class != 'all' && $section != 'all') {
        $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE class = ? AND section = ? AND session = ?");
        $student_query->bind_param('sss', $class, $section, $current_session);
    }
    $student_query->execute();
    $students = $student_query->get_result();

    if ($students->num_rows === 0) {
        echo json_encode([
            'success' => false, 'message' => 'No students found for given criteria'
        ]);
        exit;
    }

    // Prepare queries
    $demand_check = $conn->prepare("SELECT id FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND session = ? AND month_year = ?");
    $last_demand_query = $conn->prepare("SELECT rest_dues, paid, advance_amount, total, tution_fee, transport_and_other_fee 
        FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND session = ? ORDER BY id DESC LIMIT 1");
    $fee_query = $conn->prepare("SELECT tution_fee, transport_and_other_fee, back_dues 
        FROM tbl_fees WHERE reg_no = ? AND student_id = ? AND session = ? AND month_year = ? LIMIT 1");
    $demand_insert = $conn->prepare("INSERT INTO tbl_demand 
        (student_id, reg_no, session, tution_fee, transport_and_other_fee, back_dues, other_fee, total, month_year, date_and_time, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $formatted_demand_month = date('F Y', strtotime($demand_month));
    $inserted = 0;
    $inserted_student_ids = [];

    while ($student = $students->fetch_assoc()) {
        $student_id = $student['id'];
        $reg_no = $student['reg_no'];

        // Reset fees_details for each student
        $fees_details = implode(', ', $common_other_fees);

        // Check if demand already exists
        $demand_check->bind_param('isss', $student_id, $reg_no, $current_session, $formatted_demand_month);
        $demand_check->execute();
        $check_result = $demand_check->get_result();
        if ($check_result->num_rows > 0) {
            $existing = $check_result->fetch_assoc();
            $inserted_student_ids[] = $student_id;
            continue; // Already generated
        }

        // Default values
        $tution_fee = 0;
        $transport_and_other_fee = 0;
        $back_dues = 0;

        // Step 1: Check if any previous demand exists
        $last_demand_query->bind_param('iss', $student_id, $reg_no, $current_session);
        $last_demand_query->execute();
        $last_result = $last_demand_query->get_result();

        if ($last_result->num_rows > 0) {
            // Not first time → continue with last demand values
            $last = $last_result->fetch_assoc();
            $tution_fee = floatval($last['tution_fee']);
            $transport_and_other_fee = floatval($last['transport_and_other_fee']);
            $back_dues = 0; // Only first time
            $rest_dues = floatval($last['rest_dues']);
            $paid = floatval($last['paid']);
            $advance_amount = floatval($last['advance_amount']);
            $last_total = floatval($last['total']);
        } else {
            // First demand → take from tbl_fees
            $fee_query->bind_param('siss', $reg_no, $student_id, $current_session, $formatted_demand_month);
            $fee_query->execute();
            $fee_result = $fee_query->get_result();

            if ($fee_result->num_rows === 0) {
                continue; // no fees defined → skip
            }
            $fee = $fee_result->fetch_assoc();
            $tution_fee = floatval($fee['tution_fee']);
            $transport_and_other_fee = floatval($fee['transport_and_other_fee']);
            $back_dues = floatval($fee['back_dues']);
            $rest_dues = 0;
            $paid = 0;
            $advance_amount = 0;
            $last_total = 0;
        }

        // Total calculation
        $total = $tution_fee + $transport_and_other_fee + $other_total + $back_dues;

        if ($last_result->num_rows > 0) {
            // If rest_dues positive
            if ($rest_dues > 0) {
                $total += $rest_dues;
                $fees_details .= ($fees_details ? ', ' : '') . 'Back Due ' . $rest_dues;
            } else if ($rest_dues == 0 && $paid == 0 && $last_total > 0) {
                $total += $last_total;
                $fees_details .= ($fees_details ? ', ' : '') . 'Back Due ' . $last_total;
            }

            // Adjust advance
            if ($advance_amount > 0 && $rest_dues < 0) {
                $adjust = min($advance_amount, abs($rest_dues));
                $total -= $adjust;
                $fees_details .= ($fees_details ? ', ' : '') . 'Advance Amount ' . $adjust;
            }
        }

        // Insert demand
        $demand_insert->bind_param(
            'issdddsissi',
            $student_id,
            $reg_no,
            $current_session,
            $tution_fee,
            $transport_and_other_fee,
            $back_dues,
            $fees_details,
            $total,
            $formatted_demand_month,
            $dateandtime,
            $status
        );

        if ($demand_insert->execute()) {
            $inserted++;
            $inserted_student_ids[] = $student_id;
        }
    }

    if ($inserted > 0 || count($inserted_student_ids) > 0) {
        echo json_encode([
            'success' => true,
            'message' => ($inserted > 0) 
            ? 'Demand Bill Generated Successfully' 
            : 'Demand Bill Already Exists. Ready for Print.',
            'redirect' => true,
            'class' => $class,
            'section' => $section,
            'month_year' => $formatted_demand_month,
            'student_ids' => $inserted_student_ids
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No students available for bill generation.',
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
