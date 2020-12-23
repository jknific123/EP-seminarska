<?php
require_once("model/ToysDB.php");
require_once("controller/StoreController.php");
require_once("ViewHelper.php");

class StoreRESTController {

    public static function get($id) {
        try {
            echo ViewHelper::renderJSON(ToysDB::getREST(["id" => $id]));
        } catch (InvalidArgumentException $e) {
            echo ViewHelper::renderJSON($e->getMessage(), 404);
        }
    }

    public static function index() {
        $prefix = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"]
                . $_SERVER["REQUEST_URI"];
        echo ViewHelper::renderJSON(ToysDB::getAllwithURI(["prefix" => $prefix]));
    }
    
}
