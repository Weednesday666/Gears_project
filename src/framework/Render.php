<?php
//on etabli une class render pour utiliser celle ci afin d'afficher rapidement un template
class Render {
    public static function render($template = '', $args = []) {
        $layout = $template;
        foreach ($args as $key=>$value){
            $$key=$value;
        }
        // recuperation du layout pour render chaque templates
        require 'src/vues/layout.phtml';
    }
}