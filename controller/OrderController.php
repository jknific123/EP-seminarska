<?php

require_once("model/OrderDB.php");
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
        $total = Cart::total();
        $uporabnik = $_SESSION["uporabnik"];
        OrderDB::create($cart,$uporabnik,$total); //ustvarimo narocilo
        Cart::purge();// izpraznimo košarico

        echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Naročilo je bilo uspešno ustvarjeno. Z klikom na gumb Nazaj se lahko vrnete v trgovino in nadaljujete nakupovanje."]);
        // routaj nazaj na /store
    }

    public static function order() {

    }

    public static function orderList() {

        $uporabnik = $_SESSION["uporabnik"];
        $narocila = OrderDB::getAllUporabnik($uporabnik); //["uporabnik_id" => $uporabnik["uporabnik_id"]]
        //var_dump($narocila);

        echo ViewHelper::render("view/moja-narocila.php", ["narocila" => $narocila]);
    }

    public static function orderListAll() {

        $narocila = OrderDB::getAll(); //vsa narocila iz baze
        //var_dump($narocila);

        echo ViewHelper::render("view/prodajalec-narocila.php", ["narocila" => $narocila]);
    }

}
