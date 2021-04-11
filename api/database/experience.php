<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'Experience' )
        ->fields(
            Field::inst( 'Experience.id' )
                ->setFormatter( function () {
                    return null;
                }),
            Field::inst( 'Experience.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Name angegeben werden")
                ))
                ->validator(Validate::unique(
                    ValidateOptions::inst()
                        ->message("Dieser Name wird bereits verwendet!")
                )),
            Field::inst( 'Experience.description' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine Beschreibung angegeben werden")
                ))
        )
        ->process( $_POST )
        ->json();