<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
        <?php
        $vorname = $_GET['vorname'];
        $name = $_GET['name'];
        $geburtsdatum = $_GET['geburtsdatum'];


        // Datenbankangaben sollten in ein db.inc.php geschrieben werden
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $insert="INSERT INTO `mieter` (`nr`, `Vorname`, `Name`, `Geburtsdatum`) VALUES (NULL, '$vorname', '$name', '$geburtsdatum')";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        mysqli_query($link, $insert) or die("Eintrag hat nicht geklappt");
        
        mysqli_close($link);
        echo "Der neue Mieter wurde bei erfasst!";
        ?>
    </body>
</html>
