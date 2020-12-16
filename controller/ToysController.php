<?php

require_once("model/ToysDB.php");
require_once("ViewHelper.php");
require_once("forms/ToysForm.php");

// skopirano iz cart-mvc projekta, ce kej dodate dejte pls comment zraven da se ve
// BookDB sem spremenil v ToysDB, ostalo je treba se popravit

class ToysController {

    public static function index() {
        if (isset($_GET["id"])) {
            ViewHelper::render("view/book-detail.php", ["book" => ToysDB::get($_GET["id"])]);
        } else {
            ViewHelper::render("view/book-list.php", ["books" => ToysDB::getAll()]);
        }
    }

    public static function showAddForm($values = ["author" => "", "title" => "",
        "price" => "", "year" => ""]) {
        ViewHelper::render("view/book-add.php", $values);
    }

    public static function add() {
        $validData = isset($_POST["author"]) && !empty($_POST["author"]) &&
            isset($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["year"]) && !empty($_POST["year"]) &&
            isset($_POST["price"]) && !empty($_POST["price"]);

        if ($validData) {
            ToysDB::insert($_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
            ViewHelper::redirect(BASE_URL . "book");
        } else {
            self::showAddForm($_POST);
        }
    }

    public static function showEditForm($book = []) {
        if (empty($book)) {
            $book = ToysDB::get($_GET["id"]);
        }

        ViewHelper::render("view/book-edit.php", ["book" => $book]);
    }

    public static function edit() {
        $validData = isset($_POST["author"]) && !empty($_POST["author"]) &&
            isset($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["price"]) && !empty($_POST["price"]) &&
            isset($_POST["year"]) && !empty($_POST["year"]) &&
            isset($_POST["id"]) && !empty($_POST["id"]);

        if ($validData) {
            ToysDB::update($_POST["id"], $_POST["author"], $_POST["title"], $_POST["price"], $_POST["year"]);
            ViewHelper::redirect(BASE_URL . "book?id=" . $_POST["id"]);
        } else {
            self::showEditForm($_POST);
        }
    }

    public static function delete() {
        $validDelete = isset($_POST["delete_confirmation"]) && isset($_POST["id"]) && !empty($_POST["id"]);

        if ($validDelete) {
            ToysDB::delete($_POST["id"]);
            $url = BASE_URL . "book";
        } else {
            if (isset($_POST["id"])) {
                $url = BASE_URL . "book/edit?id=" . $_POST["id"];
            } else {
                $url = BASE_URL . "book";
            }
        }

        ViewHelper::redirect($url);
    }

}
