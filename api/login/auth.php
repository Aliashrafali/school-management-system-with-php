<?php
    declare(strict_types=1);
    require __DIR__ . '/../../sql/config.php';
    require __DIR__ . '/../../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    define('COOKIE_NAME', 'school_erp_token');
    define('JWT_SECRET', $secret_key); 
    define('JWT_ALGO', 'HS256');

   function login_url(): string {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $project = '/rnmissionschollERP';
        return "$protocol://$host$project/login";
    }
    function require_auth(): array{
        $token = $_COOKIE[COOKIE_NAME] ?? '' ;
        $login_url = login_url();
        if(!$token){
            header("Location:$login_url");
            exit;
        }
        try{
            $decode = JWT::decode($token, new Key(JWT_SECRET, JWT_ALGO));
            return (array)$decode;
        }catch (\Firebase\JWT\ExpiredException $e) {
            $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
            header("Location: $login_url?error=expired");
            exit;
        }catch(\Throwable $e){
            $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
            header("Location: $login_url");
            exit;
        }
    }
?>