<?php

require_once 'model/AbstractDB.php';

class ToysDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO toy (author, title, description, price, year) "
                        . " VALUES (:author, :title, :description, :price, :year)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE toy SET author = :author, title = :title, "
                        . "description = :description, price = :price, year = :year"
                        . " WHERE id = :id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM toy WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $toys = parent::query("SELECT id, author, title, description, price, year"
                        . " FROM toys"
                        . " WHERE id = :id", $id);
        
        if (count($toys) == 1) {
            return $toys[0];
        } else {
            throw new InvalidArgumentException("No such toy");
        }
    }

    public static function getAll() {
        return parent::query("SELECT id, author, title, price, year, description"
                        . " FROM toy"
                        . " ORDER BY id ASC");
    }

}
