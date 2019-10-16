<?php
            include 'db.inc.php';
        
            $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
            mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
            ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Neue Wohnung erfassen</title>
    </head>
    
    <body>
        <h3>Bitte tragen Sie die Angaben zur Wohnung ein:</h3>
        <form action="wohnung_eintrag.php" method="GET">
            Anzahl Zimmer<br/> <input type="text" name="zimmer" value="" /><br/>
            Fläche in qm<br/><input type="text" name="flaeche" value="" /><br/>
            
            <p>
            Haus <br/><select name="hausID">
                
            <?php
            $res=mysqli_query($link, "SELECT * FROM haus");
            while($row=mysqli_fetch_array($res))
                {
                ?>
                 <option value =<?php echo $row["hausID"]?>> <?php echo $row["bezeichnung"] ?></option>
                    <?php
                }
                ?>

            </select><br/>
            <p>
            <input type="submit" value="eintragen" /><input type="reset" value="Formular leeren" />
        </form>
        
        <a href="wohnung_ausgabe.php">Erfasste Wohnungen darstellen</a><br/>
        <a href="index.php">Startseite</a><br/>
        
    </body>
</html>

