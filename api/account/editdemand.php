<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
include '../../sql/config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

try {
    if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
        echo json_encode(['success'=>false, 'message'=>'Only POST Method is allowed']);
        exit;
    }

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid CSRF Token'
        ]);
        exit;
    }

    // Inputs
    $id       = intval($_POST['id'] ?? 0);
    $tfees    = floatval($_POST['tfees'] ?? 0);
    $trfee    = floatval($_POST['trfee'] ?? 0);
    $backdues = floatval($_POST['backdues'] ?? 0);

    $titles   = $_POST['title'] ?? [];
    $amounts  = $_POST['amount'] ?? [];

    // Other Fees processing
    $otherfeesArr = [];
    $otherSum = 0;
    if (!empty($titles) && is_array($titles)) {
        foreach ($titles as $i => $title) {
            $title  = trim($title);
            $amount = isset($amounts[$i]) ? floatval($amounts[$i]) : 0;
            if ($title !== "" && $amount > 0) {
                $otherfeesArr[] = $title . " " . $amount;
                $otherSum += $amount;
            }
        }
    }
    $otherfeesStr = implode(", ", $otherfeesArr);
    $total = $tfees + $trfee + $backdues + $otherSum;

    // Validate demand record
    $demand = $conn->prepare("SELECT reg_no, student_id, session FROM tbl_demand WHERE id = ?");
    $demand->bind_param('i', $id);
    $demand->execute();
    $res = $demand->get_result();
    if ($res->num_rows == 0) {
        echo json_encode(['success'=>false, 'message' => 'Demand Record not Found']);
        exit;
    }
    $demandRow = $res->fetch_assoc();
    $reg_no = $demandRow['reg_no'];
    $student_id = $demandRow['student_id'];
    $session = $demandRow['session'];

    // Update tbl_demand
    $dupdate = $conn->prepare("UPDATE tbl_demand 
        SET tution_fee = ?, transport_and_other_fee = ?, back_dues = ?, other_fee = ?, total = ? 
        WHERE id = ?");
    if (!$dupdate) {
        echo json_encode(['success'=>false, 'message'=>"Prepare failed (tbl_demand): ".$conn->error]);
        exit;
    }
    $dupdate->bind_param('dddssi', $tfees, $trfee, $backdues, $otherfeesStr, $total, $id);
    if (!$dupdate->execute()) {
        echo json_encode(['success'=>false, 'message'=>"Execution failed (tbl_demand): ".$dupdate->error]);
        exit;
    }

    // Update tbl_fees
    $fupdate = $conn->prepare("UPDATE tbl_fees 
        SET tution_fee = ?, transport_and_other_fee = ?, back_dues = ? 
        WHERE reg_no = ? AND session = ?");
    if (!$fupdate) {
        echo json_encode(['success'=>false, 'message'=>"Prepare failed (tbl_fees): ".$conn->error]);
        exit;
    }
    $fupdate->bind_param('ddiss', $tfees, $trfee, $backdues, $reg_no, $session);
    if (!$fupdate->execute()) {
        echo json_encode(['success'=>false, 'message'=>"Execution failed (tbl_fees): ".$fupdate->error]);
        exit;
    }

    echo json_encode([
        'success'=>true,
        'message' => 'Demand Bill Updated Successfully!',
        'debug' => [
            'tfees'     => $tfees,
            'trfee'     => $trfee,
            'backdues'  => $backdues,
            'otherfees' => $otherfeesStr,
            'total'     => $total
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success'=>false,
        'message'=>'Error: '.$e->getMessage()
    ]);
}
?>
