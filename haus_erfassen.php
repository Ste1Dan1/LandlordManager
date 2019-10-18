<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neues Haus erfassen</title>
    </head>
    <body>
        <?php
        include 'topbar.inc.php';   
        ?>
        
        <h3>Bitte tragen Sie die Angaben zum Haus ein:</h3>
        <form action="haus_eintrag.php" method="GET">
            Bezeichnung <br/><input type="text" name="bezeichnung" value="" /><br/>
            Strasse, Nr. <br/><input type="text" name="strasse_nr" value="" /><br/>
            PLZ <br/><input type="text" name="plz" value="" /><br/>
            Ort<br/><input type="text" name="ort" value="" /><br/>  
            
            <p>
            Anzahl Wohnungen <br/><input type="text" name="anz_whg" value="" /><br/>
            Baujahr <br/><input type="text" name="baujahr" value="" /><br/>
            <p><input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="haus_ausgabe.php">Erfasste Häuser darstellen</a><br/>
        <a href="index.php">Startseite</a>
        <?php
        // put your code here
        ?>
        
    </body>
</html>

