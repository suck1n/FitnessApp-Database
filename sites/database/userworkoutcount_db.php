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

$table = "UserWorkoutCount";

$header = "<th data-name='username'>User</th>
           <th data-name='count'>Anzahl der Workouts</th>";

echo get_tab($table, $header);