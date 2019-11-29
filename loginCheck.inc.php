<?php

if ($_SESSION['loggedin'] == true) {
    
} else {
    header("Location:login.php");
    exit;
}?>