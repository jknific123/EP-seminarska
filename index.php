<?php

session_start();

require_once("controller/ToysController.php");
require_once("controller/PeopleController.php");
require_once("controller/StoreController.php");
//tle dodaš vse controllerje, ko jih ustvariš

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

/* Uncomment to see the contents of variables
var_dump(BASE_URL);
var_dump(IMAGES_URL);
var_dump(CSS_URL);
var_dump($path);
exit(); */

// ROUTER: preusmeri na določeno funkcijo znotraj controllerjev
$urls = [
    "admin" => function () {
        #admin-view
        PeopleController::admin();
    },
    "log-in" => function () {
        #log-in
        PeopleController::login();
    },
    "sign-in" => function () {
        #sign-in
        PeopleController::signin();
    },
    "my-data" => function () {
        #update-my-data
        PeopleController::changeMyData();
    },
    "users" => function () {
        #seznam-uporabnikov
        PeopleController::users();
    },
    "store" => function () {
        #index-trgovina
        StoreController::index();
    },
    "store/add-to-cart" => function () {
        StoreController::addToCart();
    },
    "store/update-cart" => function () {
        StoreController::updateCart();
    },
    "store/purge-cart" => function () {
        StoreController::purgeCart();
    },
    // tuki ki mas toy/neki mislim da bojo ToysController-funkcije ne pa StoreController -> bom sproti popravu
    "toy/edit" => function () {
        #uredi-artikel
        StoreController::edit();
    },
    "toy/add" => function () {
        #dodaj-artikel
        StoreController::add();
    },
    "toy/delete" => function () {
        ToysController::delete();
    },
    "order" => function () {
        #narocilo-detail
        StoreController::order();
    },
    "order/list" => function () {
        #narocilo-list
        StoreController::orderList();
    },
    "" => function () { //če ni nič napisano usmeri na prvo stran od trgovine, torej razdelek toys
        ViewHelper::redirect(BASE_URL . "store");
    },
];

   
    
    
// Preveri če je vse okej in če ni izpiši napako
try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
} 
