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
            <h1>Login</h1>
            <form action="authenticate.php" method="post">
                <label for="username">
                    <i class="fas fa-user"></i>
                </label>
                <input type="text" name="username" placeholder="Username" id="username" required>
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                <input type="password" name="password" placeholder="Password" id="password" required>

                <input type="submit" value="Login">
                <a class="loginButton" href="register.php">Registrieren</a>
                <a class="loginButton" href="accountRecovery.php">Passwort vergessen</a>

            </form>
            
        </div>
         
    </body>
</html>