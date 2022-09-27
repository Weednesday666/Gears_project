<?php
spl_autoload_register(function ($class) {

    $class_file = $class.".php";

    if (file_exists("src/controllers/".$class_file)) {
        require_once "src/controllers/".$class_file;
    }

    if (file_exists("src/models/".$class_file)) {
        require_once "src/models/".$class_file;
    }

    if (file_exists("src/framework/".$class_file)) {
        require_once "src/framework/".$class_file;
    }
});