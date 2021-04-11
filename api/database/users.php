<?php
    include_once "headers.php";

    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Options,
        DataTables\Editor\ValidateOptions,
        DataTables\Editor\Validate;

    $editor = Editor::inst($db, 'Users', 'username' )
        ->fields(
            Field::inst( 'Users.username' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Username angegeben werden")
                ))
                ->validator(Validate::unique(
                    ValidateOptions::inst()
                        ->message("Dieser Username wird bereits verwendet")
                )),
            Field::inst( 'Users.name' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Vorname angegeben werden")
                )),
            Field::inst( 'Users.surname' )
                ->validator(Validate::notEmpty(
                    ValidateOptions::inst()
                        ->message("Es muss ein Nachname angegeben werden")
                )),
            Field::inst( 'Users.email' )
                ->validator(Validate::email(
                    ValidateOptions::inst()
                        ->allowEmpty( false )
                        ->optional( false )
                        ->message("Es muss eine gültige E-Mail Adresse angegeben werden")
                ))
                ->validator(Validate::unique(
                    ValidateOptions::inst()
                        ->message("Dieser Username wird bereits verwendet")
                )),
            Field::inst( 'Users.Experience' )
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
                ->validator(function ($data) {
                    return (empty($data)) ? true : 'Field is readonly!';
                }),
        )
        ->leftJoin('Experience', 'Users.experience = Experience.id');

    if($role["sql_user"] === 'administrator') {
        $editor->fields(
            Field::inst( 'Roles.sql_user' )
                ->validator(function ($data) {
                    return (empty($data)) ? true : 'Field is readonly!';
                }),
            Field::inst( 'Users.role' )
                ->options( Options::inst()
                    ->table('Roles')
                    ->value('id')
                    ->label('sql_user')
                )
                ->validator(Validate::dbValues(
                    ValidateOptions::inst()
                        ->allowEmpty(false)
                        ->optional(false)
                        ->message("Es muss eine gültige Rolle angegeben werden")
                )))
            ->leftJoin('Roles', 'Users.role = Roles.id');
    } else {
        $editor->where("username", $_SESSION["username"]);
    }

    $editor->process( $_POST )->json();