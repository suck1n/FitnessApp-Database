<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["username"])) {
        header("location: login.php");
        die();
    }

    include("../../Editor-2.0.1/lib/DataTables.php");
    include_once("../database.php");

    $role = get_role($_SESSION["username"]);
