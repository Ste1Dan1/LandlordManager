<?php


// Anleitungen unter http://fpdf.org/

include("../../fpdf/fpdf.php"); //Pfad zu fpdf.php
$pdf = new FPDF();              // Neues objekt der Klasse FPDF
$pdf->Addpage();                // Erzeugt eine Seite
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(150, 10, utf8_decode("Nebenkosten-Abrechnung für Periode xx/xx"), 'TB');

$pdf->Image('Logo_Landlord_Manager.png', 140, 0, 70);
$pdf->Ln();


$pdf->SetFont('Helvetica', 'B', 12);
$pdf->SetTextColor(255, 0, 0);  // RGB-Farbschema
$pdf->Write(10, utf8_decode("Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet."));
$pdf->Ln();

$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(192,192,192);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,5,"Kapital","LR",0,"C",1);
$pdf->Cell(50,5,"Zinssatz","LR",0,"C",1);
$pdf->Cell(50,5,"Ertrag","LR",0,"C",1);
$pdf->Ln();

//Einstellungen Tabelle
// $pdf->SetLineWidth(2);
$zinssatz =1.5;
$pdf->SetFont('Helvetica', '', 12);

for($kapital = 100; $kapital <=700; $kapital=$kapital+100)
{
    if ($kapital%200 ==0)
    {
        $pdf->SetFillColor(192,192,192);
    } else {
        $pdf->SetFillColor(224,224,224);
    }
    

    $pdf->Cell(50,5,"Fr. ".$kapital,"LR",0,"C",1);
    $pdf->Cell(50,5,$zinssatz,"LR",0,"C",1);
    $ertrag = $kapital * $zinssatz / 100;
    $pdf->Cell(50,5,"Fr. ".number_format($ertrag,2),"LR",0,"R",1);
    $pdf->Ln();
}
        

$pdf->Output("I","test-pdf");   // I = integriert im Browser, F = file
?>

