<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'GroupWorkouts', array('groupID', 'workoutID'))
        ->fields(
            Field::inst( 'GroupWorkouts.groupID' )
                ->options(Options::inst()
                    ->table('group')
                    ->value('id')
                    ->label('name')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss eine gültige Gruppe angegeben werden")
                )),
            Field::inst( 'GroupWorkouts.workoutID' )
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
            Field::inst( 'group.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                }),
            Field::inst( 'Workouts.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                })
        )
        ->leftJoin('group', 'GroupWorkouts.groupID = group.id')
        ->leftJoin('Workouts', 'GroupWorkouts.workoutID = Workouts.id')
        ->process( $_POST )
        ->json();