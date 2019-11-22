<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Kostenkategorien</title>
    </head>
    <body>
        <div class="pagecontent">
            <?php
            include('kostenkategorienDB.php');

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
            $abfrage = "SELECT * from kostenkategorien";
           
            $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
            ?>
            <h1>Kostenkategorien verwalten</h1>

            <table>
                <thead>
                    <tr>
                        <th>Beschreibung</th>
                        <th>Abrechnung</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>

                <?php while ($row = mysqli_fetch_array($res)) { ?>
                    <tr>
                        <td><?php echo $row['beschreibung']; ?></td>
                        <td><?php echo $row['abrechnung']; ?></td>
                        <td>
                            <a href="kostenkategorien.php?edit=<?php echo $row['kostKatID']; ?>" class="edit_btn" >Ändern</a>
                        </td>
                        <td>
                            <?php
                            $kostkat_id = $row['kostKatID'];
                            $abfrage_rechnungen = "SELECT count(*) AS rechnungen FROM nkrechnungen WHERE FK_kostKatID=$kostkat_id";
                            $res_rechnungen = mysqli_query($link, $abfrage_rechnungen) or die("Abfrage hat nicht geklappt");
                            $has_rechnungen = (int) current(mysqli_fetch_array($res_rechnungen)) > 0;
                            ?>
                            <a href="kostenkategorienDB.php?del=<?php echo $row['kostKatID']; ?>" class="del_btn <?php if ($has_rechnungen) echo "disabled" ?>" >Löschen</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <form method="post" action="kostenkategorienDB.php" >

                <input type="hidden" name="id" value="<?php echo $id; ?>">



                <div class="input-group">
                    <label>Beschreibung</label>
                    <input type="text" name="beschreibung" required value="<?php echo $beschreibung; ?>">

                </div>

                <div class="input-group">
                    <label>Abrechnung</label>
                    <select name="abrechnung" required>


                        <?php
                        $abrArten = array("Wohnfläche", "Wohneinheit");

                        if ($abrechnung == NULL) {
                            echo '<option value="" disabled selected>Select your option</option>';
                        } else {
                            echo '<option value="" disabled>Select your option</option>';
                        }

                        for ($i = 0; $i < count($abrArten); $i++) {

                            $select_attribute = "";

                            if ($abrArten[$i] == $abrechnung) {
                                $select_attribute = 'selected';
                                echo "<option value='" . $abrArten[$i] . "' selected = " . $select_attribute . ">" . $abrArten[$i] . "</option>";
                            } else {
                                echo "<option value='" . $abrArten[$i] . "'>" . $abrArten[$i] . "</option>";
                            }
                        }
                        ?>





                    </select>
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
