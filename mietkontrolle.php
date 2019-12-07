<?php
//include 'topbar.inc.php';
//include 'loginCheck.inc.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Kontrolle Mietzahlungen</title>
    </head>


    <body>
        <div class="report">

            <h1>Kontrolle der Mietzahlungen</h1>

            <?php
            $abfrage_jahr = "SELECT DISTINCT YEAR(datum) as jahr FROM mietEingang ORDER BY jahr;";
            $res_jahr = mysqli_query($link, $abfrage_jahr) or die("Abfrage Jahr hat nicht geklappt");
            ?>
            <form name ="jahrauswahl" method="post">
                <select class="input-group" name="jahr" required>
            <?php
            $sql = mysqli_query($link, $abfrage_jahr);


            //Default Value anzeigen falls nichts ausgewählt
            if ($jahr == NULL) {
                echo '<option value="" disabled selected>Select your option</option>';
            } else {
                echo '<option value="" disabled>Select your option</option>';
            }

            //Werte auflisten
            while ($row = $sql->fetch_assoc()) {

                $select_attribute = "";

                if ($row['jahr'] == $jahr) {
                    $select_attribute = 'selected';
                    echo "<option value=" . $row['jahr'] . " selected = " . $select_attribute . ">" . $row['jahr'] . "</option>";
                } else {
                    echo "<option value=" . $row['jahr'] . ">" . $row['jahr'] . "</option>";
                }
            }
            ?>

                </select>
                <!-- TODO: Obere Optionen noch so formulieren wie hier unten, damit ausgewähltes Jahr im Dropdown stehen bleibt -->   
                <!-- <option value="2019"<?php if ($dropDownVal == 2019) echo 'selected'; ?>>2019</option> -->


                <button class="btn" type="submit" name="show" >Anzeigen</button>          

            </form>

<?php
if (isset($_POST['show'])) {
    $jahr = $_POST['jahr'];

    $abfrage_monat = "SELECT * FROM perioden";
    $res_monat = mysqli_query($link, $abfrage_monat) or die("Abfrage Monate hat nicht geklappt");

    while ($monatrow = mysqli_fetch_array($res_monat)) {
        $monatID = $monatrow['periodID'];
        $monatName = $monatrow['periodeLang'];
        $periodenbeginn = DATE($jahr . '-' . $monatID . '-01');
        $periodenende = DATE($jahr . '-' . $monatID . '-28');

        // Abfrage funktioniert noch nicht richtig, Daten (Zeile 2, 3) werden nicht korrekt verglichen              
        $abfrage_kontrolle = "SELECT * FROM mietvertrag, mieter, wohnung WHERE 
                    mietbeginn <= '$periodenbeginn' 
                    AND (mietende >= '$periodenende' OR mietende IS NULL)
                    AND mietvertrag.FK_mieterID = mieter.MieterID
                    AND mietvertrag.FK_wohnungID = wohnung.wohnungID
                    AND mietVertragID NOT IN (SELECT mietEingang.mietEingangID FROM mietEingang WHERE mietEingang.FK_periode=$monatID) ORDER BY name;";
        $res_kontrolle = mysqli_query($link, $abfrage_kontrolle) or die("Abfrage Zahlungen hat nicht geklappt");

        ?>

                    <h2 class="pf-title">Fehlende Mietzahlungen für <?php echo $monatName ?></h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Mietername</th>
                                <th>Wohnung</th>
                                <th>Miete</th>
                                <th>Nebenkosten</th>
                                <th>Mietbeginn</th>
                                <th>Mietende</th>                        
                            </tr>
                        </thead>
        <?php
        while ($table = mysqli_fetch_array($res_kontrolle)) {
                        
            $datalt = strtotime($table['mietbeginn']);
            $mietbeginn = date("d.m.Y", $datalt);
            
            $datalt2 = strtotime($table['mietende']);
            $mietende = date("d.m.Y", $datalt2);
            
            
            ?> 

                            <tr>
                                <td><?php echo $table['vorname'] . ' ' . $table['name']; ?></td>
                                <td><?php echo $table['wohnungsNummer']; ?></td>
                                <td><?php echo $table['mietzins_mtl']; ?></td>
                                <td><?php echo $table['nebenkosten_mtl']; ?></td>
                                <td><?php echo $mietbeginn; ?></td>
                                <td><?php echo $mietende; ?></td>


                            </tr>


            <?php
        }
        ?>                       
                    </table> 
                    <br>
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
