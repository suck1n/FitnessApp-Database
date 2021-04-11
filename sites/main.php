<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["username"])) {
        header("location: login.php");
        die();
    }

    require_once "../api/database.php";
?>

<!doctype html>
<html lang="de" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/b-1.7.0/date-1.0.3/sl-1.3.3/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../Editor-2.0.1/css/editor.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../css/sidebar.css">
</head>
<body class="d-flex flex-column h-100">
    <?php require "header.php" ?>

    <div class="container-fluid d-flex flex-column pt-0 px-0 overflow-hidden h-100">
        <div id="wrapper" class="h-100">
            <div id="sidebar-wrapper" class="bg-dark h-100 overflow-hidden">
                <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
                    <li class="dropdown">
                        <span>Tables</span>
                        <ul class="menu" style="display: none;">
                            <?php
                                $template = '<li %active% data-column="%table_small%"><span>%table%</span></li>';
                                $active = true;

                                if(empty(get_tables())) {
                                    echo '<li><span>Es gibt noch keine Tables</span></li>';
                                } else {
                                    foreach (get_tables() as $table) {
                                        $temp = str_replace("%active%", $active ? "class='active'" : "", $template);
                                        $temp = str_replace("%table%", ucfirst($table), $temp);
                                        $temp = str_replace("%table_small%", $table, $temp);

                                        echo $temp;
                                        $active = false;
                                    }
                                }
                            ?>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <span>Views</span>
                        <ul class="menu" style="display: none;">
                            <?php
                                $template = '<li data-column="%table_small%"><span>%table%</span></li>';

                                if(empty(get_views())) {
                                    echo '<li><span>Es gibt noch keine Views</span></li>';
                                } else {
                                    foreach(get_views() as $view) {
                                        $temp = str_replace("%table%", ucfirst($view), $template);
                                        $temp = str_replace("%table_small%", $view, $temp);

                                        echo $temp;
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>

            <div id="page-content-wrapper">
                <div class="container-fluid xyz">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-start" id="content">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.24/b-1.7.0/date-1.0.3/sl-1.3.3/datatables.min.js"></script>
    <script src="../Editor-2.0.1/js/dataTables.editor.js"></script>

    <script src="../js/utility_table.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>