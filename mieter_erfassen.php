<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neuen Mieter erfassen</title>
    </head>
    <body>
        
        <h3>Bitte tragen Sie die Angaben zum Mieter ein:</h3>
        <form action="mieter_eintrag.php" method="GET">
            Anrede<br/><input type="radio" name="anrede" value="herr"> Herr<br/>
            <input type="radio" name="anrede" value="frau"> Frau<br/>
            <input type="radio" name="anrede" value="anderes"> Neutrale Anrede<br/>
            <p>
            Vorname<br/><input type="text" name="vorname" value="" /><br/>
            Name <br/><input type="text" name="name" value="" /><br/>
            <p>
            Geburtsdatum <br/><input type="date" name="geburtsdatum" value="" /><br/>  
            <input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="mieter_ausgabe.php">Erfasste Mieter darstellen</a><br/>
        <a href="index.php">Startseite</a>
        
        <?php
        // put your code here
        ?>
    </body>
</html>

