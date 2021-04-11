<?php
    require_once "../api/database.php";

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(empty($_SESSION["username"])) {
        header("location: login.php");
        die();
    }

    $user = get_user($_SESSION["username"]);
?>
<!doctype html>
<html lang="de">
<head>
    <title>Profile - FitnessApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">



</head>
<body>
    <?php require "header.php" ?>
    <div class="container d-flex flex-column pt-4">
        <h1>Profile</h1>
        <div class="mt-5">
            <div class="alert mb-4" style="display: none" role="alert" id="alert">
                <strong id="alert_header" style="font-size: 1.1rem"></strong>
                <p id="alert_description" class="d-inline-block mb-0 ml-2"></p>
            </div>

            <div class="form-group row mb-3">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control"
                           id="username" name="username" placeholder="Username" readonly
                           value="<?php echo $user["username"] ?>">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-info btn-block" data-for="username">Edit</button>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="name" class="col-sm-2 col-form-label">Vorname</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control"
                           id="name" name="name" placeholder="Vorname" readonly
                           value="<?php echo $user["name"] ?>">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-info btn-block" data-for="name">Edit</button>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="surname" class="col-sm-2 col-form-label">Nachname</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control"
                           id="surname" name="surname" placeholder="Nachname" readonly
                           value="<?php echo $user["surname"] ?>">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-info btn-block" data-for="surname">Edit</button>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control"
                           id="email" name="email" placeholder="E-Mail" readonly
                           value="<?php echo $user["email"] ?>">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-info btn-block" data-for="email">Edit</button>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Passwort</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control"
                           id="password" name="password" placeholder="Passwort" readonly value="XXXXXXXX">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-info btn-block" data-for="password">Edit</button>
                </div>
            </div>
            <div class="form-group row mb-3" style="display: none" id="confirm_password_group">
                <label for="confirm_password" class="col-sm-2 col-form-label">Bestätige Passwort</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control"
                           id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                </div>
            </div>

            <button class="btn btn-primary" style="display: none" id="save_button">Speichern</button>
            <button class="btn btn-danger" style="display: none" id="cancel_button">Abbrechen</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.js"></script>

    <script src="../js/profile.js"></script>
</body>
</html>

