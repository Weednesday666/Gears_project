<?php

//controller de la page principale lors de l'arrivée sur le site
// http://thomascavelier.sites.3wa.io/GEARS_FINAL/

class DefaultController {
    public static function getFigList(){
        //recupere les données des mini
        $figs = Fig::getFigs();

        //affichage des minis
         Render::render("fig-list", ['figs' => $figs]);
    }

}

