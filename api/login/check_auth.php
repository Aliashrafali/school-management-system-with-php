<?php
declare(strict_types=1);
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
require __DIR__ . '/../../sql/config.php';
require __DIR__ . '/../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret = $secret_key;

if (!isset($_SESSION['jwt'])) {
    header("Location: login");
    exit;
}

try {
    $decoded = JWT::decode($_SESSION['jwt'], new Key($secret, 'HS256'));
    return (array)$decoded;
} catch (Exception $e) {
    session_destroy();
    header("Location: login?error=invalid");
    exit;
}
?>