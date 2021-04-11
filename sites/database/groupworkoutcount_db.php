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

$table = "GroupWorkoutCount";

$header = "<th data-name='name'>Gruppe</th>
           <th data-name='count'>Anzahl der Workouts</th>";

echo get_tab($table, $header);