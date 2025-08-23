<?php
    declare(strict_types=1);
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    require __DIR__ . '/../../sql/config.php';

    define('COOKIE_NAME', 'school_erp_token');
    session_start();
    session_unset();
    session_destroy();
    
    $token = $_COOKIE[COOKIE_NAME] ?? '';

    if($token){
        $stmt = $conn->prepare("INSERT INTO jwt_blacklist (token) VALUES (?)");
        $stmt->bind_param("s", $token);
        $stmt->execute();
    }

    setcookie(COOKIE_NAME, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

header('Location: ../../login');
exit;
?>