<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neue Nebenkostenrechnung erfassen</title>
    </head>
    <body>
        <?php
        include 'topbar.inc.php';   
        ?>
        
        <h3>Bitte tragen Sie die Angaben zur Nebenkostenrechnung ein:</h3>
        <form action="nkrechnungen_eintrag.php" method="GET">
            Datum <br/><input type="date" name="rgdatum" value="" /><br/>
            Haus <br/><input type="text" name="FK_hausID" value="" /><br/>
            Lieferant <br/><input type="text" name="FK_lieferantID" value="" /><br/>
            Kostenkategorie<br/><input type="text" name="FK_kostKatID" value="" /><br/>  
            Betrag <br/><input type="text" name="betrag" value="" /><br/>
            <p><input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="nkrechnungen_ausgabe.php">Erfasste Nebenkostenrechnungen darstellen</a><br/>
        <a href="index.php">Startseite</a>
        <?php
        // put your code here
        ?>
    </body>
</html>

