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

            <?php
            $abfrage = "SELECT `haus`.*, `wohnung`.* FROM `wohnung` LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID` ORDER BY bezeichnung, wohnungsNummer;";
          
            $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
            ?>
            <h1>Wohnungen verwalten</h1>

            <table>
                <thead>
                    <tr>
                        <th>Haus</th>
                        <th>Wohnungsnummer</th>
                        <th>Zimmer</th>
                        <th>Fläche</th>
                        <th>Haus</th>
                        <th colspan="2">Aktion</th>
                    </tr>
                </thead>

                <?php while ($row = mysqli_fetch_array($res)) { ?>
                    <tr>
                        <td><?php echo $row['bezeichnung']; ?></td>
                        <td><?php echo $row['wohnungsNummer']; ?></td>
                        <td><?php echo $row['zimmer']; ?></td>
                        <td><?php echo $row['flaeche']; ?></td>
                        <td><?php echo $row['FK_hausID']; ?></td>
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
                                echo "<option value='" . $row['hausID'] . "'>" . $row['bezeichnung'] . ", " . $row['ort']  . "</option>";
                            }
                        }
                        ?>

                    </select>
                </div>    


                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="input-group">
                    <label>Wohnungsnummer</label>
                    <input type="text" name="wohnungsNummer" required value="<?php echo $wohnungsNummer; ?>">
                </div>
                <div class="input-group">
                    <label>Zimmer</label>
                    <input type="text" name="zimmer" required value="<?php echo $zimmer; ?>">
                </div>
                <div class="input-group">
                    <label>Fläche</label>
                    <input type="text" name="flaeche" required value="<?php echo $flaeche; ?>">
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