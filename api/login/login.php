<?php
    declare(strict_types = 1);
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    require __DIR__ . '/../../vendor/autoload.php';
    require __DIR__ . '/../../sql/config.php';
    require __DIR__ . '/auth.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    define('JWT_SECRET', $secret_key);
    define('JWT_ALGO', 'HS256');
    define('COOKIE_NAME', 'school_erp_token');


    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        // header("Location: ../../login.php?error=method");
        header('Location: ' . login_url() . '?error=method');
        exit;
    }

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if($username == '' || $password == ''){
        // header("Location: ../../login.php?error=required");
        header('Location: ' . login_url() . '?error=required');
        exit;
    }

    $sql = $conn->prepare("SELECT id, name, username, pass FROM users WHERE username = ? LIMIT 1");
    $sql->bind_param('s', $username);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();

    if(!$user || !password_verify($password,$user['pass'])){
        // header("Location: ../../login?error=invalid");
        header('Location: ' . login_url() . '?error=invalid');
        exit;
    }

    $issuedAt = time();
    $expired = $issuedAt + 7200;

    $payload = [
        'iss' => 'school-erp',
        'iat' => $issuedAt,
        'exp' => $expired,
        'sub' => $user['id'],
        'username' => $user['username'],
        'name' => $user['name']
    ];

    $jwt = JWT::encode($payload, JWT_SECRET,JWT_ALGO);
    $_SESSION['jwt'] = $jwt;

    setcookie(COOKIE_NAME, $jwt, [
        'expires' => $expired,
        'path' => '/',
        'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Strict'
    ]);

    header('Location:../../index');
    exit;
?>