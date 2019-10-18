<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neuen Lieferanten erfassen</title>
    </head>
    <body>
        <?php
        include 'topbar.inc.php';   
        ?>
        
        <h3>Bitte tragen Sie die Angaben zum Lieferanten ein:</h3>
        <form action="lieferanten_eintrag.php" method="GET">
            Bezeichnung <br/><input type="text" name="name" value="" /><br/>
            Strasse, Nr. <br/><input type="text" name="strasse_nr" value="" /><br/>
            PLZ <br/><input type="text" name="plz" value="" /><br/>
            Ort<br/><input type="text" name="ort" value="" /><br/>  
            
            <p><input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="lieferanten_ausgabe.php">Erfasste Lieferanten darstellen</a><br/>
        <a href="index.php">Startseite</a>
        <?php
        // put your code here
        ?>
    </body>
</html>

