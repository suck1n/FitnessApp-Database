<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'group' )
        ->fields(
            Field::inst( 'group.id' )
                ->setFormatter(function () {
                    return null;
                }),
            Field::inst( 'group.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Name angegeben werden")
                )),
            Field::inst( 'Users.username' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                }),
            Field::inst( 'group.owner' )
                ->options( Options::inst()
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
        )
        ->leftJoin('Users', 'group.owner = Users.username');

        if($role["sql_user"] !== "administrator") {
            $editor->where("username", $_SESSION["username"]);
        }

        $editor->process( $_POST )->json();