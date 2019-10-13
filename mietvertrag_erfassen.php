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
        <!-- Dropdown-Select für Mieter-->
<!--            Mieter <br/><select name="ID_mieter">
                
            //<?php
//            $res=mysqli_query($link, "SELECT * FROM mieter ORDER BY name, vorname");
//            while($row=mysqli_fetch_array($res))
//            {
//                //$id = mysqli_query($link, "SELECT ID from $res");
//                ?>
              <option value = "1">
                  //<?php echo $row["vorname"] ?> <?php echo $row["name"] ?>, <?php echo $row["geburtsdatum"] ?></option>
              //<?php
//                }
//                ?>

            </select><br/>-->
            Wohnung <br/><input type="text" name="ID_wohnung" value="" /><br/>
            <p>
            <!-- Dropdown-Select für Wohnung -->
<!--           Wohnung <br/><select name="ID_wohnung">
                
           //<?php
//               $res=mysqli_query($link, "SELECT * FROM wohnung ORDER BY haus, zimmer");
//                while($row=mysqli_fetch_array($res))
//                    {
                    // $id = mysqli_query($link, "SELECT ID from $res");
//                    ?>
//                   <option value= "2"> 
//                    <?php echo $row["zimmer"]?> Zimmer, <?php echo $row["strasse_nr"] ?>, Haus <?php echo $row["haus"] ?></option>
//                <?php
//                    }
//                ?>

            </select><br/>-->
            
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

