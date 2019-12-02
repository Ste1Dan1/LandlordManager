<?php

@session_start();
include 'db.inc.php';

// initialize variables
$anrede = "";
$vorname = "";
$name = "";
$email = $_SESSION["name"];
$id = 0;
$update = false;


if (isset($_GET['edit'])) {

    $update = true;
}


if (isset($_POST['update'])) {
    $id = $_GET['edit'];

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $link->prepare('SELECT userID, pwd FROM users WHERE email = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $email);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
    }
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['old_password'], $password)) {
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.

            $passwordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            mysqli_query($link, "UPDATE users SET pwd='$passwordHash' WHERE email='$email'");
            $_SESSION['message'] = "Passwort geändert";
            header('location: userPW.php');
        } else {
            $_SESSION['message'] = "Falches Passwort";
            header('location: userPW.php');
        }
    }
}


if (isset($_POST['cancel'])) {
    header('location: userPW.php');
}


$res = mysqli_query($link, "SELECT * FROM mieter");
?>