<html>
    <head>
        <meta charset="UTF-8">
        <title>Neuen Mieter erfassen</title>
    </head>
    <body>
        <h3>Bitte tragen Sie die Angaben zum Mieter ein:</h3>
        <form action="mieter_eintrag.php" method="GET">
            <input type="text" name="vorname" value="" /> Vorname <br/>
            <input type="text" name="name" value="" /> Name <br/>
            <input type="text" name="geburtsdatum" value="" /> Geburtsdatum <br/>  
            <input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="mieter.php">Erfasste Mieter darstellen!</a>
        <?php
        // put your code here
        ?>
    </body>
</html>

