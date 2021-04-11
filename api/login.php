<?php
require_once "database.php";

$response = [
    "status" => "error"
];

if(!empty($_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(!empty(trim($username)) and !empty(trim($password))) {
        if (user_exists($username)) {
            $hash = get_password($username);

            if ($hash != null) {
                if (password_verify($password, $hash)) {
                    $response["status"] = "success";
                    if(session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION["username"] = $username;
                } else {
                    $response["type"] = "password";
                }
            } else {
                $response["type"] = "unexpected";
            }
        } else {
            $response["type"] = "username";
        }
    } else {
        $response["type"] = "unexpected";
    }

    echo json_encode($response);
}