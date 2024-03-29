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
        <title>LandlordManager - Häuser verwalten</title>
    </head>
    <body>
        <div class="pagecontent">
            <?php
            include('hausDB.php');

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
            $abfrage = "SELECT * from haus ORDER BY bezeichnung";
            $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
            ?>
            <h1>Häuser verwalten</h1>

            <table>
                <thead>
                    <tr>
                        <th>Bezeichnung</th>
                        <th>Strasse / Nr.</th>
                        <th>PLZ</th>
                        <th>Ort</th>
                        <th>Anz. Whg.</th>
                        <th>Baujahr</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>

                <?php while ($row = mysqli_fetch_array($res)) { ?>
                    <tr>
                        <td><?php echo $row['bezeichnung']; ?></td>
                        <td><?php echo $row['strasse_nr']; ?></td>
                        <td><?php echo $row['plz']; ?></td>
                        <td><?php echo $row['ort']; ?></td>
                        <td><?php echo $row['anz_whg']; ?></td>
                        <td><?php echo $row['baujahr']; ?></td>
                        <td>
                            <a href="haus.php?edit= <?php echo $row['hausID']; ?>" class="edit_btn" >Ändern</a>
                        </td>
                        <td>
                            <?php
                            $haus_id = $row['hausID'];
                            $abfrage_wohnungen = "SELECT count(*) AS wohnungen FROM wohnung WHERE FK_hausID=$haus_id";
                            $res_wohnungen = mysqli_query($link, $abfrage_wohnungen) or die("Abfrage hat nicht geklappt");
                            $has_wohnungen = (int) current(mysqli_fetch_array($res_wohnungen)) > 0;
                            ?>
                            <a href="hausDB.php?del=<?php echo $row['hausID']; ?>" class="del_btn <?php if ($has_wohnungen) echo "disabled" ?>" >Löschen</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <form method="post" action="hausDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">



                <div class="input-group">
                    <label>Bezeichnung</label>
                    <input type="text" name="bezeichnung" required value="<?php echo $bezeichnung; ?>">
                </div>
                <div class="input-group">
                    <label>Strasse / Nr.</label>
                    <input type="text" name="strasse_nr" required value="<?php echo $strasse_nr; ?>">
                </div>
                <div class="input-group">
                    <label>PLZ</label>
                    <input type="number" name="plz" min="1000" max="9999" required value="<?php echo $plz; ?>">
                </div>
                <div class="input-group">
                    <label>Ort</label>
                    <input type="text" name="ort" required value="<?php echo $ort; ?>">
                </div>
                <div class="input-group">
                    <label>Anzahl Wohng.</label>
                    <input type="number" min="0" name="anz_whg" required value="<?php echo $anz_whg; ?>">
                </div>
                <div class="input-group">
                    <label>Baujahr</label>
                    <input type="number" min="0" name="baujahr" required value="<?php echo $baujahr; ?>">
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
