<?php
include 'topbar.inc.php';
include 'loginCheck.inc.php';

include('mietzahlungDB.php');
?>


<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Mietzahlungen verwalten</title>
    </head>

    <body>
        <div class="pagecontent">

            <h1>Mietzahlungen verwalten</h1>

            <?php
            if (isset($_SESSION['message'])):
                ?>
                <div class="msg">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif ?>
            <?php
            $abfrageHaus = "SELECT DISTINCT hausID, bezeichnung FROM haus INNER JOIN wohnung ON `wohnung`.`FK_hausID` = `haus`.`hausID` ORDER BY bezeichnung";
            $resHaus = mysqli_query($link, $abfrageHaus) or die("Haus error");
            while ($rowHaus = mysqli_fetch_array($resHaus)) {
                $hID = $rowHaus['hausID'];

                $abfrage = "SELECT `mietEingang`.*, `mietvertrag`.*, `wohnung`.*, `haus`.*, `perioden`.*, `mieter`.*
            FROM `mietEingang` 
            LEFT JOIN `mietvertrag` ON `mietEingang`.`FK_mietVertragID` = `mietvertrag`.`mietVertragID` 
            LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
            LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID` 
            LEFT JOIN `perioden` ON `mietEingang`.`FK_periode` = `perioden`.`periodID` 
            LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` WHERE `wohnung`.`FK_hausID` = $hID ORDER BY jahr, FK_periode, name ;";


                $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
                ?>


                <table>
                    <thead>
                        <tr> <th> <?php echo $rowHaus['bezeichnung']; ?></th> </tr>
                        <tr>
                            <th>Mieter</th>
                            <th>Wohnung</th>
                            <th>Zahlungsdatum</th>
                            <th  style="text-align: right">Miete-Betrag</th>
                            <th  style="text-align: right">NK-Betrag</th>
                            <th>Periode</th>
                            <th>Jahr</th>

                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        $zahldatalt = strtotime($row['datum']);
                        $zahldatum = date("d.m.Y", $zahldatalt);
                        ?>
                        <tr>
                            <td><?php echo $row['name'] . " " . $row['vorname']; ?></td>
                            <td><?php echo $row['wohnungsNummer']; ?></td>
                            <td><?php echo $zahldatum; ?></td>
                            <td style="text-align: right"><?php echo $row['mietBetrag']; ?></td>
                            <td style="text-align: right"><?php echo $row['nkBetrag']; ?></td>
                            <td style="text-align: center"><?php echo $row['periodeKurz']; ?></td>
                            <td><?php echo $row['jahr']; ?></td>

                            <td>
                                <a href="mietzahlung.php?edit= <?php echo $row['mietEingangID']; ?>" class="edit_btn" >Ändern</a>
                            </td>
                            <td>
                                <a href="mietzahlungDB.php?del=<?php echo $row['mietEingangID']; ?>" class="del_btn">Löschen</a>
                            </td>
                        </tr>
                        </tr>
                    <?php } ?>
                    <br>
                <?php } ?>
            </table>




            <form method="post" action="mietzahlungDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">



                <div class="input-group">

                    <label>Mietvertrag</label>
                    <select name="mietvertrag" required>
                        <?php
                        $sql = mysqli_query($link, "SELECT `mietvertrag`.*, `wohnung`.*, `mieter`.*, `haus`.*
                        FROM `mietvertrag` 
                            LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
                            LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` 
                            LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID` ORDER BY `haus`.`bezeichnung`, `wohnung`.`wohnungsNummer`;");

                        //Default Value anzeigen falls nichts ausgewählt
                        if ($mietvertrag == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        while ($row = $sql->fetch_assoc()) {

                            $select_attribute = "";

                            if ($row['mietVertragID'] == $mietVertrag) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $row['mietVertragID'] . "' selected = " . $select_attribute . ">" . $row['vorname'] . " " . $row['name'] . " / " . $row['bezeichnung'] . " " . $row['wohnungsNummer'] . "</option>";
                            } else {
                                echo "<option value='" . $row['mietVertragID'] . "'>" . $row['name'] . " " . $row['vorname'] . " / " . $row['bezeichnung'] . " " . $row['wohnungsNummer'] . "</option>";
                            }
                        }
                        ?>

                    </select>

                </div>


                <div class="input-group">
                    <label>Zahlungsdatum</label>
                    <input type="date" name="zahlungsdatum"  value="<?php echo $zahlungsdatum; ?>">
                </div>

                <div class="input-group">
                    <label>Miet-Betrag</label>
                    <input type="number" min="0" name="mietbetrag" required value="<?php echo $mietbetrag; ?>">
                </div>
                <div class="input-group">
                    <label>NK-Betrag</label>
                    <input type="number" min="0" name="nkbetrag" required value="<?php echo $nkbetrag; ?>">
                </div>


                <div class="input-group">
                    <label>Periode</label>
                    <select name="periode" required>
                        <?php
                        $sql = mysqli_query($link, "SELECT * FROM perioden");

                        //Default Value anzeigen falls nichts ausgewählt
                        if ($periode == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        while ($row = $sql->fetch_assoc()) {

                            $select_attribute = "";

                            if ($row['periodID'] == $periode) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $row['periodID'] . "' selected = " . $select_attribute . ">" . $row['periodeLang'] . "</option>";
                            } else {
                                echo "<option value='" . $row['periodID'] . "'>" . $row['periodeLang'] . "</option>";
                            }
                        }
                        ?>

                    </select>
                </div>    

                <div class="input-group">
                    <label>Jahr</label>
                    <select name="jahr" required>


                        <?php
                        $years = array("2019", "2020", "2021", "2022");

                        if ($jahr == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        for ($i = 0; $i < count($years); $i++) {

                            $select_attribute = "";

                            if ($years[$i] == $jahr) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $years[$i] . "' selected = " . $select_attribute . ">" . $years[$i] . "</option>";
                            } else {
                                echo "<option value='" . $years[$i] . "'>" . $years[$i] . "</option>";
                            }
                        }
                        ?>





                    </select>
                </div>    
                <?php if ($update == true): ?>
                    <button class="btn" type="submit" name="update" style="background: #556B2F;" >Ändern</button>
                    <button class="btn" type="submit" name="cancel" formnovalidate style="background: #556B2F;" >Abbrechen</button>
                <?php else: ?>
                    <button class="btn" type="exit" name="save" >Speichern</button>
                <?php endif ?>

        </div>
    </form>
</div>
</body>

<?php
include 'footer.inc.php';
?>

</html>
