<!DOCTYPE html>
<!--
Startseite mit Menüleiste und klickbaren Icons
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>LandLord Manager</title>
    </head>
    <body>
        
        <?php
        include 'topbar.inc.php';
        
        ?>
        
        <h1>Herzlich Willkommen bei Landlord Manager</h1>
        <h2>Hier finden Sie alles was Sie für Ihre Tätigkeit als Vermieter brauchen!</h2>
        <?php
        
        session_start();
        include 'loginCheck.inc.php';
         
        ?>
        
        <a href="mieter_ausgabe.php"><img src="images/Mieter.png" alt="Mieter-Icon" height="200" width="200"</a>
        <a href="wohnung_ausgabe.php"><img src="images/immobilien.png" alt="Immobilien-Icon" height="200" width="200"</a>
        <a href="nkrechnungen_ausgabe.php"><img src="images/Nebenkosten.png" alt="Nebenkosten-Icon" height="200" width="200"</a>

        
    </body>
</html>
