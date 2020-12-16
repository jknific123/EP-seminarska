<?php

require_once("model/ToysDB.php");
require_once("model/Cart.php");
require_once("ViewHelper.php");
require_once("forms/ToysForm.php");


#StoreController: za vse funkcije, ki niso direkt vezane na nekega uporabnika - torej urejanj artiklov, pregledovanje naročil, potrjevanje naročil...
# funkcije v zvezi z artikli: dodaj, uredi, izbriši
#funkcije u zvezi z naročilom in košarico
class StoreController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $vars = [
            "toys" => ToysDB::getAll(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];

        $data = filter_input_array(INPUT_GET, $rules);

        if (isset($data["id"])) {
            echo ViewHelper::render("view/toy-detail.php", [
                "toy" => ToysDB::get($data)
            ]);
        } else {
            echo ViewHelper::render("view/index-trgovina.php", $vars);
           /* echo ViewHelper::render("view/toy-list.php", [
                "toys" => ToysDB::getAll()
            ]);
           */
        }
    }

    public static function addToCart() {
        $id = isset($_POST["artikel_id"]) ? intval($_POST["artikel_id"]) : null;

        if ($id !== null) {
            Cart::add($id);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function updateCart() {
        $id = (isset($_POST["artikel_id"])) ? intval($_POST["artikel_id"]) : null;
        $quantity = (isset($_POST["quantity"])) ? intval($_POST["quantity"]) : null;

        if ($id !== null && $quantity !== null) {
            Cart::update($id, $quantity);
        }

        ViewHelper::redirect(BASE_URL . "store");
    }

    public static function purgeCart() {
        Cart::purge();

        ViewHelper::redirect(BASE_URL . "store");
    }


    public static function edit() {

    }
    
    public static function add() {

    }
    
    public static function order() {

    }
    
    public static function orderList() {

    }

}
