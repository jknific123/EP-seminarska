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
                $hash = UserDB::getPass(["email" => $email]);
                var_dump($hash["uporabnik_geslo"]);
                $valid = password_verify($data["geslo"] ,$hash["uporabnik_geslo"]);
                $uporabnik = UserDB::getUporabnik(["email" => $email]);
                var_dump($valid);
                var_dump($uporabnik);
                if ($valid) { //je ok geslo gremo ga loginat

                    if ($uporabnik) { //loginamo uporabnika tuki preverimo tut aktiviranost
                        $_SESSION["uporabnik"] = $uporabnik; // tko ga prijavim vsi uporabnikovi atributi so dosegljivi na $_SESSION["uporabnik"]["atribut"]
                        var_dump($_SESSION["uporabnik"]);
                        ViewHelper::redirect(BASE_URL . "store");
                    }
                    else { //uporabnika ni najdlo
                        $message = "Ta uporabnik ne obstaja.";
                        echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Ta uporabnik ne obstaja."]);
                    }
                }
                else {//geslo je napacno
                    $message = "Uporabniško ime ali geslo je napačno, preveri vpisano geslo!";
                    echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Uporabniško ime ali geslo je napačno, preveri vpisano geslo!"]);
                }
                
                echo ViewHelper::redirect(BASE_URL . "store");;
            } catch (PDOException $exc) {
                echo "Napaka pri prijavi.";
                var_dump($exc);
            }
        } else {
            echo $form;
        }
    }

    public static function logout() {
        unset($_SESSION["uporabnik"]);
        session_destroy(); // sam unicimo sejo in je logoutan
        echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Uporabnik je bil uspešno odjavljen."]);
    }

    //registracija
    public static function signin() {
        $form = new RegisterInsertForm("new_user");
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
    
    public static function showUserForm($userData, $form) {
             
        //$dataSource = new HTML_QuickForm2_DataSource_Array($toy);
        //$form->addDataSource($dataSource);
              
        echo ViewHelper::render("view/update-my-data.php", [
                "form" => $form,
                "userData" => $userData
            ]);
    }
    
    public static function changeMyData() {
        $userId = $_SESSION["uporabnik"]["uporabnik_id"];
        //$userId = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"];
        //var_dump($userId);
                
        $userData = UserDB::get($userId); //dobiš podatke iz baze
        
        if ($userData === null) {
            ViewHelper::redirect(BASE_URL . "store");
        }
        
        $form = new RegisterEditForm("edit_form");
            
        if ($form->isSubmitted() && $form->validate()) { //popravi vnesene podatke
            
            $data = $form->getValue();
            UserDB::update($data);
            ViewHelper::redirect(BASE_URL . "store"); //ko so spremenjeni podatki me vrne na isto stran
  
        } else { 
           $dataSource = new HTML_QuickForm2_DataSource_Array($userData);
           $form->addDataSource($dataSource);
                
           self::showUserForm($userData, $form);
        }

    }
    
    public static function users() {

    }
    

}
