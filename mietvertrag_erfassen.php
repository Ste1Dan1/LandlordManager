<?php
            include 'db.inc.php';
        
            $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
            mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
            ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neuen Mietvertrag erfassen</title>
    </head>
    <body>
        <h3>Bitte tragen Sie die Angaben zum Mietvertrag ein:</h3>
        <form action="mietvertrag_eintrag.php" method="GET">
            
            Mieter <br/><input type="text" name="ID_mieter" value="" /><br/>
            <p>
        
            Wohnung <br/><input type="text" name="ID_wohnung" value="" /><br/>
            <p>

            Datum Mietbeginn <br/><input type="date" name="mietbeginn" value="" /><br/>
            Datum Mietende <br/><input type="date" name="mietende" value="" /><br/>
            <p>
            Monatlicher Mietzins <br/><input type="text" name="mietzins_mtl" value="" /><br/>
            <p>
            <input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="mietvertrag_ausgabe.php">Erfasste Mietverträge darstellen</a><br/>
        <a href="index.php">Startseite</a>
        
        <?php
        // put your code here
        ?>
    </body>
</html>

