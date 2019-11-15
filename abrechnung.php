<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Jahresabrechnung</title>
    </head>

    <body>
        <?php
        include 'db.inc.php';
        // include 'topbar.inc.php';
        ?>
        
        <h1>Ihre erfassten Nebenkosten-Rechnungen pro Haus</h1>
        <form name ="jahrauswahl" method="post" action="abrechnung.php">
            <select name="jahr">
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
            <button class="btn" type="submit" name="show" >Anzeigen</button>          

        </form>
 
        <?php 
            
            $abfrage_haus = "SELECT * FROM haus ORDER BY bezeichnung";
            $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage Haus hat nicht geklappt");
            
            while ($table = mysqli_fetch_array($res_haus)) {
                $summe = 0;
                $anzahl = 0;
                $anzwhg = $table['anz_whg'];
                $bewmonate = $anzwhg * 12;
                $perbeginn='';
                $perende='';
                $anteil = 0;
                $summeanteil = 0;
                $differenz = 0;
                $jahr = '';
                ?>
            <h2>Nebenkosten für Haus <?php echo $table['bezeichnung'] ?></h2>
            

                <?php
                
                $hausID = $table['hausID'];
                $hausname = $table['bezeichnung'];
                
                if (isset($_POST['show'])){
                if ($_POST['jahr'] == "Alle"){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2019){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2019-01-01' AND '2019-12-31' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2020){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2020-01-01' AND '2020-12-31' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2021){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2021-01-01' AND '2021-12-31' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2022){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2022-01-01' AND '2022-12-31' ORDER BY datum;";
                }
            }
                $jahr = $_POST['jahr'];
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
                        <th>Betrag</th>
                        <th>Kostenkategorie</th>
                        <td></td><td><td></td></td>
                    </tr>
                </thead>
              
                <?php
                while ($row = mysqli_fetch_array($res)) { 
                    $summe += $row['Betrag'];
                    $anzahl +=1;
                    $datumalt = strtotime($row['Datum']);
                    $datum = date("d.m.Y", $datumalt);
                    ?>
                    <tr>
                        <td><?php echo $datum; ?></td>
                        <td><?php echo $row['Lieferant']; ?></td>
                        <td><?php echo $row['Betrag']; ?></td>
                        <td><?php echo $row['Beschreibung']; ?></td>
                        <td></td><td><td></td><td></td></td>
                    </tr>
                    <?php }
                
                if ($anzahl >=1){
                    $anteil = number_format((round(($summe / $bewmonate) * 20, 0) / 20), 2);
                ?>
                    <tr>
                        <td><strong><?php echo 'TOTAL'; ?></strong></td>
                        <td><?php echo ''; ?></td>
                        <td><strong><?php echo $summe; ?></strong></td>
                        <td><?php echo ''; ?></td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr>
                        <td><strong><?php echo 'Anz. Wohnungen'; ?></strong></td>
                        <td><?php echo $anzwhg; ?></td>
                        <td><strong><?php echo 'Anteil' ?></strong></td>
                        <td><?php echo $anteil; ?></td>
                        <td></td><td></td><td></td><td></td>
                    </tr>
                    
            <?php $abfrage_mieter = "SELECT wohnung.wohnungsNummer, mieter.vorname, mieter.name,  mietvertrag.mietbeginn, mietvertrag.mietende 
                FROM mieter, mietvertrag, wohnung, haus
                WHERE mieter.mieterID = mietvertrag.FK_mieterID
                AND wohnung.wohnungID = mietvertrag.FK_wohnungID
                AND haus.hausID = wohnung.FK_hausID
                AND haus.hausID = '$hausID'
                AND (mietvertrag.mietende >= '$jahr-01-01' OR mietvertrag.mietende is NULL)
                ORDER BY wohnung.wohnungsNummer;";
            $res_mieter = mysqli_query($link, $abfrage_mieter) or die("Abfrage Mieter hat nicht geklappt");
            
            if (mysqli_num_rows($res_mieter)==0){
                    echo 'Keine Mieter erfasst';
                }
                else {
                    ?>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                    <tr>
                        <th><?php echo 'Wohnung'; ?></th>
                        <th><?php echo 'Mieter Vorname'; ?></th>
                        <th><?php echo 'Mieter Name'; ?></th>
                        <th><?php echo 'Beginn Zahlper.' ?></th>
                        <th><?php echo 'Ende Zahlper.'; ?></th>
                        <th><?php echo 'Anz. Monate'; ?></th>
                        <th><?php echo 'Anteil Jahr'; ?></th>
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

                $anteilmieter = number_format(($anzahlmte * $anteil), 2);
                $summeanteil += $anteilmieter;
                $summeanteil = number_format($summeanteil, 2);
                                               
                
            ?>
                    <tr>
                    <td><?php echo $mietertable['wohnungsNummer']; ?></td>
                    <td><?php echo $mietertable['vorname']; ?></td>
                    <td><?php echo $mietertable['name']; ?></td>
                    <td><?php echo $perbeginn; ?></td>
                    <td><?php echo $perende; ?></td>
                    <td><?php echo $anzahlmte; ?></td>
                    <td><?php echo $anteilmieter; ?></td>
                    </tr>
                    

            <?php  
            }
            $differenz = $summe - $summeanteil;
            $gewinn = 0;
            $verlust = 0;
            
            if ($differenz <= 0){
                $gewinn = number_format((-1 * (round($differenz * 20, 0) / 20)), 2);
                $verlust = '';
            } else {
                $verlust = number_format((round ($differenz * 20, 0) / 20), 2);
                $gewinn = '';
            }
            
            ?>
                    <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <td><strong><?php echo 'TOTAL'; ?></strong></td>
                        <td><?php echo $summeanteil; ?></td>
                        <td><strong><?php echo 'Verlust'; ?></strong></td>
                        <td><FONT COLOR='#ff4300'><?php echo $verlust; ?></td>
                        <td><strong><?php echo 'Gewinn'; ?></strong></td>
                        <td><FONT COLOR='#04f014'><?php echo $gewinn; ?></td>
                        <td></td></tr>
            
            <?php
            }
            }
            }
             ?>
            </table>
            <?php  }
            
            ?>

        

</body>
</html>