<?php

include 'topbar.inc.php';
include 'db.inc.php';

// initialize variables
$anrede = "";
$vorname = "";
$name = "";
$email = $_SESSION["name"];
$id = 0;
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($link, "SELECT * FROM users WHERE email = '$email';");

    if (@count($record) == 1) {
        $n = mysqli_fetch_array($record);
        $anrede = $n['anrede'];
        $vorname = $n['vorname'];
        $name = $n['name'];
        $email = $n['email'];
    }
}


if (isset($_POST['update'])) {
    
    $anrede = $_POST['anrede'];
    $vorname = $_POST['vorname'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    mysqli_query($link, "UPDATE users SET anrede='$anrede', vorname='$vorname', name='$name', email='$email' WHERE email='$email'");
    $_SESSION['message'] = "User geändert!";
    header('location: user.php');
}

if (isset($_POST['cancel'])) {
    header('location: user.php');
}


$res = mysqli_query($link, "SELECT * FROM mieter");

?>