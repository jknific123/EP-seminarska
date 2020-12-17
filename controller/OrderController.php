<?php

require_once("model/ToysDB.php");
require_once("model/Cart.php");
require_once("ViewHelper.php");
require_once("forms/ToysForm.php");


#OrderController: za vse funkcije, ki so vezane na narocilo - torej urejanj narocil, pregledovanje naročil, potrjevanje naročil...
#funkcije u zvezi z naročilom
class OrderController {



    public static function checkOrder() {

        //treba nardit da samo prijavljen uporabnik pride do sem

        $vars = [
            "toys" => ToysDB::getAll(),
            "cart" => Cart::getAll(),
            "total" => Cart::total()
        ];

        echo ViewHelper::render("view/potrdi-nakup.php", $vars);
    }

    // to se ne dela ker nimamo se uporabnikov
    public static function createOrder() {

        $cart = Cart::getAll();
        $uporabnik = $_SESSION["uporabnik"]["uporabnik_id"];
        OrderDB::create($cart,$uporabnik);

        $message = "Naročilo je bilo uspešno ustvarjeno. Z klikom na gumb Nazaj se lahko vrnete v trgovino in nadaljujete nakupovanje.";
        echo ViewHelper::render("view/prikazi-sporocilo", $message);
        // routaj nazaj na /store
    }

    public static function order() {

    }

    public static function orderList() {

    }

}
