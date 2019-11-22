<?php

include 'topbar.inc.php';
include 'db.inc.php';

// initialize variables
$rgdatum = "";
$fk_haus_id = "";
$fk_lieferant_id = "";
$fk_kostKat_id = "";
$betrag = "";
$kostKat_beschreibung = "";
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM nkrechnungen WHERE nkRechnungID=$id");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $rgdatum = $n['rgdatum'];
        $fk_haus_id = $n['FK_hausID'];
        $fk_lieferant_id = $n['FK_lieferantID'];
        $fk_kostKat_id = $n['FK_kostKatID'];
        $betrag = $n['betrag'];
    }
}

if (isset($_POST['save'])) {
    $rgdatum = $_POST['rgdatum'];
    $fk_haus_id = $_POST['FK_hausID'];
    $fk_lieferant_id = $_POST['FK_lieferantID'];
    $fk_kostKat_id = $_POST['FK_kostKatID'];
    $betrag = $_POST['betrag'];

    mysqli_query($link, "INSERT INTO nkrechnungen (rgdatum, FK_hausID, FK_lieferantID, FK_kostKatID, betrag) VALUES ('$rgdatum', '$fk_haus_id', '$fk_lieferant_id', '$fk_kostKat_id', '$betrag')");
    $_SESSION['message'] = "Nebenkostenrechnung erfasst";
    header('location: nkrechnungen.php');
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $rgdatum = $_POST['rgdatum'];
    $fk_haus_id = $_POST['FK_hausID'];
    $fk_lieferant_id = $_POST['FK_lieferantID'];
    $fk_kostKat_id = $_POST['FK_kostKatID'];
    $betrag = $_POST['betrag'];
    mysqli_query($link, "UPDATE nkrechnungen SET rgdatum='$rgdatum', FK_hausID='$fk_haus_id', FK_lieferantID='$fk_lieferant_id', FK_kostKatID='$fk_kostKat_id', betrag='$betrag' WHERE nkRechnungID=$id");
    $_SESSION['message'] = "Nebenkostenrechnung geändert!";
    header('location: nkrechnungen.php');
}

if (isset($_POST['cancel'])) {
    header('location: nkrechnungen.php');
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($link, "DELETE FROM nkrechnungen WHERE nkRechnungID=$id");
    $_SESSION['message'] = "Nebenkostenrechnung gelöscht!";
    header('location: nkrechnungen.php');
}

$res = mysqli_query($link, "SELECT * FROM nkrechnungen");

?>