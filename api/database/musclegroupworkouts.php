<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'MuscleGroupWorkouts', array('muscleGroupID', 'workoutID'))
        ->fields(
            Field::inst( 'MuscleGroupWorkouts.muscleGroupID' )
                ->options(Options::inst()
                    ->table('MuscleGroup')
                    ->value('id')
                    ->label('name')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss eine gültige Muskelgruppe angegeben werden")
                )),
            Field::inst( 'MuscleGroupWorkouts.workoutID' )
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
            Field::inst( 'MuscleGroup.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                }),
            Field::inst( 'Workouts.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                })
        )
        ->leftJoin('MuscleGroup', 'MuscleGroupWorkouts.muscleGroupID = MuscleGroup.id')
        ->leftJoin('Workouts', 'MuscleGroupWorkouts.workoutID = Workouts.id')
        ->process( $_POST )
        ->json();