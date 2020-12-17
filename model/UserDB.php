<?php

//za sign-in rabimo dodaj() - za registracijo uporabnika
//za login rabimo preveri() - ki preveri ali so vpisani podatki v bazi

require_once 'model/AbstractDB.php';

// tuki sem popravu te crud operacije da so zdej za uporabnike
class UserDB extends AbstractDB
{

    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO artikel (artikel_ime, artikel_cena, artikel_opis) "
            . " VALUES (:ime, :cena, :opis)", $params);
    }

    public static function update(array $params)
    {
        return parent::modify("UPDATE artikel SET artikel_ime = :ime, artikel_cena = :cena, "
            . "artikel_opis = :opis"
            . " WHERE artikel_id = :id", $params);
    }

    public static function delete(array $id)
    {
        return parent::modify("DELETE FROM artikel WHERE artikel_id = :id", $id);
    }

    public static function get(array $id)
    {
        $toys = parent::query("SELECT artikel_id, artikel_ime, artikel_cena, artikel_opis"
            . " FROM artikel"
            . " WHERE artikel_id = :id", $id);

        if (count($toys) == 1) {
            return $toys[0];
        } else {
            throw new InvalidArgumentException("No such toy");
        }
    }

    public static function getAll()
    {
        return parent::query("SELECT artikel_id, artikel_ime, artikel_cena, artikel_opis"
            . " FROM artikel"
            . " ORDER BY artikel_id ASC");
    }


}
