<?php
    $page = basename($_SERVER['PHP_SELF'], ".php");
    $titles = [
        'index' => 'Home Page'
    ];

    $title = isset($titles[$page]) ? $titles[$page] : "School Management System";
?>