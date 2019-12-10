<?php
@session_start();
include('db.inc.php');
// initialize variables
$mietVertrag = "";
$zahlungsdatum = "";
$mietbetrag = "";
$nkbetrag = "";
$periode = "";
$jahr = "";
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM mietEingang WHERE mietEingangID=$id");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $mietVertrag = $n['FK_mietVertragID'];
        $zahlungsdatum = $n['datum'];
        $mietbetrag = $n['mietBetrag'];
        $nkbetrag = $n['nkBetrag'];
        $periode = $n['FK_periode'];
        $jahr = $n['jahr'];
    }
}

if (isset($_POST['save'])) {
    $mietVertrag = $_POST['mietvertrag'];
    $zahlungsdatum = $_POST['zahlungsdatum'];
    $mietbetrag = $_POST['mietbetrag'];
    $nkbetrag = $_POST['nkbetrag'];
    $periode = $_POST['periode'];
    $jahr = $_POST['jahr'];

    mysqli_query($link, "INSERT INTO mietEingang (datum, mietBetrag, nkBetrag, FK_periode,jahr,FK_mietVertragID) VALUES ( '$zahlungsdatum', '$mietbetrag', '$nkbetrag', '$periode', '$jahr','$mietVertrag')");

    $_SESSION['message'] = "Mietzahlung erfasst";
    header('location: mietzahlung.php');
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $mietVertrag = $_POST['mietvertrag'];
    $zahlungsdatum = $_POST['zahlungsdatum'];
    $mietbetrag = $_POST['mietbetrag'];
    $nkbetrag = $_POST['nkbetrag'];
    $periode = $_POST['periode'];
    $jahr = $_POST['jahr'];


    mysqli_query($link, "UPDATE mietEingang SET datum ='$zahlungsdatum', mietBetrag ='$mietbetrag', nkBetrag='$nkbetrag', FK_periode='$periode' , jahr='$jahr'  WHERE mietEingangID=$id");

    $_SESSION['message'] = "Mietzahlung geändert!" . mysqli_error($link);
    header('location: mietzahlung.php');
}

if (isset($_POST['cancel'])) {
    header('location: mietzahlung.php');
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];

    mysqli_query($link, "DELETE FROM mietEingang WHERE mietEingangID=$id");

    $_SESSION['message'] = "Mietzahlung gelöscht" . mysqli_error($link);
    header('location: mietzahlung.php');
}

$res = mysqli_query($link, "SELECT * FROM mietEingang");
?>