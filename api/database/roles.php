<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field;


    $editor = Editor::inst($db, 'Roles' )
        ->fields(
            Field::inst( 'Roles.id' )
                ->validator(function () {
                    return 'Table is readonly!';
                }),
            Field::inst( 'Roles.description' )
                ->validator(function () {
                    return 'Table is readonly!';
                }),
            Field::inst( 'Roles.sql_user' )
                ->validator(function () {
                    return 'Table is readonly!';
                })
        )
        ->process( $_POST )
        ->json();