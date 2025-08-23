<?php
    date_default_timezone_set('Asia/Kolkata');
    require __DIR__ . '/api/login/check_auth.php';
    require __DIR__ . '/api/login/auth.php';

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: 0");
    $claims = require_auth();

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
    WHERE 1=1
";

$params = [];
$types = '';

if($class !== 'all' && !empty($class)){
    $sql .= " AND r.class = ?";
    $params[] = $class;
    $types .= 's';
}

if($month_years){
    $sql .= " AND d.month_year = ?";
    $params[] = $month_years;
    $types .= 's';
}

if($section !== 'all' && !empty($section)){
    $sql .= " AND r.section = ?";
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

if($params){
    $final->bind_param($types, ...$params);
}

$final->execute();
$result = $final->get_result();

if($result->num_rows === 0){
    die("Data Not Found");
}

// Create PDF
$pdf = new PDFWithWatermark();
$pdf->AddPage();
// $pdf->SetFillColor(235, 255, 245); // RGB page color
// $pdf->Rect(0, 0, 210, 297, 'F');
$pdf->SetAutoPageBreak(false);

$billHeight = 90;
$startY = 10;
$index = 0;

while($row = $result->fetch_assoc()){
     if ($index > 0 && $index % 3 === 0) {
        $pdf->AddPage();
        // $pdf->SetFillColor(235, 255, 245); // RGB page color
        // $pdf->Rect(0, 0, 210, 297, 'F');
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
    $pdf->Cell(190, 6, strtoupper('Kid\'s Blooming World School'), 0, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(10, $yOffset += 7);
    $pdf->Cell(190, 5, strtoupper('Pojhiyan, Lalganj Vaishali,Bihar, 844121 (India)'), 0, 1, 'C');
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
    // Total printable width (adjust according to your page)
    $totalWidth = 190; // Assuming left and right margin are 10 each on A4
    $numColumns = 5;
    $colWidth = $totalWidth / $numColumns;

    // Cell height
    $cellHeight = 5;

    // Draw each field
    $pdf->Cell($colWidth, $cellHeight, 'Name : ' . ucwords(strtolower($row['name'])), 0, 0);
    $pdf->Cell($colWidth, $cellHeight, 'Class : ' . strtoupper($row['class']), 0, 0);
    $pdf->Cell($colWidth, $cellHeight, 'Section : ' . strtoupper($row['section']), 0, 0);
    $pdf->Cell($colWidth, $cellHeight, 'Roll No. : ' . strtoupper($row['roll']), 0, 0);
    $pdf->Cell($colWidth, $cellHeight, 'Session : ' . strtoupper($row['session']), 0, 1);

    $pdf->SetX(10); // left margin
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(190, 3, str_repeat('-', 200), 0, 1, 'C'); // centered line of dashes

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
    if($row['back_dues'] !== 0){
        $yOffset += 5;
        $pdf->SetXY($info_x, $yOffset);
        $pdf->Cell(30, 5, $sno++, 1, 0);
        $pdf->Cell(90, 5, 'Back Dues', 1, 0);
        $pdf->Cell(60, 5, number_format($row['back_dues'], 2), 1, 0);
    }
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
