<?php
require_once(__DIR__."/../controllers/FilmsController.php");
require_once(__DIR__."/../controllers/notFoundController.php");

class Router{
    public static function getController(string $controllerName){
        switch ($controllerName){
            case 'films':
                return new FilmsController();
            default:
            return new notFoundController();
            break;
        }
    }
}