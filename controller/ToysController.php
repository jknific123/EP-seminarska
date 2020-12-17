<?php

require_once("model/ToysDB.php");
require_once("ViewHelper.php");
require_once("forms/ToysForm.php");

// skopirano iz cart-mvc projekta


class ToysController {

    public static function index() {
        if (isset($_GET["id"])) {
            echo ViewHelper::render("view/uredi-artikel.php", ["toy" => ToysDB::get($_GET["id"])]);
        } else {
            echo ViewHelper::render("view/uredi-artikel.php", ["toys" => ToysDB::getAll()]);
        }
    }

    public static function showAddForm($values) { //ta dela
        echo ViewHelper::render("view/dodaj-artikel.php", $values);
    }

    public static function add() { //ta dela
        $form = new ToysInsertForm("new_toy");
        
        if ($form->validate()) {
            $id = ToysDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "store");
        } else { // GET request or invalid data - show form
            self::showAddForm([
                "form" => $form
            ]);
        }
    }
 
    public static function showEditForm($toy = []) {
        if (empty($toy)) {
            
            $toy = ToysDB::get($_GET["id"]); //ID not found 
        }
        
        echo ViewHelper::render("view/uredi-artikel.php", ["toy" => $toy]);
    }

    public static function edit() {
        $editForm = new ToysEditForm("edit_form");
        $validData = isset($_POST["ime"]) && !empty($_POST["ime"]) &&
            isset($_POST["cena"]) && !empty($_POST["cena"]) &&
            isset($_POST["opis"]) && !empty($_POST["opis"]) &&
            isset($_POST["id"]) && !empty($_POST["id"]);
        

        if ($validData) {
            
            ToysDB::update($_POST["id"], $_POST["ime"], $_POST["opis"], $_POST["cena"]);
            echo ViewHelper::redirect(BASE_URL . "toy?id=" . $_POST["id"]);
        } else {
            
            self::showEditForm($_POST);
        }
    }

    public static function delete() {
        $validDelete = isset($_POST["delete_confirmation"]) && isset($_POST["id"]) && !empty($_POST["id"]);

        if ($validDelete) {
            ToysDB::delete($_POST["id"]);
            $url = BASE_URL . "store";
        } else {
            if (isset($_POST["id"])) {
                $url = BASE_URL . "toy/edit?id=" . $_POST["id"];
            } else {
                $url = BASE_URL . "toy";
            }
        }

        ViewHelper::redirect($url);
    }

}
