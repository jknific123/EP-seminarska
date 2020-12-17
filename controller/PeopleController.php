<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/SigninForm.php");
require_once("forms/LoginForm.php");

/* mogoce je to treba dodat za viev::redirect

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");

*/

#People Controller : za funkcije ki so vezane na uporabnike (dodajanje, urejanje, brisanje prodajalcev ali strank)
#register-signin, login, logout, izpiši uporabnike, spremeni geslo, spremeni svoje podatke...
class PeopleController {
    
    
    public static function admin() {

    }

    public static function login() {
        $form = new LoginForm("prijava");
        if ($form->validate()) {
            try {
                $data = $form->getValue();
                $email = $data["email"];
                $hash = UserDB::getPass($email);
                $valid = password_verify($data["geslo"] ,$hash);
                $uporabnik = UserDB::getUporabnik($data["email"]);
                if ($valid) { //je ok geslo gremo ga loginat

                    if ($uporabnik) { //loginamo uporabnika tuki preverimo tut aktiviranost
                        $_SESSION["uporabnik"] = $uporabnik;
                        ViewHelper::redirect(BASE_URL . "store");
                    }
                    else { //uporabnika ni najdlo
                        echo ViewHelper::render("view/prikazi-sporocilo.php", "Ta uporabnik ne obstaja.");
                    }
                }
                else {//geslo je napacno
                    echo ViewHelper::render("view/prikazi-sporocilo.php", "Uporabniško ime ali geslo je napačno, preveri vpisano geslo!");
                }

                UserDB::preveri( $data['email'], $data['geslo']);
                echo ViewHelper::redirect(BASE_URL . "store");;
            } catch (PDOException $exc) {
                echo "Napaka pri prijavi.";
                var_dump($exc);
            }
        } else {
            echo $form;
        }
        
    }

    //registracija
    public static function signin() {
        $form = new RegisterForm("new_user");
        if ($form->validate()) {
            try {
                $data = $form->getValue();
                //nardimo hash gesla
                $data['geslo'] = password_hash($data['geslo'], PASSWORD_BCRYPT);

                if ($data['geslo'] == false) { //hashanje ni uspelo
                    echo ViewHelper::render("view/prikazi-sporocilo.php", "Hashanje gelsa ni uspelo!");
                }
                $uspelo = UserDB::dodaj($data);

                if ($uspelo) {
                    // registracija uspela
                    echo ViewHelper::redirect(BASE_URL . "log-in");
                }
                else {
                    echo ViewHelper::render("view/prikazi-sporocilo.php", "Registracija ni uspela! RIP :(");
                }

            } catch (PDOException $exc) {
                echo "Napaka pri registraciji.";
                var_dump($exc);
            }
        } else {
            echo $form;
        }
    }
    
    public static function changeMyData() {

    }
    
    public static function users() {

    }
    

}
