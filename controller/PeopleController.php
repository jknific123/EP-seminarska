<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/SigninForm.php");
require_once("forms/LoginForm.php");



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
    
    public static function signin() {
        $form = new RegisterForm("new_user");
        if ($form->validate()) {
            try {
                $data = $form->getValue();
                UserDB::dodaj($data['ime'], $data['priimek'], $data['email'], $data['geslo'], $data['naslov'], $data['vrstaUporabnika']);
                echo ViewHelper::redirect(BASE_URL . "log-in");;
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
