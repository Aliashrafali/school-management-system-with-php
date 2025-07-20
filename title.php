<?php
    $page = basename($_SERVER['PHP_SELF'], ".php");
    $titles = [
        'index' => 'Home Page',
        'student' => 'Student Panel',
        'addstudent' => 'Admission',
        'registration' => 'Registration',
        'new-registration' => 'New Registration',
        'view_records' => 'View Records',
        'print_reg' => 'Print',
        'view_admission' => 'Admission Details',
        'demand-bill' => 'Demand Bill',
        'invoice-reports' => 'Invoice and Reports',
        'payments' => 'Payments'
    ];

    $title = isset($titles[$page]) ? $titles[$page] : "School Management System";
?>