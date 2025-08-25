<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
include '../../sql/config.php';

try {
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        echo json_encode([
            'success' => false,
            'message' => 'Only POST Method Allowed'
        ]);
        exit;
    }

    $input = $_POST;
    if(!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']){
        echo json_encode([
            'success' => false,
            'message' => 'Invalid Tokens'
        ]);
        exit;
    }

    $class = trim($input['class'] ?? '');
    $section = trim($input['section'] ?? '');
    $month = trim($input['month'] ?? '');
    $session = trim($input['session'] ?? '');

    $conditions = [];
    $params = [];
    $types = '';

    if($class != 'all'){
        $conditions[] = "r.class = ?";
        $params[] = $class;
        $types .= 's';
    }
    if($section != 'all'){
        $conditions[] = "r.section = ?";
        $params[] = $section;
        $types .= 's';
    }
    if($month != 'all'){
        $conditions[] = "p.month_year = ?";
        $params[] = $month;
        $types .= 's';
    }
    if($session != 'all'){
        $conditions[] = "r.session = ?";
        $params[] = $session;
        $types .= 's';
    }

    // JOIN query
    $query = "SELECT r.reg_no, r.name, r.fname,r.mobile, r.class, r.section, r.roll, r.session,
                     p.invoice_no, p.month_year, p.total_amount, p.paid_amount, p.paid_by
              FROM registration r
              INNER JOIN tbl_payments p ON r.reg_no = p.reg_no AND r.session = p.session";

    if(!empty($conditions)){
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql = $conn->prepare($query);
    if(!empty($params)){
        $sql->bind_param($types, ...$params);
    }

    $sql->execute();
    $result = $sql->get_result();

    if($result->num_rows > 0){
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=paid_payments.xls");

        echo "Reg No\tName\tFather\tMobile\tClass\tSection\tRoll\tSession\tInvoice No\tMonth Year\tPaid Amount\tPaid By\n";
        $totalPaid = 0;
        while($row = $result->fetch_assoc()){
            echo $row['reg_no'] . "\t" .
                 strtoupper($row['name']) . "\t" .
                 strtoupper($row['fname']) . "\t" .
                 strtoupper($row['mobile']). "\t".
                 strtoupper($row['class']) . "\t" .
                 strtoupper($row['section']) . "\t" .
                 $row['roll'] . "\t" .
                 $row['session'] . "\t" .
                 ($row['invoice_no'] ?? '-') . "\t" .
                 ($row['month_year'] ?? '-') . "\t" .
                 ($row['paid_amount'] ?? '0') . "\t" .
                 ($row['paid_by'] ?? '-') . "\n";
                 $totalPaid += (float)($row['paid_amount'] ?? 0);
        }
        echo "\t\t\t\t\t\t\t\t\t\tTotal Paid\t" . number_format($totalPaid, 2) . "\n";
        exit;
    } else {
        echo "No data found!";
    }

} catch(Exception $e){
    echo json_encode([
        'success' => false,
        'message' => 'Error: '.$e->getMessage()
    ]);
}
?>
