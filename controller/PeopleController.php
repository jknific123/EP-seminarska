<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';

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
    
    public static function authorize(){
        # vprasa za certifikat,
        # pridobi podatke uporabniskega certifikata,
        # primerja ime uporabnika v certifikatu z imenom uporabnika v bazi (glej pravila podjetja spodaj)
        # če je OK, potrdi in uporabniku pusti, da se vrne na glavno stran,
        # ce ni OK, uporabniku zavrne dostop in mu ponudi moznost vracila nazaj.

        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
        
        $cert_data = openssl_x509_parse($client_cert);
        $commonname = $cert_data['subject']['CN'];
        
        $name = explode(' ',trim($commonname))[0];
        
        $userLoggingin = $_SESSION["uporabnik"]["uporabnik_ime"];
        
        # Naše podjetje od prodajalcev in administratorjev pričakuje,
        # da če si spremenijo ime, moramo zaprositi za nov certifikat.
        # To piše v naši konstituciji.
        if (strcmp($userLoggingin, $name) == 0){
            echo ViewHelper::render("view/prikazi-sporocilo.php", 
                    ["message" => "Pozdravljen/a $commonname, tvoja identiteta je bila preverjena. Z gumbom za nazaj se vrneš na glavno stran."]);
        }else{
            # deluje podobno kot odjava.
            unset($_SESSION["uporabnik"]);
            session_destroy(); // sam unicimo sejo in je logoutan
            echo ViewHelper::render("view/prikazi-sporocilo.php", 
                    ["message" => "Tvoj certifikat se ne ujema z računom $userLoggingin. Če si $userLoggingin, si ga uvozi v brskalnik ali piši administratorju. Če nisi, pa smo te dobili."]);
        }
        #var_dump(($cert_data));
    }
    
    public static function login() {

        // za https ze na login strani
        if(!isset($_SERVER["HTTPS"])){
            $url = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $url);
        }

        $form = new LoginForm("prijava");
        if ($form->validate()) {
            try {
                $data = $form->getValue();
                $email = $data["email"];
                $hash = UserDB::getPass(["email" => $email]);
                if ($hash) { // ali sploh najde uporabnika z tem emailo, da pol lahko najde njegovo geslo
                    //var_dump($hash["uporabnik_geslo"]);
                    $valid = password_verify($data["geslo"] ,$hash["uporabnik_geslo"]);
                    $uporabnik = UserDB::getUporabnik(["email" => $email]); // tuki dejansko pridobimo tega uporabnika
                    //var_dump($valid);
                    //var_dump($uporabnik);
                    if ($valid) { //je ok geslo gremo ga loginat

                        if ($uporabnik) { //loginamo uporabnika tuki preverimo tut aktiviranost
                            session_regenerate_id(); # varnost. tako prijavljeni uporabnik pridobi nov id seje!
                            $_SESSION["uporabnik"] = $uporabnik;
                            
                            if(($_SESSION["uporabnik"]["uporabnik_vrsta"] == "administrator") ||
                               ($_SESSION["uporabnik"]["uporabnik_vrsta"] == "prodajalec")){
                                # avtorizacija prodajalca in administratorja.
                                ViewHelper::redirect( BASE_URL . "/log-in/authorize" );
                             }else{
                                # stranke nimajo certifikatov.
                                $_SESSION["uporabnik"] = $uporabnik; // tko ga prijavim vsi uporabnikovi atributi so dosegljivi na $_SESSION["uporabnik"]["atribut"]
                                ViewHelper::redirect(BASE_URL . "store");                                 
                             }
                        }
                        else { //uporabnika ni najdlo
                            echo ViewHelper::render("view/log-in.php", ["form" => $form,  "errorMessage" => "Ta uporabnik ne obstaja ali pa ni aktiviran."]);
                            //echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Ta uporabnik ne obstaja."]);
                        }
                    }
                    else {//geslo je napacno
                        echo ViewHelper::render("view/log-in.php", ["form" => $form, "errorMessage" => "Uporabniško ime ali geslo je napačno, preveri vpisano geslo!"]);
                        ///echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Uporabniško ime ali geslo je napačno, preveri vpisano geslo!"]);
                    }
                }
                else { //email je narobe oz uporabnik z tem emailom ne obstaja
                    echo ViewHelper::render("view/log-in.php", ["form" => $form, "errorMessage" => "Uporabniško ime ali geslo je napačno, preveri vpisano geslo in email!"]);
                }
                
                //echo ViewHelper::redirect(BASE_URL . "store");
            } catch (PDOException $exc) {
                echo "Napaka pri prijavi.";
                var_dump($exc);
            }
        } else {
            //echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Try ni ratal."]);
            echo ViewHelper::render("view/log-in.php", ["form" => $form]); //, "errorMessage" => "Kaj se dogaja??"
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
                $email = $data["email"];
                if ($data['geslo'] == false) { //hashanje ni uspelo
                    echo ViewHelper::render("view/prikazi-sporocilo.php", "Hashanje gelsa ni uspelo!");
                }

                //var_dump($_SERVER['REQUEST_METHOD']);
                //var_dump($_POST['recaptcha_response']);
                //najprej z reCAPTCHA v3 preverimo ali se registrira clovek ali robot
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

                    //zgradimo POST poizvedbo:
                    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
                    $recaptcha_secret = '6LdXaRIaAAAAAI9eX6LmWvYg6lmqd2PL4NXTld3c';
                    $recaptcha_response = $_POST['recaptcha_response'];

                    //Izvedemo in dekodiramo POST poizvedbo:
                    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
                    $recaptcha = json_decode($recaptcha);

                    //Preverimo vrnjen score in se glede na to odlocimo ali je bot ali clovek:
                    if ($recaptcha->score >= 0.6) {
                        // Preverjeno -> uporabnika registriramo
                        $uspelo = UserDB::dodaj($data);
                        if ($uspelo) {
                            // registracija uspela -> posljemo potrditveni mail
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            $mail->Mailer = "smtp";
                            $mail->SMTPDebug  = 1;
                            $mail->SMTPAuth   = TRUE;
                            $mail->SMTPSecure = "tls";
                            $mail->Port       = 587;
                            $mail->Host       = "smtp.gmail.com";
                            $mail->Username   = "ep.trgovina123@gmail.com";
                            $mail->Password   = "geslo12345";
                            $mail->IsHTML(true);
                            $mail->AddAddress($data["email"]);
                            $mail->SetFrom("ep.trgovina123@gmail.com", "Admin");
                            $mail->AddReplyTo("ep.trgovina123@gmail.com", "Admin");
                            $mail->Subject = "Potrditveni email!";
                            $content = "<b>Pozdravljeni! Dobrodošli v naši spletni trgovini. Želimo vam veliko užitkov in ugodnih nakupov. Lep pozdrav EP Team :)</b>";

                            $mail->MsgHTML($content);
                            if(!$mail->Send()) {
                                echo "Error while sending Email.";
                                //var_dump($mail);
                            } else {
                                echo "Email sent successfully";
                            }
                            //echo ViewHelper::render("view/prikazi-sporocilo.php", ["message" => "Registracija bi mogla uspet!"]);
                            ViewHelper::redirect(BASE_URL . "store");
                        }
                        else {
                            echo ViewHelper::render("view/prikazi-sporocilo.php", "Registracija ni uspela!");
                        }
                    } else {
                        // ni passal preverjanja -> bot
                        echo ViewHelper::render("view/prikazi-sporocilo.php", "Registracija ni uspela zaradi CAPTCHA, to pomeni da si bot!");
                    }

                }

            } catch (PDOException $exc) {
                echo "Napaka pri registraciji.";
                var_dump($exc);
            }
        } else {
            echo ViewHelper::render("view/sign-in.php", [
		"form" => $form,
		]);
        }
    }
    
        // Use with data sources
    private static function convertParamNames($user) {
       $user = [
            "id" =>$user["uporabnik_id"],
            "ime" =>$user["uporabnik_ime"],
            "priimek" =>$user["uporabnik_priimek"],
            "email" =>$user["uporabnik_email"],
            "geslo" =>$user["uporabnik_geslo"],
            "naslov" =>$user["uporabnik_naslov"],
            "uporabnik_vrsta" =>$user["uporabnik_vrsta"],
           
        ];
        return $user;
    }

    public static function changeMyData() {
        $uporabnikId = $_SESSION["uporabnik"]["uporabnik_id"];
             
        $userData = UserDB::get(["uporabnik_id" => $uporabnikId]); //dobiš podatke iz baze
        
        if ($userData === null) {
            ViewHelper::redirect(BASE_URL . "store");
        }
        
        $form = new RegisterEditForm("edit_form");
            
        if ($form->isSubmitted() && $form->validate()) { //popravi vnesene podatke
            
            $data = $form->getValue();
            $trenutnoGeslo = $_SESSION["uporabnik"]["uporabnik_geslo"];
            $aliJeGesloSpremenjeno = password_verify($data["geslo"] ,$trenutnoGeslo); //če je geslo isto pol je v tej spremenljivki true če različno pol je false
            if (!$aliJeGesloSpremenjeno){ //če je bilo geslo spremenjeno pol ga hashaj  -> pogleda a je ta spremenljivka true ali false
                $data['geslo'] = password_hash($data['geslo'], PASSWORD_BCRYPT);
            }
            UserDB::update($data);
            $_SESSION["uporabnik"]["uporabnik_ime"] = $data['ime'];
            $_SESSION["uporabnik"]["uporabnik_priimek"] = $data['priimek'];
            $_SESSION["uporabnik"]["uporabnik_email"] = $data['email'];
            $_SESSION["uporabnik"]["uporabnik_geslo"] = $data['geslo'];
            $_SESSION["uporabnik"]["uporabnik_naslov"] = $data['naslov'];
            $_SESSION["uporabnik"]["uporabnik_vrsta"] = $data['uporabnik_vrsta'];
            ViewHelper::redirect(BASE_URL . "store"); 
  
        } else { 
           $dataSource = new HTML_QuickForm2_DataSource_Array(self::convertParamNames($userData));
           
           $form->addDataSource($dataSource);
           echo ViewHelper::render("view/update-my-data.php", [
                "form" => $form,
                "userData" => $userData
            ]);
        }

    }
    
    
    public static function users() { //seznam-uporabnikov
        //izpisi seznam vseh strank in mej možnost aktivacija/deaktivacije

        if (isset($_SESSION["uporabnik"])) { //lahko samo ce je logiran not
            $allUsers = UserDB::getAllUsers("stranka");
            //var_dump($allUsers);
            echo ViewHelper::render("view/seznam-strank.php", [
                "allUsers" => $allUsers
            ]);
        }
        else {
            ViewHelper::redirect(BASE_URL . "log-in");
        }
    }


    public static function admin() { //admin-view
        //izpisi seznam vseh prodajalcev in mej možnost aktivacija/deaktivacije

        if (isset($_SESSION["uporabnik"])) { //lahko samo ce je logiran not
            $allUsers = UserDB::getAllUsers("prodajalec");
            var_dump($allUsers);
            echo ViewHelper::render("view/admin-view.php", [
                "allUsers" => $allUsers
            ]);
        }
        else {
            ViewHelper::redirect(BASE_URL . "log-in");
        }
    }

    public static function strankaEdit(){
        //TODO urejanje atributov določene stranke + lahko samo ce je logiran

        var_dump($_GET);
        var_dump($_POST);
        $uporabnikId = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"];
        var_dump($uporabnikId);
        $uporabnik= UserDB::get(["uporabnik_id" => $uporabnikId]);
        var_dump($uporabnik);
        if ($uporabnik == null) {
            ViewHelper::redirect(BASE_URL . "users"); // ni najdlo narocila
        }else {

        }
        //tuki je treba nardit se uno fromo za updejtat podatke

        echo ViewHelper::render("view/stranka-edit.php", ["uporabnik" => $uporabnik]);
    }

    public static function prodajalecEdit(){
        //TODO urejanje atributov določenega prodajalca + lahko samo ce je logiran

        var_dump($_GET);
        var_dump($_POST);
        $prodajalecId = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"];
        var_dump($prodajalecId);
        $uporabnik= UserDB::get(["uporabnik_id" => $prodajalecId]);
        var_dump($uporabnik);
        if ($uporabnik == null) {
            ViewHelper::redirect(BASE_URL . "admin"); // ni najdlo narocila
        }else {

        }
        //tuki je treba nardit se uno fromo za updejtat podatke

        echo ViewHelper::render("view/prodajalec-edit.php", ["uporabnik" => $uporabnik]);
    }

    public static function aktiviraj(){

        $uporabnikId = isset($_POST["uporabnik_id"]) ? intval($_POST["uporabnik_id"]) : null;
        $status = 1;
        $uporabnik = UserDB::get(["uporabnik_id" => $uporabnikId]);

        if ($uporabnikId != null) { //updejatamo status
            UserDB::updateAktiviranost(["uporabnik_id" => $uporabnikId, "uporabnik_aktiviran" => $status]);

            if ($uporabnik != null) { //najde uporabnika samo refreshamo site

                ViewHelper::redirect(BASE_URL . "user/edit?id=" . $uporabnikId);
            }
            else {
                ViewHelper::redirect(BASE_URL . "users"); // ni najdlo uporabnika   BASE_URL . "user/edit?id=" . $user["uporabnik_id"]
            }
        }
        else { //ni najdlo uporabnikaId samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "users"); // ni najdlo narocila
        }
    }

    public static function aktivirajProdajalca(){

        $uporabnikId = isset($_POST["uporabnik_id"]) ? intval($_POST["uporabnik_id"]) : null;
        $status = 1;
        $uporabnik = UserDB::get(["uporabnik_id" => $uporabnikId]);

        if ($uporabnikId != null) { //updejatamo status
            UserDB::updateAktiviranost(["uporabnik_id" => $uporabnikId, "uporabnik_aktiviran" => $status]);

            if ($uporabnik != null) { //najde uporabnika samo refreshamo site

                ViewHelper::redirect(BASE_URL . "admin/edit?id=" . $uporabnikId);
            }
            else {
                ViewHelper::redirect(BASE_URL . "admin"); // ni najdlo uporabnika   BASE_URL . "user/edit?id=" . $user["uporabnik_id"]
            }
        }
        else { //ni najdlo uporabnikaId samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "admin"); // ni najdlo narocila
        }
    }

    public static function deaktiviraj(){

        $uporabnikId = isset($_POST["uporabnik_id"]) ? intval($_POST["uporabnik_id"]) : null;
        $status = 0;
        $uporabnik = UserDB::get(["uporabnik_id" => $uporabnikId]);

        if ($uporabnikId !== null) { //updejatamo status
            UserDB::updateAktiviranost(["uporabnik_id" => $uporabnikId, "uporabnik_aktiviran" => $status]);

            if ($uporabnik != null) { //najde uporabnika samo refreshamo site
                ViewHelper::redirect(BASE_URL . "user/edit?id=" . $uporabnikId);
            }
            else {
                ViewHelper::redirect(BASE_URL . "users"); // ni najdlo uporabnika
            }
        }
        else { //ni najdlo uporabnika samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "users"); // ni najdlo narocila
        }
    }

    public static function deaktivirajProdajalca(){

        $uporabnikId = isset($_POST["uporabnik_id"]) ? intval($_POST["uporabnik_id"]) : null;
        $status = 0;
        $uporabnik = UserDB::get(["uporabnik_id" => $uporabnikId]);

        if ($uporabnikId !== null) { //updejatamo status
            UserDB::updateAktiviranost(["uporabnik_id" => $uporabnikId, "uporabnik_aktiviran" => $status]);

            if ($uporabnik != null) { //najde uporabnika samo refreshamo site
                ViewHelper::redirect(BASE_URL . "admin/edit?id=" . $uporabnikId);
            }
            else {
                ViewHelper::redirect(BASE_URL . "admin"); // ni najdlo uporabnika
            }
        }
        else { //ni najdlo uporabnika samo redirectamo nazaj -> to se nebi smelo dogajat
            ViewHelper::redirect(BASE_URL . "admin"); // ni najdlo narocila
        }
    }
    


}
