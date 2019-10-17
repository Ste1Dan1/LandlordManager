<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $datum = $_GET['datum'];
        $mietBetrag = $_GET['mietBetrag'];
        $nkBetrag = $_GET['nkBetrag'];
        $FK_periode = $_GET['FK_periode'];
        $FK_mietVertragID = $_GET['FK_mietvertragID'];

        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `mietEingang` (`mietEingangID`, `datum`, `mietBetrag`, `nkBetrag`, `FK_periode`, `FK_mietVertragID`) "
                . "VALUES (NULL, '$datum', '$mietBetrag', '$nkBetrag', NULL, NULL);";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Die neue Mietzinszahlung wurde erfasst!";
        ?>
        
        <a href="mietzahlung_ausgabe.php">Erfasste Mietzahlungen darstellen</a><br/>
        <a href="mietzahlung_erfassen.php">Neue Mietzahlung erfassen</a><br/>
        <a href="index.php">Startseite</a><br/>
    </body>
</html>
