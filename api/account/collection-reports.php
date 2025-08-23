<?php
    date_default_timezone_set('Asia/Kolkata');
    session_start();
    include '../../sql/config.php';

    try{
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message' => 'Only POST Method Allowed'
            ]);
            exit;
        }
        $input = $_POST;
        if(!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']){
            echo json_encode([
                'success' => false,
                'message' => 'Invalid Tokens'
            ]);
            exit;
        }

        $class = trim($input['class'] ?? '');
        $section = trim($input['section'] ?? '');
        $month = $input['month'] ?? '';
        $session = $input['session'] ?? '';

        if($class == 'all' AND $section == 'all' AND $session == 'all' AND $month == 'all'){
            $sql = $conn->query("SELECT reg_no FROM registration");

            $data = [];
            while($row = $sql->fetch_assoc()){
                $data[] = $row['reg_no'];
            }

            if(count($data) > 0){
                $in = "'" . implode("','", $data) . "'";
                $payment = $conn->query("SELECT * FROM tbl_payments WHERE reg_no IN ($in)");

                if($payment->num_rows > 0){
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=paid_payments.xls");

                    echo "Registration_no\tMonth Years\tSession\tInvoice No\tPaid Amount\tPaid By\n";
                    $totalPaidAmount = 0;
                    while($row = $payment->fetch_assoc()){
                        echo $row['reg_no'] . "\t".
                             $row['month_year']."\t".
                             $row['session']. "\t",
                             $row['invoice_no'] . "\t".
                             $row['paid_amount'] . "\t".
                             $row['paid_by'] . "\n";
                        $totalPaidAmount+= (float)$row['paid_amount'];
                    }
                    echo "\t\t\t\n\t\t\tTotal\t" . $totalPaidAmount . "\n";
                    exit;
                    
                }else{
                     echo "No paid payments found!";
                }
            }else{
                echo "No registrations found!";
            }
        }



    }catch(Exception $e){
        echo json_encode([
            'success' => false,
            'message' => 'Error'.$e->getMessage()
        ]);
    }
?>