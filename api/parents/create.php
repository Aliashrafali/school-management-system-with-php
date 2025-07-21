<?php
    date_default_timezone_set('Asia/Kolkata');
    include '../../sql/config.php';
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode(['success' => false, 'message' => 'Only Post Method Allow']);
            exit;
        }
        if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']){
            echo json_encode(['success' => false, 'message'=> 'Invalid CSRF Token']);
            exit;
        }
        $name = $_POST['name'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $altmobile = $_POST['altmobile'] ?? '';
        $email = $_POST['email'] ?? '';
        $bgroup = $_POST['bgroup'] ?? '';
        $adhar = trim(preg_replace('/\s+/', '', $_POST['adhar'] ?? ''));
        $occupation = $_POST['occupation'] ?? '';
        $department = $_POST['department'] ?? '';
        $designation = $_POST['designation'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $religion = $_POST['religion'] ?? '';
        $category = $_POST['category'] ?? '';
        $childnum = $_POST['childnum'] ?? '';
        $present_address = $_POST['present_address'] ?? '';
        $parmanent_address = $_POST['parmanent_address'] ?? '';

        $adharcheck = $conn->prepare("SELECT * FROM tbl_parents WHERE adhar = ?");
        $adharcheck->bind_param('s',$adhar);
        $adharcheck->execute();
        $adharcheck->store_result();
        if($adharcheck->num_rows > 0){
            echo json_encode([
                'success' =>false,
                'message' => 'Parents Already Exits ?'
            ]);
            exit;
        }
        $adharcheck->close();

        $insert = $conn->prepare("INSERT INTO tbl_parents(name,phone,altmobile,email,bgroup,adhar,occupation,department,designation,gender,religion,category,childnum,present_address,parmanent_address)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $insert->bind_param('sssssssssssssss', $name,$mobile,$altmobile,$email,$bgroup,$adhar,$occupation,$department,$designation,$gender,$religion,$category,$childnum,$present_address,$parmanent_address);
        try{
            $insert->execute();
            echo json_encode([
                'success' => true,
                'message' => 'Parents Added Successful!.',
            ]);
        }catch(mysqli_sql_exception $e){
            echo json_encode([
                'success' => false,
                'message' => 'DB Error'.$conn->error
            ]);
        }
    }catch(Exception $e){
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'error'.$e->getMessage()]);
    }
?>