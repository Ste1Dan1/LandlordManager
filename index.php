<?php
include 'topbar.inc.php';
include 'loginCheck.inc.php';
?><!DOCTYPE html>
<!--
Startseite mit Menüleiste und klickbaren Icons
-->

<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>LandLord Manager</title>
    </head>
    <body>



        <div class="pagecontent">
                <h1>Herzlich Willkommen bei Landlord Manager</h1>
                <h2>Hier finden Sie alles was Sie für Ihre Tätigkeit als Vermieter brauchen!</h2>


            <div class="wrapper">
                <a href="mieter.php"><img src="Images/Mieter.png" title="Mieter" alt="Mieter-Icon" height="200" width="200"/></a>
                <a href="wohnung.php"><img src="Images/immobilien.png" title="Immobilien" alt="Immobilien-Icon" height="200" width="200"/></a>
                <a href="nkrechnungen_ausgabe.php"><img src="Images/Nebenkosten.png" title="Nebenkosten" alt="Nebenkosten-Icon" height="200" width="200"/></a>
                <a href=#reporting><img src="Images/Reporting.png" alt="Reporting-Icon" title="Reporting" height="200" width="200"/></a>
            </div>
        </div>


    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>
