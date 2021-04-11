<?php
    function get_user(string $username): ?array {
        $user = execute_query("select * from Users where username = ?", array($username), true);

        if($user == false || empty($user)) {
            return null;
        }

        return $user[0];
    }

    function get_user_without_password(string $username): ?array {
        $user = execute_query("select username, name, surname, email, role from Users where username = ?", array($username), true);

        if($user == false || empty($user)) {
            return null;
        }

        return $user[0];
    }

    function get_user_by_mail(string $email): ?array {
        $user = execute_query("select * from Users where email = ?", array($email));

        if($user == false || empty($user)) {
            return null;
        }

        return $user[0];
    }

    function user_exists(string $username): bool {
        return get_user($username) != null;
    }

    function email_exists(string $email): bool {
        return get_user_by_mail($email) != null;
    }

    function get_password(string $username): ?string {
        $user = get_user($username);

        if($user == null) {
            return null;
        }

        return $user["password"];
    }

    function create_user(string $name, string $surname, string $username, string $password, string $email, int $level): bool {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $result = execute_query("INSERT INTO Users(username, name, surname, password, role, email, experience) 
                                        values (?, ?, ?, ?, 1, ?, ?)",
                array($username, $name, $surname, $hash, $email, $level));


        return is_array($result);
    }

    function forgot_password_hash_exists(string $hash): bool {
        return get_username_from_hash($hash) != null;
    }

    function get_username_from_hash(string $hash): ?string {
        $response = execute_query("select * from ForgotPassword where hash = ?", array($hash), true);

        if(empty($response)) {
            return null;
        }

        return $response[0]["user"];
    }

    function delete_hash(string $hash): bool {
        $response = execute_query("delete from ForgotPassword where hash = ?", array($hash));

        return is_array($response);
    }

    function save_hash_for_username(string $username, string $hash): bool {
        $response = execute_query("INSERT INTO ForgotPassword values(?, ?)", array($hash, $username));

        return is_array($response);
    }

    function get_tables_and_views(): ?array {
        $response = execute_query("show full tables");

        if($response === false) {
            return null;
        }

        $return_value = array(
            "tables" => array(),
            "views" => array()
        );

        foreach($response as $value) {
            $table = $value["Tables_in_fitness_app"];
            $type = $value["Table_type"];

            if(!empty($table)) {
                if($type === "BASE TABLE") {
                    array_push($return_value["tables"], $table);
                } else if($type === "VIEW") {
                    array_push($return_value["views"], $table);
                }
            }
        }

        return $return_value;
    }

    function get_tables(): ?array {
        $tables_views = get_tables_and_views();

        if($tables_views === null) {
            return null;
        }

        $tables = [];

        foreach($tables_views["tables"] as $table) {
            if(strtolower($table) !== "forgotpassword") {
                array_push($tables, $table);
            }
        }

        return $tables;
    }

    function get_views(): ?array {
        $tables_views = get_tables_and_views();

        if($tables_views === null) {
            return null;
        }

        return $tables_views["views"];
    }

    function experience_level_exists(int $id): bool {
        $value = execute_query("select * from Experience where Experience.id = ?", array($id));

        if($value == false || empty($value)) {
            return false;
        }

        return true;
    }


    function execute_query(string $query, array $data = array(), bool $useDefaultAccount = false): array | bool {
        $db = get_database($useDefaultAccount);

        $stmt = $db->prepare($query);

        if($stmt->execute($data)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    function get_role(string $username): array | bool {
        $stmt = database()->prepare("select sql_user, sql_password 
                                           from Roles, Users where Users.username = ? and Users.role = Roles.id");

        if($stmt->execute(array($username))) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
        } else {
            return false;
        }
    }

    function get_database(bool $useDefaultAccount = false): ?PDO {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(!empty($_SESSION["username"]) and !$useDefaultAccount) {
            $role = get_role($_SESSION["username"]);
            if($role) {
                $db = database($role["sql_user"], $role["sql_password"]);
            } else {
                $db = database();
            }
        } else {
            $db = database();
        }

        return $db;
    }

    function database(string $user = null, string $pass = null): ?PDO {
        if($settings = parse_ini_file(__DIR__ . "/database_settings.ini", TRUE)) {
            $host = 'host=' . $settings['database']['host'];
            $port = (!empty($settings['database']['port']) ? ';port=' . $settings['database']['port'] : '');
            $dbname = ';dbname=' . $settings['database']['database'];

            $dns = 'mysql:' . $host . $port . $dbname;

            $username = $user == null ? $settings['database']['username'] : $user;
            $password = $pass == null ? (empty($settings['database']['password']) ? null : $settings["database"]["password"]) : $pass;

            return new PDO($dns, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } else {
            return null;
        }
    }