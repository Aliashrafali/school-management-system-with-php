<?php
    date_default_timezone_set('Asia/Kolkata');
    session_start();
    include '../../sql/config.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST, PUT");
    header("Access-Control-Allow-Headers: Content-Type");

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message' => 'Only POST Method Allows'
            ]);
            exit;
        }

        $input = $_POST;

        if(!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']){
            echo json_encode([
                'success'=>false,
                'message'=>'Invalid CSRF Tokens'
            ]);
            exit;
        }

        $class = trim($input['class'] ?? '');
        $section = trim($input['section'] ?? '');
        $dateandtime = date('Y-m-d H:i:s');
        $status = 0;

        if(empty($class) || empty($section)){
            echo json_encode([
                'success' => true,
                'message' => 'Class or Section missing'
            ]);
            exit;
        };

        $fees_details = '';
        $other_total  = 0;
        if(isset($input['title']) && isset($input['fees'])){
            $titles = $input['title'];
            $fees = $input['fees'];
            $combined = [];
            for($i = 0 ; $i < count($titles); $i++){
                $title = trim($titles[$i]);
                $fee = trim($fees[$i]);

                if(isset($title) && is_numeric($fee)){
                    $combined[] = $title.' '.$fee;
                    $other_total += floatval($fee); 
                }
            }
            $fees_details = implode(', ', $combined);
        }

        // get student data based on the class and section
        $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE class = ? AND section = ?");
        $student_query->bind_param('ss', $class,$section);
        $student_query->execute();
        $students = $student_query->get_result();

        if($students->num_rows === 0){
            echo json_encode([
                'success' =>false,
                'message' => 'Record Not Found'
            ]);
            exit;
        }

        // get fees on the basic of reg_no and student_id
        $tbl_fee = $conn->prepare("SELECT tution_fee,transport_and_other_fee,month_year FROM tbl_fees WHERE reg_no = ? AND student_id = ?");
        $demand_insert = $conn->prepare("INSERT INTO tbl_demand(student_id,reg_no,tution_fee,transport_and_other_fee,other_fee,total,month_year,date_and_time,status)VALUES(?,?,?,?,?,?,?,?,?)");

        $inserted = 0;
        while($student = $students->fetch_assoc()){
            $student_id = $student['id'];
            $reg_no = $student['reg_no'];

            // get fee
            $tbl_fee->bind_param('si', $reg_no,$student_id);
            $tbl_fee->execute();
            $result_fee = $tbl_fee->get_result();

            if($result_fee->num_rows > 0){
                $fee_row = $result_fee->fetch_assoc();
                $tution_fee = floatval($fee_row['tution_fee']);
                $transport_and_other_fee = floatval($fee_row['transport_and_other_fee']);
                $total = $tution_fee + $transport_and_other_fee + $other_total;
                $month_years = $fee_row['month_year'];

                // $check_existing = $conn->prepare()
                
                $demand_insert->bind_param(
                    "isddsissi",
                    $student_id,
                    $reg_no,
                    $tution_fee,
                    $transport_and_other_fee,
                    $fees_details,
                    $total,
                    $month_years,
                    $dateandtime,
                    $status
                );
                $demand_insert->execute();
                $inserted++;
            }
        }
        echo json_encode([
            'success' => true,
            'message' => "$inserted rows inserted with total and other_fee."
        ]);

    }catch(Exception $e){
        echo json_encode([
            'success'=>false, 
            'message'=>"Error".$e->getMessage()
        ]);
    }

?>