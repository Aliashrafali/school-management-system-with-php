<?php
include 'sql/config.php';
include 'title.php';
session_start();
require_once('./fpdf/fpdf.php');
require_once('./FPDI/src/autoload.php');

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
    $sql2 = $conn->prepare("SELECT SUM(total_amount) AS total_amount, SUM(paid_amount) AS total_paid, SUM(discount_amount) AS discount_amount, SUM(advance_amount) AS advance_amount, SUM(grant_total) AS grant_total FROM tbl_payments WHERE session = ? AND reg_no = ?");
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
        $grant_total = $row2['grant_total'] ?? 0;
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
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(10,10);
        $pdf->Cell(0, 10, 'Session - ', 0, 1, '');
        $pdf->SetXY(35,10);
        $pdf->Cell(0, 10, $session, 0, 1, '');
        $pdf->SetXY(210,10);
        $pdf->Cell(0, 10, 'Registration No - ', 0, 1, '');
        $pdf->SetXY(251,10);
        $pdf->Cell(0, 10, $reg_no, 0, 1, '');
        $y = $pdf->GetY();
        $pdf->Line(10, $y, 230, $y);

        // info here
        $X_AXIS = 10;
        $Y_AXIS = 10;
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY($X_AXIS,$Y_AXIS +=10);
        $pdf->Cell(40, 8, 'Name', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Father', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Mobile', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Class', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Section', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Roll.', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Total', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Advance', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Discount', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Grand', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Paid', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Dues', 1, 0, 'C');

        $pdf->SetXY($X_AXIS,$Y_AXIS +=8);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(40, 5, strtoupper($registration_info ['name']), 1, 0, 'C');
        $pdf->Cell(40, 5, strtoupper($registration_info ['fname']), 1, 0, 'C');
        $pdf->Cell(20, 5, $registration_info ['mobile'], 1, 0, 'C');
        $pdf->Cell(20, 5, strtoupper($registration_info ['class']), 1, 0, 'C');
        $pdf->Cell(20, 5, strtoupper($registration_info['section']), 1, 0, 'C');
        $pdf->Cell(20, 5, strtoupper($registration_info['roll']), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_grant, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_advance, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_discount, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($grant_total, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($total_paid, 2), 1, 0, 'C');
        $pdf->Cell(20, 5, number_format($rest_due_row['rest_dues'], 2), 1, 0, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY($X_AXIS + 90,$Y_AXIS +=15);
        $pdf->Cell(50, 8, 'Payment History', 0, 0, 'C');
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
