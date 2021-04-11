<?php
require_once "database.php";

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(session_unset()) {
    if(session_destroy()) {
        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000);
        }
    }
}

header("location: ../sites/login.php");
die();