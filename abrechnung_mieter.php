<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Jahresabrechnung Mieter</title>
    </head>

    <body>
        <div class="pagecontent">           
        
    <?php
       include 'topbar.inc.php';
       include 'db.inc.php';
    ?>
    
<!-- Alle Variablen zusammentragen -->

    <?php   
        $mietvertragID = $_GET['mietvertragID'];
        $jahr = $_GET['jahr'];   

        $offen = 0;

        $abfrage_mieter = "SELECT wohnung.FK_hausID, haus.bezeichnung, wohnung.wohnungsNummer, wohnung.flaeche, mieter.vorname, mieter.name,  
            mietvertrag.mietbeginn, mietvertrag.mietende, SUM(nkBetrag) as Summe, haus.strasse_nr, haus.plz, haus.ort 
        FROM mieter, mietvertrag, wohnung, haus, mietEingang
        WHERE mietvertrag.mietVertragID = $mietvertragID
            AND mieter.mieterID = mietvertrag.FK_mieterID
            AND wohnung.wohnungID = mietvertrag.FK_wohnungID
            AND haus.hausID = wohnung.FK_hausID
            AND (mietvertrag.mietende >= '$jahr-01-01' OR mietvertrag.mietende is NULL)
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
                                                    
                if($jahr.'0101' >= $mietbeginn){
                    $perbeginn = '01.01.'.$jahr;
                } 
                if ($jahr.'0101' < $mietbeginn) {
                    $perbeginn = date('d.m.Y',strtotime($mietertable['mietbeginn']));
                }
                
                // Periodenende (Ende Mietvertrag oder 31. Dezember) evaluieren
                // Wenn noch nicht das Ende des Jahres erreicht ist, wird das heutige Datum als Periodenende genommen
                $mietende = strtotime($mietertable['mietende']);
                $mietende= date('Ymd', $mietende);
                
                if ($mietende < $jahr.'1231') {
                    $perende = date('d.m.Y',strtotime($mietertable['mietende']));
                }

                if($mietende == '19700101'){
                    $perende='31.12.'.$jahr;
                }

                if($mietende >= $jahr.'1231'){
                    $perende='31.12.'.$jahr;
                }             
                
                if ($perende >= date('Ymd')){
                    $perende = date('d.m.Y');
                }
 
                //Berechnung Monate
                $anzahlmte;
                
                $d1=new DateTime($perende); 
                $d2=new DateTime($perbeginn);                                  
                $Months = $d2->diff($d1); 
                $anzahlmte = (($Months->y) * 12) + ($Months->m);
                              
                
                $abfrage_haus = "SELECT hausID, bezeichnung, anz_whg, SUM(flaeche) as hausflaeche FROM haus, wohnung WHERE haus.hausID = $hausID AND haus.hausID = wohnung.FK_hausID GROUP BY hausID ORDER BY bezeichnung;";
                $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage Haus hat nicht geklappt");
            
                while ($table = mysqli_fetch_array($res_haus)) {
                    $anzwhg = $table['anz_whg'];
                    $hausflaeche = $table['hausflaeche'];
                }                
                
                $abfrage_kat = "SELECT kategorieID, beschreibung, abrechnung, SUM(betrag) as betrag from nkrechnungenprohaus WHERE bezeichnung = '$hausbezeichnung' AND datum BETWEEN '$jahr-01-01' AND '$jahr-12-31' GROUP BY kategorieID;";                            
                $res_kat = mysqli_query($link, $abfrage_kat) or die("Abfrage NK-Kategorien hat nicht geklappt");

        ?>
        
        <!-- Layout der ganzen Abrechnung -->  
    <!-- Plugin für PDF-Druck, E-Mail, Druck von https://www.printfriendly.com/button-->
    <script>var pfHeaderImgUrl = '';
        var pfDisablePDF = 0;
        var pfDisableEmail = 1;
        var pfDisablePrint = 0;
        var pfHeaderTagline = '';
        var pfdisableClickToDel = 1;
        var pfHideImages = 0;
        var pfImageDisplayStyle = 'right';
        var pfCustomCSS = './CSS/style.css';
        var pfBtVersion='2';
        (function(){var js,pf;pf=document.createElement('script');
            pf.type='text/javascript';
            pf.src='//cdn.printfriendly.com/printfriendly.js';
            document.getElementsByTagName('head')[0].appendChild(pf)})();
    </script><a href="https://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;
                " class="printfriendly" onclick="window.print();return false;" title="Druck oder PDF auslösen">
        <img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src='Images/Icon_Print_PDF.png'
             alt="PDF, E-Mail oder Druck auslösen"/></a>

        <br><br>
        <?php echo $vorname.' '.$name ?><br>
        <?php echo $strassenr ?><br>
        <?php echo $plz.' '.$ort ?><br><br>

        <?php echo date('d.m.Y') ?><br><br>
        
        <h2>Nebenkostenabrechnung</h2>

        <p>Abrechnung für die Periode vom <?php echo $perbeginn ?> bis <?php echo $perende ?> (<?php echo $anzahlmte ?> Monate)<br>
            Wohnung <?php echo $whgnr ?>, Fläche <?php echo $flaechewhg ?> m2 /
            Haus <?php echo $hausbezeichnung ?>, Hausfläche <?php echo $hausflaeche ?> m2, <?php echo $anzwhg ?> Wohnungen</p>
        
        <h2>Ausgaben</h2>
        <p><strong>Anteile:</strong> <br>- <strong>Wohnfläche:</strong> Pro Monat, pro Quadratmeter Ihrer Wohnung<br>
            - <strong>Wohneinheit:</strong> Pro Monat, pro Wohnung</p>
      
        <?php
        if (mysqli_num_rows($res_kat)==0){
                    echo 'Keine Kategorien erfasst';
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
                    </tr>
                    
              
                <?php
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
                                                         
                    ?>
                    <tr>
                        <td><?php echo $beschreibung; ?></td>
                        <td><?php echo $betrag; ?></td>
                        <td><?php echo $abrechnungstyp; ?></td>
                        <td><?php echo number_format($anteil, 2); ?></td>
                        <td><?php echo number_format($gesamtanteil, 2); ?></td>
                        <td><?php echo number_format($zeitanteil, 2); ?></td>
                    </tr>
                <?php }
                ?>
                    
                <tr></tr>
                <tr>
                    <td></td><td></td><td></td><td></td>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo number_format ((round($summe *20)/20), 2)?></strong></td>                    
                </tr>
                <tr>
                    <td><strong>Vorausbezahlt</strong></td>
                    <td></td><td></td><td></td><td></td>
                    <td><strong>- <?php echo number_format ($bezahlt, 2)?></strong></td>                    
                </tr>
                <tr>
                    <td><strong>Nachzahlung </strong></td>
                    <td></td><td></td><td></td><td></td>
                    <td><strong><?php echo number_format ((round($offen * 20)/20), 2)?></strong></td>                    
                </tr>
                </table> 

        <p> Nachzahlung von CHF <?php echo number_format ((round($offen * 20)/20), 2)?> fällig bis am <?php echo $zahlenbis ?> auf unser Konto. Vielen Dank.</p>
                
                    <?php
                
                }
                    ?>
                    <br>

                    


            <?php 
            }
                } ?>
        </div>
</body>
</html>