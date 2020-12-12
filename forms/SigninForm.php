
<?php
    set_include_path('/usr/share/php' . PATH_SEPARATOR . '/usr/share/kopano/php');
    
    require_once 'HTML/QuickForm2.php';
    require_once 'HTML/QuickForm2/Container/Fieldset.php';
    require_once 'HTML/QuickForm2/Element/InputSubmit.php';
    require_once 'HTML/QuickForm2/Element/InputText.php';
    
    require_once 'HTML/QuickForm2/Element/Textarea.php';
    require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
    require_once 'HTML/QuickForm2/Element/InputPassword.php';
    
    
    
    //Forma za registracijo stranke
    //Stranka ima atribute v DB: id, ime, priimek, email, geslo
    //implementacija registracije z uporabo potrditvenega emaila
    //implementacija registracije strank z uporabo filtriranja CAPTCHA
    
    class RegisterForm extends HTML_QuickForm2 {
        
        public $geslo;
        public $email;
        
        public $button;
        
        public $ime;
        public $priimek;
        
        public function __construct($id) {
            parent::__construct($id);
                
                $this->ime = new HTML_QuickForm2_Element_InputText('ime');
                $this->ime->setLabel('Ime');
                $this->ime->addRule('regex', 'Letters only.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
                $this->addElement($this->ime);
                
                $this->priimek = new HTML_QuickForm2_Element_InputText('priimek');
                $this->priimek->setLabel('Priimek');
                $this->priimek->addRule('regex', 'Letters only.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
                $this->addElement($this->priimek);
            
                $this->email = new HTML_QuickForm2_Element_InputText('email');
                $this->email->setAttribute('size',30);
                
                $this->email->setLabel('Elektronski naslov:');
                $this->addElement($this->email);
                
                $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
                $this->geslo->setAttribute('size',20);
                $this->geslo->setLabel('Geslo: ');
                $this->addElement($this->geslo);
                
                $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
                $this->button->setAttribute('value', 'Registriraj se');
                $this->addElement($this->button);
                
                $this->addRecursiveFilter('trim');
                $this->addRecursiveFilter('htmlspecialchars');
                
        }
        
    }
    
