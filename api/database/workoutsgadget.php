<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'WorkoutsGadget', array('gadgetID', 'workoutID'))
        ->fields(
            Field::inst( 'WorkoutsGadget.gadgetID' )
                ->options(Options::inst()
                    ->table('gadget')
                    ->value('id')
                    ->label('name')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss ein gültiges Gerät angegeben werden")
                )),
            Field::inst( 'WorkoutsGadget.workoutID' )
                ->options(Options::inst()
                    ->table('Workouts')
                    ->value('id')
                    ->label('name')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss ein gültiges Workout angegeben werden")
                )),

            Field::inst( 'gadget.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                }),
            Field::inst( 'Workouts.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                })
        )
        ->leftJoin('gadget', 'WorkoutsGadget.gadgetID = gadget.id')
        ->leftJoin('Workouts', 'WorkoutsGadget.workoutID = Workouts.id')
        ->process( $_POST )
        ->json();