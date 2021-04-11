<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'weightclass' )
        ->fields(
            Field::inst( 'weightclass.id' )
                ->setFormatter(function () {
                    return null;
                }),
            Field::inst( 'weightclass.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Name angegeben werden")
                ))
                ->validator(Validate::unique(
                    ValidateOptions::inst()
                        ->message("Es gibt bereits eine Gewichtsklasse mit diesem Namen")
                )),
            Field::inst( 'weightclass.description' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine Beschreibung angegeben werden")
                ))
        )
        ->process( $_POST )
        ->json();