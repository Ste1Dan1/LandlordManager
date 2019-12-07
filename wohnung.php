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
        <title>LandlordManager - Wohnungen verwalten</title>
    </head>
    <body>
        <div class="pagecontent">
            <?php
            include('wohnungDB.php');
            if (isset($_SESSION['message'])):
                ?>
                <div class="msg">
                    <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif ?>
            <h1>Wohnungen verwalten</h1>
            <?php
            $abfrageHaus = "SELECT DISTINCT hausID, bezeichnung FROM haus INNER JOIN wohnung ON `wohnung`.`FK_hausID` = `haus`.`hausID` ORDER BY bezeichnung";
            $resHaus = mysqli_query($link, $abfrageHaus) or die("Abfrage hat nicht geklappt");
            while ($rowHaus = mysqli_fetch_array($resHaus)) {
                $hID = $rowHaus['hausID'];



                $abfrage = "SELECT `haus`.*, `wohnung`.* FROM `wohnung` "
                        . "LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID` "
                        . "WHERE `wohnung`.`FK_hausID` = $hID ORDER BY bezeichnung, wohnungsNummer;";


                $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
                ?>
                <table>
                    <thead>
                        <tr> <th> <?php echo $rowHaus['bezeichnung']; ?></th> </tr>
                        <tr>
                            <th>Wohnungsnummer</th>
                            <th>Zimmer</th>
                            <th>Fläche</th>
                            <th colspan="2">Aktion</th>
                        </tr>
                    </thead>

                    <?php while ($row = mysqli_fetch_array($res)) { ?>
                        <tr>
                            <td><?php echo $row['wohnungsNummer']; ?></td>
                            <td><?php echo $row['zimmer']; ?></td>
                            <td><?php echo $row['flaeche']; ?></td>
                            <td>
                                <a href="wohnung.php?edit= <?php echo $row['wohnungID']; ?>" class="edit_btn" >Ändern</a>
                            </td>
                            <td>
                                <?php
                                $wohnung_id = $row['wohnungID'];
                                $abfrage_mietvertraege = "SELECT count(*) AS mietvertraege FROM mietvertrag WHERE FK_wohnungID=$wohnung_id";
                                $res_mietvertraege = mysqli_query($link, $abfrage_mietvertraege) or die("Abfrage hat nicht geklappt");
                                $has_mietvertraege = (int) current(mysqli_fetch_array($res_mietvertraege)) > 0;
                                ?>
                                <a href="wohnungDB.php?del=<?php echo $row['wohnungID']; ?>" class="del_btn <?php if ($has_mietvertraege) echo "disabled" ?>" >Löschen</a>
                            </td>
                        </tr>

                    <?php } ?>
                    <br>
                <?php } ?>
            </table>




            <form method="post" action="wohnungDB.php" >

                <div class="input-group">
                    <label>Haus</label>
                    <select name="FK_hausID" required>
                        <?php
                        $sql = mysqli_query($link, "SELECT `haus`.*FROM `haus` ORDER BY bezeichnung;");

                        //Default Value anzeigen falls nichts ausgewählt
                        if ($mieter == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        while ($row = $sql->fetch_assoc()) {

                            $select_attribute = "";

                            if ($row['hausID'] == $FK_hausID) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $row['hausID'] . "' selected = " . $select_attribute . ">" . $row['bezeichnung'] . ", " . $row['ort'] . "</option>";
                            } else {
                                echo "<option value='" . $row['hausID'] . "'>" . $row['bezeichnung'] . ", " . $row['ort'] . "</option>";
                            }
                        }
                        ?>

                    </select>
                </div>    


                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="input-group">
                    <label>Wohnungsnummer</label>
                    <input type="number" min="0" name="wohnungsNummer" required value="<?php echo $wohnungsNummer; ?>">
                </div>
                <div class="input-group">
                    <label>Zimmer</label>
                    <input type="number" min="1" step="0.5" name="zimmer" required value="<?php echo $zimmer; ?>">
                </div>
                <div class="input-group">
                    <label>Fläche</label>
                    <input type="number" min="1" name="flaeche" required value="<?php echo $flaeche; ?>">
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
