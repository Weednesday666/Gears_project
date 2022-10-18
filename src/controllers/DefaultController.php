<?php

//controller de la page principale lors de l'arrivée sur le site apres connexion
class DefaultController {
    public static function getFigList(){
        //recupere les données des mini
        $figs = Fig::getFigs();
        //affichage des minis
         Render::render("fig-list", ['figs' => $figs]);
         
    }
    public static function getPublicList(){
        //recupere les données des mini
        $figs = Fig::getFigs();
        //affichage des minis pour le public
         Render::render('public-list' , ['figs' => $figs]);
    }
}

