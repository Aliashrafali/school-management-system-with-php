<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
require './sql/config.php';
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
            $c = cos($angle); $s = sin($angle);
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

// get class section and month_years
$class = $_GET['class'] ?? '';
$section = $_GET['section'] ?? '';
$month_years = $_GET['month_year'] ?? '';
$student_ids_param = $_GET['student_ids'] ?? '';
$student_ids = [];

if (!empty($student_ids_param)) {
    $ids = explode(',', $student_ids_param);
    foreach ($ids as $id) {
        if (is_numeric($id)) {
            $student_ids[] = intval($id);
        }
    }
}


if(empty($class) || empty($month_years)){
    die("Missing Class and Month_Years");
}

$sql = "
    SELECT d.*, r.name, r.fname, r.roll, r.class, r.section, r.reg_no
    FROM tbl_demand d
    JOIN registration r ON d.student_id = r.id 
    WHERE r.class = ? AND d.month_year = ?
";

$params = [$class,$month_years];
$types = 'ss';

if(!empty($section)){
    $sql .= "AND r.section = ?";
    $params[] = $section;
    $types .= 's';
}

if (!empty($student_ids)) {
    $in_clause = implode(',', array_fill(0, count($student_ids), '?'));
    $sql .= " AND d.student_id IN ($in_clause)";
    $params = array_merge($params, $student_ids);
    $types .= str_repeat('i', count($student_ids));
}

$final = $conn->prepare($sql);
$final->bind_param($types, ...$params);
$final->execute();
$result = $final->get_result();

if($result->num_rows === 0){
    die("Data Not Found");
}

// Create PDF
$pdf = new PDFWithWatermark();
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// Set light yellow background
// $pdf->SetFillColor(255, 255, 204);
// $pdf->Rect(0, 0, 210, 297, 'F');

// Bill layout
// $billCount = 3;
// $billHeight = 90;
// $startY = 10;
$billHeight = 90;
$startY = 10;
$index = 0;

