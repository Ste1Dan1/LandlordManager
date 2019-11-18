<?php
require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>



//<?php
//
//
//// Anleitungen unter http://fpdf.org/
//
//include("fpdf.php"); //Pfad zu fpdf.php
//$pdf = new FPDF();              // Neues objekt der Klasse FPDF
//$pdf->Addpage();                // Erzeugt eine Seite
//$pdf->SetFont('Arial', 'B', 16);
//$pdf->Cell(150, 10, utf8_decode("Nebenkosten-Abrechnung für Jahr "), 'TB');
//
//$pdf->Image('Logo_Landlord_Manager.png', 140, 0, 70);
//$pdf->Ln();
//
//
//$pdf->SetFont('Helvetica', 'B', 12);
//$pdf->SetTextColor(255, 0, 0);  // RGB-Farbschema
//$pdf->Write(10, utf8_decode("Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet."));
//$pdf->Ln();
//
//$pdf->SetDrawColor(0,0,0);
//$pdf->SetFillColor(192,192,192);
//$pdf->SetTextColor(0,0,0);
//$pdf->Cell(50,5,"Kapital","LR",0,"C",1);
//$pdf->Cell(50,5,"Zinssatz","LR",0,"C",1);
//$pdf->Cell(50,5,"Ertrag","LR",0,"C",1);
//$pdf->Ln();
//
////Einstellungen Tabelle
//// $pdf->SetLineWidth(2);
//$zinssatz =1.5;
//$pdf->SetFont('Helvetica', '', 12);
//
//for($kapital = 100; $kapital <=700; $kapital=$kapital+100)
//{
//    if ($kapital%200 ==0)
//    {
//        $pdf->SetFillColor(192,192,192);
//    } else {
//        $pdf->SetFillColor(224,224,224);
//    }
//    
//
//    $pdf->Cell(50,5,"Fr. ".$kapital,"LR",0,"C",1);
//    $pdf->Cell(50,5,$zinssatz,"LR",0,"C",1);
//    $ertrag = $kapital * $zinssatz / 100;
//    $pdf->Cell(50,5,"Fr. ".number_format($ertrag,2),"LR",0,"R",1);
//    $pdf->Ln();
//}
//        
//
//$pdf->Output("I","test-pdf");   // I = integriert im Browser, F = file
//?>

