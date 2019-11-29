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
        <title>LandlordManager - Mieter verwalten</title>
    </head>

    <body>
        <div class="pagecontent">
        <?php
        include('mieterDB.php');

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
        $abfrage = "SELECT * from mieter";
      
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
        ?>

        
            
            <h1>Mieter verwalten</h1>
            
            <table>
                <thead>
                    <tr>
                        <th>Anrede</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>Geburtsdatum</th>
                        <th colspan="2">Aktion</th>
                    </tr>
                </thead>

                <?php
                while ($row = mysqli_fetch_array($res)) {
                    $datumalt = strtotime($row['geburtsdatum']);
                    $datum = date("d.m.Y", $datumalt);
                    ?>
                    <tr>
                        <td><?php echo $row['anrede']; ?></td>
                        <td><?php echo $row['vorname']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $datum; ?></td>
                        <td>
                            <a href="mieter.php?edit= <?php echo $row['mieterID']; ?>" class="edit_btn" >Ändern</a>
                        </td>
                        <td>
                            <?php
                            $mieter_id = $row['mieterID'];
                            $abfrage_mietvertraege = "SELECT count(*) AS mietvertraege FROM mietvertrag WHERE FK_mieterID=$mieter_id";
                            $res_mietvertraege = mysqli_query($link, $abfrage_mietvertraege) or die("Abfrage hat nicht geklappt");
                            $has_mietvertraege = (int) current(mysqli_fetch_array($res_mietvertraege)) > 0;
                            ?>
                            <a href="mieterDB.php?del=<?php echo $row['mieterID']; ?>" class="del_btn <?php if ($has_mietvertraege) echo "disabled" ?>" >Löschen</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <form method="post" action="mieterDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="input-radio">
                    <label>Anrede</label>
                    <input type="radio" name="anrede" value="Herr" required <?php echo $anrede == "Herr" ? 'checked' : ""; ?>>Herr
                    <input type="radio" name="anrede" value="Frau" <?php echo $anrede == "Frau" ? 'checked' : ""; ?>>Frau
                    <input type="radio" name="anrede" value="Neutral" <?php echo $anrede == "Neutral" ? 'checked' : ""; ?>>Neutral
                </div>

                <div class="input-group">
                    <label>Vorname</label>
                    <input type="text" name="vorname" required value="<?php echo $vorname; ?>">
                </div>
                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" required value="<?php echo $name; ?>">
                </div>
                <div class="input-group">
                    <label>Geburtsdatum</label>
                    <input type="date" name="geburtsdatum" required value="<?php echo $geburtsdatum; ?>">
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
