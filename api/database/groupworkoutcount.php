<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field;

    $editor = Editor::inst($db, 'GroupWorkoutCount', 'name' )
        ->fields(
            Field::inst( 'GroupWorkoutCount.name' )
                ->validator(function () {
                    return 'View is readonly';
                }),
            Field::inst( 'GroupWorkoutCount.count' )
                ->validator(function () {
                    return 'View is readonly';
                })
        )
        ->process( $_POST )
        ->json();