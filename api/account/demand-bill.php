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
        $month = date('n'); // numeric month (1 to 12)
        $year = date('Y');
        if($month >= 4){
            $current_session = $year . '-' . substr($year + 1, -2);
        }else{
             $current_session = ($year - 1) . '-' . substr($year, -2);
        }
        // $current_year = date('Y');
        // $next_year = $current_year + 1;
        // $current_session = $current_year . '-' . substr($next_year, -2);

        if(empty($class) || empty($section)){
            echo json_encode([
                'success' => false,
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
            $student_query = $conn->prepare("SELECT id, reg_no, session FROM registration WHERE class = ? AND section = ? AND session = ?");
            $student_query->bind_param('sss', $class,$section, $current_session);
        }else{
            $student_query = $conn->prepare("SELECT id, reg_no, session FROM registration WHERE class = ? AND session = ?");
            $student_query->bind_param('ss', $class, $current_session);
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
        $tbl_fee = $conn->prepare("SELECT session, tution_fee,transport_and_other_fee,month_year FROM tbl_fees WHERE reg_no = ? AND student_id = ? AND session = ?");
        
        $demand_insert = $conn->prepare("INSERT INTO tbl_demand(student_id,reg_no,session,tution_fee,transport_and_other_fee,other_fee,total,month_year,date_and_time,status)VALUES(?,?,?,?,?,?,?,?,?,?)");

        $inserted = 0;
        $inserted_student_ids = [];
        while($student = $students->fetch_assoc()){
            $student_id = $student['id'];
            $reg_no = $student['reg_no'];

            // get admission date
            $admission = $conn->prepare("SELECT month_year FROM tbl_fees WHERE student_id = ? AND reg_no = ? AND session = ?");
            $admission->bind_param('iss', $student_id,$reg_no, $current_session);
            $admission->execute();
            $admision_result = $admission->get_result();
            $admission_date = '';
            if($admision_result->num_rows > 0){
                $admission_row = $admision_result->fetch_assoc();
                $admission_date = $admission_row['month_year'];
            }

            // get last dues from tbl_demand
            $check_last = $conn->prepare("SELECT month_year, advance_amount, rest_dues, paid, total FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND session = ? ORDER BY id DESC LIMIT 1");
            $check_last->bind_param('iss', $student_id, $reg_no, $current_session);
            $check_last->execute();
            $check_result = $check_last->get_result();

            $last_due = 0;
            $paid = 0;
            $advance_amount = 0;
            $previous_total = 0;
            if($check_result->num_rows > 0){
                $last_demand = $check_result->fetch_assoc();
                $last_month = $last_demand['month_year'];
                $last_due = floatval($last_demand['rest_dues'] ?? '');
                $paid = floatval($last_demand['paid'] ?? '');
                $advance_amount = floatval($last_demand['advance_amount'] ?? '');
                $previous_total = floatval($last_demand['total'] ?? 0); 
                
                $month_years = date('F Y', strtotime($last_month . "+1 month"));
            }else{
                if(!empty($admission_date)){
                    $month_years = date('F Y', strtotime($admission_date));
                }else{
                    $month_years = date('F Y');
                }
            }

            // get fee
            $tbl_fee->bind_param('sis', $reg_no,$student_id, $current_session);
            $tbl_fee->execute();
            $result_fee = $tbl_fee->get_result();
            
            if($result_fee->num_rows > 0){
                $fee_row = $result_fee->fetch_assoc();
                $tution_fee = floatval($fee_row['tution_fee']);
                $transport_and_other_fee = floatval($fee_row['transport_and_other_fee']);
                $total = $tution_fee + $transport_and_other_fee + $other_total;
                $fee_month_year = $fee_row['month_year'];
                $current_month_year = date('F Y');
                if($fee_month_year === $current_month_year){
                    continue;
                }
                $current_month = date('Y-m');
                $already_cut = $conn->prepare(" SELECT id FROM tbl_demand WHERE student_id = ? AND reg_no = ? AND session = ? AND DATE_FORMAT(date_and_time, '%Y-%m') = ?");
                $already_cut->bind_param('isss', $student_id, $reg_no, $current_session, $current_month);
                $already_cut->execute();
                $cut_result = $already_cut->get_result();
                if ($cut_result->num_rows > 0) {
                    continue;
                }

                // final fee
                $final_other_fee = $fees_details;
                $adjusted_advance = 0;
                $adjusted_due = 0;
               if ($last_due > 0) {
                    $total += $last_due;
                    $adjusted_due = $last_due;
                    $final_other_fee .= ($final_other_fee ? ', ' : '') . 'Previous Due ' . $adjusted_due;

                } elseif ($last_due == 0 && $paid == 0 && $previous_total > 0) {
                    // no payment done, so last month's full total becomes due
                    $total += $previous_total;
                    $adjusted_due = $previous_total;
                    $final_other_fee .= ($final_other_fee ? ', ' : '') . 'Previous Due ' . $adjusted_due;
                } 

                if ($advance_amount > 0 && $last_due < 0) {
                    // Negative due means advance exists, reduce total
                    $adjustable = min($advance_amount, abs($last_due));
                    $total -= $adjustable;
                    $adjusted_advance = $adjustable;
                    $final_other_fee .= ($final_other_fee ? ', ' : '') . 'Advance Amount ' . $adjusted_advance;
                }
                
                $demand_insert->bind_param(
                    "issddsissi",
                    $student_id,
                    $reg_no,
                    $current_session,
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
            exit;
        }else{
            echo json_encode([
                'success' => false,
                'message' => "No demand bill generated. Bills may already exist for this month.",
                'redirect' => false
            ]);
            exit;
        }
    }catch(Exception $e){
        echo json_encode([
            'success'=>false, 
            'message'=>"Error".$e->getMessage()
        ]);
    }
?>