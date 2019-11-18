<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Jahresabrechnung</title>
    </head>

    
    <body>
        <?php
        include 'db.inc.php';
        include 'topbar.inc.php';
        ?>
        
        <h1>Ihre erfassten Nebenkosten-Rechnungen pro Haus</h1>

        
        <!-- Plugin für PDF-Druck, E-Mail, Druck von https://www.printfriendly.com/button-->
        <script>var pfHeaderImgUrl = 'Images/Logo_Landlord_Manager.png';
            var pfHeaderTagline = '';
            var pfdisableClickToDel = 1;
            var pfHideImages = 0;
            var pfImageDisplayStyle = 'right';
            var pfDisablePDF = 0;
            var pfDisableEmail = 1;
            var pfDisablePrint = 0;
            var pfCustomCSS = './CSS/style.css';
            var pfBtVersion='2';
            (function(){var js,pf;pf=document.createElement('script');
                pf.type='text/javascript';
                pf.src='//cdn.printfriendly.com/printfriendly.js';
                document.getElementsByTagName('head')[0].appendChild(pf)})();
        </script><a href="https://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;
                    " class="printfriendly" onclick="window.print();return false;" title="Druck oder PDF auslösen">
            <img style="border:none;-webkit-box-shadow:none;box-shadow:none;
                 " src='Images/Icon_Print_PDF.png'
                 alt="Druck oder PDF auslösen"/></a>
        
        <?php
            if (!empty($_POST['jahr'])) {
                $dropDownVal = $_POST['jahr'];
            } else {
                $dropDownVal = 1;
            }
        ?>
        
        <form name ="jahrauswahl" method="post">
            <select name="jahr">
                <option value="2019"<?php if ($dropDownVal==2019) echo 'selected'; ?>>2019</option>
                <option value="2020"<?php if ($dropDownVal==2020) echo 'selected'; ?>>2020</option>
                <option value="2021"<?php if ($dropDownVal==2021) echo 'selected'; ?>>2021</option>
                <option value="2022"<?php if ($dropDownVal==2022) echo 'selected'; ?>>2022</option>
            </select>
            
            
            <button class="btn" type="submit" name="show" >Anzeigen</button>          

        </form>
 
        <?php 
            $abfrage_haus = "SELECT hausID, bezeichnung, anz_whg, SUM(flaeche) as hausflaeche FROM haus, wohnung WHERE haus.hausID = wohnung.FK_hausID GROUP BY hausID ORDER BY bezeichnung;";
            $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage Haus hat nicht geklappt");
            
            while ($table = mysqli_fetch_array($res_haus)) {
                $summewhg = 0;
                $summefl = 0;
                $anzahl = 0;
                $anzwhg = $table['anz_whg'];
                $flaeche = $table['hausflaeche'];
                $bewmonate = $anzwhg * 12;
                $perbeginn='';
                $perende='';
                $anteil = 0;
                $summeanteil = 0;
                $offenmieter = 0;
                $differenz = 0;
                ?>

           
                <?php
                
                $hausID = $table['hausID'];
                $hausname = $table['bezeichnung'];
                
                if (isset($_POST['show'])){
                    
                    $jahr = $_POST['jahr'];
                    $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '$jahr-01-01' AND '$jahr-12-31' ORDER BY datum;";

                    $jahr = $_POST['jahr'];
            } else {
                $jahr = date("Y");
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '$jahr-01-01' AND '$jahr-12-31' ORDER BY datum;";                
            }
            ?> 
            <hr>
            <section class="page-break-after">
            <h2 class="pf-title">Nebenkosten für Haus <?php echo $table['bezeichnung']?></h2>
            
                <?php
                $res = mysqli_query($link, $abfrage_NK) or die("Abfrage NK-Rechnungen hat nicht geklappt");
                             
                if (mysqli_num_rows($res)==0){
                    echo 'Keine Rechnungen erfasst';
                }
                else { ?>
                <table>
                <thead>
                    <tr>
                        <th>Datum NK-Rechnung</th>
                        <th>Lieferant</th>
                        <th>Kostenkategorie</th>
                        <th>Betrag</th>                       
                    </tr>
                </thead>
              
                <?php
                while ($row = mysqli_fetch_array($res)) { 
                    
                    $abrechnungstyp = $row['Abrechnung'];
                    if ($abrechnungstyp =="Wohneinheit"){
                    $summewhg += $row['Betrag'];
                    }
                    
                    if ($abrechnungstyp =="Wohnfläche"){
                    $summefl += $row['Betrag'];
                    } 
                    
                    $anzahl +=1;
                    $datumalt = strtotime($row['Datum']);
                    $datum = date("d.m.Y", $datumalt);
                    ?>
                    <tr>
                        <td><?php echo $datum; ?></td>
                        <td><?php echo $row['Lieferant']; ?></td>
                        <td><?php echo $row['Beschreibung'].' ('.$row['Abrechnung'].')'; ?></td>
                        <td><?php echo $row['Betrag']; ?></td>

                    </tr>
                    <?php }
                
                if ($anzahl >=1){
                    $anteilfl = $summefl / $flaeche / $bewmonate;
                    $anteilwhg = $summewhg / $bewmonate;
                    
                ?>
                    <tr>
                        <td><strong><?php echo 'TOTAL pro Wohnung'; ?></strong></td>
                        <td></td><td></td>
                        <td><strong><?php echo number_format($summewhg, 2); ?></strong></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo 'TOTAL pro Wohnfläche'; ?></strong></td>
                        <td></td><td></td>
                        <td><strong><?php echo number_format($summefl, 2); ?></strong></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo 'Anz. Wohnungen'; ?></strong></td>
                        <td><?php echo $anzwhg; ?></td>
                        <td><strong><?php echo 'mtl. Anteil/Whg' ?></strong></td>
                        <td><?php echo number_format($anteilwhg, 2); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo 'Gesamtfläche'; ?></strong></td>
                        <td><?php echo $flaeche; ?></td>
                        <td><strong><?php echo 'mtl. Anteil/qm' ?></strong></td>
                        <td><?php echo number_format($anteilfl, 2); ?></td>
                    </tr>
            
            <?php
                }
            
                $abfrage_kat = "SELECT kategorieID, beschreibung, SUM(betrag) as betrag from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '$jahr-01-01' AND '$jahr-12-31' GROUP BY kategorieID;";                
            
                $res_kat = mysqli_query($link, $abfrage_kat) or die("Abfrage NK-Kategorien hat nicht geklappt");
                             
                if (mysqli_num_rows($res_kat)==0){
                    echo 'Keine Kategorien erfasst';
                }
                else { ?>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr>
                        <th>Kostenkategorie</th>
                        <th>Summe</th>
                        <th></th><th></th>
                    </tr>
                    
              
                <?php
                while ($kat = mysqli_fetch_array($res_kat)) { 
                    ?>
                    <tr>
                        <td><?php echo $kat['Beschreibung']; ?></td>
                        <td><?php echo $kat['betrag']; ?></td>
                        <td></td><td></td>

                    </tr>
                    <?php }
                    ?>
                    </table>                                        
            
                    
            <?php $abfrage_mieter = "SELECT wohnung.wohnungsNummer, wohnung.flaeche, mieter.vorname, mieter.name,  mietvertrag.mietbeginn, mietvertrag.mietende, SUM(nkBetrag) as Summe 
                FROM mieter, mietvertrag, wohnung, haus, mietEingang
                WHERE mieter.mieterID = mietvertrag.FK_mieterID
                AND wohnung.wohnungID = mietvertrag.FK_wohnungID
                AND haus.hausID = wohnung.FK_hausID
                AND haus.hausID = '$hausID'
                AND (mietvertrag.mietende >= '$jahr-01-01' OR mietvertrag.mietende is NULL)
                AND mietvertrag.mietVertragID = mietEingang.FK_mietVertragID
                GROUP BY mietEingang.FK_mietVertragID
                ORDER BY wohnung.wohnungsNummer;";
            $res_mieter = mysqli_query($link, $abfrage_mieter) or die("Abfrage Mieter hat nicht geklappt");
            
            if (mysqli_num_rows($res_mieter)==0){
                    echo 'Keine Mieter erfasst';
                }
                else {
                    ?>
                    <table>                
                    <tr>
                        <th><?php echo 'Wohnung'; ?></th>
                        <th><?php echo 'Mieter'; ?></th>
                        <th><?php echo 'Zahlperiode' ?></th>
                        <th><?php echo 'Anz. Monate'; ?></th>
                        <th><?php echo 'Anteil Jahr'; ?></th>
                        <th><?php echo 'Bezahlt'; ?></th>                        
                        <th><?php echo 'Offen'; ?></th>                    
                    </tr>
            <?php
                //Periodenbeginn (Start Mietvertrag oder 01. Januar) evaluieren  
                while ($mietertable = mysqli_fetch_array($res_mieter)) { 
                $mietbeginn = strtotime($mietertable['mietbeginn']);
                $mietbeginn= date('Ymd', $mietbeginn);
                                
                if($jahr.'0101' >= $mietbeginn){
                    $perbeginn = '01.01.'.$jahr;
                } 
                if ($jahr.'0101' < $mietbeginn) {
                    $perbeginn = date('d.m.Y',strtotime($mietertable['mietbeginn']));
                }
                
                //Periodenende (Ende Mietvertrag oder 31. Dezember) evaluieren  
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
 
                //Berechnung Monate
                $anzahlmte;
                
                $d1=new DateTime($perende); 
                $d2=new DateTime($perbeginn);                                  
                $Months = $d2->diff($d1); 
                $anzahlmte = (($Months->y) * 12) + ($Months->m) + 1;
                
                $flaechewhg = $mietertable['flaeche'];

                $anteilmieter = number_format((($anzahlmte * $anteilwhg) + ($anzahlmte * $flaechewhg * $anteilfl)), 2);
                $summeanteil += $anteilmieter;
                $summeanteil = number_format($summeanteil, 2);
                
                $bezahlt = $mietertable['Summe'];
                $offen = number_format(($anteilmieter - $bezahlt), 2);
                $offenmieter += $offen;


            ?>
                    <tr>
                    <td><?php echo $mietertable['wohnungsNummer']; ?></td>
                    <td><?php echo $mietertable['vorname'].' '.$mietertable['name']; ?></td>
                    <td><?php echo $perbeginn.' - '.$perende; ?></td>
                    <td><?php echo $anzahlmte; ?></td>
                    <td><?php echo $anteilmieter; ?></td>
                    <td><?php echo $bezahlt; ?></td>
                    <td><?php echo $offen; ?></td>                    
                    </tr>
                    
            <?php  
            }
            $summe = $summewhg + $summefl;
            $differenz = $summe - $summeanteil;
            $gewinn = 0;
            $verlust = 0;
            $offenmieter = number_format($offenmieter, 2);
            
            if ($differenz <= 0){
                $gewinn = number_format((-1 * (round($differenz * 20, 0) / 20)), 2);
                $verlust = '';
            } else {
                $verlust = number_format((round ($differenz * 20, 0) / 20), 2);
                $gewinn = '';
            }
            
            ?>
                    <tr></tr><tr>
                        <td><strong><?php echo 'TOTAL'; ?></strong></td>
                        <td><?php echo $summeanteil; ?></td>
                        <td><strong><?php echo 'Offen: '.$offenmieter; ?></strong></td>
                        <td><strong><?php echo 'Verlust'; ?></strong></td>
                        <td><FONT COLOR='#ff4300'><?php echo $verlust; ?></td>
                        <td><strong><?php echo 'Gewinn'; ?></strong></td>
                        <td><FONT COLOR='#04f014'><?php echo $gewinn; ?></td>
                        <td></td>
                        </tr>
            
            <?php
            }
            }
            }
             ?>
            </table>
            </section>
            <?php  }
            
            ?>

</body>
</html>
