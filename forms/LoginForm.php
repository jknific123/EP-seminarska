<?php
    set_include_path('/usr/share/php' . PATH_SEPARATOR . '/usr/share/kopano/php');

    require_once 'HTML/QuickForm2.php';
    require_once 'HTML/QuickForm2/Container/Fieldset.php';
    require_once 'HTML/QuickForm2/Element/InputSubmit.php';
    require_once 'HTML/QuickForm2/Element/InputText.php';
    
    require_once 'HTML/QuickForm2/Element/Textarea.php';
    require_once 'HTML/QuickForm2/Element/InputCheckbox.php';
    require_once 'HTML/QuickForm2/Element/InputPassword.php';
    
    //prijava uporabnika - lahko je admin ali prodjalec, kjer rabimo še preverjanje certifikata
    //lahko je stranka, ki tega ne potrebuje
    
    
    class LoginForm extends HTML_QuickForm2 {
        
        public $geslo;
        public $email; 
        public $button;
        
        public function __construct($id) {
            parent::__construct($id);

                $this->email = new HTML_QuickForm2_Element_InputText('email');
                $this->email->setAttribute('size',25);
                $this->email->setLabel('Elektronski naslov: ');
                
                
                $this->geslo = new HTML_QuickForm2_Element_InputPassword('geslo');
                $this->geslo->setLabel('Vnesite geslo:');
                $this->geslo->setAttribute('size', 20);
                $this->geslo->addRule('required', 'Geslo je obvezen podatek.');

                $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
                $this->button->setAttribute('value', 'Prijavi se');
                
                $this->addElement($this->email);
                $this->addElement($this->geslo);
                $this->addElement($this->button);
                
                $this->addRecursiveFilter('trim');
                $this->addRecursiveFilter('htmlspecialchars');
                
        }
        
    }
    