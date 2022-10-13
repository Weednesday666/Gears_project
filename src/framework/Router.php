<?php

class Router {
    public static function route() {
        $route = '';
        if (isset($_GET['p'])) {
            $route = $_GET['p'];
        }

        $route_exploded = explode('/', $route);
        if ($route_exploded[0] === 'index'){
            DefaultController::getFigList();
        }

        if ($route_exploded[0]==='display'){
            $id = null;
            if (preg_match("/^display\/(?<ID>[0-9]+)$/", $route, $matches)) {
                $id = $matches['ID'];
            }
            if($id != null){
                FigController::showFig($id);
            }else{
                header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
                exit();
            }
        }

        if ($route_exploded[0] === 'addfig'){
            FigController::addFig();
        }

        if ($route_exploded[0]=== 'update'){
            $id = null;
            if (preg_match("/^update\/(?<ID>[0-9]+)$/", $route, $matches)) {
                $id = $matches['ID'];
            }
            if($id != null){
                FigController::updateFig($id);
            }else{
                header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
            exit();
            }

        }
        if ($route_exploded[0]=== 'delete'){
            $id = null;
            if (preg_match("/^delete\/(?<ID>[0-9]+)$/", $route, $matches)) {
                $id = $matches['ID'];
            }
            if($id != null){
                FigController::deleteFig($id);
            }else{
                header("Location: https://thomascavelier.sites.3wa.io/GEARS_FINAL/index ");
            exit();
            }


        }

        if ($route_exploded[0] === ''){
        Render::render("log-form");
        }

         if ($route_exploded[0] === 'signup'){
        include("src/controllers/SignupController.php");

        }

        if ($route_exploded[0] === 'login'){
            include("src/controllers/LoginController.php");
        }

        if ($route_exploded[0] === 'logout'){
            include("src/controllers/LogoutController.php");
        }

         if ($route_exploded[0] === 'fig'){
            include("src/controllers/FigController.php");
            FigController::findAjax();
        }
    }
}