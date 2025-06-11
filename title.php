<?php
    $page = basename($_SERVER['PHP_SELF'], ".php");
    $titles = [
        'index' => 'Home Page',
        'student' => 'Student Panel',
        'addstudent' => 'Add Student'
    ];

    $title = isset($titles[$page]) ? $titles[$page] : "School Management System";
?>