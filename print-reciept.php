<?php
    include 'sql/config.php';
    include 'title.php';
    session_start();
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

    // get invoice_id
    $invoice_no = $_GET['invoice_no'] ?? '';
    
    $sql = $conn->prepare("
        SELECT p.*, r.name,r.fname,r.reg_no,r.mobile,r.class,r.section,r.roll,r.session
        FROM tbl_payments p JOIN registration r ON p.student_id = r.id WHERE invoice_no = ?
    ");
    $sql->bind_param('s', $invoice_no);
    $sql->execute();
    $result = $sql->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }
    
    $pdf = new PDFWithWatermark();
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();

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
    $pdf->Cell(0, 10, strtoupper('RN Mission Public School'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(10,16);
    $pdf->Cell(0, 10, strtoupper('Mujauna bazar, Parsa(Saran)'), '0', 1, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetXY(85,23);
    $pdf->SetTextColor(0,0,139);
    $pdf->SetDrawColor(0, 0, 139);
    $pdf->Cell(50, 10, 'PAYMENT RECEIPT', 0, 0, 'C');
    $x = $pdf->GetX() - 50; // starting X of the cell
    $y = $pdf->GetY() + 8; // 10mm below current line
    $pdf->Line($x+8, $y, $x + 41, $y); // x1, y1, x2, y2
    // Get current Y position and draw the line
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0, 0, 0);
    $y = $pdf->GetY(); // position after title
    $pdf->Line(10, $y + 10, 200, $y + 10); // horizontal line across the page (10 to 200)

    // Add a little vertical spacing after the line
    $pdf->Ln(5);

    $pdf->SetXY(15,33);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(50, 10, 'Invoice Number'.' '.':', 0, 0);
    $pdf->SetXY(40,33);
    $pdf->Cell(50, 10, $row['invoice_no'], 0, 1);
    
    $pdf->SetXY(85,33);
    $pdf->Cell(50, 10, 'Reg. No.'.' '.':', 0, 0);
    $pdf->SetXY(104,33);
    $pdf->Cell(50, 10, $row['reg_no'], 0, 1);
    
    $pdf->SetXY(165,33);
    $pdf->Cell(50, 10, 'Date'.' '. ':', 0, 0);

    $pdf->SetXY(177,33);
    $date = date('d-m-Y');
    $pdf->Cell(50, 10, $date, 0, 0);

    $x_axis = 15;
    $y_axis = 33;

    $pdf->SetXY($x_axis,$y_axis += 10);
    $pdf->Cell(50, 10, 'Name'.' '. ':', 0, 0);

    $pdf->SetXY($x_axis+25,$y_axis);
    $pdf->Cell(50, 10, ucwords(strtolower($row['name'])), 0, 0);

    $pdf->SetXY($x_axis,$y_axis += 8);
    $pdf->Cell(50, 10, "Father's Name"." ".":", 0, 0);

    $pdf->SetXY($x_axis + 25,$y_axis);
    $pdf->Cell(50, 10, ucwords(strtolower($row['fname'])), 0, 0);

    $pdf->SetXY($x_axis,$y_axis += 8);
    $pdf->Cell(50, 10, 'Mobile No.'.' '.':', 0, 0);
    $pdf->SetXY($x_axis+25,$y_axis);
    $pdf->Cell(50, 10, '+91-'.strtoupper($row['mobile']), 0, 0);

    // $x_axis = 15;
    // $y_axis = 33;
    // $pdf->SetXY($x_axis,$y_axis += 20);
    // $pdf->Cell(50, 10, 'Class'.' '. ':', 0, 0);

    // $pdf->SetXY($x_axis+12,$y_axis);
    // $pdf->Cell(50, 10, strtoupper($row['class']), 0, 0);

    // $pdf->SetXY($x_axis+=45,$y_axis);
    // $pdf->Cell(50, 10, "Section"." ".":", 0, 0);

    // $pdf->SetXY($x_axis+=15,$y_axis);
    // $pdf->Cell(50, 10, strtoupper($row['section']), 0, 0);

    // $pdf->SetXY($x_axis+=25,$y_axis);
    // $pdf->Cell(50, 10, 'Roll No.'.' '.':', 0, 0);
    // $pdf->SetXY($x_axis+=15,$y_axis);
    // $pdf->Cell(50, 10, $row['roll'], 0, 0);

    // Output PDF
    $pdf->Output('I', 'file.pdf');
?>