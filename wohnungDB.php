<?php
@session_start();
include 'db.inc.php';
// initialize variables

$wohnungsNummer = "";
$zimmer = "";
$flaeche = "";
$FK_hausId = "";
$id = 0;
$update = false;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM wohnung WHERE wohnungID=$id");
    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $wohnungsNummer = $n['wohnungsNummer'];
        $zimmer = $n['zimmer'];
        $flaeche = $n['flaeche'];
        $FK_hausID = $n['FK_hausID'];
    }
}
if (isset($_POST['save'])) {
    $wohnungsNummer = $_POST['wohnungsNummer'];
    $zimmer = $_POST['zimmer'];
    $flaeche = $_POST['flaeche'];
    $FK_hausID = $_POST['FK_hausID'];
    mysqli_query($link, "INSERT INTO wohnung (wohnungsNummer, zimmer, flaeche, FK_hausID) VALUES ('$wohnungsNummer', '$zimmer', '$flaeche', '$FK_hausID')");
    $_SESSION['message'] = "Wohnung erfasst";
    header('location: wohnung.php');
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $wohnungsNummer = $_POST['wohnungsNummer'];
    $zimmer = $_POST['zimmer'];
    $flaeche = $_POST['flaeche'];
    $FK_hausID = $_POST['FK_hausID'];
    
    mysqli_query($link, "UPDATE wohnung SET wohnungsNummer='$wohnungsNummer', zimmer='$zimmer', flaeche='$flaeche', FK_hausID='$FK_hausID' WHERE wohnungID=$id");
    $_SESSION['message'] = "Wohnung geändert!";
    header('location: wohnung.php');
}
if (isset($_POST['cancel'])) {
    header('location: wohnung.php');
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($link, "DELETE FROM wohnung WHERE wohnungID=$id");
    $_SESSION['message'] = "Wohnung gelöscht!";
    header('location: wohnung.php');
}
$res = mysqli_query($link, "SELECT * FROM wohnung");
?>