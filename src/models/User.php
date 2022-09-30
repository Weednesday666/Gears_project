<?php


class User{
    public $id;
    public $username;
    public $password;
    public $mail;


    public function __construct($mail = "", $password = ""){
        if(!empty($mail))
        $this->mail = $mail;

        if(!empty($password))
        $this->password = ($password);
    }

    public static function getUser(){
        $db = Db::getdb();

        $request= $db->prepare('SELECT * FROM users WHERE id = :id') ;
        $request->execute(['id'=> $ID]);
        $request ->setFetchMode(PDO::FETCH_CLASS , get_class());

        return $request->fetch();
        }

};

// password hashed in bcrypt in db
// log : weednesday666
// password : the munsters lane ;)