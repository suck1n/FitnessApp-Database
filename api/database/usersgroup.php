<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;


    $editor = Editor::inst($db, 'UsersGroup', array('username', 'groupID', 'roleID'))
        ->fields(
            Field::inst( 'UsersGroup.username' )
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
            Field::inst( 'UsersGroup.groupID' )
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
            Field::inst( 'UsersGroup.roleID' )
                ->options(Options::inst()
                    ->table('Grouprole')
                    ->value('id')
                    ->label('name')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss eine gültige Rolle angegeben werden")
                )),

            Field::inst( 'group.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                }),
            Field::inst( 'Grouprole.name' )
                ->validator(function($data) {
                    return empty($data) ? true : "This field is readonly";
                })
        )
        ->leftJoin('group', 'UsersGroup.groupID = group.id')
        ->leftJoin('Grouprole', 'UsersGroup.roleID = Grouprole.id');

        if($role["sql_user"] !== "admin") {
            $editor->where("username", $_SESSION["username"]);
        }

        $editor->process( $_POST )->json();