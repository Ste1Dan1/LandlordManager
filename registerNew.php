<?php

session_start();
include 'db.inc.php';


$link = mysqli_connect("localhost", $benutzer, $passwort) or die("Keine Verbindung zur Datenbank!");
mysqli_select_db($link, $dbname) or die("DB nicht gefunden");


// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['email'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    die('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['email']) || empty($_POST['password'])) {
    // One or more values are empty.
    die('Please complete the registration form');
}

if ($stmt = $link->prepare('SELECT userID, pwd FROM users WHERE email = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        
        $_SESSION['messageNEG'] = "E-Mail Adresse existiert bereits!";
        header('location: register.php');
    } else {
        // Username doesnt exists, insert new account
        if ($stmt = $link->prepare('INSERT INTO users (vorname, name, email, pwd) VALUES (?, ?,?,?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('ssss', $_POST['name'], $_POST['vorname'], $_POST['email'], $password);
            $stmt->execute();
           
            $_SESSION['messagePOS'] = "Sie wurden erfolgreich registriert";
            header('location: register.php');
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.

            $_SESSION['messageNEG'] = "Es ist etwas schief gegangen...";
            header('location: register.php');
        }
    }
    $stmt->close();
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo 'Could not prepare statement!';
}
$link->close();
?>
       