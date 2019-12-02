<?php

@session_start();
include 'db.inc.php';
$errors = [];


if (isset($_POST['email'])) {
    $email = $_POST['email'];
    // ensure that the user exists on our system
    $query = "SELECT email FROM users WHERE email='$email'";
    $results = mysqli_query($link, $query);

    if (empty($email)) {
        $_SESSION['messageNEG'] = "Bitte E-Mail eintragen";
        array_push($errors, "Your email is required");
        header('location: accountRecovery.php');
    } else if (mysqli_num_rows($results) <= 0) {
        $_SESSION['messageNEG'] = "Es existiert kein Benutzer mit dieser E-Mail";
        array_push($errors, "Sorry, no user exists on our system with that email");
        header('location: accountRecovery.php');
    }



    if (count($errors) == 0) {

        // neues Passwort erzeugen

        $pwd = bin2hex(openssl_random_pseudo_bytes(4));

        //Passwort in DB speichern

        $passwordHash = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_query($link, "UPDATE users SET pwd='$passwordHash' WHERE email='$email'");

        //Passwort verschicken
        $to_email_address = $email;
        $subject = "Neues Passwort";
        $message = "Guten Tag, Ihr neues Passwort lautet $pwd";
        $headers = 'From: llm@bplaced.net';

        mail($to_email_address, $subject, $message);
        $_SESSION['messageNEG'] = "E-Mail mit neuem Passwort wurde verschickt";
        header('location: login.php');
    }

}
?>