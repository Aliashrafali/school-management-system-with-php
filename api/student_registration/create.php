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
        // random registration no
        $prefix = 'ABC';
        $years = date('Y');
        $randomnumber = mt_rand(100000, 999999);
        $reg_no = $prefix . $years . $randomnumber;
        $name = $_POST['name'] ?? '';
        $fname = $_POST['fname'] ?? '';
        $mname = $_POST['mname'] ?? '';
        $dob = $_POST['dob'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $altmobile = $_POST['altmobile'] ?? '';
        $email = $_POST['email'] ?? '';
        $bgroup = $_POST['bgroup'] ?? '';
        $adhar = trim(preg_replace('/\s+/', '', $_POST['adhar'] ?? ''));
        $gender = $_POST['gender'] ?? '';
        $religion = $_POST['religion'] ?? '';
        $category = $_POST['category'] ?? '';
        $parmanent_address = $_POST['parmanent_address'] ?? '';
        $present_address = $_POST['present_address'] ?? '';
        $class = $_POST['class'] ?? '';
        $registration_d = $_POST['registration_date'] ?? '';
        $time = date("H:i:s");
        $registration_date = $registration_d.' '.$time;
        $registration_fee = $_POST['registration_fee'] ?? '';
        $session = $_POST['session'] ?? '';
        $status = 0;
        
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Image Upload Error: ' . ($_FILES['image']['error'] ?? 'Not Set')
                ]);
                exit;
            }

            $filePath = $_FILES['image']['tmp_name'];
            $filename = $_FILES['image']['name'];
            $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'png', 'jpeg'];
            if(!in_array($fileExtension, $allowed)){
                echo json_encode(['success' => false, 'message' => 'Invalid Image Type']);
                exit;
            }
            $uploadDir = '../../sql/students';
            if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $newFileName = uniqid(). '_' . basename($filename);
            $destpath = $uploadDir . '/' . $newFileName;
            if(!move_uploaded_file($filePath, $destpath)){
                echo json_encode(['success' => false, 'message' => 'Error While File Uploading']);
                exit;
            }

            //check already exits
            $check = $conn->prepare("SELECT * FROM registration WHERE adhar = ? AND class = ?");
            $check->bind_param('ss', $adhar, $class);
            $check->execute();
            $check->store_result();
            if($check->num_rows > 0){
                echo json_encode([
                    'success' => false,
                    'message' => 'Student Already Registered with same Aadhaar and Class.'
                ]);
                exit;
            }

            $check1 = $conn->prepare("SELECT * FROM registration WHERE reg_no = ? AND session = ?");
            $check1->bind_param('ss', $reg_no,$session);
            $check1->execute();
            $check1->store_result();
            if($check1->num_rows > 0){
                echo json_encode([
                    'success' => false,
                    'message' => 'Student Already Registered in this Session!'
                ]);
                exit;
            }

            $insert = $conn->prepare("INSERT INTO registration(reg_no,name,fname,mname,dob,mobile,altmobile,email,bgroup,adhar,gender,religion,category,parmanent_address,present_address,class,registration_date,registration_fee,session,image,status)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $insert->bind_param('ssssssssssssssssssssi', $reg_no, $name, $fname, $mname, $dob, $mobile, $altmobile, $email, $bgroup, $adhar, $gender, $religion, $category, $parmanent_address,$present_address, $class,$registration_date, $registration_fee,$session,$newFileName, $status);
                try{
                    $insert->execute();
                    $id = $insert->insert_id;
                    $reg_id = $conn->prepare("SELECT * FROM registration WHERE id = ?");
                    $reg_id->bind_param('i', $id);
                    $reg_id->execute();
                    $result = $reg_id->get_result();
                    $reg_no = $result->fetch_assoc()['reg_no'];
                    echo json_encode([
                        'success' => true,
                        'message' => 'Registration successful!.',
                        'reg_id' => $reg_no,
                        'redirect' => 'print_reg?reg_no='.$reg_no
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