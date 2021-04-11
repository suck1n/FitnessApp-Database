<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field;

    $editor = Editor::inst($db, 'UserWorkoutCount', 'username' )
        ->fields(
            Field::inst( 'UserWorkoutCount.username' )
                ->validator(function () {
                    return 'View is readonly';
                }),
            Field::inst( 'UserWorkoutCount.count' )
                ->validator(function () {
                    return 'View is readonly';
                })
        );

        if($role["sql_user"] !== "administrator") {
            $editor->where("username", $_SESSION["username"]);
        }

        $editor->process( $_POST )->json();