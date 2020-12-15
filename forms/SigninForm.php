
<?php
    //set_include_path('/usr/share/php' . PATH_SEPARATOR . '/usr/share/kopano/php');
    
    require_once 'HTML/QuickForm2.php';
    require_once 'HTML/QuickForm2/Container/Fieldset.php';
    require_once 'HTML/QuickForm2/Element/InputSubmit.php';
    require_once 'HTML/QuickForm2/Element/InputText.php';
    
    require_once 'HTML/QuickForm2/Element/Textarea.php';
    require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
    require_once 'HTML/QuickForm2/Element/InputPassword.php';
    
    
    
    //Forma za registracijo stranke
    //Stranka ima atribute v DB: id, ime, priimek, email, geslo, aktiviran, naslov, vrsta uporabnika
    //implementacija registracije z uporabo potrditvenega emaila
    //implementacija registracije strank z uporabo filtriranja CAPTCHA
    
    class RegisterForm extends HTML_QuickForm2 {
        public $ime;
        public $priimek;
        
        public $email;
        public $geslo;
        
        //public $aktiviran;
        public $naslov;
        public $vrstaUporabnika;
        
        public $button; //potrdi registracijo
        
        
        
        public function __construct($id) {
            parent::__construct($id);
                
                $this->ime = new HTML_QuickForm2_Element_InputText('ime');
                $this->ime->setAttribute('size', 20);
                $this->ime->setLabel('Ime:');
                $this->ime->addRule('required', 'Ime je obvezen podatek.');
                $this->ime->addRule('regex', 'Pri imenu uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
                $this->ime->addRule('maxlength', 'Ime naj bo krajše od 45 znakov.', 45);
                
                $this->priimek = new HTML_QuickForm2_Element_InputText('priimek');
                $this->priimek->setAttribute('size', 20);
                $this->priimek->setLabel('Priimek:');
                $this->priimek->addRule('required', 'Priimek je obvezen podatek.');
                $this->priimek->addRule('regex', 'Pri priimku uporabite le črke.', '/^[a-zA-ZščćžŠČĆŽ\- ]+$/');
                $this->priimek->addRule('maxlength', 'Priimek naj bo krajši od 45 znakov.', 45);
                
                $this->email = new HTML_QuickForm2_Element_InputText('email');
                $this->email->setAttribute('size', 25);
                $this->email->setLabel('Elektronski naslov:');
                $this->email->addRule('required', 'Elektronski naslov je obvezen podatek.');
                $this->email->addRule('callback', 'Vnesite veljaven elektronski naslov.', array( //preveri kako dela - pošlji potrditveni email
                    'callback' => 'filter_var',
                    'arguments' => [FILTER_VALIDATE_EMAIL])
                );
                
                $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
                $this->geslo->setLabel('Izberite geslo:');
                $this->geslo->setAttribute('size', 20);
                $this->geslo->addRule('required', 'Geslo je obvezen podatek.');
                $this->geslo->addRule('minlength', 'Geslo naj vsebuje vsaj 5 znakov.', 5);
                $this->geslo->addRule('regex', 'V geslu uporabite vsaj 1 številko.', '/[0-9]+/');
                $this->geslo->addRule('regex', 'V geslu uporabite vsaj 1 veliko črko.', '/[A-Z]+/');
                $this->geslo->addRule('regex', 'V geslu uporabite vsaj 1 malo črko.', '/[a-z]+/');
                
                $this->naslov = new HTML_QuickForm2_Element_InputText('naslov');
                $this->naslov->setAttribute('size', 25);
                $this->naslov->setLabel('Ulica in hišna številka:');
                $this->naslov->addRule('required', 'To je obvezen podatek.');
                $this->naslov->addRule('regex', 'Uporabiti smete le črke, številke in presledek.', '/^[a-zA-ZščćžŠČĆŽ 0-9]+$/');
                $this->naslov->addRule('maxlength', 'Vnos naj bo krajši od 150 znakov.', 150);
                
                $this->vrsta_uporabnika = new HTML_QuickForm2_Element_InputText('vrsta_uporabnika');
                $this->vrsta_uporabnika->setAttribute('size', 20);
                $this->vrsta_uporabnika->setLabel('Ali se želiš registrirati kot stranka ali prodajalec?');
                $this->vrsta_uporabnika->addRule('required', 'To je obvezen podatek.');
                $this->vrsta_uporabnika->addRule('regex', 'Možni vpisi: stranka, prodajalec', '\b(stranka|prodajalec)\b');
                $this->vrsta_uporabnika->addRule('maxlength', 'Možni vpisi: stranka, prodajalec', 15);
                
                
                //-------------------------------------------------------------------------------------------------
                $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
                $this->button->setAttribute('value', 'Registriracija');

                $this->osebno->addElement($this->ime);
                $this->osebno->addElement($this->priimek);
        
                $this->racun->addElement($this->email);
                $this->racun->addElement($this->geslo);
                
                $this->osebno->addElement($this->naslov);
                $this->osebno->addElement($this->vrsta_uporabnka);
                //tle bi mejbi mogla dodat še za button

                $this->addRecursiveFilter('trim');
                $this->addRecursiveFilter('htmlspecialchars');
        }
        
    }
    
