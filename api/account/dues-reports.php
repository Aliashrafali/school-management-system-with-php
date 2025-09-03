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
    // $query = "SELECT r.reg_no, r.name, r.fname,r.mobile, r.class, r.section, r.roll, r.session,
    //                   p.month_year, p.total, p.rest_dues, p.paid
    //           FROM registration r
    //           INNER JOIN tbl_demand p ON r.reg_no = p.reg_no AND r.session = p.session";

    // updated
    if($month == 'all'){
        // Latest month record per student
        $query = "
            SELECT r.reg_no, r.name, r.fname, r.mobile, r.class, r.section, r.roll, r.session,
                p.month_year, p.total, p.rest_dues, p.paid
            FROM registration r
            INNER JOIN tbl_demand p 
                ON r.reg_no = p.reg_no AND r.session = p.session
            INNER JOIN (
                SELECT reg_no, session, MAX(STR_TO_DATE(month_year, '%M %Y')) as max_month
                FROM tbl_demand
                GROUP BY reg_no, session
            ) latest 
                ON p.reg_no = latest.reg_no 
            AND p.session = latest.session 
            AND STR_TO_DATE(p.month_year, '%M %Y') = latest.max_month
        ";
    } else {
        // Specific month record
        $query = "
            SELECT r.reg_no, r.name, r.fname, r.mobile, r.class, r.section, r.roll, r.session,
                p.month_year, p.total, p.rest_dues, p.paid
            FROM registration r
            INNER JOIN tbl_demand p 
                ON r.reg_no = p.reg_no AND r.session = p.session
        ";
        $conditions[] = "p.month_year = ?";
        $params[] = $month;
        $types .= 's';
    }

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
        header("Content-Disposition: attachment; filename=dues_reports.xls");

        echo "Reg No\tName\tFather\tMobile\tClass\tSection\tRoll\tSession\tMonth Year\tDues Amount\n";
        $totalPaid = 0;
        while($row = $result->fetch_assoc()){
            if ($row['rest_dues'] <= 0 && $row['paid'] > 0) {
                continue; // skip this row
            }
             $line = $row['reg_no'] . "\t" .
                 strtoupper($row['name']) . "\t" .
                 strtoupper($row['fname']) . "\t" .
                 strtoupper($row['mobile']). "\t".
                 strtoupper($row['class']) . "\t" .
                 strtoupper($row['section']) . "\t" .
                 $row['roll'] . "\t" .
                 $row['session'] . "\t";
                if ($month == 'all') {
                    $line .= "All\t";  // static
                } else {
                    $line .= ($row['month_year'] ?? '-') . "\t"; // actual month
                }
                 ($row['total'] ?? '-') . "\t";
                 if($row['rest_dues'] == 0 && $row['paid'] == 0){
                    $line .= ($row['total']); 
                    $totalPaid += (float)($row['total'] ?? 0);
                 }else{
                    $line .= ($row['rest_dues']);
                    $totalPaid += (float)($row['rest_dues'] ?? 0);
                 }
                 $line .= "\n";
                 echo $line;
        }
        echo "\t\t\t\t\t\t\t\t\tTotal Dues\t" . number_format($totalPaid, 2) . "\n";
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
