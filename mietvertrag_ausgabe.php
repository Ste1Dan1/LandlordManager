<!DOCTYPE html>
<!--
Mieterseite mit Tabellenübersicht der Mieter
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>LLM: Mietvertragsübersicht</title>
    </head>
    <body>
        <h1>Ihre erfassten Mietverträge </h1>
        <?php
        include 'db.inc.php';

        $link = mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");

        $abfrage = "SELECT `mietvertrag`.`mietVertragID`, `mietvertrag`.`mietbeginn`, `mietvertrag`.`mietende`, `mietvertrag`.`mietzins_mtl`, `mietvertrag`.`nebenkosten_mtl`,  `mieter`.`name` AS `Mieter`, `haus`.`bezeichnung` AS `Immobilie`,`wohnung`.`wohnungsNummer`
FROM `mietvertrag` 
	LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
	LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` 
	LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID`;";

        mysqli_query($link, "SET NAMES 'utf8'");
        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt");

        echo "<table border=\"1\">";

        $anzahl_spalten = mysqli_num_fields($res);
        echo "<tr align='center'>\n";
        for ($i = 0; $i < $anzahl_spalten; $i++) {
            $finfo = mysqli_fetch_field_direct($res, $i);
            echo "<th>" . $finfo->name . "</th>\n";
        }
        echo "</tr>\n";

        while ($zeile = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            while (list($key, $value) = each($zeile)) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        mysqli_close($link);
        ?> 

        <a href="mietvertrag_erfassen.php">Neuen Mietvertrag erfassen</a>
        <a href="index.php">Startseite</a>
    </body>
</html>
