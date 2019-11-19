<?php

include 'topbar.inc.php';
include 'db.inc.php';

// initialize variables
$mieter = "";
$wohnung = "";
$mietbeginn = "";
$mietende = "";
$mietzins = "";
$nebenkosten = "";
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM mietvertrag WHERE mietVertragID=$id");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $mieter = $n['FK_mieterID'];
        $wohnung = $n['FK_wohnungID'];
        $mietbeginn = $n['mietbeginn'];
        $mietende = $n['mietende'];
        $mietzins = $n['mietzins_mtl'];
        $nebenkosten = $n['nebenkosten_mtl'];
    }
}

if (isset($_POST['save'])) {
    $mieter = $_POST['mieter'];
    $wohnung = $_POST['wohnung'];
    $mietbeginn = $_POST['mietbeginn'];
    $mietende = $_POST['mietende'];
    $mietzins = $_POST['mietzins_mtl'];
    $nebenkosten = $_POST['nebenkosten_mtl'];

    mysqli_query($link, "INSERT INTO mietvertrag (FK_mieterID, FK_wohnungID, mietbeginn, mietende, mietzins_mtl,nebenkosten_mtl) VALUES ('$mieter', '$wohnung', '$mietbeginn',  " . ($mietende == NULL ? "NULL" : "'$mietende'") . ", '$mietzins', '$nebenkosten')");

    $_SESSION['message'] = "Mietvertrag erfasst";
    header('location: mietvertrag.php');
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $mieter = $_POST['mieter'];
    $wohnung = $_POST['wohnung'];
    $mietbeginn = $_POST['mietbeginn'];
    $mietende = $_POST['mietende'];
    $mietzins = $_POST['mietzins_mtl'];
    $nebenkosten = $_POST['nebenkosten_mtl'];


    mysqli_query($link, "UPDATE mietvertrag SET FK_mieterID ='$mieter', FK_wohnungID ='$wohnung', mietbeginn='$mietbeginn', mietende = " . ($mietende == NULL ? "NULL" : "'$mietende'") . ", mietzins_mtl='$mietzins' , nebenkosten_mtl='$nebenkosten'  WHERE mietVertragID=$id");

    $_SESSION['message'] = "Mietvertrag geändert!" . mysqli_error($link);
    header('location: mietvertrag.php');
}

if (isset($_POST['cancel'])) {
    header('location: mietvertrag.php');
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];

    mysqli_query($link, "DELETE FROM mietvertrag WHERE mietVertragID=$id");

    $_SESSION['message'] = "Mietvertrag gelöscht" . mysqli_error($link);
    header('location: mietvertrag.php');
}

$res = mysqli_query($link, "SELECT * FROM mieter");
?>