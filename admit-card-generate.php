<?php
    date_default_timezone_set('Asia/Kolkata');
    require __DIR__ . '/api/login/check_auth.php';
    require __DIR__ . '/api/login/auth.php';

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");
    $claims = require_auth();

    include 'sql/config.php';
    include 'title.php';

    require_once('./fpdf/fpdf.php');
    require_once('./FPDI/src/autoload.php');
    include './phpqrcode/qrlib.php';
    use setasign\Fpdi\Fpdi;

    if(isset($_GET['exam_id']) && isset($_GET['session']) && isset($_GET['class'])){
        $exam_id = $_GET['exam_id'];
        $session = $_GET['session'];
        $class   = $_GET['class'];
        $section = $_GET['section'] ?? null;
    }

    $sql = $conn->prepare("
        SELECT r.reg_no, r.session, r.name, r.class, r.fname, r.mname, r.section, r.roll, e.exam_type
        FROM summative_assessment01 s
        INNER JOIN exam_type e ON s.exam_id = e.id
        INNER JOIN registration r ON s.reg_no = r.reg_no AND s.session = r.session
        WHERE s.exam_id = ? AND s.session = ? AND r.class = ? AND r.status = 1
        " . ($section && $section !== "all" ? " AND r.section = ?" : "")
    );
    if($section && $section !== "all"){
        $sql->bind_param('isss', $exam_id, $session, $class, $section);
    }else{
        $sql->bind_param('iss', $exam_id, $session, $class);
    }
    $sql->execute();
    $result = $sql->get_result();
    $students = [];
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $students[] = $row;
        }
    }else{
        header('Location:index');
        exit;
    }

    $pdf = new Fpdi();
    $pdf->SetAutoPageBreak(false);
    // $pageCount = $pdf->setSourceFile(__DIR__ . "/pdf/rnmsadmitcard2025.pdf");
    $pageCount = $pdf->setSourceFile(__DIR__ . "/pdf/rnmsadmitcard2025.pdf");
    $tplId = $pdf->importPage(1);
    $size = $pdf->getTemplateSize($tplId);

    foreach($students as $student){
        $regNo = $student['reg_no'];
        // Add new page with same size
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        // Place the imported page
        $pdf->useTemplate($tplId);
        $X_AXIS = 50;
        $Y_AXIS = 43;
        // $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0, 0, 0); // Light gray
        // $pdf->SetXY($X_AXIS, $Y_AXIS - 10);
        $pdf->Cell(0, 58, strtoupper('[ '.$student['exam_type'].' - '.date('Y').' ]'), 0, 1,'C');
        $pdf->SetXY($X_AXIS + 133, $Y_AXIS + 6);
        $pdf->Cell(0, 10, 'Photo', 0, 1);
        $pdf->SetXY($X_AXIS, $Y_AXIS);
        $pdf->Cell(0, 10, strtoupper($student['name']), 0, 1);
        $pdf->SetXY($X_AXIS + 90, $Y_AXIS);
        $pdf->Cell(0, 10, strtoupper($student['class']), 0, 1);

        $pdf->SetXY($X_AXIS, $Y_AXIS += 5);
        $pdf->Cell(0, 10, strtoupper($student['fname']), 0, 1);

        if(!empty($student['section']) && $student['section'] != 0){
            $pdf->SetXY($X_AXIS + 90, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper($student['section']), 0, 1);
        }
        $pdf->SetXY($X_AXIS, $Y_AXIS += 5);
        if(!empty($student['mname']) && $student['mname'] != 0){
            $pdf->Cell(0, 10, strtoupper($student['mname']), 0, 1);
        }
        $pdf->SetXY($X_AXIS, $Y_AXIS += 6);
        $pdf->Cell(0, 10, $student['session'], 0, 1);
        
        $pdf->SetXY($X_AXIS - 15, $Y_AXIS += 7);
        if(!empty($student['roll']) && $student['roll'] != 0){
            $pdf->Cell(0, 10, $student['roll'], 0, 1);
        }
        $pdf->SetXY($X_AXIS + 47, $Y_AXIS);
        $pdf->Cell(0, 10, $student['reg_no'], 0, 1);

        $X_AXIS = 10;
        $Y_AXIS = 90;
        $class = strtoupper(trim($student['class']));
        $class = str_replace(' ', '', $class);
        if(in_array($class, ['PLAY','KG1','KG2'])){
            $pdf->SetXY($X_AXIS, $Y_AXIS);
            $pdf->Cell(0, 10, "23-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("HINDI"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "24-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("ENGLISH"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "25-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("MATH"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "26-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("DRAWING"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);

        }else if(in_array($class, ['LKG','UKG'])){
            $pdf->SetXY($X_AXIS, $Y_AXIS);
            $pdf->Cell(0, 10, "23-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("HINDI"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "24-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("ENGLISH"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("EVS"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "25-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("MATH"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "26-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("DRAWING"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);
        }else if(in_array($class, ['1','2','3','4','5','6','7','8'])){
            $pdf->SetXY($X_AXIS, $Y_AXIS);
            $pdf->Cell(0, 10, "23-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("HINDI"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("MATHS"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "24-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("ENGLISH"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("SCIENCE"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "25-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("SOCIAL STUDIES"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("G.K"), 0, 1);

            $pdf->SetXY($X_AXIS, $Y_AXIS +=9);
            $pdf->Cell(0, 10, "26-09-2025", 'B', 0, 1);
            $pdf->SetXY($X_AXIS + 43, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("COMPUTER"), 0, 1);
            $pdf->SetXY($X_AXIS + 113, $Y_AXIS);
            $pdf->Cell(0, 10, strtoupper("_____"), 0, 1);
        }

        $sign = 'img/sign.png';
        if(file_exists($sign)){
            $pdf->Image($sign, 155, 128, 20, 15);
        }
    }

    // Output PDF
    $pdf->Output('I', 'Admit_Cards'.'.pdf');
?>