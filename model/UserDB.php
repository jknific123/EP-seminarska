<?php

//za sign-in rabimo dodaj() - za registracijo uporabnika
//za login rabimo preveri() - ki preveri ali so vpisani podatki v bazi

require_once 'model/AbstractDB.php';

// tuki sem popravu te crud operacije da so zdej za uporabnike
class UserDB extends AbstractDB
{




    public static function getUporabnik(array $email)
    {
        // tuki se preveri tudi ce je uporabnik aktiven
        $uporabnik = parent::query("SELECT * "
            . " FROM uporabnik"
            . " WHERE uporabnik_email = :email AND uporabnik_aktiviran = 1", $email);

        //var_dump($uporabnik);

        if ($uporabnik != null) { //smo ga najdli
            return $uporabnik[0];
        }else {
            return false;
        }
    }

    public static function getPass(array $email)
    {
        //mogoce treba dodat se AND aktiviran = 1
        $pass = parent::query("SELECT uporabnik_geslo"
            . " FROM uporabnik"
            . " WHERE uporabnik_email = :email", $email);

        if (count($pass) == 1) {
            return $pass[0];
        } else {
            throw new InvalidArgumentException("No such password");
        }

    }

    // to je registracija uporabnik
    // $data['ime'], $data['priimek'], $data['email'], $data['geslo'], $data['naslov'], $data['vrstaUporabnika']
    public static function dodaj(array $params)
    {
        return parent::modify("INSERT INTO uporabnik (uporabnik_ime, uporabnik_priimek, uporabnik_email, uporabnik_geslo, uporabnik_naslov, uporabnik_vrsta) "
            . " VALUES (:ime, :priimek, :email, :geslo, :naslov, :uporabnik_vrsta)", $params);

    }

    public static function update(array $params)
    {
        //zaenkrat samo ime priimek in email ker se razlikujejo uporabniki
        return parent::modify("UPDATE uporabnik SET uporabnik_ime = :ime, uporabnik_priimek = :priimek, uporabnik_email = :email "
            . " WHERE uporabnik_id = :id", $params);
    }

    public static function delete(array $id)
    {
        return parent::modify("DELETE FROM uporabnik WHERE uporabnik_email = :email", $id);
    }

    //treba popravit nujno
    public static function getAll()
    {
        return parent::query("SELECT artikel_id, artikel_ime, artikel_cena, artikel_opis"
            . " FROM artikel"
            . " ORDER BY artikel_id ASC");
    }

    // treba popravit
    public static function insert(array $params)
    {
        return parent::modify("INSERT INTO artikel (artikel_ime, artikel_cena, artikel_opis) "
            . " VALUES (:ime, :cena, :opis)", $params);
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




}
