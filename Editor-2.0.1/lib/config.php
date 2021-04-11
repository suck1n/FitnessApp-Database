<?php if (!defined('DATATABLES')) exit();

include_once "../../api/database.php";

error_reporting(E_ALL);
ini_set('display_errors', '1');

$sql_details = array(
    "type" => "Mysql",
    "pdo"  => get_database()
);