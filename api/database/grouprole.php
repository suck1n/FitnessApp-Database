<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'Grouprole' )
        ->fields(
            Field::inst( 'Grouprole.id' )
                ->setFormatter(function () {
                    return null;
                }),
            Field::inst( 'Grouprole.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Name angegeben werden")
                ))
                ->validator(Validate::unique(
                    ValidateOptions::inst()
                        ->message("Es gibt bereits eine Rolle mit diesem Namen")
                )),
            Field::inst( 'Grouprole.description' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine Beschreibung angegeben werden")
                ))
        )
        ->process( $_POST )
        ->json();