<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'Workouts' )
        ->fields(
            Field::inst( 'Workouts.id' )
                ->setFormatter( function () {
                    return null;
                }),
            Field::inst( 'Workouts.level' )
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
            Field::inst( 'Workouts.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Name angegeben werden")
                )),
            Field::inst( 'Workouts.url' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine URL angegeben werden")
                ))
                ->validator(Validate::url(
                    ValidateOptions::inst()
                        ->message("Es muss eine gültige URL angegeben werden")
                )),
            Field::inst( 'Workouts.length' )
                ->validator(Validate::numeric(",",
                    ValidateOptions::inst()
                        ->message('Es muss eine Zahl angegeben werden')
                )),
            Field::inst( 'Workouts.description' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss eine Beschreibung angegeben werden")
                )),
            Field::inst( 'Workouts.sets' )
                ->validator(Validate::numeric(",",
                    ValidateOptions::inst()
                        ->message('Es muss eine Zahl angegeben werden')
                )),
            Field::inst( 'Workouts.repetitions' )
                ->validator(Validate::numeric(",",
                    ValidateOptions::inst()
                        ->message('Es muss eine Zahl angegeben werden')
                )),
            Field::inst( 'Experience.name' )
                ->validator(function ($data) {
                    return (empty($data)) ? true : 'Field is readonly!';
                })
        )
        ->leftJoin('Experience', 'Workouts.level = Experience.id')
        ->process( $_POST )
        ->json();