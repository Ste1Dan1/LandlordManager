<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>

    <body>
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
        $abfrage = "SELECT `mietvertrag`.`mietVertragID`, `mietvertrag`.`mietbeginn`, `mietvertrag`.`mietende`, `mietvertrag`.`mietzins_mtl`, `mietvertrag`.`nebenkosten_mtl`,  `mieter`.`name` AS `Mieter`, `haus`.`bezeichnung` AS `Immobilie`,`wohnung`.`wohnungsNummer`
        FROM `mietvertrag` 
	LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
	LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` 
	LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID` ORDER BY `haus`.`bezeichnung`, `wohnung`.`wohnungID`, `mietvertrag`.`mietbeginn`;";
        mysqli_query($link, "SET NAMES 'utf8'");
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
        ?>

        <table>
            <thead>
                <tr>
                    <th>Mieter</th>
                    <th>Immobilie</th>
                    <th>Wohnung</th>
                    <th>Mietbeginn</th>
                    <th>Mietende</th>
                    <th>Mietzins / Monat</th>
                    <th>Nebenkosten / Monat</th>

                    <th colspan="2">Action</th>
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($res)) { 
                    $mbalt = strtotime($row['mietbeginn']);
                    $mbdatum = date("d.m.Y", $mbalt);
                    $mealt = strtotime($row['mietende']);
                    $medatum = date("d.m.Y", $mealt);
                    if ($medatum =='01.01.1970'){
                    $medatum='';
                }
                
                ?>
                <tr>
                    <td><?php echo $row['Mieter']; ?></td>
                    <td><?php echo $row['Immobilie']; ?></td>
                    <td><?php echo $row['wohnungsNummer']; ?></td>
                    <td><?php echo $mbdatum; ?></td>
                    <td><?php echo $medatum; ?></td>
                    <td><?php echo $row['mietzins_mtl']; ?></td>
                    <td><?php echo $row['nebenkosten_mtl']; ?></td>

                    <td>
                        <a href="mietvertrag.php?edit= <?php echo $row['mietVertragID']; ?>" class="edit_btn" >Ändern</a>
                    </td>
                    <td>
                        <?php
                        $mietvertrag_id = $row['mietVertragID'];
                        $abfrage_mieteingang = "SELECT count(*) AS mieteingaenge FROM mieteingang WHERE FK_mietVertragID=$mietvertrag_id";
                        $res_mieteingaenge = mysqli_query($link, $abfrage_mieteingang) or die("Abfrage hat nicht geklappt");
                        $has_mieteingaenge = (int) current(mysqli_fetch_array($res_mieteingaenge)) > 0;
                        ?>
                        <a href="mietvertragDB.php?del=<?php echo $row['mietVertragID']; ?>" class="del_btn <?php if ($has_mieteingaenge) echo "disabled" ?>" >Löschen</a>
                    </td>
                </tr>
                </tr>
            <?php }
            ?>
        </table>




        <form method="post" action="mietvertragDB.php" >

            <input type="hidden" name="id" value="<?php echo $id; ?>">



            <div class="input-group">

                <label>Mieter</label>
                <select class="input-group" name="mieter" required>
                    <?php
                    $sql = mysqli_query($link, "SELECT mieterID, name, vorname FROM mieter");


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
                <input type="date" name="mietende"  value="<?php echo $mietende; ?>">
            </div>
            <div class="input-group">
                <label>Mietzins / Monat</label>
                <input type="text" name="mietzins_mtl" required value="<?php echo $mietzins; ?>">
            </div>
            <div class="input-group">
                <label>Nebenkosten / Monat</label>
                <input type="text" name="nebenkosten_mtl" required value="<?php echo $nebenkosten; ?>">
            </div>
            <div class="input-group">

                <?php if ($update == true): ?>
                    <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
                    <button class="btn" type="submit" name="cancel" formnovalidate style="background: #556B2F;" >cancel</button>
                <?php else: ?>
                    <button class="btn" type="exit" name="save" >Save</button>
                <?php endif ?>

            </div>
        </form>
    </body>
</html>
