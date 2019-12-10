<?php
@session_start();
include 'db.inc.php';
if (isset($_SESSION['messageNEG'])):
    ?>
    <div class="msgNEG">
        <?php
        echo $_SESSION['messageNEG'];
        unset($_SESSION['messageNEG']);
        ?>
    </div>

<?php endif ?>

<html>
    <head>
        <meta charset="utf-8">
        <title>LandlordManager</title>
        <link href="./CSS/login.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="./CSS/MSGBOX.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <?php
        include 'db.inc.php';
        if (isset($_SESSION['messageNEG'])):
            ?>
            <div class="msgNEG">
                <?php
                echo $_SESSION['messageNEG'];
                unset($_SESSION['messageNEG']);
                ?>
            </div>

        <?php endif ?>


        <div class="login">

            <img src="./Images/Logo_Landlord_Manager.png" alt="LogoLLM">
            <h1>Passort zurücksetzen</h1>
            <form action="resetPassword.php" method="post">
                <input type="email" name="email" placeholder="E-Mail" id="email" required>


                <input type = "submit" value = "Passwort Zurücksetzen">

                <a href = "login.php"> Zurück zur Anmeldung</a>


            </form>

        </div>
    </body>
</html>