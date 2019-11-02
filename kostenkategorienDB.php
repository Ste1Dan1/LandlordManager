<?php

include 'topbar.inc.php';
include 'db.inc.php';

// initialize variables
$abrechnung = "";
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM kostenkategorien WHERE kostKatID=$id");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $abrechnung = $n['abrechnung'];
    }
}

if (isset($_POST['save'])) {
    $abrechnung = $_POST['abrechnung'];

    mysqli_query($link, "INSERT INTO kostenkategorien (abrechnung) VALUES ('$abrechnung')");
    $_SESSION['message'] = "Kostenkategorien erfasst";
    header('location: kostenkategorien.php');
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $abrechnung = $_POST['abrechnung'];
    
    mysqli_query($link, "UPDATE kostenkategorien SET abrechnung='$abrechnung' WHERE kostKatID=$id");
    $_SESSION['message'] = "Kostenkategorien geändert!";
    header('location: kostenkategorien.php');
}

if (isset($_POST['cancel'])) {
    header('location: kostenkategorien.php');
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($link, "DELETE FROM kostenkategorien WHERE kostKatID=$id");
    $_SESSION['message'] = "Kostenkategorien gelöscht!";
    header('location: kostenkategorien.php');
}

$res = mysqli_query($link, "SELECT * FROM kostenkategorien");

?>