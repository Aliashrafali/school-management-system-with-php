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

    $month = date('n');
    $year = date('Y');
    $current_session = ($month >= 4)
        ? $year . '-' . substr($year + 1, -2)
        : ($year - 1) . '-' . substr($year, -2);

    $common_other_fees = [];
    $other_total = 0;
    if (isset($input['title'], $input['fees']) && is_array($input['title']) && is_array($input['fees'])) {
        for ($i = 0; $i < count($input['title']); $i++) {
            $title = trim($input['title'][$i]);
            $fee = trim($input['fees'][$i]);
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
    } else {
        $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE class = ? AND section = ? AND session = ?");
        $student_query->bind_param('sss', $class, $section, $current_session);
    }
    $student_query->execute();
    $students = $student_query->get_result();

    if ($students->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'No students found for given criteria']);
        exit;
    }

    // Prepare queries
    $demand_check = $conn->prepare("SELECT id FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND session = ? AND month_year = ?");
    $last_demand_query = $conn->prepare("SELECT rest_dues, paid, advance_amount, total, tution_fee, transport_and_other_fee FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND session = ? ORDER BY id DESC LIMIT 1");
    $fee_query = $conn->prepare("SELECT tution_fee, transport_and_other_fee, back_dues FROM tbl_fees WHERE reg_no = ? AND student_id = ? AND session = ? AND month_year = ? LIMIT 1");
    $admission_query = $conn->prepare("SELECT MIN(month_year) as admission_month FROM tbl_fees WHERE reg_no = ? AND student_id = ? AND session = ?");
    $demand_insert = $conn->prepare("INSERT INTO tbl_demand (student_id, reg_no, session, tution_fee, transport_and_other_fee, back_dues, other_fee, total, month_year, date_and_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $formatted_demand_month = date('F Y', strtotime($demand_month));
    $inserted = 0;
    $inserted_student_ids = [];

    while ($student = $students->fetch_assoc()) {
        $student_id = $student['id'];
        $reg_no = $student['reg_no'];
        $fees_details = implode(', ', $common_other_fees);

        // Check if demand already exists
        $demand_check->bind_param('isss', $student_id, $reg_no, $current_session, $formatted_demand_month);
        $demand_check->execute();
        $check_result = $demand_check->get_result();
        if ($check_result->num_rows > 0) {
            $inserted_student_ids[] = $student_id;
            continue;
        }

        // Check admission month
        $admission_query->bind_param('sis', $reg_no, $student_id, $current_session);
        $admission_query->execute();
        $admission_result = $admission_query->get_result();
        if ($admission_result->num_rows === 0) continue;

        $admission_row = $admission_result->fetch_assoc();
        $admission_month = strtotime($admission_row['admission_month']);
        $selected_month = strtotime($demand_month);
        if ($selected_month < $admission_month) continue;

        // Calculate missed months
        $missed_total = 0;
        $current = $admission_month;
        while ($current < $selected_month) {
            $month_year = date('F Y', $current);
            $fee_query->bind_param('siss', $reg_no, $student_id, $current_session, $month_year);
            $fee_query->execute();
            $fee_result = $fee_query->get_result();
            if ($fee_result->num_rows > 0) {
                $fee = $fee_result->fetch_assoc();
                $month_fee = floatval($fee['tution_fee']) + floatval($fee['transport_and_other_fee']) + floatval($fee['back_dues']);
                $missed_total += $month_fee;
            }
            $current = strtotime("+1 month", $current);
        }

        // Current month fee
        $fee_query->bind_param('siss', $reg_no, $student_id, $current_session, $formatted_demand_month);
        $fee_query->execute();
        $fee_result = $fee_query->get_result();
        if ($fee_result->num_rows === 0) continue;

        $fee = $fee_result->fetch_assoc();
        $tution_fee = floatval($fee['tution_fee']);
        $transport_and_other_fee = floatval($fee['transport_and_other_fee']);
        $back_dues = floatval($fee['back_dues']);

        $total = $tution_fee + $transport_and_other_fee + $other_total + $back_dues + $missed_total;

        // Append missed dues summary
        if ($missed_total > 0) {
            $first_missed = date('F Y', $admission_month);
            $last_missed = date('F Y', strtotime("-1 month", $selected_month));
            $missed_summary = 'Back Dues (' . $first_missed . ' to ' . $last_missed . ') ₹' . $missed_total;
            $fees_details .= ($fees_details ? ', ' : '') . $missed_summary;
        }

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

    echo json_encode([
        'success' => $inserted > 0 || count($inserted_student_ids) > 0,
        'message' => ($inserted > 0)
            ? 'Demand Bill Generated Successfully'
            : 'Demand Bill Already Exists. Ready for Print.',
        'redirect' => true,
        'class' => $class,
        'section' => $section,
        'month_year' => $formatted_demand_month,
        'student_ids' => $inserted_student_ids
    ]);
} catch (Exception $e) {
     echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}