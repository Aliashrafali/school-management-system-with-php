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

    // Get data
    $invoice_no = $_GET['invoice_no'] ?? '';
    $sql = $conn->prepare("SELECT p.*, r.name,r.fname,r.reg_no,r.mobile,r.class,r.section,r.roll,r.session FROM tbl_payments p JOIN registration r ON p.student_id = r.id WHERE invoice_no = ?");
    $sql->bind_param('s', $invoice_no);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    $pdf = new PDFWithWatermark();
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    // $pdf->SetFillColor(249,182,197); // RGB
    // $pdf->Rect(0, 0, 210, 297, 'F');

function generateReceipt($pdf, $row, $yShift = 0, $copyType = 'SCHOOL COPY') {
    // Draw Border
    $pdf->Rect(10, 10 + $yShift, $pdf->GetPageWidth() - 20, ($pdf->GetPageHeight() / 2.4) - 10);
    
    $image = 'img/logo.png';
    $pdf->Image($image, 10, $yShift + 12, 40, 20);

     // QR code    
    $qr_paymentrecieved = 'Paid Amount : '.$row['total_amount'];
    $qr_file = 'qr_paymentrecieved/qr_'.$row['invoice_no'].'.png';
    if(!file_exists('qr_paymentrecieved')){
         mkdir('qr_paymentrecieved');
    }
    QRcode::png($qr_paymentrecieved, $qr_file, QR_ECLEVEL_L, 3);
    $pdf->Image($qr_file, 173, $yShift + 12, 20, 20);

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(10, 10 + $yShift);
    $pdf->Cell(0, 10, strtoupper('Kid\'s Blooming World School'), 0, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(10, 16 + $yShift);
    $pdf->Cell(0, 10, strtoupper('Pojhiyan, Lalganj Vaishali,Bihar, 844121 (India)'), 0, 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(81, 23 + $yShift);
    $pdf->SetTextColor(0, 0, 139);
    $pdf->Cell(50, 10, 'PAYMENT RECEIPT', 0, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Line(10, 33 + $yShift, 200, 33 + $yShift);
    $pdf->Ln(5);

    // Header Info
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(10, 36 + $yShift);
    $pdf->Cell(30, 6, 'Invoice Number :', 0, 0);
    $pdf->Cell(40, 6, $row['invoice_no'], 0, 0);

    $pdf->SetXY(80, 36 + $yShift);
    $pdf->Cell(20, 6, 'Reg. No. :', 0, 0);
    $pdf->Cell(30, 6, $row['reg_no'], 0, 0);

    $pdf->SetXY(145, 36 + $yShift);
    $pdf->Cell(15, 6, 'Date :', 0, 0);
    $formattedDate = date('d-m-Y h:i:s A', strtotime($row['date_and_time']));
    $pdf->Cell(40, 6, $formattedDate, 0, 1);

    // Student Info Box
    $startX = 10;
    $startY = 45 + $yShift;
    $leftWidth = 120;
    $rightWidth = 70;
    $boxHeight = 30;

    $pdf->Rect($startX, $startY, $leftWidth, $boxHeight);
    $pdf->Rect($startX + $leftWidth, $startY, $rightWidth, $boxHeight);
    $pdf->SetFont('Arial', '', 10);

    $pdf->SetXY($startX + 2, $startY + 2);
    $pdf->Cell(30, 6, "Name:", 0, 0);
    $pdf->Cell(70, 6, ucwords(strtolower($row['name'])), 0, 1);

    $pdf->SetX($startX + 2);
    $pdf->Cell(30, 6, "Father's Name:", 0, 0);
    $pdf->Cell(70, 6, ucwords(strtolower($row['fname'])), 0, 1);

    $pdf->SetX($startX + 2);
    $pdf->Cell(30, 6, "Mobile No.:", 0, 0);
    $pdf->Cell(70, 6, '+91-' . $row['mobile'], 0, 1);

    $pdf->SetX($startX + 2);
    $pdf->Cell(30, 6, "Payment Of:", 0, 0);
    $pdf->Cell(70, 6, $row['month_year'], 0, 1);

    $pdf->SetXY($startX + $leftWidth + 2, $startY + 2);
    $pdf->Cell(25, 6, "Class:", 0, 0);
    $pdf->Cell(40, 6, strtoupper($row['class']), 0, 1);

    $pdf->SetX($startX + $leftWidth + 2);
    $pdf->Cell(25, 6, "Roll No.:", 0, 0);
    $pdf->Cell(40, 6, $row['roll'], 0, 1);

    $pdf->SetX($startX + $leftWidth + 2);
    $pdf->Cell(25, 6, "Section:", 0, 0);
    $pdf->Cell(40, 6, $row['section'], 0, 1);

    $pdf->SetX($startX + $leftWidth + 2);
    $pdf->Cell(25, 6, "Session:", 0, 0);
    $pdf->Cell(40, 6, $row['session'], 0, 1);

    // Amount section
    $y_axis = 75 + $yShift;
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetXY(10, $y_axis);
    $pdf->Cell(120, 7, 'Particulars:', 1, 0);
    $pdf->Cell(70, 7, 'Amount:', 1, 1);
    $pdf->SetFont('Arial', '', 9);

    $pdf->SetX(10);
    $pdf->Cell(120, 7, 'Total Amount:', 1, 0);
    $pdf->Cell(70, 7, number_format($row['total_amount'], 2), 1, 1);

    if ($row['advance_amount'] !== 0 || !empty($row['advance_amount'])) {
        $pdf->Cell(120, 7, 'Advance Amount:', 1, 0);
        $pdf->Cell(70, 7, number_format($row['advance_amount'], 2), 1, 1);
    }

    if(!empty($row['discount_amount']) || $row['discount_amount'] !== 0){
        $pdf->Cell(120, 7, 'Discount Amount:', 1, 0);
        $pdf->Cell(70, 7, number_format($row['discount_amount'], decimals: 2), 1, 1);
    }

    $pdf->Cell(120, 7, 'Paid Amount:', 1, 0);
    $pdf->Cell(70, 7, number_format($row['paid_amount'], 2), 1, 1);

    $pdf->Cell(120, 7, 'Rest Dues:', 1, 0);
    $pdf->Cell(70, 7, number_format($row['rest_dues'], 2), 1, 1);


    // Payment Mode Box
    $startY = 103 + $yShift;
    if(!empty($row['advance_amount']) || !empty($row['discount_amount'])){
        $boxHeight = 30;
    }else{
        $boxHeight = 21;
    }
    
    $pdf->Rect($startX, $startY, $leftWidth, $boxHeight);
    $pdf->Rect($startX + $leftWidth, $startY, $rightWidth, $boxHeight);
    $pdf->SetFont('Arial', '', 10);
    if(!empty($row['advance_amount']) || !empty($row['discount_amount'])){
        $pdf->SetXY($startX, $startY + 8);
    }else{
        $pdf->SetXY($startX, $startY + 2);
    }
    
    $pdf->Cell(30, 6, "Payment By :", 0, 0);
    $pdf->Cell(70, 6, strtoupper($row['paid_by']), 0, 1);

    $pdf->SetX($startX);
    if ($row['paid_by'] == 'cash') {
        $pdf->Cell(30, 6, "Reference :", 0, 0);
        $pdf->Cell(70, 6, ucwords(strtolower($row['payment_by'])), 0, 1);
    } else if ($row['paid_by'] == 'online') {
        $pdf->Cell(30, 6, "Transaction ID :", 0, 0);
        $pdf->Cell(70, 6, $row['transaction_id'], 0, 1);
    } else if ($row['paid_by'] == 'check') {
        $pdf->Cell(30, 6, "Check No :", 0, 0);
        $pdf->Cell(70, 6, $row['check_no'], 0, 1);
    }

    $pdf->SetX($startX);
    if(!empty($row['advance_amount']) || !empty($row['discount_amount'])){
        $pdf->Cell(30, 10, "Payment Status:", 0, 0);
    }else{
        $pdf->Cell(30, 6, "Payment Status:", 0, 0);
    }
    if ($row['rest_dues'] == 0) {
        $pdf->SetTextColor(0, 128, 0);
        $status = "Full Paid";
    } else if ($row['rest_dues'] > 0) {
        $pdf->SetTextColor(255, 165, 0);
        $status = "Partial Paid";
    } else {
        $pdf->SetTextColor(0, 0, 255);
        $status = "Advanced Paid";
    }
    if(!empty($row['advance_amount']) || !empty($row['discount_amount'])){
        $pdf->Cell(70, 10, $status, 0, 1);
    }else{
        $pdf->Cell(70, 6, $status, 0, 1);
    }
    
    $pdf->SetTextColor(0, 0, 0);

    // Type of Copy
    if(!empty($row['advance_amount']) || !empty($row['discount_amount'])){
        $pdf->SetXY($startX + 90, $startY + 16);
        $pdf->Cell(30, 3, "TYPE", 0, 0);
        $pdf->SetXY($startX + 83, $startY + 24);
        $pdf->Cell(30, 3, $copyType, 0, 0);
    }else{
        $pdf->SetXY($startX + 90, $startY + 4);
        $pdf->Cell(30, 3, "TYPE", 0, 0);
        $pdf->SetXY($startX + 83, $startY + 10);
        $pdf->Cell(30, 3, $copyType, 0, 0);
    }

    if(!empty($row['advance_amount']) || !empty($row['discount_amount'])){
        $pdf->SetXY($startX + $leftWidth + 25, $startY + 22);
    }else{
        $pdf->SetXY($startX + $leftWidth + 25, $startY + 12);
    }
    
    $pdf->Cell(25, 6, "Signature:", 0, 0);

}
$filename = 'receipt_' . $row['reg_no'] . '.pdf';
// Call the receipt generation twice with Y offset
generateReceipt($pdf, $row, 0, 'SCHOOL COPY');
generateReceipt($pdf, $row, 135, 'STUDENT COPY');

$pdf->Output('I', $filename);
?>
