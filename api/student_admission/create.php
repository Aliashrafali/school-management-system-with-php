<?php
    date_default_timezone_set('Asia/Kolkata');
    include '../../sql/config.php';
    session_start();

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST, PUT");
    header("Access-Control-Allow-Headers: Content-Type");

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message' => 'Only POST Method Allow for this'
            ]);
            exit;
        }
        $input = json_decode(file_get_contents("php://input"), true);

        if (!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid CSRF Token'
            ]);
            exit;
        }

        $reg_no = $input['reg_no'] ?? '';
        $session = $input['session'] ?? '';
        $id = isset($input['id']) ? (int)$input['id'] : '';

        $section = $input['section'] ?? '';
        $admission_d = $input['admission_date'] ?? '';
        $time = date("H:i:s");
        $admission_date = $admission_d. ' '.$time;
        $roll = isset($input['roll']) ? (int)$input['roll'] : '';
        $tution_fee = isset($input['tution_fee']) ? (float)$input['tution_fee'] : '';
        $transport_and_other_fee = isset($input['transport_and_other_fee']) ? (float)$input['transport_and_other_fee'] : '';
        $back_dues = isset($input['back_dues']) ? (float)$input['back_dues'] : '';
        $total = isset($input['total']) ? (float)$input['total'] : '';
        $month_years = $input['month_years'] ?? '';
        $status = 1;
        $now = date('Y-m-d H:i:s');

        // select admision data if already exits
        $check = $conn->prepare("SELECT * FROM registration WHERE reg_no = ? AND session = ? AND status = ?");
        $check->bind_param('ssi', $reg_no,$session,$status);
        $check->execute();
        $check->store_result();
        if($check->num_rows > 0){
            echo json_encode([
                'success' => false,
                'message' => 'Admission has already been completed for this student.'
            ]);
            exit;
        }

        $update = $conn->prepare("UPDATE registration SET section = ?, roll = ?, admission_date = ?, status = ? WHERE reg_no = ?");
        $update->bind_param('sisis', $section,$roll,$admission_date,$status, $reg_no);
        $update_result  = $update->execute();

        $insert = $conn->prepare("INSERT INTO tbl_fees(student_id,reg_no,session,tution_fee,transport_and_other_fee,back_dues,total,month_year,date_time,status)VALUES(?,?,?,?,?,?,?,?,?,?)");
        $insert->bind_param('issddddssi', $id,$reg_no,$session,$tution_fee,$transport_and_other_fee,$back_dues,$total,$month_years,$now, $status);
        try{
            $insert_result = $insert->execute();
            if($update_result && $insert_result){
                echo json_encode([
                    'success' => true,
                    'message' => 'Admission Successful!'
                ]);
            }else{
                echo json_encode([
                    'success' => false,
                    'message' => 'Error'.$conn->error
                ]);
            }
        }catch(mysqli_sql_exception $e){
            if(strpos(strtolower($e->getMessage()), 'duplicate entry') !== false){
                echo json_encode([
                    'success' => false,
                    'message' => 'Admission has already been completed for this student.'
                ]);
            }else{
                echo json_encode([
                    'success' => false,
                    'message' => 'DB Error'.$conn->error
                ]);
            }
        }
    }catch(Exception $e){
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'error'.$e->getMessage()
        ]);
    }
?>