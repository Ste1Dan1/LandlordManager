<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $ID_mieter= $_GET['ID_mieter'];
        $ID_wohnung = $_GET['ID_wohnung'];
        $mietbeginn = $_GET['mietbeginn'];
        $mietende = $_GET['mietende'];
        $mietzins_mtl = $_GET['mietzins_mtl'];

        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `mietvertrag` (`ID`, `ID_mieter`, `ID_wohnung`, `mietbeginn`, `mietende`, `mietzins_mtl`) "
                . "VALUES (NULL, '$ID_mieter', '$ID_wohnung', '$mietbeginn', '$mietende', '$mietzins_mtl');";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Der neue Mietvertrag wurde erfasst!";
        ?>
        <br/>
        <a href="mietvertrag_ausgabe.php">Erfasste Mietverträge darstellen</a><br/>
        <a href="mietvertrag_erfassen.php">Neuen Mietvertrag erfassen</a><br/>
        <a href="index.php">Startseite</a>
    </body>
</html>
