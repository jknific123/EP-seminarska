<?php

require_once 'model/AbstractDB.php';
require_once 'model/DB.php';


// tuki sem popravu te crud operacije da so zdej za narocila, dodaj narocilo, updejtaj status narocila, dobi usa narocila...

class OrderDB extends AbstractDB {

    public static function get(array $id) {
        // za dobit narocilo

        $orders = parent::query("SELECT narocilo_id, narocilo_status, uporabnik_id"
            . " FROM narocilo"
            . " WHERE narocilo_id = :narocilo_id", $id);

        if (count($orders) == 1) {
            return $orders[0];
        } else {
            throw new InvalidArgumentException("No such toy");
        }

    }

    public static function getAll() {
        //pridobi usa narocila
        return parent::query("SELECT * FROM narocilo");
    }

    public static function getAllUporabnik(array $uporabnik) {
        //pridobi usa narocila
        return parent::query("SELECT * FROM narocilo"
        . " WHERE uporabnik_id = :uporabnik_id", $uporabnik);
    }

    public static function update(array $params) {
        // tuki se updejta samo status narocila

        return parent::modify("UPDATE narocilo SET narocilo_status = :status"
            . " WHERE narocilo_id = :narocilo_id", $params);
    }

    public static function create($cart, $uporabnik, $total) {
        // za ustvarit narocilo
        $narocilo_status = "v obdelavi";
        $narocilo_postavka = $total;

        //Vrne referenco na instanco  razreda PDO za dostop do baze. -> povezava na bazo also je sam ena povezava na enkrat
        $dbh = DBInit::getInstance();

        //NAROCILO
        //sql poizvedba za nardit narocilo
        // TODO: dodat je treba se narocilo_postavka -> $total
        $narocilo = "INSERT INTO narocilo (uporabnik_id, narocilo_status, narocilo_postavka) "
            . " VALUES (:uporabnik_id, :narocilo_status, :narocilo_postavka)";

        // pripravi statement za izvedbo
        $statementNarocilo = $dbh->prepare($narocilo);
        $statementNarocilo->bindParam(":uporabnik_id", $uporabnik["uporabnik_id"]);
        $statementNarocilo->bindParam(":narocilo_status", $narocilo_status);
        $statementNarocilo->bindParam(":narocilo_postavka", $narocilo_postavka);
        // izvedemo sql statementNarocilo
        $statementNarocilo->execute();

        //za dobit id narocila
        $narocilo_id = $dbh->lastInsertId();
        $artikel_id;
        $artikelnarocilo_kolicina;

        //ARTIKEL NAROCILO
        //sql poizvedba za nardit artikelnarocilo
        $artikelNarocilo =  "INSERT INTO artikelnarocilo (artikel_id, narocilo_id, artikelnarocilo_kolicina) "
            . " VALUES (:artikel_id, :narocilo_id, :artikelnarocilo_kolicina)";

        // pripravi statement za izvedbo
        $statementArtikelNarocilo = $dbh->prepare($artikelNarocilo);

        $statementArtikelNarocilo->bindParam(":artikel_id", $artikel_id);
        $statementArtikelNarocilo->bindParam(":narocilo_id", $narocilo_id);
        $statementArtikelNarocilo->bindParam(":artikelnarocilo_kolicina", $artikelnarocilo_kolicina);

        foreach ($cart as $toy) {
            $artikel_id = $toy["artikel_id"];
            $artikelnarocilo_kolicina = $toy["quantity"];
            $statementArtikelNarocilo->execute();
        }

    }


    // to more bit tuki drugace je error
    public static function insert(array $params) {
        //tega mislim da sploh ne bmo rabli ker itak mam gor funkcijo za ustvarit narocilo -> create
    }

    public static function delete(array $id) {
        //tega mislim da sploh ne bmo rabli
    }

}
