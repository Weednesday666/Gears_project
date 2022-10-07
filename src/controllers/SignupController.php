<?php
//controller qui herite de signup
class SignupController  extends Signup{
    //declaration de la classe
    private $username;
    private $pwd;
    private $pwdRepeat;
    private $email;
    //constructor
    public function __construct($username, $pwd, $pwdRepeat, $email){
        //declaration du contructor
        $this->username = $username;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }

    public function signupUser(){
        //getionnaire des erreurs a afficher si erreur il y a.

        //si le champ est vide , suite a la verification par la methode emptyInput
        if($this->emptyInput() == false){
            //on envoi un message d'erreur en indiquant  l'erreur en question
             echo "empty input ! ";
            exit;
        }
        //si le pseudo n'est pas valide suite a la verification par la methode invalidUsername
        if($this->invalidUsername() == false){
            //on envoi un message d'erreur en indiquant l'erreur en question
             echo "invalid Username ! ";
            exit;
        }
        //si le mail n'est pas conforme via la verification de invalidEmail
        if($this->invalidEmail() == false){
            //on envoi un message d'erreur en indiquant l'erreur en question
             echo "invalid email ! ";
            exit;
        }
        // si les mot de passe ne sont pas identique , suite a la verification via pwdMatch
         if($this->pwdMatch() == false){
             //on envoi un message d'erreur en indiquant l'erreur en question
             echo "passwords don't match ! ";
            exit;
        }
        // si le pseudo ou le mail est deja present dans la database , suite a la verification faite par usernameTakenCheck
         if($this->usernameTakenCheck() == false){
             //on envoi un message d'erreur en indiquant l'erreur en question
             echo "username or email already taken ! ";
            exit;
        }
        //on etabli le profil de l'utilisateur si toutes les conditions sont passée et qu'aucune erreur n'est declecnchée
        $this->setUser($this->username, $this->pwd , $this->email);
    }

    //verification de champ vide
    public function emptyInput() {
       $result;
       //si un des champs du formulaire est vide
        if(empty($this->username) || empty($this->pwd) || empty($this->pwdRepeat) ||empty($this->email)){
            //on envoi false
            $result = false;
        //sinon
        }else{
            //on envoi true
            $result = true;
        }
        //on renvoi le resultat qui servira dans la methode signupUser
        return $result;
    }
    
    // on verifie que le nom de l'utilisateur est conforme
    private function invalidUsername() {
        $result;
        //si son pseudo contient des caracteres non autorisés ( de a a z en minuscule ou majuscules et les chiffres de 0 a 9)
        if(!preg_match("/^[a-zA-Z0-9]*$/" , $this->username)){
            //on renvoi false
            $result= false;
        //sinon
        }else{
            //on renvoi true
            $result = true;
        }
        //on renvoi le resultat qui servira dans la methoe signupUser
        return $result;
    }
    
    //verification de la validité de l'adresse mail
    private function invalidEmail() {
        $result;
        //on utilise la fonction native de php pour cerifier si l'email est correct.
        //si il ne convient pas
        if (!filter_var($this->email , FILTER_VALIDATE_EMAIL)) {
            //on envoi false
            $result = false;
        //sinon
        }else{
            //on envoi true
            $result = true ;
        }
        //on renvoi le resultat qui servira dans la methode signupUser
        return $result;
    }
    
    //verification de l'exactitude du password
    private function pwdMatch(){
        $result;
        //si le champ mot de passe et sa repetition ne sont pas identique
        if($this->pwd !== $this->pwdRepeat){
            //on envoi false
            $result = false;
        //sinon
        }else{
            //on evoi true
            $result = true;
        }
         //on renvoi le resultat qui servira dans la methode signupUser
        return $result;
    }
    
    //verification de la disponibilté du pseudo et/ou du mail
    private function usernameTakenCheck(){
        $result;
        //on lance une methode checkUser et si le resultat n'est pas conforme
        //CAD si la methode a trouver une correspondance dans la db
        if(!$this->checkUser($this->username, $this->email)){
            //on envoi false
            $result = false;
        //sinon
        }else{
            //on envoi true
            $result = true;
        }
        //on renvoi le resultat qui servira dans la methode signupUser
        return $result;
    }
}

//si les champs sont valide et qu'aucun n'est vide
if(isset($_POST)  && !empty($_POST)){

    //recuperation des données
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];
    $email = $_POST["email"];
    //instanciation de la classe signup
    $signup = new SignupController($username, $pwd, $pwdRepeat, $email);
    //gestion des erreurs
    $signup->signupUser();
    //retour a la homepage
    header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=none" );
}