<?php

// declaration de la classe DB
class Db {
    private static $db = null;

    public static function getDb() {
        if (isset(self::$db)) {
            return self::$db;
        } else {
            return self::connect();
        }
    }
    //connexion a la db

    private static function connect() {
        try{
        $db = parse_ini_file("src/.ini");
        $host = $db['host'];
        $name = $db['name'];
        $user = $db['user'];
        $pass = $db['pass'];
            self::$db = new PDO(
                'mysql:host='.$host.';port=3306;dbname='.$name.";charset=utf8",$user,$pass
            );
        }catch(PDOException $e){
            die("ERROR: Could not connect. " . $e->getMessage());
        }
            return self::$db;
    }

}