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
        if(!empty($section)){
            $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE class = ? AND section = ?");
            $student_query->bind_param('ss', $class,$section);
        }else{
            $student_query = $conn->prepare("SELECT id, reg_no FROM registration WHERE class = ?");
            $student_query->bind_param('s', $class);
        }
        
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
        $inserted_student_ids = [];
        while($student = $students->fetch_assoc()){
            $student_id = $student['id'];
            $reg_no = $student['reg_no'];

            // get admission date
            $admission = $conn->prepare("SELECT month_year FROM tbl_fees WHERE student_id = ? AND reg_no = ?");
            $admission->bind_param('is', $student_id,$reg_no);
            $admission->execute();
            $admision_result = $admission->get_result();
            $admission_date = '';
            if($admision_result->num_rows > 0){
                $admission_row = $admision_result->fetch_assoc();
                $admission_date = $admission_row['month_year'];
            }

            // get last dues from tbl_demand
            $check_last = $conn->prepare("SELECT month_year, rest_dues FROM tbl_demand WHERE student_id = ? AND reg_no = ? ORDER BY id DESC LIMIT 1");
            $check_last->bind_param('is', $student_id, $reg_no);
            $check_last->execute();
            $check_result = $check_last->get_result();

            $last_due = 0;
            if($check_result->num_rows > 0){
                $last_demand = $check_result->fetch_assoc();
                $last_month = $last_demand['month_year'];
                $last_due = floatval($last_demand['rest_dues']);
                $month_years = date('F Y', strtotime($last_month . "+1 month"));
            }else{
                if(!empty($admission_date)){
                    $month_years = date('F Y', strtotime($admission_date));
                }else{
                    $month_years = date('F Y');
                }
            }

            // get fee
            $tbl_fee->bind_param('si', $reg_no,$student_id);
            $tbl_fee->execute();
            $result_fee = $tbl_fee->get_result();

            if($result_fee->num_rows > 0){
                $fee_row = $result_fee->fetch_assoc();
                $tution_fee = floatval($fee_row['tution_fee']);
                $transport_and_other_fee = floatval($fee_row['transport_and_other_fee']);
                $total = $tution_fee + $transport_and_other_fee + $other_total + $last_due;

                $current_month = date('Y-m');
                $already_cut = $conn->prepare(" SELECT id FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND DATE_FORMAT(date_and_time, '%Y-%m') = ?");
                $already_cut->bind_param('iss', $student_id, $reg_no, $current_month);
                $already_cut->execute();
                $cut_result = $already_cut->get_result();
                if ($cut_result->num_rows > 0) {
                    continue;
                }

                // final fee
                $final_other_fee = $fees_details;
                if($last_due > 0){
                    $final_other_fee .= ($final_other_fee ? ', ' : '') . 'Previous Due' . number_format($last_due, 2);
                }
                
                $demand_insert->bind_param(
                    "isddsissi",
                    $student_id,
                    $reg_no,
                    $tution_fee,
                    $transport_and_other_fee,
                    $final_other_fee,
                    $total,
                    $month_years,
                    $dateandtime,
                    $status
                );
                $demand_insert->execute();
                $inserted++;
                $inserted_student_ids[] = $student_id;
            }
        }
        if($inserted > 0){
            echo json_encode([
                'success' => true,
                'message' => "Demand Bill Generated Please Downalod Your PDF",
                'redirect'=>true,
                'class'=>$class,
                'section'=>$section,
                'month_year'=> $month_years,
                'student_ids' => $inserted_student_ids
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => "No demand bill generated. Bills may already exist for this month.",
                'redirect' => false
            ]);
        }
    }catch(Exception $e){
        echo json_encode([
            'success'=>false, 
            'message'=>"Error".$e->getMessage()
        ]);
    }

?>