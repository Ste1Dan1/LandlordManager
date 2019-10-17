<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $zimmer= $_GET['zimmer'];
        $flaeche = $_GET['flaeche'];
        $haus = $_GET['hausID'];


        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `wohnung` (`wohnungID`, `wohnungs_Nummer`, `zimmer`, `flaeche`, `FK_hausID`) "
                . "VALUES (NULL, NULL, '$zimmer', '$flaeche', '$haus')";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Die neue Wohnung wurde erfasst!";
        ?>
        <a href="wohnung_ausgabe.php">Erfasste Wohnungen darstellen</a><br/>
        <a href="wohnung_erfassen.php">Neuen Wohnung erfassen</a><br/>
        <a href="index.php">Startseite</a><br/>
    </body>
</html>
