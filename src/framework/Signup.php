<?php

if(isset($_POST["submit"])){

    //recuperation des données
    $id = $_POST["username"];
    $id = $_POST["pwd"];
    $id = $_POST["pwdrepeat"];
    $id = $_POST["email"];

    //instanciation de la classe signup
    include "../models/signup.php";
    include "../controllers/SignupController.php";

    $signup = new SignupContr($username, $pwd, $pwdrepeat, $email);



    //gestion des erreurs



    //retour a la homepage
}
Render::render("sign-up");