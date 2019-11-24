<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Nebenkostenrechnungen verwalten</title>
    </head>
    <body>
        <div class="pagecontent">


            <?php
            include('nkrechnungenDB.php');

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
            $abfrage = "SELECT nkrechnungen.*, haus.bezeichnung AS haus_bezeichnung, lieferanten.name AS lieferant_name, "
                    . "kostenkategorien.abrechnung AS kostenkat_abrechnung, "
                    . "kostenkategorien.beschreibung AS kostenkat_beschreibung "
                    . "FROM nkrechnungen LEFT JOIN haus ON nkrechnungen.FK_hausID=haus.hausID "
                    . "LEFT JOIN lieferanten ON nkrechnungen.FK_lieferantID=lieferanten.lieferantID "
                    . "LEFT JOIN kostenkategorien ON nkrechnungen.FK_kostKatID=kostenkategorien.kostKatID "
                    . "ORDER BY rgdatum";
           
            $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
            ?>
            <h1>Nebenkostenrechnungen verwalten</h1>

            <table>
                <thead>
                    <tr>
                        <th>Rechnungsdatum</th>
                        <th>Haus</th>
                        <th>Lieferant</th>
                        <th>Kostenkategorie</th>
                        <th>Beschreibung</th>
                        <th>Betrag</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>

                <?php
                while ($row = mysqli_fetch_array($res)) {
                    $datalt = strtotime($row['rgdatum']);
                    $datum = date("d.m.Y", $datalt);
                    ?>
                    <tr>
                        <td><?php echo $datum; ?></td>
                        <td><?php echo $row['haus_bezeichnung']; ?></td>
                        <td><?php echo $row['lieferant_name']; ?></td>
                        <td><?php echo $row['kostenkat_abrechnung']; ?></td>
                        <td><?php echo $row['kostenkat_beschreibung']; ?></td>
                        <td><?php echo $row['betrag']; ?></td>
                        <td>
                            <a href="nkrechnungen.php?edit= <?php echo $row['nkRechnungID']; ?>" class="edit_btn" >Ändern</a>
                        </td>
                        <td>
                            <a href="nkrechnungenDB.php?del=<?php echo $row['nkRechnungID']; ?>" class="del_btn" >Löschen</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <form method="post" action="nkrechnungenDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="input-group">
                    <label>Rechnungsdatum</label>
                    <input type="date" name="rgdatum" required value="<?php echo $bezeichnung; ?>">
                </div>

                <?php
                $abfrage_haus = "SELECT * FROM haus";
                mysqli_query($link, "SET NAMES 'utf8'");
                $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage hat nicht geklappt");
                ?>
                <div class="input-group">
                    <label>Haus</label>
                    <select name="FK_hausID">
                        <?php while ($row = mysqli_fetch_array($res_haus)) { ?>
                            <option value="<?php echo $row['hausID'] ?>" <?php if ($fk_haus_id === $row['hausID']) echo 'selected' ?>><?php echo $row['bezeichnung'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php
                $abfrage_lieferanten = "SELECT * FROM lieferanten";
                mysqli_query($link, "SET NAMES 'utf8'");
                $res_lieferanten = mysqli_query($link, $abfrage_lieferanten) or die("Abfrage hat nicht geklappt");
                ?>
                <div class="input-group">
                    <label>Lieferant</label>
                    <select name="FK_lieferantID">
                        <?php while ($row = mysqli_fetch_array($res_lieferanten)) { ?>
                            <option value="<?php echo $row['lieferantID'] ?>" <?php if ($fk_lieferant_id === $row['lieferantID']) echo 'selected' ?>><?php echo $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php
                $abfrage_kostenkategorien = "SELECT * FROM kostenkategorien";
                mysqli_query($link, "SET NAMES 'utf8'");
                $res_kostenkategorien = mysqli_query($link, $abfrage_kostenkategorien) or die("Abfrage hat nicht geklappt");
                ?>
                <div class="input-group">
                    <label>Kostenkategorie</label>
                    <select name="FK_kostKatID">
                        <?php while ($row = mysqli_fetch_array($res_kostenkategorien)) { ?>
                            <option value="<?php echo $row['kostKatID'] ?>" <?php if ($fk_lieferant_id === $row['kostKatID']) echo 'selected' ?>><?php echo $row['abrechnung'] . ': ' . $row['beschreibung'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Betrag</label>
                    <input type="number" name="betrag" required value="<?php echo $betrag; ?>">
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
        </div>
    </body>


    <?php
    include 'footer.inc.php';
    ?>
</html>
