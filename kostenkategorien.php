<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>
    <body>
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
        mysqli_query($link, "SET NAMES 'utf8'");
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
        ?>

        <table>
            <thead>
                <tr>
                    <th>Abrechnung</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            
            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?php echo $row['abrechnung']; ?></td>
                    <td>
                        <a href="kostenkategorien.php?edit= <?php echo $row['kostKatID']; ?>" class="edit_btn" >Edit</a>
                    </td>
                    <td>
                        <?php
                        $id = $row['kostKatID'];
                        $abfrage_rechnungen = "SELECT count(*) AS rechnungen FROM nkrechnungen WHERE FK_kostKatID=$id";
                        $res_rechnungen = mysqli_query($link, $abfrage_rechnungen) or die("Abfrage hat nicht geklappt");
                        $has_rechnungen = (int) current(mysqli_fetch_array($res_rechnungen)) > 0;
                        ?>
                        <a href="kostenkategorienDB.php?del=<?php echo $row['kostKatID']; ?>" class="del_btn <?php if ($has_rechnungen) echo "disabled" ?>" >Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <form method="post" action="kostenkategorienDB.php" >

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            
            
            <div class="input-group">
                <label>Abrechnung</label>
                <input type="text" name="abrechnung" required value="<?php echo $abrechnung; ?>">
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