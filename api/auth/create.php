<?php
    include '../../sql/config.php';
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message' => 'Only POST is Allowed'
            ]);
            exit;
        }
        if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']){
            echo json_encode([
                'success' => false,
                'message' => 'Invalid Tokens' 
            ]);
            exit;
        }
        $term = $_POST['term'] ?? '';
        $date = date('Y-m-d H:i:s');
        $name = trim($_POST['name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if(empty($term)){
            echo json_encode([
                'success' => false,
                'message' => 'Check term & condition'
            ]);
            exit;
        }
        if(strlen($password) < 8){
             echo json_encode([
                'success' => false,
                'message' => 'Password must be at least 8 characters long.'
            ]);
            exit;
        }
        if(empty($username) || empty($password)){
            echo json_encode(['success' => false, 'message' => 'all fields are required']);
            exit;
        }else if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
            echo json_encode(['success'=>false, 'message' => 'Invalid Email Formate']);
            exit;
        }else{
            $sql = $conn->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
            $sql->bind_param('s', $username);
            $sql->execute();
            $sql->store_result();
            if($sql->num_rows > 0){
                echo json_encode(['success' => false, 'message' => 'User already Added !']);
                exit;
            }else{
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $insert = $conn->prepare('INSERT INTO users(name,username,pass,created_at)VALUES(?, ?, ?, ?)');
                $insert->bind_param('ssss',$name,$username,$hashed_password,$date);
                if($insert->execute()){
                    echo json_encode([
                        'success'=>true,
                        'message' => 'User Added !'
                    ]);
                }else{
                    echo json_encode([
                        'success'=>false,
                        'message' => 'Failed'
                    ]);
                }
            }
        }
    }catch(Exception $e){
        http_response_code(500);
        echo json_encode([
            'success'=>false,
            'message'=>'Error'.$e->getMessage()
        ]);
    }
?>