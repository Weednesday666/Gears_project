<?php

class LoginController  extends Login{


    private $pwd;
    private $username;

    public function __construct($username, $pwd){

        $this->username = $username;
        $this->pwd = $pwd;


    }

    public function loginUser(){
        if($this->emptyInput() == false){
             echo "empty input ! ";
            //header ("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=emptyinput");
            exit;
        }

        $this->getUser($this->username , $this->pwd);

    }


    public function emptyInput() {
       $result;
        if(empty($this->username) ||empty($this->pwd)){

            $result = false;
        }
        else{
            $result = true;
        }
        return $result;

    }
}


if(isset($_POST)  && !empty($_POST)){

    //recuperation des données
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];


    //instanciation de la classe login

    $login = new LoginController($username, $pwd);

    //gestion des erreurs
    $login->getUser($username , $pwd);
    

    //retour a la homepage
    header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index" );
    exit();
}