while($row = $result->fetch_assoc()){
     if ($index > 0 && $index % 3 === 0) {
        $pdf->AddPage();
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(0, 0, 210, 297, 'F');
        $startY = 10;
    }

    $yOffset = $startY + ($index % 3) * $billHeight;

    // Border
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetLineWidth(0.2);
    $pdf->Rect(10, $yOffset, 190, $billHeight - 5);

    // Header
    $pdf->SetXY(10, $yOffset += 2);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(190, 6, strtoupper('RN Mission Public School'), 0, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(10, $yOffset += 7);
    $pdf->Cell(190, 5, strtoupper('Mujauna Bazar, Parsa(Saran)'), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetXY(10, $yOffset += 5);
    $pdf->SetTextColor(0,0,139);
    $pdf->SetDrawColor(0, 0, 139);
    $pdf->Cell(190, 5, strtoupper('Monthaly Demand Bill'), 0, 1, 'C');
    $x = $pdf->GetX() + 78; // starting X of the cell
    $y = $pdf->GetY(); // 10mm below current line
    $pdf->Line($x-2, $y, $x + 36, $y); // x1, y1, x2, y2
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetX(10); // left margin
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(190, 3, str_repeat('-', 200), 0, 1, 'C');

    // Student Info
    $info_x = 15;
    $width = 50;
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY($info_x, $yOffset += 9); 
    $pdf->Cell($width, 5, 'Serial No.: ' . ($index + 1), 0, 0); 

    $pdf->SetXY($info_x + $width - 15, $yOffset += 0); 
    $pdf->Cell($width, 5, 'Date.:', 0, 0); 

    $pdf->SetXY($info_x + $width - 5, $yOffset += 0); 
    $date = $row['date_and_time'];
    $org_date = date('d-m-Y g:i A', strtotime($date));
    $pdf->Cell(40, 5, $org_date, 0, 0);

    $pdf->SetXY($info_x + $width + 32, $yOffset += 0); 
    $pdf->Cell($width, 5, 'Reg No.:', 0, 0); 

    $pdf->SetXY($info_x + $width + 48, $yOffset += 0); 
    $pdf->Cell($width, 5, $row['reg_no'], 0, 0); 

    $pdf->SetXY($info_x + $width + 85, $yOffset += 0); 
    $pdf->Cell($width, 5, 'Month-Year:', 0, 0); 

    $pdf->SetXY($info_x + $width + 105, $yOffset += 0); 
    $pdf->Cell($width, 5, $row['month_year'], 0, 0); 

    $yOffset += 7;
    $pdf->SetXY($info_x, $yOffset);

    $pdf->Cell(15, 5, 'Name :', 0, 0);
    $pdf->Cell(40, 5, ucwords(strtolower($row['name'])), 0, 0);

    $pdf->Cell(15, 5, 'Class :', 0, 0);
    $pdf->Cell(20, 5, strtoupper($row['class']), 0, 0);

    $pdf->Cell(20, 5, 'Section :', 0, 0);
    $pdf->Cell(15, 5, strtoupper($row['section']), 0, 0);

    $pdf->Cell(20, 5, 'Roll No. :', 0, 0);
    $pdf->Cell(20, 5, strtoupper($row['roll']), 0, 0);
    
    $pdf->SetX(10); // left margin
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(190, 15, str_repeat('-', 200), 0, 1, 'C'); // centered line of dashes

    $yOffset += 10;
    $pdf->SetXY($info_x, $yOffset);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(30, 5, 'S.No. :', 1, 0);
    $pdf->Cell(90, 5, 'Particulars:', 1, 0);
    $pdf->Cell(60, 5, 'Amount ( INR ):', 1, 0);

    // fees details
    $sno = 1;
    $yOffset += 5;
    $pdf->SetXY($info_x, $yOffset);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(30, 5, $sno++, 1, 0);

    $pdf->Cell(90, 5, 'Tution Fee', 1, 0);
    $pdf->Cell(60, 5, number_format($row['tution_fee'], 2), 1, 0);

    $yOffset += 5;
    $pdf->SetXY($info_x, $yOffset);
    $pdf->Cell(30, 5, $sno++, 1, 0);
    $pdf->Cell(90, 5, 'Transport Fee', 1, 0);
    $pdf->Cell(60, 5, number_format($row['transport_and_other_fee'], 2), 1, 0);

    $other_fee = $row['other_fee'];
    $fees = explode(',', $other_fee);
    $pared_fee = [];
    
    foreach($fees as $fee){
        $fee = trim($fee);
        if(preg_match('/(.*?)(\d+)$/', $fee, $matches)){
            $title = trim($matches[1]);
            $amount = isset($matches[2]) && is_numeric($matches[2]) ? (float)$matches[2] : 0.00;
            $pared_fee[] = [
                'title' => $title,
                'amount' => $amount
            ];
        }
    }
    $yOffset += 5;
    $pdf->SetXY($info_x, $yOffset);
    foreach ($pared_fee as $fee_item) {
        $maxLength = 40;
        $title = strlen($fee_item['title']) > $maxLength ? substr($fee_item['title'], 0, $maxLength - 3) . '...' : $fee_item['title'];
        $pdf->SetXY($info_x, $yOffset);
        $pdf->Cell(30, 5, $sno++, 1, 0, 'L'); 
        $pdf->Cell(90, 5, $title, 1, 0, 'L');  
        $pdf->Cell(60, 5, number_format($fee_item['amount'], 2), 1, 1, 'L');

        $yOffset += 5;
    }
    $yOffset += 3;
    $pdf->SetXY($info_x + 100, $yOffset);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(90, 5, strtoupper('Total :'), 0, 0);
    $pdf->SetXY($info_x + 119, $yOffset);
    $pdf->Cell(40, 5, number_format($row['total'], 2), 0, 0);

    $yOffset += 7;
    $pdf->SetXY($info_x + 119, $yOffset);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(90, 5, 'Signature : ', 0, 0);
    $index++;
}
// Output
$pdf->Output('I', 'multi-demand.pdf');
?>
