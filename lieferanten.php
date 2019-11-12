<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>
    <body>
        <?php
        include('lieferantenDB.php');
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
               
        $abfrage = "SELECT * from lieferanten ORDER BY name";
        mysqli_query($link, "SET NAMES 'utf8'");
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
        ?>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Strasse, Nr.</th>
                    <th>PLZ</th>
                    <th>Ort</th>
                    <th colspan="2">Aktion</th>
                </tr>
            </thead>
            
            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['strasse_nr']; ?></td>
                    <td><?php echo $row['plz']; ?></td>
                    <td><?php echo $row['ort']; ?></td>
                    <td>
                        <a href="lieferanten.php?edit= <?php echo $row['lieferantID']; ?>" class="edit_btn" >Ändern</a>
                    </td>
                    <td>
                        <?php
                        $lieferant_id = $row['lieferantID'];
                        $abfrage_nk_rechnungen = "SELECT count(*) AS nk_rechnungen FROM nkrechnungen WHERE FK_lieferantID=$lieferant_id";
                        $res_nk_rechnungen = mysqli_query($link, $abfrage_nk_rechnungen) or die("Abfrage hat nicht geklappt");
                        $has_nk_rechnungen = (int) current(mysqli_fetch_array($res_nk_rechnungen)) > 0;
                        ?>
                        <a href="lieferantenDB.php?del=<?php echo $row['hausID']; ?>" class="del_btn <?php if ($has_nk_rechnungen) echo "disabled" ?>" >Löschen</a>
                    </td>
                </tr>
            <?php } ?>
        </table>




        <form method="post" action="lieferantenDB.php" >

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" required value="<?php echo $name; ?>">
            </div>
            <div class="input-group">
                <label>Strasse, Nr.</label>
                <input type="text" name="strasse_nr" required value="<?php echo $strasse_nr; ?>">
            </div>
            <div class="input-group">
                <label>PLZ</label>
                <input type="text" name="plz" required value="<?php echo $plz; ?>">
            </div>
            <div class="input-group">
                <label>Ort</label>
                <input type="text" name="ort" required value="<?php echo $ort; ?>">
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
    </body>
</html>