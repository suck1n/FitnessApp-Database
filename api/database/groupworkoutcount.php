<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field;

    $editor = Editor::inst($db, 'groupworkoutcount', 'name' )
        ->fields(
            Field::inst( 'groupworkoutcount.name' )
                ->validator(function () {
                    return 'View is readonly';
                }),
            Field::inst( 'groupworkoutcount.count' )
                ->validator(function () {
                    return 'View is readonly';
                })
        )
        ->process( $_POST )
        ->json();