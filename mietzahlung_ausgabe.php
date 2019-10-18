<!DOCTYPE html>
<!--
Seite mit Tabellenübersicht der Mietzahlungen
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Mietzahlungsübersicht</title>
    </head>
    <body>
        
        <?php
        include 'topbar.inc.php';   
        ?>
        
        <h1>Ihre erfassten Mietzahlungen </h1>
        <?php
        include 'db.inc.php';
        
        $link=mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
        
        $abfrage="SELECT * from `mietEingang` ORDER BY FK_periode DESC, datum DESC";
        
        mysqli_query($link,"SET NAMES 'utf8'");
        $res=mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");
    
        echo "<table border=\"1\">";
       
        $anzahl_spalten = mysqli_num_fields($res);
        echo "<tr align='center'>\n"; 
        for ($i=0; $i<$anzahl_spalten; $i++)
        {
            $finfo = mysqli_fetch_field_direct($res, $i);
            echo "<th>".$finfo->name."</th>\n";
        }
        echo "</tr>\n";
 
        while($zeile= mysqli_fetch_assoc($res))
        {
           echo "<tr>";
           while(list($key,$value)=each($zeile))
           {
             echo "<td>".$value."</td>";  
           }        
           
           ?>
    <td><button class="changedata">Ändern</button></td>       
    <td><button class="deletedata">Löschen</button></td>
           <?php
           echo "</tr>";
        }
        echo "</table>";       
        mysqli_close($link); 
        ?> 
        
        <a href="mietzahlung_erfassen.php">Neue Mietzahlung erfassen</a><br/>
        <a href="index.php">Startseite</a><br/>
    </body>
</html>