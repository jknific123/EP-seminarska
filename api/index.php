<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
set_include_path('/home/ep/NetBeansProjects/EP-seminarska');
require_once '/home/ep/NetBeansProjects/EP-seminarska//model/ToysDB.php';
header('Content-Type: application/json');

$http_method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);
$server_address = filter_input(INPUT_SERVER, "SERVER_ADDR", FILTER_SANITIZE_SPECIAL_CHARS);
#$server_address = "10.0.2.2"; #emulator
$php_self = filter_input(INPUT_SERVER, "PHP_SELF", FILTER_SANITIZE_SPECIAL_CHARS);
$script_uri = substr($php_self, 0, strripos($php_self, "/"));

$request = filter_input(INPUT_GET, "request", FILTER_SANITIZE_SPECIAL_CHARS);

echo $request;

if($request != null){
    $path = explode("/", $request);
}else{
    returnError(400, "Manjka pot.");
}

if(isset($path[0])){
    $source = $path[0];
}else{
    returnError(400, "Manjka vir.");
}

if(isset($path[1])){
    $param = $path[1];
}else{
    $param = null;
}


function returnError($code, $message){
    http_response_code($code);
    echo json_encode($message);
    exit();
}

if($source == "toy"){
    if($http_method == "GET" && param == null){
        $igracke = ToysDB::getAll();
        echo json_encode($igracke, JSON_PRETTY_PRINT);
    }else if ($http_method == "GET" && $param != null){
        $igracka = ToysDB::get(["id" => $param]);
        if($igracka != null){
            echo json_encode($igracka, JSON_PRETTY_PRINT);
        }
    }
}else{
    returnError(404, "Invalid resource: " . $source);
}


?>