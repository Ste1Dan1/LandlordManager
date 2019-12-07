<?php
include 'db.inc.php';

        $mietvertragID = $_GET['mietvertragID'];
        $perbeginn = $_GET['von'];   
        $perbeginn = date("Y-m-d", strtotime($perbeginn));
        $perende = $_GET['bis'];  
        $perende = date("Y-m-d", strtotime($perende));
        $offen = 0;

        $abfrage_mieter = "SELECT wohnung.FK_hausID, haus.bezeichnung, wohnung.wohnungsNummer, wohnung.flaeche, mieter.vorname, mieter.name,  
            mietvertrag.mietbeginn, mietvertrag.mietende, SUM(nkBetrag) as Summe, haus.strasse_nr, haus.plz, haus.ort 
        FROM mieter, mietvertrag, wohnung, haus, mietEingang
        WHERE mietvertrag.mietVertragID = $mietvertragID
            AND mieter.mieterID = mietvertrag.FK_mieterID
            AND wohnung.wohnungID = mietvertrag.FK_wohnungID
            AND haus.hausID = wohnung.FK_hausID
            AND (mietvertrag.mietende > '$perbeginn' OR mietvertrag.mietende is NULL)
            AND mietvertrag.mietbeginn < '$perende'
            AND mietvertrag.mietVertragID = mietEingang.FK_mietVertragID
        GROUP BY mietEingang.FK_mietVertragID
        ORDER BY wohnung.wohnungsNummer;";

        $res_mieter = mysqli_query($link, $abfrage_mieter) or die("Abfrage Mieter hat nicht geklappt");
        

        if (mysqli_num_rows($res_mieter)==0){
                echo 'Mieter wurde nicht gefunden';
            }
            else {
            while ($row = mysqli_fetch_array($res_mieter)){
                $whgnr = $row['wohnungsNummer'];
                $flaechewhg = $row['flaeche'];
                $hausID = $row['FK_hausID'];
                $hausbezeichnung = $row['bezeichnung'];
                $vorname = $row['vorname'];
                $name = $row['name'];

                $strassenr = $row['strasse_nr'];
                $plz = $row['plz'];
                $ort = $row['ort'];

                $mietbeginn = date ('Ymd', strtotime($row['mietbeginn']));
                $mietende = $row['mietende'];
                $bezahlt = $row['Summe'];
                $summe = 0;
                $offen = 0;

 
                //Berechnung Monate
                $anzahlmte;
                
                $d1=new DateTime($perende); 
                $d2=new DateTime($perbeginn);                                  
                $Months = $d2->diff($d1); 
                $anzahlmte = (($Months->y) * 12) + ($Months->m) + 1;
                              
                
                $abfrage_haus = "SELECT hausID, bezeichnung, anz_whg, SUM(flaeche) as hausflaeche FROM haus, wohnung WHERE haus.hausID = $hausID AND haus.hausID = wohnung.FK_hausID GROUP BY hausID ORDER BY bezeichnung;";
                $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage Haus hat nicht geklappt");
            
                while ($table = mysqli_fetch_array($res_haus)) {
                    $anzwhg = $table['anz_whg'];
                    $hausflaeche = $table['hausflaeche'];
                }                
                
                $abfrage_kat = "SELECT kategorieID, beschreibung, abrechnung, SUM(betrag) as betrag from nkrechnungenprohaus WHERE bezeichnung = '$hausbezeichnung' AND datum BETWEEN '$perbeginn' AND '$perende' GROUP BY kategorieID ORDER BY beschreibung;";                            
                $res_kat = mysqli_query($link, $abfrage_kat) or die("Abfrage NK-Kategorien hat nicht geklappt");
                $today = date('d.m.Y');
                
                $fehler_kat = 'Keine Kategorien erfasst';

        

$html = $vorname.' '.$name.'<br>'
        .$strassenr.'<br>'
        .$plz.' '.$ort.'<br><br>'

        .$today.'<br><br>
        
        <h2>Nebenkostenabrechnung</h2>

        <p>Abrechnung für die Periode vom '.$perbeginn.' bis '.$perende.' ('.$anzahlmte.' Monate)<br>'.
        'Wohnung '.$whgnr.', Fläche '.$flaechewhg.' m2 / Haus '.
        $hausbezeichnung.', Hausfläche '.$hausflaeche.' m2, '.$anzwhg.' Wohnungen</p>
        
        <h2>Ausgaben</h2>
        <p><strong>Anteile:</strong> <br>
            - <strong>Wohnfläche:</strong> Pro Monat, pro Quadratmeter Ihrer Wohnung<br>
            - <strong>Wohneinheit:</strong> Pro Monat, pro Wohnung</p>
      
        <?php
        if (mysqli_num_rows($res_kat)==0){
                    echo $fehler_kat;
                }
                else { 
                   
                    ?>
        
                   <table><tr>
                        <th>Kostenkategorie</th>
                        <th>Gesamt</th>
                        <th>Abrechnung</th>
                        <th>Anteil</th>
                        <th>Gesamt</th>
                        <th>Zeitraum</th>
                    </tr>';
                    

                while ($kat = mysqli_fetch_array($res_kat)) { 
                    
                    $beschreibung = $kat['Beschreibung'];
                    $betrag = $kat['betrag'];                   
                    $abrechnungstyp = $kat['Abrechnung'];
                    
                    $anteil = 0; 
                    $gesamtanteil = 0;
                    $zeitanteil = 0;
                    $bewmonate = $anzwhg * 12;
                                       
                    if ($abrechnungstyp =="Wohneinheit"){
                    $anteil = $betrag / $bewmonate;
                    
                    $gesamtanteil = $anteil * 12;
                    $zeitanteil = $anteil * $anzahlmte;
                                     
                    }
                    
                    if ($abrechnungstyp =="Wohnfläche"){
                    $anteil = $betrag / $hausflaeche / 12;
                    $gesamtanteil = $anteil * $flaechewhg  * 12;
                    $zeitanteil = $anteil * $flaechewhg * $anzahlmte;

                    }
                    
                    $summe += $zeitanteil;
                    $offen = $summe - $bezahlt;
                    $zahlenbis = strtotime("+30 day", time());
                    $zahlenbis = date('d.m.Y', $zahlenbis);
                    
                    $anteil = number_format($anteil, 2);
                    $gesamtanteil = number_format($gesamtanteil, 2);
                    $zeitanteil = number_format($zeitanteil, 2);
                    
                     if ($offen > 0){
                        $zubezahlen = number_format ($offen, 2);
                        $nachzahlung = 'Nachzahlung von CHF '.$zubezahlen.' fällig bis am '.$zahlenbis.' auf unser Konto. Vielen Dank.';
                     }
                     
                     if ($offen < 0){
                         $zurück = -$offen;
                         $zurück = number_format ($zurück, 2);
                         $nachzahlung = 'Sie haben CHF '.$zurück.' zu viel bezahlt. Wir werden Ihnen in den nächsten Tagen CHF '.$zurück.' auf Ihr Konto überweisen.';
                     }
                     
                    
                    $html .='<tr>
                        <td>'.$beschreibung.'</td>
                        <td>'.$betrag.'</td>
                        <td>'.$abrechnungstyp.'</td>
                        <td>'.$anteil.'</td>
                        <td>'.$gesamtanteil.'</td>
                        <td>'.$zeitanteil.'</td>
                    </tr>';
                    
                }
                
                    $summe = number_format ($summe, 2);
                    $bezahlt = number_format ($bezahlt, 2);
                    $offen = number_format ($offen, 2);     
                    
                $html.= '<tr></tr>
                    <tr>
                    <td></td><td></td><td></td><td></td>
                    <td><strong>Total</strong></td>
                    <td><strong>'.$summe.'</strong></td>                    
                </tr>
                <tr>
                    <td><strong>Vorausbezahlt</strong></td>
                    <td></td><td></td><td></td><td></td>
                    <td><strong>- '.$bezahlt.'</strong></td>                    
                </tr>
                <tr>
                    <td><strong>Nachzahlung </strong></td>
                    <td></td><td></td><td></td><td></td>
                    <td><strong>'.$offen.'</strong></td>                    
                </tr>
                </table> 

        <p>'.$nachzahlung.'</p>';
                
                
                }
                
                $html.='<br>';

            }
               // } 
        $html .= '</div>';
        
    
 // TCPDF Library laden
require_once('tcpdf/tcpdf.php');

// Erstellung des PDF Dokuments
$pdfname = "Nebenkostenabrechnung";
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
//$pdf->SetTitle('Rechnung '.$rechnungs_nummer);
//$pdf->SetSubject('Rechnung '.$rechnungs_nummer);

// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('dejavusans', '', 10);

// Neue Seite
$pdf->AddPage();

// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');

//Ausgabe der PDF

// Clean any content of the output buffer
ob_end_clean();

//Variante 1: PDF direkt an den Benutzer senden:

$pdf->Output($pdfName, 'I');
//Variante 2: PDF im Verzeichnis abspeichern:
//$pdf->Output(dirname(__FILE__).'/'.$pdfName, 'F');
//echo 'PDF herunterladen: <a href="'.$pdfName.'">'.$pdfName.'</a>';

?>
