<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// DB Connection
require_once '../../sql/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF Token']);
    exit;
}

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Demand ID is missing']);
    exit;
}

if (!isset($_POST['reg_no']) || empty($_POST['reg_no'])) {
    echo json_encode(['success' => false, 'message' => 'Registration number is required']);
    exit;
}

try {
    $demand_id = intval($_POST['id']);
    $reg_no = $_POST['reg_no'] ?? '';
    $sid = isset($_POST['sid']) && is_numeric($_POST['sid']) ? (int)$_POST['sid'] : null;
    $amount = (float)($_POST['amount'] ?? 0);
    $adv_month = (int)($_POST['adv_month'] ?? 0);
    $adv_amount = (float)($_POST['adv_amount'] ?? 0);
    $discount = (float)($_POST['discount'] ?? 0);
    $grant_total = (float)($_POST['grant_total'] ?? 0);
    $paid = (float)($_POST['paid'] ?? 0);
    $rest_dues = (float)($_POST['rest_dues'] ?? 0);
    $payment_by = $_POST['payment_by'] ?? '';
    $month_year = $_POST['month_year'] ?? '';

    // Payment method fields
    $online = $_POST['online'] ?? '';
    $cash = $_POST['cash'] ?? '';
    $check = $_POST['check'] ?? '';

    // Generate invoice number
    $invoice_no = 'INV' . date('dmy') . mt_rand(3, 999);
    $currentDateTime = date("Y-m-d H:i:s");
    $status = 0;

    // Get old demand values
    $stmt = $conn->prepare("SELECT * FROM tbl_demand WHERE id = ?");
    $stmt->bind_param('i', $demand_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $session = $row['session'];
    }

    $old_paid = (float)$row['paid'];
    $old_adv_month = (int)$row['advance_month'];
    $old_advance_amount = (float)$row['advance_amount'];
    $old_discount = (float)$row['discount'];
    $total_amount = (float)$row['total'];

    // Insert into tbl_payments
    $insert = $conn->prepare("INSERT INTO tbl_payments(
        demand_id, reg_no, student_id, invoice_no,session, total_amount, month_year,
        no_of_advance_month, advance_amount, discount_amount, grant_total, paid_amount,
        rest_dues, paid_by, transaction_id, payment_by, check_no, date_and_time, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

   $insert->bind_param('isissdsidddddsssssi', 
    $demand_id, $reg_no, $sid, $invoice_no, $session, $amount, $month_year,
    $adv_month, $adv_amount, $discount, $grant_total, $paid,
    $rest_dues, $payment_by, $online, $cash, $check, $currentDateTime, $status);
    $insert->execute();
    $inserted_id = $insert->insert_id;

    // Update tbl_demand
    $new_paid = $old_paid + $paid;
    $new_adv_month = $old_adv_month + $adv_month;
    $new_adv_amount = $old_advance_amount + $adv_amount;
    $new_discount = $old_discount + $discount;
    $new_rest_dues = $rest_dues;

    // $new_rest_dues = $grant_total - $paid; isko hi use karna hai normal 

    $update = $conn->prepare("UPDATE tbl_demand SET 
        paid = ?, advance_month = ?, advance_amount = ?, discount = ?, rest_dues = ?
        WHERE id = ?");

    $update->bind_param('dsdddi', $new_paid, $new_adv_month, $new_adv_amount,$new_discount,$new_rest_dues,$demand_id);
    $update->execute();

    if($insert && $update){
         echo json_encode([
            'success' => true,
            'message' => 'Receipt generated successfully',
            'invoice_no' => $invoice_no
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
