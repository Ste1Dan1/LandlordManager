<?php
include 'topbar.inc.php';
include 'loginCheck.inc.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Mietverträge verwalten</title>
    </head>

    <body>
        <div class="pagecontent">

            <h1>Mietverträge verwalten</h1>
            <?php
            include('mietvertragDB.php');


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
            $resHaus = mysqli_query($link, $abfrageHaus) or die("Abfrage hat nicht geklappt");
            while ($rowHaus = mysqli_fetch_array($resHaus)) {
                $hID = $rowHaus['hausID'];

                $abfrage = "SELECT `mietvertrag`.`mietVertragID`, `mietvertrag`.`mietbeginn`, `mietvertrag`.`mietende`, `mietvertrag`.`mietzins_mtl`, `mietvertrag`.`nebenkosten_mtl`,  `mieter`.`name`,`mieter`.`vorname` , `haus`.`bezeichnung` AS `Immobilie`,`wohnung`.`wohnungsNummer`
        FROM `mietvertrag` 
	LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
	LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` 
	LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID`
        WHERE `wohnung`.`FK_hausID` = $hID ORDER BY `haus`.`bezeichnung`, `wohnung`.`wohnungsNummer`, `mietvertrag`.`mietbeginn`;";

                $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
                ?>
                <table>
                    <thead>
                        <tr> <th> <?php echo $rowHaus['bezeichnung']; ?></th> </tr>

                        <tr>
                            <th>Mieter</th>
                            <th>Wohnung</th>
                            <th>Mietbeginn</th>
                            <th>Mietende</th>
                            <th style="text-align: right">Mietzins</th>
                            <th style="text-align: right">Nebenkosten</th>

                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <?php
                    while ($row = mysqli_fetch_array($res)) {
                        $mbalt = strtotime($row['mietbeginn']);
                        $mbdatum = date("d.m.Y", $mbalt);
                        $mealt = strtotime($row['mietende']);
                        $medatum = date("d.m.Y", $mealt);
                        if ($medatum == '01.01.1970') {
                            $medatum = '';
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['name'] . " " . $row['vorname']; ?></td>
                            <td><?php echo $row['wohnungsNummer']; ?></td>
                            <td><?php echo $mbdatum; ?></td>
                            <td><?php echo $medatum; ?></td>
                            <td style="text-align: right"><?php echo $row['mietzins_mtl']; ?></td>
                            <td style="text-align: right"><?php echo $row['nebenkosten_mtl']; ?></td>

                            <td>
                                <a href="mietvertrag.php?edit= <?php echo $row['mietVertragID']; ?>" class="edit_btn" >Ändern</a>
                            </td>
                            <td>
                                <?php
                                $mietvertrag_id = $row['mietVertragID'];
                                $abfrage_mieteingang = "SELECT count(*) AS mieteingaenge FROM mietEingang WHERE FK_mietVertragID=$mietvertrag_id";
                                $res_mieteingaenge = mysqli_query($link, $abfrage_mieteingang) or die("Abfrage hat nicht geklappt");
                                $has_mieteingaenge = (int) current(mysqli_fetch_array($res_mieteingaenge)) > 0;
                                ?>
                                <a href="mietvertragDB.php?del=<?php echo $row['mietVertragID']; ?>" class="del_btn <?php if ($has_mieteingaenge) echo "disabled" ?>" >Löschen</a>
                            </td>
                        </tr>
                        </tr>
                    <?php } ?>
                    <br>
                <?php } ?>
            </table>




            <form method="post" action="mietvertragDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">



                <div class="input-group">

                    <label>Mieter</label>
                    <select class="input-group" name="mieter" required>
                        <?php
                        $sql = mysqli_query($link, "SELECT mieterID, name, vorname FROM mieter ORDER BY name");


                        //Default Value anzeigen falls nichts ausgewählt
                        if ($mieter == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        //Werte auflisten
                        while ($row = $sql->fetch_assoc()) {

                            $select_attribute = "";

                            if ($row['mieterID'] == $mieter) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $row['mieterID'] . "' selected = " . $select_attribute . ">" . $row['name'] . " " . $row['vorname'] . "</option>";
                            } else {
                                echo "<option value='" . $row['mieterID'] . "'>" . $row['name'] . " " . $row['vorname'] . "</option>";
                            }
                        }
                        ?>

                    </select>

                </div>

                <div class="input-group">
                    <label>Haus / Wohnung</label>
                    <select name="wohnung" required>
                        <?php
                        $sql = mysqli_query($link, "SELECT wohnungID, wohnungsNummer, bezeichnung, ort FROM wohnung LEFT JOIN haus on FK_hausID = hausID ORDER BY bezeichnung, wohnungsNummer ASC;");

                        //Default Value anzeigen falls nichts ausgewählt
                        if ($mieter == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        while ($row = $sql->fetch_assoc()) {

                            $select_attribute = "";

                            if ($row['wohnungID'] == $wohnung) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $row['wohnungID'] . "' selected = " . $select_attribute . ">" . $row['bezeichnung'] . ", " . $row['ort'] . " / " . $row['wohnungsNummer'] . "</option>";
                            } else {
                                echo "<option value='" . $row['wohnungID'] . "'>" . $row['bezeichnung'] . ", " . $row['ort'] . " / " . $row['wohnungsNummer'] . "</option>";
                            }
                        }
                        ?>

                    </select>
                </div>    

                <div class="input-group">
                    <label>Mietbeginn</label>
                    <input type="date" name="mietbeginn" required value="<?php echo $mietbeginn; ?>">
                </div>
                <div class="input-group">
                    <label>Mietende</label>
                    <input type="date" name="mietende"   value="<?php echo $mietende; ?>">
                </div>
                <div class="input-group">
                    <label>Mietzins / Monat</label>
                    <input type="number" min="0" name="mietzins_mtl" required value="<?php echo $mietzins; ?>">
                </div>
                <div class="input-group">
                    <label>Nebenkosten / Monat</label>
                    <input type="number" min="0" name="nebenkosten_mtl" required value="<?php echo $nebenkosten; ?>">
                </div>
                <div class="input-group">

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
