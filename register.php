<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/register.css" rel="stylesheet" type="text/css">
           <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
                 
        <title>Registrieren</title>
    </head>
    <body>

        <?php
        include 'topbar.inc.php';   
        ?>

        <div class="register">
            <h1>Register</h1>
            
            <form action="registerNew.php" method="post" autocomplete="off">
                
                </label><label for="email">
                    <i class="fas fa-envelope"></i>
                </label>
                        <input type="email" name="email" placeholder="Email" id="email" required>
                
                 <label for="name">
                    <i class="fas fa-user"></i>
                </label>
                        <input type="text" name="name" placeholder="Name" id="username" required>
                
                <label for="vorname">
                    <i class="fas fa-user"></i>
                </label>
                        <input type="text" name="vorname" placeholder="Vorname" id="username" required>
       
                <label for="password">
                    <i class="fas fa-lock"></i>
                </label>
                  <input type="password" name="password" placeholder="Password" id="password" required>

                <input type="submit" value="Registrieren">
                
                <a href="login.php"> Haben Sie schon ein Konto? Anmelden</a>
            </form>
            </div>




            </body>
            </html>
