<?php

class SignupController  extends Signup{

    private $username;
    private $pwd;
    private $pwdRepeat;
    private $email;

    public function __construct($username, $pwd, $pwdRepeat, $email){

        $this->username = $username;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;

    }

    public function signupUser(){
        if($this->emptyInput() == false){
            // echo "empty input ! ";
            header ("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=emptyinput");
            exit;
        }
        if($this->invalidUsername() == false){
            // echo "invalid Username ! ";
            header ("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=username");
            exit;
        }
        if($this->invalidEmail() == false){
            // echo "invalid email ! ";
            header ("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=email");
            exit;
        }
         if($this->pwdMatch() == false){
            // echo "passwords don't match ! ";
            header ("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=passwordmatch");
            exit;
        }
         if($this->usernameTakenCheck() == false){
            // echo "username or email already taken ! ";
            header ("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=userormailtaken");
            exit;
        }

        $this->setUser($this->username, $this->pwd , $this->email);
    }


    public function emptyInput() {
       $result;
        if(empty($this->username) || empty($this->pwd) || empty($this->pwdRepeat) ||empty($this->email)){

            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function invalidUsername() {
        $result;
        if(!preg_match("/^[a-zA-Z0-9]*$/" , $this->username)){

            $result= false;
        }else{
            $result = true;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;
        if (!filter_var($this->email , FILTER_VALIDATE_EMAIL)) {

            $result = false;
        }
        else{
            $result = true ;
        }
        return $result;
    }

    private function pwdMatch(){
        $result;
        if($this->pwd !== $this->pwdRepeat){

            $result = false;
        }
        else{

            $result = true;
        }
        return $result;
    }

    private function usernameTakenCheck(){
        $result;
        if(!$this->checkUser($this->username, $this->email)){

            $result = false;
        }
        else{

            $result = true;
        }
        return $result;
    }



}