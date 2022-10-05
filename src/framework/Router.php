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
            FigController::showFig($id);
        }


        if ($route_exploded[0] === 'addfig'){
            FigController::addFig();

        }


        if ($route_exploded[0]=== 'update'){
            $id = null;
            if (preg_match("/^update\/(?<ID>[0-9]+)$/", $route, $matches)) {
                $id = $matches['ID'];
            }

            FigController::updateFig($id);




        }
        if ($route_exploded[0]=== 'delete'){
            $id = null;
            if (preg_match("/^delete\/(?<ID>[0-9]+)$/", $route, $matches)) {
                $id = $matches['ID'];
            }
            FigController::deleteFig($id);
        }

        //when log successfully create , change log to empty single quote
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
    }
}