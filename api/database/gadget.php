<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'gadget' )
        ->fields(
            Field::inst( 'gadget.id' )
                ->setFormatter( function () {
                    return null;
                }),
            Field::inst( 'gadget.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Name angegeben werden")
                ))
                ->validator(Validate::unique(
                    ValidateOptions::inst()
                        ->message("Dieser Name wird bereits verwendet!")
                )),
            Field::inst( 'gadget.description' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine Beschreibung angegeben werden")
                )),
            Field::inst( 'gadget.url' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine URL angegeben werden")
                ))
                ->validator(Validate::url(
                    ValidateOptions::inst()
                        ->message("Es muss eine gültige URL angegeben werden")
                )),
            Field::inst( 'gadget.difficulty' )
                ->options( Options::inst()
                    ->table('Experience')
                    ->value('id')
                    ->label('name')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss ein gültiges Erfahrungs-Level angegeben werden")
                )),
            Field::inst( 'Experience.name' )
                ->validator( function ($data) {
                    return empty($data) ? true : "This field is readonly!";
                })
        )
        ->leftJoin("Experience", "gadget.difficulty = Experience.id")
        ->process( $_POST )
        ->json();