<?php

require_once("model/ToysDB.php");

// skopirano iz cart-mvc projekta, ce kej dodate dejte pls comment zraven da se ve


class Cart {

    public static function getAll() {
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            return [];
        }

        $ids = array_keys($_SESSION["cart"]);
        $cart = ToysDB::getForIds($ids);

        // Adds a quantity field to each toy in the list
        foreach ($cart as &$toy) {
            $toy["quantity"] = $_SESSION["cart"][$toy["artikel_id"]];
        }

        return $cart;
    }

    public static function add($id) {
        $toy = ToysDB::get(array("id" => $id));

        if ($toy != null) {
            if (isset($_SESSION["cart"][$id])) { //ce je ze v kosarici samo ++
                $_SESSION["cart"][$id] += 1;
            } else {
                $_SESSION["cart"][$id] = 1; //cene nastavimo kolicino na 1
            }
        }
        var_dump($_SESSION["cart"]);
    }

    public static function update($id, $quantity) {
        $toy = ToysDB::get($id);
        $quantity = intval($quantity);

        if ($toy != null) {
            if ($quantity <= 0) { //ce zmanjsamo kolicino na <= 0 zbrise igraco iz kosarice
                unset($_SESSION["cart"][$id]);
            } else { // cene nastavi kolicino na quantitiy
                $_SESSION["cart"][$id] = $quantity;
            }
        }
    }

    public static function purge() { //izbris kosarice
        unset($_SESSION["cart"]);
    }

    public static function total() { // izracuna sestevek cene
        return array_reduce(self::getAll(), function ($total, $toy) {
            return $total + $toy["artikel_cena"] * $toy["quantity"];
        }, 0);
    }
}
