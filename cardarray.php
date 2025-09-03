<?php
    // session_start();
    include 'sql/config.php';
    $students = $conn->prepare("SELECT COUNT(*) as total FROM registration r INNER JOIN tbl_fees a ON r.reg_no = a.reg_no WHERE r.status = 1 AND a.status = 1");
    $students->execute();
    $students->bind_result($students_total);
    $students->fetch();
    $students->close();

    // active students
    $active = $conn->prepare("SELECT COUNT(*) as active FROM registration r INNER JOIN tbl_fees a ON r.reg_no = a.reg_no WHERE a.status = 1 AND r.status = 1");
    $active->execute();
    $active->bind_result($activestudents);
    $active->fetch();
    $active->close();

    // suspended students
    $suspended = $conn->prepare("SELECT COUNT(*) as suspended FROM registration r INNER JOIN tbl_fees a ON r.reg_no = a.reg_no WHERE r.status = 2 AND a.status = 2");
    $suspended->execute();
    $suspended->bind_result($suspendedstudents);
    $suspended->fetch();
    $suspended->close();

    $users = $conn->prepare("SELECT COUNT(*) as totalusers FROM users");
    $users->execute();
    $users->bind_result($total_users);
    $users->fetch();
    $users->close();

    // august 2025 collection 
    $month = date('n');
    $year = date('Y');
    if ($month >= 4) {
        $current_session = $year . '-' . substr($year + 1, -2);
    } else {
        $current_session = ($year - 1) . '-' . substr($year, -2);
    }
    $monthly_collection = $conn->prepare("
        SELECT DATE_FORMAT(p.date_and_time, '%M-%Y') AS month_year,
        SUM(p.paid_amount) AS total_paid
        FROM tbl_payments p INNER JOIN registration r ON r.reg_no = p.reg_no AND r.session = p.session WHERE p.session = ? AND MONTH(p.date_and_time) = ? AND YEAR(p.date_and_time) = ?
        GROUP BY month_year
    ");
    $monthly_collection->bind_param('sii', $current_session,$month,$year);
    $monthly_collection->execute();
    $result = $monthly_collection->get_result();
    $total_paid = 0;
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $total_paid = $row['total_paid'];
        }
    }
    

    $today_collection = $conn->prepare("
        SELECT SUM(paid_amount) AS today_total
        FROM tbl_payments
        WHERE session = ?
        AND DATE(date_and_time) = CURDATE()
    ");
    $today_collection->bind_param('s', $current_session);
    $today_collection->execute();
    $today_collection_reports = $today_collection->get_result();
    $todayPaid = 0;
    if($today_collection_reports->num_rows > 0){
        while($row_today = $today_collection_reports->fetch_assoc()){
            $todayPaid = $row_today['today_total'];
        }
    }

    // total dues
    $current_month_year = date('F Y');
    $dues = $conn->prepare("
        SELECT r.reg_no, r.name, r.fname,r.mobile, r.class, r.section, r.roll, r.session,
                      p.month_year, p.total, p.rest_dues, p.paid
              FROM registration r
              INNER JOIN tbl_demand p ON r.reg_no = p.reg_no AND r.session = p.session WHERE p.paid < p.total AND month_year = ?"
    );
    $dues->bind_param('s', $current_month_year);
    $dues->execute();
    $dues_result = $dues->get_result();
    $data = [];
    $total_dues = 0;
    if($dues_result->num_rows > 0){
    while ($rowdues = $dues_result->fetch_assoc()) {
        $data[] = $rowdues;
        if($rowdues['rest_dues'] == 0 && $rowdues['paid'] == 0){
            $total_dues += (float)($rowdues['total'] ?? 0);
        } else {
            $total_dues += (float)($rowdues['rest_dues'] ?? 0);
        }
    }
}


    $cards = [
        [
            "icon"=>"fas fa-user-graduate", 
            "num"=>$students_total, 
            "url"=>"student",
            "title"=>"Total Students", 
            "bg-color"=>"#FFEDF3", "color"=>"#FF7601", 
            "card-color"=>'#fff', 
            "num-color"=>'#000',
            "border-left" => '#FF7601'
        ],
        [
            "icon"=>"fas fa-check-circle", 
            "num"=>$activestudents, 
            "url"=>"#",
            "title"=>"Active Students", 
            "bg-color"=>"#E8F9FF", 
            "color"=>"#4300FF", 
            "card-color"=>'#fff', 
            "num-color"=>'#000',
            "border-left" => '#4300FF'
        ],
        [
            "icon"=>"fas fa-ban text-danger", 
            "num"=>$suspendedstudents, 
            "url"=>"#",
            "title"=>"Suspended Students", 
            "bg-color"=>"#FFE2E2", 
            "color"=>"#F564A9", 
            "card-color"=>'#fff', 
            "num-color"=>'#000',
            "border-left" => '#F564A9'
        ],
        [
            "icon"=>"fas fa-user", 
            "num"=>0,
            "url"=>"#", 
            "title"=>"Parents", 
            "bg-color"=>"#CBDCEB", 
            "color"=>"#01a9ac", 
            "card-color"=>'#fff', 
            "num-color"=>'#000',
            "border-left" => '#01a9ac'
        ],
        [
            "icon"=>"fas fa-user", 
            "num"=>$total_users, 
            "url"=>"#",
            "title"=>"User", 
            "bg-color"=>"#fff", 
            "color"=>"#FF7601", 
            "card-color"=>'#FF7601', 
            "num-color"=>'#fff',
            "border-left" => '#FF7601'
        ],
        [
            "icon"=>"fas fa-folder-open", 
            "num"=>$todayPaid, 
            "url"=>"collection-reports",
            "title"=>"Today's Collection", 
            "bg-color"=>"#fff", 
            "color"=>"#4300FF", 
            "card-color"=>'#4300FF', 
            "num-color"=>'#fff',
            "border-left" => '#4300FF'
        ],
        [
            "icon"=>"fas fa-folder-open", 
            "num"=>$total_paid, 
            "url"=>"collection-reports",
            "title"=>date("M-y") ." Collection", 
            "bg-color"=>"#fff", 
            "color"=>"#dc3545", 
            "card-color"=>'#dc3545', 
            "num-color"=>'#fff',
            "border-left" => '#dc3545'
        ],
        [
            "icon"=>"fas fa-file-invoice-dollar", 
            "num"=>$total_dues, 
            "url"=>"dues-reports",
            "title"=>"Total Dues", 
            "bg-color"=>"#fff", 
            "color"=>"#01a9ac", 
            "card-color"=>'#01a9ac', 
            "num-color"=>'#fff',
            "border-left" => '#01a9ac'
        ],
    ];
?>