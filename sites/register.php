<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION["username"])) {
        header("location: main.php");
        die();
    }

    include_once "../api/database.php";
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page - FitnessApp</title>
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>

<div class="limiter">
    <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
        <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
            <form class="login100-form validate-form flex-sb flex-w" action="../api/register.php" destination="main.php">
                <span class="login100-form-title p-b-53">Register</span>


                <!--a href="#" class="btn-face m-b-20">
                    <i class="fa fa-facebook-official"></i>
                    Facebook
                </a-->

                <!--a href="#" class="btn-google m-b-20">
                    <img src="../images/icons/icon-google.png" alt="GOOGLE">
                    Google
                </a-->

                <div class="login-group">
                    <div class="p-t-31 p-b-9">
                        <span class="txt1">Name</span>
                    </div>
                    <div class="wrap-input100 alert-input" data-validate="Name is required" data-wrong="">
                        <input class="input100" type="text" name="name" tabindex="1">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">Username</span>
                    </div>
                    <div class="wrap-input100 alert-input" data-validate="Username is required" data-wrong="User already exist">
                        <input class="input100" type="text" name="username"  tabindex="3">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">Password</span>
                    </div>
                    <div class="wrap-input100 alert-input" data-validate="Password is required" data-wrong="Password length needs to be between 8 and 16 characters and needs at least 1 uppercase letter, 1 lowercase letter, 1 digit and 1 symbol.">
                        <input class="input100" type="password" name="password" tabindex="5">
                        <span class="focus-input100"></span>
                    </div>
                </div>

                <div class="login-group">
                    <div class="p-t-31 p-b-9">
                        <span class="txt1">Surname</span>
                    </div>
                    <div class="wrap-input100 alert-input" data-validate="Surname is required" data-wrong="">
                        <input class="input100" type="text" name="surname" tabindex="2">
                        <span class="focus-input100"></span>
                    </div>


                    <div class="p-t-13 p-b-9">
                        <span class="txt1">E-Mail</span>
                    </div>
                    <div class="wrap-input100 alert-input" data-validate="E-Mail is required" data-wrong="E-Mail already in use">
                        <input class="input100" type="email" name="email" tabindex="4">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="p-t-13 p-b-9">
                        <span class="txt1">Confirm Password</span>
                    </div>
                    <div class="wrap-input100 alert-input" data-validate="Repeat the Password" data-wrong="Not the same password">
                        <input class="input100" type="password" name="confirm_password" tabindex="6">
                        <span class="focus-input100"></span>
                    </div>
                </div>

                <div class="p-t-13 p-b-9">
                    <span class="txt1">Experience-Level</span>
                </div>
                <div class="wrap-input100 alert-input" data-validate="Level can not be empty" data-wrong="Not a valid level">
                    <select class="input100 border-0" name="experience_level" tabindex="7" style="outline: none">
                        <?php
                            $template = "<option value='%id%' %selected%>%name%</option>";
                            $selected = true;

                            $levels = execute_query("select id, name from Experience order by id");

                            foreach ($levels as $experience) {
                                $name = $experience["name"];
                                $id = $experience["id"];

                                $temp = str_replace("%name%", $name, $template);
                                $temp = str_replace("%id%", $id, $temp);
                                $temp = str_replace("%selected%", $selected ? "selected" : "", $temp);

                                echo $temp;
                                $selected = false;
                            }
                        ?>
                    </select>
                    <span class="focus-input100"></span>
                </div>



                <div class="w-full text-center p-t-55">
                    <span class="txt2">Already a member?</span>
                    <a href="login.php" class="txt2 bo1">Login now</a>
                </div>

                <div class="container-login100-form-btn m-t-17">
                    <button class="login100-form-btn">Register User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script src="../vendor/animsition/js/animsition.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
<script src="../vendor/select2/select2.min.js"></script>
<script src="../vendor/daterangepicker/moment.min.js"></script>
<script src="../vendor/daterangepicker/daterangepicker.js"></script>
<script src="../vendor/countdowntime/countdowntime.js"></script>

<script src="../js/utility.js"></script>
<script src="../js/validator.js"></script>
<script src="../js/form_parser.js"></script>

</body>
</html>