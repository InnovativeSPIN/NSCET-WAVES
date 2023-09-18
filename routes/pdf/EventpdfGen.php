<?php
require('fpdf.php');
include('../connect.php');

$house = mysqli_real_escape_string($conn, $_POST["house"]);

// $house = 'TIGER THRASHERS';
$sql = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `housedb` WHERE `name`='$house'"));
$gender = $sql['gender'];


class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // GFG logo image
        $this->Image('../../public/images/logos/clg-logo.png', 10, 13, 20);

        // GFG logo image
        $this->Image('../../public/images/logos/waves-logo.png', 180, 15, 20);

        // Set font-family and font-size
        $this->SetFont('Times', 'B', 12);

        // Move to the right
        $this->Cell(80);

        // Set the title of pages.
        $this->Cell(30, 10, 'NADAR SARASWATHI COLLEGE OF ENGINEERING & TECHNOLOGY', 0, 2, 'C');
        $this->SetFont('Times', 'BIU', 12);

        $this->Cell(30, 8, 'WAVES 23', 0, 2, 'C');

        // $this->Text(35,190,'W a t e r m a r k   d e m o');
        $this->Image('../../public/images/logos/background-logo.png', 15, 100, 177, 86);
        // Break line with given space
        $this->Ln(1);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);

        // Set font-family and font-size of footer.
        $this->SetFont('Arial', 'I', 8);

        // set page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() .
            '/{nb}', 0, 0, 'C');
    }
}


// Create new object.
$pdf = new PDF();
$pdf->AliasNbPages();

// Add new pages
$pdf->AddPage();

// $pdf->SetDrawColor(240,248,255);


// Set font-family and font-size.

$pdf->SetFont('Times', 'B', 15);

$pdf->Cell(190, 10, "$house", 0, 2, 'C');
$pdf->SetFont('Helvetica', '', 10);

$houseDetail = mysqli_query($conn, "SELECT * FROM `admindb` WHERE `house_name`='$house'");

while ($data = mysqli_fetch_array($houseDetail)) {
    $pdf->Cell(190, 5, "$data[role] : $data[name]", 0, 1, 'C');
}

$pdf->Ln(2);



// Create the table data rows

$fill = false;
$event = mysqli_query($conn, "SELECT * FROM `eventdb` WHERE `gender`='$gender' || `gender`='COMMON'");
$data = mysqli_fetch_array($event);

while ($data = mysqli_fetch_array($event)) {
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->Cell(190, 5, "Event Name : $data[event_name]", 0, 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('Times', 'B', 12);

    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell(12, 10, "S_no", 1, 0, 'C', true);
    $pdf->Cell(45, 10, "Register Number", 1, 0, 'C', true);
    $pdf->Cell(70, 10, "Student Name", 1, 0, 'C', true);
    $pdf->Cell(15, 10, "Group", 1, 0, 'C', true);
    $pdf->Cell(35, 10, "Deparment", 1, 0, 'C', true);
    $pdf->Cell(15, 10, "Year", 1, 0, 'C', true);

    $pdf->Ln(10);
    $row = 0;
    $query = mysqli_query($conn, "SELECT * FROM `registerationdb` WHERE `event_name`='$data[event_name]' && `student_house`='$house' ORDER BY `registerationdb`.`grouped` ASC");
    $i=0;
    while ($row < $data['max_participants']) { 
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
        if ($i==0) {
            while ($eventData = mysqli_fetch_array($query)) {
                $pdf->Cell(12, 10, $row + 1, 1, 0, 'C', $fill);
                $pdf->Cell(45, 10, $eventData['reg_no'], 1, 0, 'C', $fill);
                $pdf->Cell(70, 10, $eventData['student_name'], 1, 0, 'C', $fill);
                $pdf->Cell(15, 10, $eventData['grouped'], 1, 0, 'C', $fill);
                $pdf->Cell(35, 10, $eventData['student_dept'], 1, 0, 'C', $fill);
                $pdf->Cell(15, 10, $eventData['grouped'], 1, 0, 'C', $fill);
                $row++;
                $pdf->Ln(10);
            }
            $i=1;
        } else {
            $pdf->Cell(12, 10, $row + 1, 1, 0, 'C', $fill);
            $pdf->Cell(45, 10, ' ', 1, 0, 'C', $fill);
            $pdf->Cell(70, 10, ' ', 1, 0, 'C', $fill);
            $pdf->Cell(15, 10, ' ', 1, 0, 'C', $fill);
            $pdf->Cell(35, 10, ' ', 1, 0, 'C', $fill);
            $pdf->Cell(15, 10, ' ', 1, 0, 'C', $fill);
            $row++;
            $pdf->Ln(10);

        }
    }
    

    $pdf->Ln(30);
}
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(190, 10, "---------------------------------------", 0, 1, 'C');

$pdf->Output();

?>