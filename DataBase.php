<?php

class DBConnect {
    const dbname = DBNAME;
    const username = USERNAME;
    const password = PASS;
    const opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    private $connect;

    function start(){
        $this->connect = new PDO("mysql:host=localhost;dbname=".self::dbname, self::username, self::password, self::opt);

        if (!$this->connect){
            die('Ошибка с подключением к Базе данных!');
        }
    }

    function getUser($first_name, $last_name){
        $query = "SELECT first_name, last_name FROM users WHERE `first_name`='$first_name' AND `last_name`='$last_name'";
        $user = $this->connect->query($query)->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    function addUser($first_name, $last_name){
        $user = new User($first_name, $last_name);

        $query = "INSERT INTO users (first_name, last_name) VALUES ('{$user->first_name}', '{$user->last_name}')";
        $this->connect->query($query);

        return $user;
    }
}

    $DB = new DBConnect();
    $connect = $DB->start();
?>