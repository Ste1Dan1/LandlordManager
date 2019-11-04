<?php
include 'topbar.inc.php';
include 'db.inc.php';
// initialize variables
$name = "";
$strasse_nr = "";
$plz = "";
$ort = "";
$id = 0;
$update = false;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM lieferanten WHERE lieferantID=$id");
    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $name = $n['name'];
        $strasse_nr = $n['strasse_nr'];
        $plz = $n['plz'];
        $ort = $n['ort'];
    }
}
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $strasse_nr = $_POST['strasse_nr'];
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    mysqli_query($link, "INSERT INTO lieferanten (name, strasse_nr, plz, ort) VALUES ('$name', '$strasse_nr', '$plz', '$ort')");
    $_SESSION['message'] = "Lieferant erfasst";
    header('location: lieferanten.php');
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
   $name = $_POST['name'];
    $strasse_nr = $_POST['strasse_nr'];
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    
    mysqli_query($link, "UPDATE lieferanten SET name='$name', strasse_nr='$strasse_nr', plz='$plz', ort='$ort' WHERE lieferantID=$id");
    $_SESSION['message'] = "Lieferant geändert!";
    header('location: lieferanten.php');
}
if (isset($_POST['cancel'])) {
    header('location: lieferanten.php');
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($link, "DELETE FROM lieferanten WHERE lieferantID=$id");
    $_SESSION['message'] = "Lieferant gelöscht!";
    header('location: lieferanten.php');
}
$res = mysqli_query($link, "SELECT * FROM lieferanten");
?>