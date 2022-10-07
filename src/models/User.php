<?php

//on etabli la class user
class User{
    public $id;
    public $username;
    public $password;
    public $mail;
    //constructor
    public function __construct($mail = "", $password = ""){
        if(!empty($mail))
        $this->mail = $mail;

        if(!empty($password))
        $this->password = ($password);
    }
    //on etabli la fonction pour recuperer les infos de l'utilisateur
    public static function getUser(){
        //connexion a la db 
        $db = Db::getdb();
        //on prepare une requete qui va selectionner toute les infos de user 
        $request= $db->prepare('SELECT * FROM users WHERE id = :id') ;
        //on execute la requete en ciblant l'id
        $request->execute(['id'=> $ID]);
        //on recupere les données necessaire
        $request ->setFetchMode(PDO::FETCH_CLASS , get_class());
        //on retourne le resultat
        return $request->fetch();
        }

};
