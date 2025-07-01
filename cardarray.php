<?php
    session_start();
    include 'sql/config.php';
    $students = $conn->prepare("SELECT COUNT(*) as total FROM registration r INNER JOIN tbl_admission a ON r.reg_no = a.reg_no");
    $students->execute();
    $students->bind_result($students_total);
    $students->fetch();
    $students->close();

    // active students
    $active = $conn->prepare("SELECT COUNT(*) as active FROM registration r INNER JOIN tbl_admission a ON r.reg_no = a.reg_no WHERE a.status = 0 AND r.status = 0");
    $active->execute();
    $active->bind_result($activestudents);
    $active->fetch();
    $active->close();

    // suspended students
    $suspended = $conn->prepare("SELECT COUNT(*) as suspended FROM registration r INNER JOIN tbl_admission a ON r.reg_no = a.reg_no WHERE r.status = 1 AND a.status = 1");
    $suspended->execute();
    $suspended->bind_result($suspendedstudents);
    $suspended->fetch();
    $suspended->close();

    $cards = [
        [
            "icon"=>"fas fa-user-graduate", 
            "num"=>$students_total, 
            "url"=>"student",
            "title"=>"Total Students", 
            "bg-color"=>"#FFEDF3", "color"=>"#FF7601", 
            "card-color"=>'#fff', 
            "num-color"=>'#000'
        ],
        [
            "icon"=>"fas fa-check-circle", 
            "num"=>$activestudents, 
            "url"=>"#",
            "title"=>"Active Students", 
            "bg-color"=>"#E8F9FF", 
            "color"=>"#4300FF", 
            "card-color"=>'#fff', 
            "num-color"=>'#000'
        ],
        [
            "icon"=>"fas fa-ban text-danger", 
            "num"=>$suspendedstudents, 
            "url"=>"#",
            "title"=>"Suspended Students", 
            "bg-color"=>"#FFE2E2", 
            "color"=>"#F564A9", 
            "card-color"=>'#fff', 
            "num-color"=>'#000'
        ],
        [
            "icon"=>"fas fa-user", 
            "num"=>389,
            "url"=>"#", 
            "title"=>"Parents", 
            "bg-color"=>"#CBDCEB", 
            "color"=>"#01a9ac", 
            "card-color"=>'#fff', 
            "num-color"=>'#000'
        ],
        [
            "icon"=>"fas fa-user", 
            "num"=>3, 
            "url"=>"#",
            "title"=>"User", 
            "bg-color"=>"#fff", 
            "color"=>"#FF7601", 
            "card-color"=>'#FF7601', 
            "num-color"=>'#fff'
        ],
        [
            "icon"=>"fas fa-folder-open", 
            "num"=>7500, 
            "url"=>"#",
            "title"=>date("j F Y"). " Collection", 
            "bg-color"=>"#fff", 
            "color"=>"#4300FF", 
            "card-color"=>'#4300FF', 
            "num-color"=>'#fff'
        ],
        [
            "icon"=>"fas fa-folder-open", 
            "num"=>145450, 
            "url"=>"#",
            "title"=>date("F Y") ." Collection", 
            "bg-color"=>"#fff", 
            "color"=>"#dc3545", 
            "card-color"=>'#dc3545', 
            "num-color"=>'#fff'
        ],
        [
            "icon"=>"fas fa-file-invoice-dollar", 
            "num"=>145450, 
            "url"=>"#",
            "title"=>"Total Dues", 
            "bg-color"=>"#fff", 
            "color"=>"#01a9ac", 
            "card-color"=>'#01a9ac', 
            "num-color"=>'#fff'
        ],
    ];
?>