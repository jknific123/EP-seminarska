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

    public static function orderList() {

        $uporabnik = $_SESSION["uporabnik"];
        $narocila = OrderDB::getAllUporabnik($uporabnik); //["uporabnik_id" => $uporabnik["uporabnik_id"]]
        //var_dump($narocila);

        echo ViewHelper::render("view/moja-narocila.php", ["narocila" => $narocila]);
    }

    public static function orderEdit() {

        var_dump($_GET);
        var_dump($_POST);
        $orderId = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"];
        var_dump($orderId);
        $narocilo = OrderDB::get(["narocilo_id" => $orderId]);
        $artikelNarocilo = OrderDB::getAllArtikelNarocilo(["narocilo_id" => $orderId]);
        $uporabnik = UserDB::get(["uporabnik_id" => $narocilo["uporabnik_id"] ]);
        $artikli;
        foreach ($artikelNarocilo as $element) {
            $artikli[$element["artikel_id"]] = ToysDB::get($element["artikel_id"]);
        }

        if ($narocilo === null) {
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }
        //var_dump($toyData);exit();
        if ($narocilo["narocilo_status"] == "obdelano") { // izjema za obdelana/potrjena narocila ker samo njih lahko storniramo
            echo ViewHelper::render("view/upravljaj-narocilo-obdelano.php", ["narocilo" => $narocilo, "artikelNarocilo" => $artikelNarocilo, "artikli" => $artikli, "uporabnik" => $uporabnik]);
        }
        else {
            echo ViewHelper::render("view/upravljaj-narocilo.php", ["narocilo" => $narocilo, "artikelNarocilo" => $artikelNarocilo, "artikli" => $artikli, "uporabnik" => $uporabnik]);
        }
    }

    public static function orderApprove() {

        $orderId = isset($_POST["narocilo_id"]) ? intval($_POST["narocilo_id"]) : null;
        $status = "obdelano";

        if ($orderId !== null) { //updejatamo status
            OrderDB::update(["status" => $status, "narocilo_id" => $orderId]);
        }
        else { //ni najdlo narocila samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }

        $narocilo = OrderDB::get(["narocilo_id" => $orderId]);
        $artikelNarocilo = OrderDB::getAllArtikelNarocilo(["narocilo_id" => $orderId]);
        $uporabnik = UserDB::get(["uporabnik_id" => $narocilo["uporabnik_id"] ]);
        $artikli;
        foreach ($artikelNarocilo as $element) {
            $artikli[$element["artikel_id"]] = ToysDB::get($element["artikel_id"]);
        }
        if ($narocilo === null) { //ni najdlo narocila samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }

        //uspesno updejta status routamo nazaj na isto stran
        echo ViewHelper::render("view/upravljaj-narocilo.php", ["narocilo" => $narocilo, "artikelNarocilo" => $artikelNarocilo, "artikli" => $artikli, "uporabnik" => $uporabnik]);
    }

    public static function orderDiscard() {

        $orderId = isset($_POST["narocilo_id"]) ? intval($_POST["narocilo_id"]) : null;
        $status = "preklicano";

        if ($orderId !== null) { //updejatamo status
            OrderDB::update(["status" => $status, "narocilo_id" => $orderId]);
        }
        else { //ni najdlo narocila samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }

        $narocilo = OrderDB::get(["narocilo_id" => $orderId]);
        $artikelNarocilo = OrderDB::getAllArtikelNarocilo(["narocilo_id" => $orderId]);
        $uporabnik = UserDB::get(["uporabnik_id" => $narocilo["uporabnik_id"] ]);
        $artikli;
        foreach ($artikelNarocilo as $element) {
            $artikli[$element["artikel_id"]] = ToysDB::get($element["artikel_id"]);
        }
        if ($narocilo === null) { //ni najdlo narocila samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }

        //uspesno updejta status routamo nazaj na isto stran
        echo ViewHelper::render("view/upravljaj-narocilo.php", ["narocilo" => $narocilo, "artikelNarocilo" => $artikelNarocilo, "artikli" => $artikli, "uporabnik" => $uporabnik]);
    }

    public static function orderStorniraj() {

        $orderId = isset($_POST["narocilo_id"]) ? intval($_POST["narocilo_id"]) : null;
        $status = "stornirano";

        if ($orderId !== null) { //updejatamo status
            OrderDB::update(["status" => $status, "narocilo_id" => $orderId]);
        }
        else { //ni najdlo narocila samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }

        $narocilo = OrderDB::get(["narocilo_id" => $orderId]);
        $artikelNarocilo = OrderDB::getAllArtikelNarocilo(["narocilo_id" => $orderId]);
        $uporabnik = UserDB::get(["uporabnik_id" => $narocilo["uporabnik_id"] ]);
        $artikli;
        foreach ($artikelNarocilo as $element) {
            $artikli[$element["artikel_id"]] = ToysDB::get($element["artikel_id"]);
        }
        if ($narocilo === null) { //ni najdlo narocila samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "order/listAllUnapproved"); // ni najdlo narocila
        }

        //uspesno updejta status routamo nazaj na isto stran
        echo ViewHelper::render("view/upravljaj-narocilo.php", ["narocilo" => $narocilo, "artikelNarocilo" => $artikelNarocilo, "artikli" => $artikli, "uporabnik" => $uporabnik]);
    }

    public static function orderListAll() {

        $narocila = OrderDB::getAll(); //vsa narocila iz baze
        //$uporabnik = UserDB::get();
        //var_dump($narocila);

        echo ViewHelper::render("view/prodajalec-narocila.php", ["narocila" => $narocila]);
    }

    public static function orderListAllUnapproved() {

        $narocila = OrderDB::getAllUnapproved(["narocilo_status" => "v obdelavi"]); //vsa narocila iz baze
        //var_dump($narocila);

        echo ViewHelper::render("view/prodajalec-narocilaNeobdelana.php", ["narocila" => $narocila]);
    }

    public static function orderListAllApproved() {

        $narocila = OrderDB::getAllApproved(["narocilo_status" => "obdelano"]); //vsa narocila iz baze
        //var_dump($narocila);

        echo ViewHelper::render("view/prodajalec-narocilaPotrjena.php", ["narocila" => $narocila]);
    }
}
