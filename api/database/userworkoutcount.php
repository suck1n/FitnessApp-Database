<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field;

    $editor = Editor::inst($db, 'userworkoutcount', 'username' )
        ->fields(
            Field::inst( 'userworkoutcount.username' )
                ->validator(function () {
                    return 'View is readonly';
                }),
            Field::inst( 'userworkoutcount.count' )
                ->validator(function () {
                    return 'View is readonly';
                })
        );

        if($role["sql_user"] !== "admin") {
            $editor->where("username", $_SESSION["username"]);
        }

        $editor->process( $_POST )->json();