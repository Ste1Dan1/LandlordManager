<?php
$benutzer="landlord_DB_user";
$passwort="";
$dbname="landlordmanager";
        $link=mysqli_connect("localhost", $benutzer, $passwort, $dbname) or die("Keine Verbindung zur Datenbank!");
        mysqli_select_db($link, $dbname) or die("DB nicht gefunden");
?>

