<?php

include 'db.inc.php';

// initialize variables
$anrede = "";
$vorname = "";
$name = "";
$geburtsdatum = "";
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM mieter WHERE mieterID=$id");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $anrede = $n['anrede'];
        $vorname = $n['vorname'];
        $name = $n['name'];
        $geburtsdatum = $n['geburtsdatum'];
    }
}

if (isset($_POST['save'])) {
    $anrede = $_POST['anrede'];
    $vorname = $_POST['vorname'];
    $name = $_POST['name'];
    $geburtsdatum = $_POST['geburtsdatum'];

    mysqli_query($link, "INSERT INTO mieter (anrede, vorname, name, geburtsdatum) VALUES ('$anrede', '$vorname', '$name', '$geburtsdatum')");
    $_SESSION['message'] = "Mieter erfasst";
    header('location: ./mieter.php');
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $anrede = $_POST['anrede'];
    $vorname = $_POST['vorname'];
    $name = $_POST['name'];
    $geburtsdatum = $_POST['geburtsdatum'];
    
    mysqli_query($link, "UPDATE mieter SET anrede='$anrede', vorname='$vorname', name='$name', geburtsdatum='$geburtsdatum' WHERE mieterID=$id");
    $_SESSION['message'] = "Mieter geändert!";
    header('location: ./mieter.php');
}

if (isset($_POST['cancel'])) {
    header('Location: ./mieter.php');

}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($link, "DELETE FROM mieter WHERE mieterID=$id");
    $_SESSION['message'] = "Mieter gelöscht!";
    header('Location: ./mieter.php');
}

$res = mysqli_query($link, "SELECT * FROM mieter");

?>