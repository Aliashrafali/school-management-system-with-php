<?php
    date_default_timezone_set('Asia/Kolkata');
    include '../../sql/config.php';
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    try {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'success' => false,
                'message' => 'Only POST Methode Allowed'
            ]);
            exit;
        }
        if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']){
            echo json_encode(['success' => false, 'message' => 'Invalid Tokens']);
            exit;
        }
        $class = $_POST['class'] ?? '';
        $section = $_POST['section'] ?? '';
        $session = $_POST['session'] ?? '';
        $exam_type = $_POST['exam_type'] ?? '';
        $dateandtime = date('Y-m-d H:i:s');
        $status = 1;

        if (empty($class) || empty($session) || empty($exam_type)) {
            echo json_encode([
                'success' => false,
                'message' => 'Class, Session Exam Type are compulsary !'
            ]);
            exit;
        }
        
        $examtype = $conn->prepare("SELECT * FROM exam_type WHERE exam_type = ? AND session = ?");
        $examtype->bind_param('ss', $exam_type,$session);
        $examtype->execute();
        $getExam = $examtype->get_result();
        if($getExam->num_rows > 0){
            $row = $getExam->fetch_assoc();
            $exam_id = $row['id'];
        }else{
            $insertExam = $conn->prepare("INSERT INTO exam_type(exam_type,session,date_time,status)VALUES(?, ?, ? ,?)");
            $insertExam->bind_param('sssi',$exam_type,$session,$dateandtime,$status);
            $insertExam->execute();
            $exam_id = $insertExam->insert_id;
        }

        $sql = "SELECT reg_no, class, session FROM registration WHERE class = ? AND session = ?";
        $params = [$class, $session];
        $types = "ss";
        if (!empty($section) && $section !== "all") {
            $sql .= " AND section = ?";
            $params[] = $section;
            $types .= "s";
        }
        $std = $conn->prepare($sql);
        $std->bind_param($types, ...$params);
        $std->execute();
        $stdresult = $std->get_result();
        if($stdresult === false || $stdresult->num_rows === 0){
            echo json_encode([
                'success' => false,
                'message' => 'Records Not Found'
            ]);
            exit;
        }

        // existing admit cards check
        $checkSql = "
            SELECT sa.id 
            FROM summative_assessment01 sa
            INNER JOIN registration r ON sa.reg_no = r.reg_no
            WHERE sa.class = ? AND sa.session = ? AND sa.exam_id = ?";
        $checkParams = [$class, $session, $exam_id];
        $checkTypes = "ssi";

        if (!empty($section) && $section !== "all") {
            $checkSql .= " AND section = ?";
            $checkParams[] = $section;
            $checkTypes .= "s";
        }

        $check = $conn->prepare($checkSql);
        $check->bind_param($checkTypes, ...$checkParams);
        $check->execute();
        $existing = $check->get_result();

        if($existing->num_rows > 0){
            // Already generated -> Direct redirect
            echo json_encode([
                'success' => true,
                'message' => "Admit Cards Already Generated. Opening PDF...",
                'exam_id' => $exam_id,
                'session' => $session,
                'class'   => $class,
                'section' => $section,
                'redirect' => "admit-card-generate?exam_id={$exam_id}&session={$session}&class={$class}&section={$section}"
            ]);
            exit;
        }

        $insert = $conn->prepare("
            INSERT IGNORE INTO summative_assessment01
            (reg_no, class, session, exam_id, date_time, status)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $countInserted = 0;
        while ($row = $stdresult->fetch_assoc()) {
            $insert->bind_param(
                "sssisi",
                $row['reg_no'],
                $row['class'],
                $row['session'],
                $exam_id,
                $dateandtime,
                $status
        );
        if ($insert->execute() && $insert->affected_rows > 0) {
            $countInserted++;
        }
    }
    if($countInserted > 0){
        echo json_encode([
            'success' => true,
            'message' => "{$countInserted} Admit Card Generated. Please Download.",
            'exam_id' => $exam_id,
            'session' => $session,
            'class'   => $class,
            'section' => $section,
            'redirect' => "admit-card-generate.php?exam_id={$exam_id}&session={$session}&class={$class}&section={$section}"
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'message' => "Admit Cards Already Generated ?"
        ]);
    }
    exit;
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'error'.$e->getMessage()
        ]);
        exit;
    }

?>