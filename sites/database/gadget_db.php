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

$table = "gadget";

$header = "<th data-name='id' data-table-only='true'>Gadget ID</th>
               <th data-name='name'>Name</th>
               <th data-name='description'>Beschreibung</th>
               <th data-name='url'>URL</th>
               <th data-name='difficulty' data-type='select' data-column='Experience.name'>Schwierigkeitsgrad</th>";

$role = get_role($_SESSION["username"]);

if($role["sql_user"] === "administrator") {
    echo get_tab($table, $header, array('create', 'edit', 'remove'));
} else {
    echo get_tab($table, $header);
}