<?php

class LoginController  extends Login{

    //declaration de la classe
    private $pwd;
    private $username;

    //constructor
    public function __construct($username, $pwd){
        $this->username = $username;
        $this->pwd = $pwd;
    }
    //methode de connexion au site
    public function loginUser(){
        //si le champ est vide , il renvoi a la methode emptyInput
        if($this->emptyInput() == false){
            //annonce qu'un champ est vide
             echo "empty input ! ";
            exit;
        }
        //necessaire de connexion au site
        $this->getUser($this->username , $this->pwd);
    }

    //methode de verification des champs vides
    public function emptyInput() {
       $result;
       // si le champ de pseudo ou de password est vide
        if(empty($this->username) ||empty($this->pwd)){
            //on renvoi faux
            $result = false;
        }
        //sinon
        else{
            //on renvoi true
            $result = true;
        }
        //on renvoi le resultat qui servira a la methode loginUser
        return $result;
    }
}

//si les champs sont rempli
if(isset($_POST)  && !empty($_POST)){
    //recuperation des données
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    //instanciation de la classe login
    $login = new LoginController($username, $pwd);
    //gestion des erreurs
    $login->getUser($username , $pwd);
    //on envoi a la homepage du site
    header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index" );
    exit();
}