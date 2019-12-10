<?php
include 'topbar.inc.php';
include 'loginCheck.inc.php';
include 'db.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Jahresabrechnung</title>
    </head>


    <body>
        <div class="report">

            <h1>Ihre erfassten Nebenkosten-Rechnungen pro Haus</h1>


            <form name ="jahrauswahl" method="post" class ="print-no">         

                <div class="input-group">
                    <label>Abrechnung von: </label>
                    <input type="date" name="periodenbeginn" value ="<?php echo date('Y-m-d', strtotime('first day of january this year')); ?>">
                </div>
                <div class="input-group"> 
                    <label>Bis: </label>
                    <input type="date" name="periodenende" value ="<?php echo date('Y-m-d', strtotime('last day of december this year')); ?>">        
                </div>

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
                $perbeginn = '';
                $perende = '';
                $anteil = 0;
                $summerg = 0;
                $summeanteil = 0;
                $offenmieter = 0;
                $differenz = 0;
                ?>


                <?php
                $hausID = $table['hausID'];
                $hausname = $table['bezeichnung'];

                if (isset($_POST['show'])) {

                    $periodenbeginn = $_POST['periodenbeginn'];
                    $periodenende = $_POST['periodenende'];

                    $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname'"
                            . "AND datum BETWEEN '$periodenbeginn' AND '$periodenende' ORDER BY datum, betrag;";

                    $beginn = date('d.m.Y', strtotime($periodenbeginn));
                    $ende = date('d.m.Y', strtotime($periodenende));
                    ?> 
                    <hr>
                    <section class="page-break-after">
                        <h2 class="pf-title">Nebenkosten für Haus <?php echo $table['bezeichnung'] ?> von <?php echo $beginn ?> bis <?php echo $ende ?></h2>
                      
                        <?php
                        $res = mysqli_query($link, $abfrage_NK) or die("Abfrage NK-Rechnungen hat nicht geklappt");

                        if (mysqli_num_rows($res) == 0) {
                            echo 'Keine Rechnungen erfasst';
                        } else {
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Rechnung</th>
                                        <th>Lieferant</th>
                                        <th>Kostenkategorie</th>
                                        <th>Betrag</th>                       
                                    </tr>
                                </thead>

                                <?php
                                while ($row = mysqli_fetch_array($res)) {

                                    $abrechnungstyp = $row['Abrechnung'];

                                    $summerg += $row['Betrag'];

                                    $anzahl +=1;
                                    $datumalt = strtotime($row['Datum']);
                                    $datum = date("d.m.Y", $datumalt);
                                    ?>

                                    <tr>
                                        <td><?php echo $datum; ?></td>
                                        <td><?php echo $row['Lieferant']; ?></td>
                                        <td><?php echo $row['Beschreibung']; ?></td>
                                        <td><?php echo $row['Betrag']; ?></td>

                                    </tr>
                                    <?php
                                }

                                if ($anzahl >= 1) {
                                    ?>
                                    <tr>
                                        <td><strong><?php echo 'TOTAL'; ?></strong></td>
                                        <td></td><td></td>
                                        <td><strong><?php echo number_format($summerg, 2); ?></strong></td>
                                        <td><?php echo ''; ?></td>
                                    </tr>
                                    <tr><td></td><td></td><td></td><td></td></tr>
                                    <tr>
                                        <td><strong><?php echo 'Anz. Wohnungen'; ?></strong></td>
                                        <td><?php echo $anzwhg; ?></td>
                                        <td><strong><?php echo 'Gesamtfläche'; ?></strong></td>
                                        <td><?php echo $flaeche; ?></td>                        
                                    </tr>

                                    <?php
                                }

                                $abfrage_kat = "SELECT kategorieID, beschreibung, abrechnung, SUM(betrag) as betrag "
                                        . "from nkrechnungenprohaus WHERE bezeichnung = '$hausname' "
                                        . "AND datum BETWEEN '$periodenbeginn' AND '$periodenende' GROUP BY kategorieID ORDER BY beschreibung;";

                                $res_kat = mysqli_query($link, $abfrage_kat) or die("Abfrage NK-Kategorien hat nicht geklappt");

                                if (mysqli_num_rows($res_kat) == 0) {
                                    echo 'Keine Kategorien erfasst';
                                } else {
                                    ?>
                                    <tr><td></td><td></td><td></td><td></td></tr>
                                    <tr>
                                        <th>Kostenkategorie</th>
                                        <th>Summe</th>
                                        <th>Abrechnung</th>
                                        <th>Anteil*</th>


                                        <th></th>
                                    </tr>


                                    <?php
                                    $summeanteilwhg = 0;
                                    $summeanteilfl = 0;

                                    while ($kat = mysqli_fetch_array($res_kat)) {
                                        $anteil = 0;
                                        $anteilfl = 0;
                                        $anteilwhg = 0;

                                        $abrechnung = $kat['Abrechnung'];
                                        $betrag = $kat['betrag'];
                                        if ($abrechnung == 'Wohnfläche') {
                                            $anteilfl = $betrag / $flaeche / 12;
                                            $summeanteilfl+= $anteilfl;
                                        } elseif ($abrechnung == 'Wohneinheit') {
                                            $anteilwhg = $betrag / $bewmonate;
                                            $summeanteilwhg += $anteilwhg;
                                        }

                                        $anteil = $anteilwhg + $anteilfl;
                                        ?>
                                        <tr>
                                            <td><?php echo $kat['Beschreibung']; ?></td>
                                            <td><?php echo $betrag; ?></td>
                                            <td><?php echo $abrechnung; ?></td>
                                            <td><?php echo number_format($anteil, 2); ?></td>
                                            <td></td>

                                        </tr>
                                    <?php }
                                    ?>
                                </table> 
                        <p>* Anteil Wohneinheit: Pro Monat, Pro Wohnung <br>* Anteil Wohnfläche: Pro Monat, pro Quadratmeter Ihrer Wohnung </p>

                        <br>


                                <?php
                                $abfrage_mieter = "SELECT wohnung.wohnungsNummer, wohnung.flaeche, mieter.mieterID, mieter.vorname, mieter.name,  mietvertrag.mietVertragID, mietvertrag.mietbeginn, mietvertrag.mietende, SUM(nkBetrag) as Summe
                FROM mietvertrag
				LEFT JOIN mieter on mieter.mieterID = mietvertrag.FK_mieterID
				LEFT JOIN wohnung on wohnung.wohnungID = mietvertrag.FK_wohnungID
				LEFT JOIN mietEingang on mietEingang.FK_mietVertragID = mietvertrag.mietVertragID
                WHERE wohnung.FK_hausID = '$hausID'
                and (mietvertrag.mietende >= '$periodenbeginn' OR mietvertrag.mietende is NULL)
                and (mietvertrag.mietbeginn <= '$periodenende')
                GROUP BY mietVertragID;";
                                $res_mieter = mysqli_query($link, $abfrage_mieter) or die("Abfrage Mieter hat nicht geklappt");

                                if (mysqli_num_rows($res_mieter) == 0) {
                                    echo 'Keine Mieter erfasst';
                                } else {
                                    ?>
                                    <table>                
                                        <tr>
                                            <th><?php echo 'Wohnung'; ?></th>
                                            <th><?php echo 'Mieter'; ?></th>
                                            <th><?php echo 'Zahlperiode / Anz. Mte.' ?></th>
<!--                                        <th><?php //echo 'Mte.'; ?></th>
                                            <th><?php //echo 'Anteil'; ?></th>
                                            <th><?php //echo 'Bezahlt'; ?></th>                        
                                            <th><?php //echo 'Offen'; ?></th>    -->
                                            <th></th>
                                        </tr>
                                        <?php
                                        //Periodenbeginn (Start Mietvertrag oder 01. Januar) evaluieren  
                                        while ($mietertable = mysqli_fetch_array($res_mieter)) {
                                            $anteilmieter = 0;

                                            $periodenbeginn = $_POST['periodenbeginn'];
                                            $periodenende = $_POST['periodenende'];

                                            $periodenbeginn = strtotime($periodenbeginn);
                                            $perbeginn = date('Ymd', $periodenbeginn);

                                            $mietbeginn = strtotime($mietertable['mietbeginn']);
                                            $mietbeginn = date('Ymd', $mietbeginn);

                                            if ($perbeginn < $mietbeginn) {
                                                $perbeginn = date('d.m.Y', strtotime($mietbeginn));
                                                // $perbeginn = $mietbeginn;
                                            }

                                            $perbeginn = date('d.m.Y', strtotime($perbeginn));

                                            //Periodenende (Ende Mietvertrag oder 31. Dezember) evaluieren  
                                            $periodenende = strtotime($periodenende);
                                            $perende = date('Ymd', $periodenende);

                                            $mietende = strtotime($mietertable['mietende']);
                                            $mietende = date('Ymd', $mietende);

                                            if ($mietende == '19700101') {
                                                $mietende = $perende;
                                            }

                                            if ($perende >= $mietende) {
                                                $perende = $mietende;
                                            }

                                            $perende = date('d.m.Y', strtotime($perende));

                                            //Berechnung Monate
                                            $anzahlmte;

                                            $d1 = new DateTime($perende);
                                            $d2 = new DateTime($perbeginn);
                                            $anzahlmte = date_diff($d1, $d2,TRUE );
                                            
                                            if($anzahlmte->m == 1){
                                                $anzahlmte =0;
                                            }
                                            
                                            $flaechewhg = $mietertable['flaeche'];

                                            $anteilmieter = (($anzahlmte->m + 1) * $summeanteilwhg) + (($anzahlmte->m + 1) * $flaechewhg * $summeanteilfl);
                                            $summeanteil += $anteilmieter;

//                                            $bezahlt = $mietertable['Summe'];
//                                            $offen = $anteilmieter - $bezahlt;
//                                            $offenmieter += $offen;

                                            $whgnr = $mietertable['wohnungsNummer'];
                                            $mietername = $mietertable['vorname'] . ' ' . $mietertable['name'];
                                            $mieterID = $mietertable['mieterID'];
                                            $mietvertragID = $mietertable['mietVertragID'];
                                            ?>
                                            <tr>
                                                <td><?php echo $whgnr ?></td>
                                                <td><?php echo $mietername ?></td>
                                                <td><?php echo $perbeginn . ' - ' . $perende.' / '.($anzahlmte->m + 1).' Monate'; ?></td>
<!--                                                <td><?php //echo $anzahlmte->m + 1; ?></td>-->
<!--                                                <td><?php //echo number_format($anteilmieter, 2); ?></td>
                                                <td><?php //echo number_format($bezahlt,2); ?></td>
                                                <td><?php //echo number_format($offen, 2); ?></td> -->
                                                <th class = "print-no"><a href="abrechnung_mieter_pdf.php?mietvertragID=<?php echo $mietvertragID ?>&von=<?php echo $perbeginn ?>&bis=<?php echo $perende ?> "target="_blank" style="color:#6D9F00;text-decoration:none;" title="PDF anzeigen">
                                                        <img style="border:none;-webkit-box-shadow:none;box-shadow:none;
                                                             " src='Images/Icon_PDF.png' alt="PDF anzeigen"/></a></th>
                                            </tr>

                                            <?php
                                        }

//                                        $differenz = $summerg - $summeanteil;
//                                        $gewinn = 0;
//                                        $verlust = 0;
//                                        $offenmieter = number_format($offenmieter, 2);
//
//                                        if ($differenz <= 0) {
//                                            $gewinn = number_format((-1 * (round($differenz * 20, 0) / 20)), 2);
//                                            $verlust = '';
//                                        } else {
//                                            $verlust = number_format((round($differenz * 20, 0) / 20), 2);
//                                            $gewinn = '';
//                                        }
//                                        ?>
<!--                                        <tr></tr><tr>
                                            <td><strong><?php //echo 'Verrechenbar'; ?></strong></td>
                                            <td><?php //echo number_format($summeanteil, 2); ?></td>
                                            <td><strong><?php //echo 'Offen: ' . $offenmieter; ?></strong></td>
                                            <td></td><td></td><td></td><td></td><td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>//<?php //echo 'Verlust'; ?></strong></td>
                                            <td><FONT COLOR='#ff4300'>//<?php //echo $verlust; ?></td>
                                            <td><strong>//<?php //echo 'Gewinn'; ?></strong></td>
                                            <td><FONT COLOR='#04f014'>//<?php //echo $gewinn; ?></td>
                                            <td></td><td></td><td></td><td></td>
                                        </tr>-->

                                        <?php
                                    }
                                }
                            }
                            ?>
                        </table>
                        <br>
                    </section>
                    <?php
                }
            }
            ?>
        </div>
    </body>


    <?php
    include 'footer.inc.php';
    ?>
</html>
