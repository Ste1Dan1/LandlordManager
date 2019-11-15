<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Wohnungen verwalten</title>
    </head>
    <body>
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
               
        $abfrage = "SELECT * from wohnung";
        mysqli_query($link, "SET NAMES 'utf8'");
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
        ?>

        <table>
            <thead>
                <tr>
                    <th>Wohnungsnummer</th>
                    <th>Zimmer</th>
                    <th>Fläche</th>
                    <th>Haus</th>
                    <th colspan="2">Aktion</th>
                </tr>
            </thead>
            
            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
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
                <label>Haus</label>
                <input type="text" name="FK_hausID" required value="<?php echo $FK_hausID; ?>">
                
                <?php //query
                    $sql=mysql_query("SELECT hausID,bezeichnung FROM haus");
                        if(mysql_num_rows($sql)){
                            $select= '<select name="select">';
                            while($rs=mysql_fetch_array($sql)){
                            $select.='<option value="'.$rs['id'].'">'.$rs['name'].'</option>';
                            }
                        }
                $select.='</select>';
                echo $select;
                ?>
                
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