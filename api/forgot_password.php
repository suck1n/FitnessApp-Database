<?php
require_once "database.php";

$response = [
    "status" => "error"
];

if(!empty($_POST)) {
    $email = $_POST["email"];

    if(!empty(trim($email))) {
        if (email_exists($email)) {
            $collection = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $hash = '';
            for($i = 0; $i < 50; $i++) {
                $char = $collection[random_int(0, strlen($collection) - 1)];
                $hash .= $char;
            }

            $link = "http://localhost/sites/forgot_password.php?hash=" . $hash;

            $username = get_user_by_mail($email)["username"];

            save_hash_for_username($username, $hash);

            /*$sent = mail($email, "FitnessApp - Reset your Password",
                "Hello " . $username . ",\n
                 you can reset your password by following this link:\n " . $link);*/

            $sent = true;


            if($sent) {
                $response["status"] = "success";
                $response["message"] = $link;
            } else {
                $response["type"] = "sending";
            }
        } else {
            $response["type"] = "email";
        }
    } else {
        $response["type"] = "unexpected";
    }

    echo json_encode($response);
}