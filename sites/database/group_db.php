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

$table = "group";

$header = "<th data-name='id' data-table-only='true'>Group ID</th>
               <th data-name='name'>Name</th>
               <th data-name='owner' data-type='select' data-column='Users.username'>Owner</th>";

$role = get_role($_SESSION["username"]);

if($role["sql_user"] === "administrator") {
    echo get_tab($table, $header, array('create', 'edit', 'remove'));
} else {
    echo get_tab($table, $header);
}