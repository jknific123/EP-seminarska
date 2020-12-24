<?php

require_once 'model/AbstractDB.php';

// tuki sem popravu te crud operacije da so zdej za artikle
// dodal bom se ene par funkcij k jih rabi Cart.php

class ToysDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO artikel (artikel_ime, artikel_cena, artikel_opis) "
                        . " VALUES (:ime, :cena, :opis)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE artikel SET artikel_ime = :ime, artikel_cena = :cena, "
                        . "artikel_opis = :opis"
                        . " WHERE artikel_id = :id", $params);
    }

    public static function delete($id) { //samo deaktiviramo ne pa izbrisemo

        return parent::modify("UPDATE artikel SET artikel_aktiviran = 0 "
            . " WHERE artikel_id = :id", ["id" => $id]);
    }

    //artikel_id, artikel_ime, artikel_cena, artikel_opis
    public static function get($id) {
        $toys = parent::query("SELECT *"
                        . " FROM artikel"
                        . " WHERE artikel_id = :id", ["id" => $id]);
        if (count($toys) == 1) {
            return $toys[0];
        } else {
            return null;
        }
    }
    public static function getREST($id) {
        $toys = parent::query("SELECT *"
                        . " FROM artikel"
                       # . " WHERE artikel_id = :id", ["id" => $id]);
                        . " WHERE artikel_id = :id", $id);
        if (count($toys) == 1) {
            return $toys[0];
        } else {
            return null;
        }
    }
    
    
    public static function getAll() {
        return parent::query("SELECT *"
                        . " FROM artikel"
                        . " ORDER BY artikel_id ASC");
    }
    
    public static function getAllwithURI(array $prefix) {
        return parent::query("SELECT artikel_id,artikel_ime,artikel_cena,artikel_opis,artikel_aktiviran, "
                        . "          CONCAT(:prefix, artikel_id) as uri "
                        . "FROM artikel "
                        . "ORDER BY artikel_id ASC", $prefix);
    }

    // za Cart.php
    public static function getForIds($ids) {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

        $statement = $db->prepare("SELECT artikel_id, artikel_ime, artikel_cena, artikel_opis FROM artikel 
            WHERE artikel_id IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        // mogoce se da to skrajsat pa nardit z parent::query -> TODO

        return $statement->fetchAll();
    }

}
