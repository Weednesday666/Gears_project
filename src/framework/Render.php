<?php

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