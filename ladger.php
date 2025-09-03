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
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.3F %.3F %.3F %.3F %.3F %.3F cm', $c, $s, -$s, $c, $cx, $cy));
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

    if(isset($_GET['session']) && isset($_GET['reg'])){
        $session = urldecode($_GET['session']);
        $reg_no = urldecode(($_GET['reg']));
    }else{
        die('Data Not Available');
    }

    $sql = $conn->prepare("
        SELECT 
        tbl_payments.*,
        registration.id,
        registration.reg_no,
        registration.session,
        registration.name,
        registration.mobile,
        registration.fname,
        registration.class,
        registration.section,
        registration.roll,
        registration.session,
        registration.mname
        from tbl_payments 
        INNER JOIN registration
        ON tbl_payments.reg_no = registration.reg_no AND tbl_payments.session = registration.session
        WHERE tbl_payments.session = ? AND tbl_payments.reg_no = ?
    ");
    $sql->bind_param('ss', $session,$reg_no);
    $sql->execute();
    $result = $sql->get_result();
    $data = [];
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
           $data[] = $row;
        }
    }
    if(empty($data)){
         die('⚠️ Data Not Available for this Registration No and Session.');
    }
    $registration_info = $data[0];

    // total amount
    $sql2 = $conn->prepare("SELECT SUM(total) AS total_amount, SUM(paid) AS total_paid, SUM(discount) AS discount_amount, SUM(advance_amount) AS advance_amount FROM tbl_demand WHERE session = ? AND reg_no = ?");
    $sql2->bind_param('ss', $session, $reg_no);
    $sql2->execute();
    $result2 = $sql2->get_result();
    $total_grant = 0;
    $total_discount = 0;
    $total_paid = 0;
    $total_advance = 0; 
    $grant_total = 0;
    
    if ($result2 && $result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $total_grant = $row2['total_amount'] ?? 0;
        $total_paid = $row2['total_paid'] ?? 0;
        $total_discount = $row2['discount_amount'] ?? 0;
        $total_advance = $row2['advance_amount'] ?? 0;
        // $grant_total = $row2['grant_total'] ?? 0;
    }
    $last_dues = $conn->prepare("SELECT id, rest_dues FROM tbl_payments WHERE reg_no = ? AND session = ? ORDER BY id DESC LIMIT 1");
    $last_dues->bind_param('ss', $reg_no, $session);
    $last_dues->execute();
    $rest_due = $last_dues->get_result();
    if($rest_due->num_rows > 0){
        $rest_due_row = $rest_due->fetch_assoc();
    }
    
        $pdf = new PDFWithWatermark('L', 'mm', array(297, 150));
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
        // Set font and text
        $pdf->SetLineWidth(0.1); // border की मोटाई
        $pdf->Rect(5, 5, $pdf->GetPageWidth() - 10, $pdf->GetPageHeight() - 10);

        $logo = 'img/logo.png';
        $pdf->Image($logo, 2, 6, 50, 25);

        $qr_ladger = 'Total Amount : '.$total_grant;
        $qr_file = 'qr_ladger/qr_'.$reg_no.'.png';
        if(!file_exists('qr_ladger')){
            mkdir('qr_ladger');
        }
        QRcode::png($qr_ladger, $qr_file, QR_ECLEVEL_L, 3);
        $pdf->Image($qr_file, 262, 6, 25, 25);

        //title
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(0, 10, strtoupper('KID\'S BLOOMING WORLD SCHOOL'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(10,16);
        $pdf->Cell(0, 10, strtoupper('Pojhiyan, Lalganj Vaishali,Bihar, 844121 (India)'), '0', 1, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(120,23);
        $pdf->SetTextColor(0,0,139);
        $pdf->SetDrawColor(0, 0, 139);
        $pdf->Cell(50, 10, 'STUDENT LADGER', 0, 0, 'C');
        $x = $pdf->GetX() - 44; // starting X of the cell
        $y = $pdf->GetY() + 8; // 10mm below current line
        $pdf->Line($x, $y, $x + 38, $y); // x1, y1, x2, y2

        $pdf->SetXY(120,38);
        $y = $pdf->GetY();
        $pdf->Line(10, $y, 289, $y);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(10,30);
        $pdf->Cell(0, 10, 'SESSION - ', 0, 1, '');
        $pdf->SetXY(30,30);
        $pdf->Cell(0, 10, $session, 0, 1, '');
        $pdf->SetXY(225,30);
        $pdf->Cell(0, 10, 'REGISTRATION NO - ', 0, 1, '');
        $pdf->SetXY(262,30);
        $pdf->Cell(0, 10, $reg_no, 0, 1, '');
        // info here
        $X_AXIS = 10;
        $Y_AXIS = 30;
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY($X_AXIS,$Y_AXIS +=10);
        $pdf->Cell(50, 8, 'Name', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Father', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Mobile', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Class', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Section', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Roll.', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Total', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Advance', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Discount', 1, 0, 'C');
        // $pdf->Cell(20, 8, 'Grand', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Paid', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Dues', 1, 0, 'C');

        $pdf->SetXY($X_AXIS,$Y_AXIS +=8);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 5, strtoupper($registration_info ['name']), 1, 0, 'C');
        $pdf->Cell(50, 5, strtoupper($registration_info ['fname']), 1, 0, 'C');
        $mobile = '';
        if(!empty($registration_info['mobile']) || $registration_info['mobile'] != 0){
            $mobile = $registration_info['mobile'];
        }
        $pdf->Cell(20, 5, $mobile, 1, 0, 'C');
        $pdf->Cell(20, 5, strtoupper($registration_info ['class']), 1, 0, 'C');
        $pdf->Cell(20, 5, strtoupper($registration_info['section']), 1, 0, 'C');
        $roll = '';
        if(!empty($registration_info['roll']) || $registration_info['roll'] != 0){
            $roll = $registration_info['roll'];
        }
        $pdf->Cell(20, 5, $roll, 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_grant, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_advance, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_discount, 2), 1, 0, 'C');
        // $pdf->Cell(20, 5, number_format($grant_total, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_paid, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($rest_due_row['rest_dues'], 2), 1, 0, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY($X_AXIS + 110,$Y_AXIS +=15);
        $pdf->Cell(50, 8, strtoupper('Payment History'), 0, 0, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY($X_AXIS,$Y_AXIS +=8);
        $pdf->Cell(10, 8, 'Sno.', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Invoice No.', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Month', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Total', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Adv. Month', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Adv. Amount', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Disc.', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Grand Total', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Paid', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Dues', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Paid By', 1, 0, 'C');
        
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY($X_AXIS,$Y_AXIS +=8);
        $sno = 1;
        foreach($data as $row){
            $pdf->Cell(10, 5, $sno++, 1, 0, 'C'); // NO line break (0)
            $pdf->Cell(30, 5, $row['invoice_no'], 1, 0, 'C');
            $pdf->Cell(30, 5, $row['month_year'], 1, 0, 'C');
            $pdf->Cell(30, 5, number_format($row['total_amount'], 2), 1, 0, 'C');
            $pdf->Cell(30, 5, $row['no_of_advance_month'], 1, 0, 'C');
            $pdf->Cell(30, 5, number_format($row['advance_amount'], 2), 1, 0, 'C');
            $pdf->Cell(30, 5, number_format($row['discount_amount'], 2), 1, 0, 'C');
            $pdf->Cell(30, 5, number_format($row['grant_total'], 2), 1, 0, 'C');
            $pdf->Cell(20, 5, number_format($row['paid_amount'], 2), 1, 0, 'C');
            $pdf->Cell(20, 5, number_format($row['rest_dues'], 2), 1, 0, 'C');
            $pdf->Cell(20, 5, $row['paid_by'], 1, 1, 'C'); // Line break here (1)
        }

    $pdf->Output('I', 'ladger_' . $reg_no . '.pdf');
?>
