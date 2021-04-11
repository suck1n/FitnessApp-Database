<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["username"])) {
        header("location: login.php");
        die();
    }

    include_once "utility_db.php";
    include_once "../../api/database.php";

    $table = "Roles";

    $header = "<th data-name='id' data-table-only='true'>Rollen ID</th>
                   <th data-name='description'>Beschreibung</th>
                   <th data-name='sql_user'>Username</th>";

    echo get_tab($table, $header);