<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $bezeichnung = $_GET['bezeichnung'];
        $strasse_nr = $_GET['strasse_nr'];
        $plz = $_GET['plz'];
        $ort = $_GET['ort'];
        $anz_whg = $_GET['anz_whg'];
        $baujahr = $_GET['baujahr'];

        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `haus` (`ID`, `bezeichnung`, `strasse_nr`, `plz`, `ort`, `anz_whg`, `baujahr`) "
                . "VALUES (NULL, '$bezeichnung', '$strasse_nr', '$plz', '$ort', '$anz_whg', '$baujahr');";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Das neue Haus wurde erfasst!";
        ?>
        
        <a href="haus_ausgabe.php">Erfasste Häuser darstellen</a><br/>
        <a href="haus_erfassen.php">Neue Häuser erfassen</a><br/>
        <a href="index.php">Startseite</a><br/>
    </body>
</html>
