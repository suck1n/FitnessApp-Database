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

$table = "UsersGroup";

$header = "<th data-name='username' data-type='select'>User</th>
               <th data-name='groupID' data-type='select' data-column='group.name'>Gruppe</th>
               <th data-name='roleID' data-type='select' data-column='Grouprole.name'>Rolle</th>";

$role = get_role($_SESSION["username"]);

if($role["sql_user"] === "admin") {
    echo get_tab($table, $header, array('create', 'edit', 'remove'));
} else {
    echo get_tab($table, $header);
}