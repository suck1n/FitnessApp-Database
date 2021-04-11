<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;

    $editor = Editor::inst($db, 'UsersWorkouts', array('username', 'workoutID'))
        ->fields(
            Field::inst( 'UsersWorkouts.username' )
                ->options(Options::inst()
                    ->table('Users')
                    ->value('username')
                    ->label('username')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss ein gültiger User angegeben werden")
                )),
            Field::inst( 'UsersWorkouts.workoutID' )
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

            Field::inst( 'Workouts.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                })
        )
        ->leftJoin('Workouts', 'UsersWorkouts.workoutID = Workouts.id');

        if($role["sql_user"] !== "administrator") {
            $editor->where("username", $_SESSION["username"]);
        }

        $editor->process( $_POST )->json();