<?php

session_start();

require_once("controller/ToysController.php");
require_once("controller/PeopleController.php");
require_once("controller/StoreController.php");
require_once("controller/OrderController.php");
require_once("controller/StoreRESTController.php");
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

    "log-in" => function () {
        #log-in
        PeopleController::login();
    },
    "log-in/authorize" => function() {
        ViewHelper::render("view/authorize.php");
        PeopleController::authorize();
    },
    "log-out" => function () {
        #log-out
        PeopleController::logout();
    },
    "sign-in" => function () {
        #sign-in
        PeopleController::signin();
    },
    "my-data" => function () {
        #update-my-data
        PeopleController::changeMyData();
    },
    "admin" => function () {
        #admin-view
        PeopleController::admin();
    },
    "admin/edit" => function () {
        #stranka-edit
        //var_dump($_SESSION["uporabnik"]);
        PeopleController::prodajalecEdit();
    },
    "admin/activate" => function () {
        #stranka-activate
        PeopleController::aktivirajProdajalca();
    },
    "admin/deactivate" => function () {
        #stranka-deactivate
        PeopleController::deaktivirajProdajalca();
    },
    "users" => function () {
        #seznam-uporabnikov
        PeopleController::users();
    },
    "user/edit" => function () {
        #stranka-edit
        var_dump($_SESSION["uporabnik"]);
        PeopleController::strankaEdit();
    },
    "user/activate" => function () {
        #stranka-activate
        PeopleController::aktiviraj();
    },
    "user/deactivate" => function () {
        #stranka-deactivate
        PeopleController::deaktiviraj();
    },
    "prodajalec/edit" => function () {
        #stranka-edit
        PeopleController::prodajalecEdit();
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
    "order/potrdi-nakup" => function () {
        OrderController::checkOrder();
    },
    "order/ustvari-narocilo" => function () {
        OrderController::createOrder();
    },
    "order/orderEdit" => function () {
        OrderController::orderEdit();
    },
    "order/approve" => function () {
        OrderController::orderApprove();
    },
    "order/discard" => function () {
        OrderController::orderDiscard();
    },
    "order/storniraj" => function () {
        OrderController::orderStorniraj();
    },
    "order/listAll" => function () {
        #narocilo-detail
        OrderController::orderListAll();
    },
    "order/listAllUnapproved" => function () {
        #narocilo-detail
        OrderController::orderListAllUnapproved();
    },
    "order/listAllApproved" => function () {
        #narocilo-detail
        OrderController::orderListAllApproved();
    },
    "order/list" => function () {
        #narocilo-list -> uporabnikova narocila
        OrderController::orderList();
    },
    "toy" => function () {
        #uredi-artikel
        ToysController::index();
    },
    "toy/edit" => function () {
        #uredi-izbrisi-artikel
        ToysController::edit();
    },
    "toy/add" => function () {
        #dodaj-artikel
        ToysController::add();
    },
    "toy/delete" => function () {
        #uredi-izbrisi-artikel
        ToysController::delete();
    },

    "test" => function () {
        #testing
        echo ViewHelper::render("view/prikazi-sporocilo.php");
    },
    "" => function () { //če ni nič napisano usmeri na prvo stran od trgovine, torej razdelek toys
        ViewHelper::redirect(BASE_URL . "store");
    },
     # REST API
    "api/store/" => function ($id) {
            StoreRESTController::get($id);
    },
  #  "api/store/1" => function($id){
  #          StoreRESTController::get($id);
  #  },
    "api/store" => function () {
            
            StoreRESTController::index();
                
        
    }
];

 

// Preveri če je vse okej in če ni izpiši napako
try {
    if(preg_match("/^api\/store\/(\d+)$/", $path)){
        $pth = explode("/", $path);
        $urls["api/store/"]($pth[2]);
        
    }else if(isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (InvalidArgumentException $e) {
    ViewHelper::error404();
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
}
