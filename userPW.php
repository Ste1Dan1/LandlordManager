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
            include('userDB.php');

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
            $abfrage = "SELECT * FROM users WHERE email = '$email';";
            $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
            ?>



            <h1>User verwalten</h1>

            <table>
                <thead>
                    <tr>
                        <th>Anrede</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>E-Mail</th>
                        <th colspan="2">Aktion</th>
                    </tr>
                </thead>

                <?php
                while ($row = mysqli_fetch_array($res)) {
                    ?>
                    <tr>
                        <td><?php echo $row['anrede']; ?></td>
                        <td><?php echo $row['vorname']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>

                        <td>
                            <a href="userPW.php?edit= <?php echo $row['userID']; ?>" class="edit_btn" >Passwort ändern</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php if ($update == true): ?>
                <form method="post" action="userPWDB.php" >

                    <input type="hidden" name="id" value="<?php echo $id; ?>">


                    <div class="input-group">
                        <label>Altes Passwort</label>
                        <input type="password" name="old_password" >
                    </div>
                    <div class="input-group">
                        <label>Neues Passwort</label>
                        <input type="password" name="new_password" required ">
                    </div>
                    <div class="input-group">


                        <button class="btn" type="submit" name="update" style="background: #556B2F;" >Ändern</button>
                        <button class="btn" type="submit" name="cancel" formnovalidate style="background: #556B2F;" >Abbrechen</button>
                    <?php else: ?>

                    <?php endif ?>

                </div>
            </form>

        </div>

    </body>

    <?php
    include 'footer.inc.php';
    ?>
</html>
