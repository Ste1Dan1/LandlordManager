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
            <h1>Nebenkostenrechnungen verwalten</h1>
            <?php
            $abfrageHaus = "SELECT DISTINCT hausID, bezeichnung  FROM haus INNER JOIN NKRechnungen ON `NKRechnungen`.`FK_hausID` = `haus`.`hausID` ORDER BY bezeichnung;";
            $resHaus = mysqli_query($link, $abfrageHaus) or die("Abfrage Haus hat nicht geklappt");
            while ($rowHaus = mysqli_fetch_array($resHaus)) {
                $hID = $rowHaus['hausID'];
                $abfrage = "SELECT NKRechnungen.*, haus.bezeichnung , lieferanten.name, kostenKategorien.abrechnung, kostenKategorien.beschreibung 
                        FROM NKRechnungen LEFT JOIN haus ON NKRechnungen.FK_hausID=haus.hausID 
                        LEFT JOIN lieferanten ON NKRechnungen.FK_lieferantID=lieferanten.lieferantID 
                        LEFT JOIN kostenKategorien ON NKRechnungen.FK_kostKatID=kostenKategorien.kostKatID
                        WHERE hausID=$hID
                        ORDER BY rgdatum, name";

                $res = mysqli_query($link, $abfrage) or die("Abfrage Rechnungen hat nicht geklappt");
                ?>


                <table>
                    <thead>
                        <tr> <th> <?php echo $rowHaus['bezeichnung']; ?></th> </tr>
                        <tr>
                            <th>Rechnungsdatum</th>
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
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['abrechnung']; ?></td>
                            <td><?php echo $row['beschreibung']; ?></td>
                            <td><?php echo $row['betrag']; ?></td>
                            <td>
                                <a href="nkrechnungen.php?edit= <?php echo $row['nkRechnungID']; ?>" class="edit_btn" >Ändern</a>
                            </td>
                            <td>
                                <a href="nkrechnungenDB.php?del=<?php echo $row['nkRechnungID']; ?>" class="del_btn" >Löschen</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </table><br>

                <?php } ?>

            <form method="post" action="nkrechnungenDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="input-group">
                    <label>Rechnungsdatum</label>
                    <input type="date" name="rgdatum" required value="<?php echo $rgdatum; ?>">
                </div>

                <?php
                $abfrage_haus = "SELECT * FROM haus ORDER BY bezeichnung";

                $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage hat nicht geklappt");
                ?>
                <div class="input-group">
                    <label>Haus</label>
                    <select name="FK_hausID">
                        <?php
                        if ($fk_haus_id == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        while ($row = mysqli_fetch_array($res_haus)) {
                            ?>
                            <option value="<?php echo $row['hausID'] ?>" <?php if ($fk_haus_id === $row['hausID']) echo 'selected' ?>><?php echo $row['bezeichnung'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php
                $abfrage_lieferanten = "SELECT * FROM lieferanten ORDER BY name";

                $res_lieferanten = mysqli_query($link, $abfrage_lieferanten) or die("Abfrage hat nicht geklappt");
                ?>
                <div class="input-group">
                    <label>Lieferant</label>
                    <select name="FK_lieferantID">
                        <?php
                        if ($fk_lieferant_id == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        while ($row = mysqli_fetch_array($res_lieferanten)) {
                            ?>
                            <option value="<?php echo $row['lieferantID'] ?>" <?php if ($fk_lieferant_id === $row['lieferantID']) echo 'selected' ?>><?php echo $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php
                $abfrage_kostenkategorien = "SELECT * FROM kostenKategorien ORDER BY beschreibung";

                $res_kostenkategorien = mysqli_query($link, $abfrage_kostenkategorien) or die("Abfrage hat nicht geklappt");
                ?>
                <div class="input-group">
                    <label>Kostenkategorie</label>
                    <select name="FK_kostKatID">
                        <?php
                        if ($fk_kostKat_id == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }
                        while ($row = mysqli_fetch_array($res_kostenkategorien)) {
                            ?>
                            <option value="<?php echo $row['kostKatID'] ?>" <?php if ($fk_lieferant_id === $row['kostKatID']) echo 'selected' ?>><?php echo $row['beschreibung'] . " / " . $row['abrechnung'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Betrag</label>
                    <input type="number" min="0" name="betrag" required value="<?php echo $betrag; ?>">
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
