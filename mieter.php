<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>
    <body>
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
        mysqli_query($link, "SET NAMES 'utf8'");
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
        ?>

        <table>
            <thead>
                <tr>
                    <th>Anrede</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Geburtsdatum</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            
            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?php echo $row['anrede']; ?></td>
                    <td><?php echo $row['vorname']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['geburtsdatum']; ?></td>
                    <td>
                        <a href="mieter.php?edit= <?php echo $row['mieterID']; ?>" class="edit_btn" >Edit</a>
                    </td>
                    <td>
                        <a href="mieterDB.php?del=<?php echo $row['mieterID']; ?>" class="del_btn">Delete</a>
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
                    <button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
                    <button class="btn" type="submit" name="cancel" formnovalidate style="background: #556B2F;" >cancel</button>
                <?php else: ?>
                    <button class="btn" type="exit" name="save" >Save</button>
                <?php endif ?>

            </div>
        </form>
    </body>
</html>
