<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $rgdatum = $_GET['rgdatum'];
        $FK_hausID = $_GET['FK_hausID'];
        $FK_lieferantID = $_GET['FK_lieferantID'];
        $FK_kostKatID = $_GET['FK_kostKatID'];
        $betrag = $_GET['betrag'];

        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `NKRechnungen` (`nkRechnungID`, `rgdatum`, `FK_hausID`, `FK_lieferantID`, `FK_kostKatID`, `betrag`) "
                . "VALUES (NULL, NULL, NULL, NULL, NULL, NULL);";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Die neue Nebenkostenrechnung wurde erfasst!";
        ?>
        
        <a href="nkrechnungen_ausgabe.php">Erfasste Nebenkostenrechnungen darstellen</a><br/>
        <a href="nkrechnungen_erfassen.php">Neue Nebenkostenrechnung erfassen</a><br/>
        <a href="index.php">Startseite</a><br/>
    </body>
</html>
