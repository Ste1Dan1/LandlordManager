<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $name = $_GET['name'];
        $strasse_nr = $_GET['strasse_nr'];
        $plz = $_GET['plz'];
        $ort = $_GET['ort'];

        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `lieferanten` (`lieferantID`, `name`, `strasse_nr`, `plz`, `ort`) "
                . "VALUES (NULL, '$name', '$strasse_nr', '$plz', '$ort');";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Der neue Lieferant wurde erfasst!";
        ?>
        
        <a href="lieferanten_ausgabe.php">Erfasste Lieferanten darstellen</a><br/>
        <a href="lieferanten_erfassen.php">Neuen Lieferanten erfassen</a><br/>
        <a href="index.php">Startseite</a><br/>
    </body>
</html>
