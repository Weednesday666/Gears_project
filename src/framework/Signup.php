<?php
//var_dump($_POST);
if(isset($_POST)  && !empty($_POST)){

    //recuperation des données
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];
    $email = $_POST["email"];

    //instanciation de la classe signup
    include "src/controllers/SignupController.php";

    $signup = new SignupController($username, $pwd, $pwdRepeat, $email);



    //gestion des erreurs
    $signup->signupUser();


    //retour a la homepage
    header("location: https://thomascavelier.sites.3wa.io/GEARS_FINAL?error=none" );
}
//Render::render("sign-up");
//Render::render("log-form");