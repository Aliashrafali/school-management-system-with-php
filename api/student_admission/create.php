<?php
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
        $admission_date = $input['admission_date'] ?? '';
        $roll = isset($input['roll']) ? (int)$input['roll'] : '';
        $tution_fee = isset($input['tution_fee']) ? (float)$input['tution_fee'] : '';
        $transport_and_other_fee = ($input['transport_and_other_fee']) ? (float)$input['transport_and_other_fee'] : '';
        $total = isset($input['total']) ? (float)$input['total'] : '';
        $month_years = $input['month_years'] ?? '';
        $status = 0;

        $insert = $conn->prepare("INSERT INTO tbl_admission(student_id,reg_no,session,section,admission_date,roll,tution_fee,transport_and_other_fee,total,month_year,status)VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $insert->bind_param('issssidddsi', $id,$reg_no,$session,$section,$admission_date,$roll,$tution_fee,$transport_and_other_fee,$total,$month_years,$status);
        try{
            $insert->execute();
            echo json_encode([
                'success' => true,
                'message' => 'Admission Successful!'
            ]);
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