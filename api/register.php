<?php
require_once "database.php";
require_once "utility.php";

$response = [
    "status" => "error",
    "message" => ""
];

if(!empty($_POST)) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $confirm_pass = $_POST["confirm_password"];
    $level = $_POST["experience_level"];

    if(!empty(trim($name)) and !empty(trim($surname)) and !empty(trim($email))
        and !empty(trim($user)) and !empty(trim($pass)) and !empty(trim($confirm_pass))) {
        if(!user_exists($user)) {
            if(check_email_format($email)) {
                if(!email_exists($email)) {
                    if(check_password_format($pass)) {
                        if($pass == $confirm_pass) {
                            if(experience_level_exists($level)) {
                                if(create_user($name, $surname, $user, $pass, $email, $level)) {
                                    $response["status"] = "success";
                                    if(session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    $_SESSION["username"] = $user;
                                } else {
                                    $response["type"] = "unexpected";
                                }
                            } else {
                                $response["type"] = "experience_level";
                            }
                        } else {
                            $response["type"] = "confirm_password";
                        }
                    } else {
                        $response["type"] = "password";
                    }
                } else {
                    $response["type"] = "email";
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