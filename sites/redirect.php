<?php
    $types = array("email", "password");
    $type = "";

    if(!empty($_GET["type"])) {
        if(in_array($_GET["type"], $types)) {
            $type = $_GET["type"];
        }
    } else {
        header("location: login.php");
        die();
    }
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page - FitnessApp</title>
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <form class="login100-form validate-form flex-sb flex-w" action="../api/login.php" destination="main.php">
                <span class="login100-form-title p-b-53">
                    <?php echo $type === 'email' ? "You will receive an E-Mail shortly" : "Your password has been reset!" ?>
                </span>
                <span style="text-align: center; display: block; width: 100%; font-size: 23px;">
                    Redirecting...
                </span>
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

<script>
    setTimeout(() => {
        window.location.replace("login.php");
    }, 3000);
</script>

</body>
</html>