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
    include 'phpqrcode/qrlib.php';
class PDFWithWatermark extends FPDF {
    protected $angle = 0;

    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.3F %.3F %.3F %.3F %.3F %.3F cm',
                $c, $s, -$s, $c, $cx, $cy));
        }
    }

    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}
    //fetch data from database
    if(isset($_GET['reg_no'])){
        $reg_id = $_GET['reg_no'];
        $fetch = $conn->prepare("SELECT * FROM registration WHERE reg_no = ?");
        $fetch->bind_param('s', $reg_id);
        $fetch->execute();
        $result = $fetch->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
        }else{
            header("Location:registration");
            exit;
        }
    }
    if(!empty($row['image'])){
        $image = 'sql/students/'.$row['image'];
    }else{
        $image = 'img/office-man.png';
    }
    $pdf = new PDFWithWatermark();
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
     $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetTextColor(220, 220, 220); // Light gray
    $pdf->RotatedText(80, 213, 'KID\'S BLOOMING WORLD SCHOOL', 45); // ✅ Now this works
    $pdf->SetLineWidth(0.8); // Border thickness (3px)
    $pdf->SetDrawColor(0, 0, 0); // Black


    // Apply half-page border
    $pdf->Rect(
        10,                      // X (left margin)
        10,                      // Y (top margin)
        $pdf->GetPageWidth() - 20,  // Width (full width minus margins)
        ($pdf->GetPageHeight() / 2.4) - 10 // Half height - 10mm bottom padding
    );

    // Set font and text
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(0, 10, strtoupper('KID\'S BLOOMING WORLD SCHOOL'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(10,16);
    $pdf->Cell(0, 10, strtoupper('Pojhiyan, Lalganj Vaishali,Bihar, 844121 (India)'), '0', 1, 'C');

    $pdf->SetXY(15,26);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(50, 10, 'Serial Number'.' '.':', 0, 0);
    $pdf->SetXY(40,26);
    $pdf->Cell(50, 10, '0'.$row['id'], 0, 1);
    
    $pdf->SetXY(165,26);
    $pdf->Cell(50, 10, 'Date'.' '. ':', 0, 0);

    $pdf->SetXY(177,26);
    $date = date('d-m-Y');
    $pdf->Cell(50, 10, $date, 0, 0);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(85,35);
    $pdf->SetTextColor(0,0,139);
    $pdf->SetDrawColor(0, 0, 139);
    $pdf->Cell(50, 10, 'REGISTRATION RECIEVED', 0, 0, 'C');
    $x = $pdf->GetX() - 50; // starting X of the cell
    $y = $pdf->GetY() + 8; // 10mm below current line
    $pdf->Line($x-2, $y, $x + 52, $y); // x1, y1, x2, y2

    $pdf->SetLineWidth(0.4);
    $pdf->SetDrawColor(169, 169, 169); // Light gray
    $pdf->Rect(12, 45, 185, 55); // x, y, w, h
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(15,45);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(26, 10, 'Registration No.'. ' '.':', 0, 0,);
    $pdf->SetXY(45,45);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, $row['reg_no'], 0, 0,);

    $pdf->SetXY(130,45);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, 'Registration Date.'. ' '.':', 0, 0,);
    $pdf->SetXY(158,45);
    $pdf->SetFont('Arial', 'B', 9);
    $date = new DateTime($row['registration_date']);
    $org_date = $date->format('d-m-Y h:i:s A');
    $pdf->Cell(26, 10, $org_date, 0, 0,);

    $x_axis = 15;
    $y_axis = 55;
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY($x_axis,$y_axis);
    $pdf->Cell(26, 10, 'Name'.' '. ':', 0, 0,);
    $pdf->SetXY(45,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, strtoupper($row['name']), 0, 0,);

    $pdf->SetXY($x_axis,$y_axis+=7);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Father's Name".' '. ':', 0, 0,);
    $pdf->SetXY(45,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, strtoupper($row['fname']), 0, 0,);

    $pdf->SetXY(15,$y_axis+=7);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Mobile".' '. ':', 0, 0,);
    $pdf->SetXY(45,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, $row['mobile'], 0, 0,);

    $pdf->SetXY(15,$y_axis+=7);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Class".' '. ':', 0, 0,);
    $pdf->SetXY(45,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, strtoupper($row['class']), 0, 0,);

    $pdf->SetXY(90,$y_axis);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Gender".' '. ':', 0, 0,);
    $pdf->SetXY(105,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, strtoupper($row['gender']), 0, 0,);

    $pdf->SetXY(15,$y_axis+=7);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Registration Fee".' '. ':', 0, 0,);
    $pdf->SetXY(45,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, 'INR.'. ' '.number_format($row['registration_fee'], 2), 0, 0,);

    $pdf->SetXY(90,$y_axis);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Session".' '. ':', 0, 0,);
    $pdf->SetXY(105,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(26, 10, $row['session'], 0, 0,);

    $pdf->SetXY(167,$y_axis);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Status".' '. ':', 0, 0,);
    $pdf->SetXY(180,$y_axis);
    $pdf->SetFont('Arial', 'B', 9);
    if($row['status'] == 0 || $row['status'] == 1){
        $status = 'Success';
    }else{
        $status = 'Fail';
    }
    $pdf->Cell(26, 10, $status, 0, 0,);

    $pdf->SetXY(170,$y_axis+=30);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "Signature".' '. ':', 0, 0,);
    // image
    $pdf->SetXY(180,$y_axis);
    $pdf->Image($image, 170,55,23, 25);

    // QR code
    
    $qr_text = 'Reg ID: '.$row['reg_no'].', Name: '.strtoupper($row['name']);
    $qr_file = 'reg_qr/qr_'.$row['reg_no'].'.png';
    if(!file_exists('reg_qr')){
         mkdir('reg_qr');
    }
    QRcode::png($qr_text, $qr_file, QR_ECLEVEL_L, 3);

    $pdf->Image($qr_file, 13, $y_axis - 12, 20, 20); // X, Y, Width, Height
    $pdf->SetXY(14,$y_axis + 3);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(26, 10, "If you scan this QRcode then your details will be visible.", 0, 0,);
    // Output PDF
    $pdf->Output('I', $row['reg_no'].'.pdf');
?>