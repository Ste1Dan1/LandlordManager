<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neue Mietzahlung erfassen</title>
    </head>
    <body>
        
        <?php
        include 'topbar.inc.php';   
        ?>
        
        <h3>Bitte tragen Sie die Angaben zum Mietzinszahlung ein:</h3>
        <form action="mietzahlung_eintrag.php" method="GET">
            Datum <br/><input type="date" name="datum" value="" /><br/>
            Betrag <br/><input type="text" name="mietBetrag" value="" /><br/>
            Nebenkosten-Betrag <br/><input type="text" name="nkBetrag" value="" /><br/>
            Zahl-Periode<br/><input type="text" name="FK_periode" value="" /><br/>  
            Zugehörender Mietvertrag<br/><input type="text" name="FK_mietVertragID" value="" /><br/>  

            <p><input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="mietzahlung_ausgabe.php">Erfasste Mietzahlungen darstellen</a><br/>
        <a href="index.php">Startseite</a>
        <?php
        // put your code here
        ?>
    </body>
</html>

