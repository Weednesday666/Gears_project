<?php

class AuthController{

    public static function login(){

            if(!empty($_POST ['username']) && !empty($_POST ['password'])):
                $user= Authenticator::authenticate(new User($_POST['username'], $_POST['password']));
                echo'NOICE ! LOGGED! ';
                endif;

            if(empty($_POST['username']) && empty($_POST['password'])):
                echo'ERROR ! EMPTY FIELD !';
                endif;

            if(!empty($_POST['username'])=== null && !empty($_POST['password'])=== null):
                echo 'ERROR! UNKNOWN USER ! ';
                endif;


        var_dump(Authenticator::isLogged());

        self::render('login');
    }

    public static function logout(){
        Authenticator::logout();

        header('location: ./login');
    }
};