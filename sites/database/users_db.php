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

    $table = "Users";

    $header = "<th data-name='username'>Username</th>
               <th data-name='name'>Vorname</th>
               <th data-name='surname'>Nachname</th>
               <th data-name='email'>E-Mail</th>
               <th data-name='Experience' data-type='select' data-column='Experience.name'>Erfahrung</th>";

    $role = get_role($_SESSION["username"]);

    if($role["sql_user"] === "administrator") {
        $header .= "<th data-name='role' data-type='select' data-column='Roles.sql_user'>Rolle</th>";
        echo get_tab($table, $header, array('edit', 'remove'));
    } else {
        echo get_tab($table, $header);
    }