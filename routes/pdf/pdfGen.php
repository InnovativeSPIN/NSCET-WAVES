<?php
require('fpdf.php');
include('../connect.php');

$house = mysqli_real_escape_string($conn, $_POST["houes"]);

$sql = mysqli_query($conn,"SELECT * FROM `studentdb` WHERE `house`='$house'");

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // GFG logo image
        $this->Image('../../public/images/logos/clg-logo.png', 30, 13, 20);
          
        // GFG logo image
        $this->Image('../../public/images/logos/waves-logo.png', 160, 15, 20);
          
        // Set font-family and font-size
        $this->SetFont('Times','B',20);
          
        // Move to the right
        $this->Cell(80);
          
        // Set the title of pages.
        $this->Cell(30, 20, 'WAVES 2023', 0, 2, 'C');
          
        // Break line with given space
        $this->Ln(5);
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
$pdf->Ln( 5 );


// Set font-family and font-size.
$pdf->SetFont('Times','B',12);

$pdf->SetTextColor(255,255,255);

$pdf->Cell( 12, 10, "S_no", 1, 0, 'C', true );
$pdf->Cell( 50, 10, "Register Number", 1, 0, 'C', true );
$pdf->Cell( 70, 10, "Student Name", 1, 0, 'C', true );
$pdf->Cell( 45, 10, "Deparment", 1, 0, 'C', true );
$pdf->Cell( 15, 10, "Year", 1, 0, 'C', true );

$pdf->Ln( 10 );

// Create the table data rows

$fill = false;
$row = 0;

while ($data = mysqli_fetch_array($sql)) {

 
    // Create the data cells
    $pdf->SetTextColor( 0,0,0 );
    $pdf->SetFillColor( 255, 255, 255 );
    $pdf->SetFont( 'Arial', '', 15 );
    
    
    $pdf->Cell( 12, 10, $row+1, 1, 0, 'C', $fill );
    $pdf->Cell( 50, 10, $data['reg_no'], 1, 0, 'C', $fill );
    $pdf->Cell( 70, 10, $data['name'], 1, 0, 'C', $fill );
    $pdf->Cell( 45, 10, $data['dept'], 1, 0, 'C', $fill );
    $pdf->Cell( 15, 10, $data['year'], 1, 0, 'C', $fill );
  
    $row++;
    $fill = !$fill;
    $pdf->Ln( 10 );
}
      
$pdf->Output();
  
?>