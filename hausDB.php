<?php
@session_start();
include 'db.inc.php';

// initialize variables
$bezeichnung = "";
$strasse_nr = "";
$plz = "";
$ort = "";
$anz_whg = "";
$baujahr = "";
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM haus WHERE hausID=$id");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $bezeichnung = $n['bezeichnung'];
        $strasse_nr = $n['strasse_nr'];
        $plz = $n['plz'];
        $ort = $n['ort'];
        $anz_whg = $n['anz_whg'];
        $baujahr = $n['baujahr'];
    }
}

if (isset($_POST['save'])) {
    $bezeichnung = $_POST['bezeichnung'];
    $strasse_nr = $_POST['strasse_nr'];
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    $anz_whg = $_POST['anz_whg'];
    $baujahr = $_POST['baujahr'];

    mysqli_query($link, "INSERT INTO haus (bezeichnung, strasse_nr, plz, ort, anz_whg, baujahr) VALUES ('$bezeichnung', '$strasse_nr', '$plz', '$ort', '$anz_whg', '$baujahr')");
    $_SESSION['message'] = "Haus erfasst";
    header('location: haus.php');
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $bezeichnung = $_POST['bezeichnung'];
    $strasse_nr = $_POST['strasse_nr'];
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    $anz_whg = $_POST['anz_whg'];
    $baujahr = $_POST['baujahr'];

    mysqli_query($link, "UPDATE haus SET bezeichnung='$bezeichnung', strasse_nr='$strasse_nr', plz='$plz', ort='$ort', anz_whg='$anz_whg', baujahr='$baujahr' WHERE hausID=$id");
    $_SESSION['message'] = "Haus geändert!";
    header('location: haus.php');
}

if (isset($_POST['cancel'])) {
    header('location: haus.php');
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($link, "DELETE FROM haus WHERE hausID=$id");
    $_SESSION['message'] = "Haus gelöscht!";
    header('location: haus.php');
}

$res = mysqli_query($link, "SELECT * FROM haus");
?>