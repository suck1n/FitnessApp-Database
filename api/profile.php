<?php
require_once "database.php";
require_once "utility.php";

$response = [
    "status" => "error"
];

if(!empty($_POST)) {
    $op = $_POST["operation"];

    switch ($op) {
        case "default_values":
            if(session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if(empty($_SESSION["username"])) {
                $response["message"] = "Session expired";
            } else {
                $username = $_SESSION["username"];
                $response["status"] = "success";
                $response["data"] = get_user_without_password($username);
            }
            break;
        case "update":
            if(session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if(empty($_SESSION["username"]) and empty($_POST["hash"])) {
                $response["message"] = "Session expired";
            } else {
                if(empty($_SESSION["username"])) {
                    $current_username = get_username_from_hash($_POST["hash"]);
                    $only_password = true;
                } else {
                    $current_username = $_SESSION["username"];
                    $only_password = false;
                }
                $new_data = $_POST["data"];

                if(!empty($new_data)) {
                    $column_whitelist = $only_password ?
                        array("password") :
                        array("username", "name", "surname", "email", "password");

                    $key = $new_data["key"];
                    $value = $new_data["value"];

                    if(in_array($key, $column_whitelist, true)) {
                        if($key === "email") {
                            if(!check_email_format($value)) {
                                $response["message"] = "Incorrect E-Mail format";
                                echo json_encode($response);
                                die();
                            }
                            if(email_exists($value)) {
                                $response["message"] = "E-Mail already in use";
                                echo json_encode($response);
                                die();
                            }
                        }
                        if($key === "password") {
                            $confirm_password = $new_data["confirm_password"];
                            if(check_password_format($value)) {
                                if($value != $confirm_password) {
                                    $response["message"] = "Password and confirm password are not equal";
                                    $response["type"] = "confirm_password";
                                    echo json_encode($response);
                                    die();
                                }
                            } else {
                                $response["message"] = "Incorrect password format";
                                $response["type"] = "password";
                                echo json_encode($response);
                                die();
                            }

                            $value = password_hash($value, PASSWORD_BCRYPT);
                        }
                        if($key === "username") {
                            if(user_exists($value)) {
                                $response["message"] = "Username already exists";
                                echo json_encode($response);
                                die();
                            }
                        }

                        $result = execute_query("update Users set " . $key . " = ? where Users.username = ?",
                            array($value, $current_username), true);

                        if($key === "username") {
                            $_SESSION["username"] = $value;
                        }

                        if(is_array($result)) {
                            if(!empty($_POST["hash"])) {
                                if(delete_hash($_POST["hash"])) {
                                    $response["status"] = "success";
                                } else {
                                    $response["status"] = "error";
                                    $response["message"] = "Unexpected error";
                                }
                            } else {
                                $response["status"] = "success";
                            }
                        } else {
                            $response["message"] = "Unexpected error";
                        }
                    } else {
                        $response["message"] = "Not valid column";
                    }
                }
            }
            break;
    }

    echo json_encode($response);
}