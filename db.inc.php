<?php
$benutzer="llm_dbUser";
$passwort="LMM2019";
$dbname="llm_landlordmanager";
        $link=mysqli_connect('localhost', $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
?>