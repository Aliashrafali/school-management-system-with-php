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
        'payments' => 'Payments',
        'parents' => 'Parents',
        'view_demand' => 'View all Payments',
        'ladger' => 'Ladger',
        'add-parents' => 'Add Parents',
        'previous-reports' => 'Previous Reports',
        'collection-reports' => 'Collection Reports',
        'dues-reports' => 'Dues Reports',
        'admit-cards' => 'Admit Cards',
        'question-paper' => 'Question Paper',
        'all-admitcards' => 'All Admitcards',
        'all-questionpapers' => 'All Questionpapers',
        'edit-marks' => 'Edit Marks',
        'all-marks' => 'All Marks',
        'marksheet' => 'Marksheet'
    ];

    $title = isset($titles[$page]) ? $titles[$page] : "School Management System";
?>