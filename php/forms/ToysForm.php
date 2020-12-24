<?php

#Treba je spremenit atribute, saj je ta primer narejen za knjigo mi pa potrebujemo atribute od igrač
#Artributi od artikla v DB so: id, ime, cena, slika, opis, aktiviran

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputCheckbox.php';

abstract class ToysAbstractForm extends HTML_QuickForm2 {

    public $ime;
    public $cena;
    public $opis;
    //public $aktiviran;
    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->ime = new HTML_QuickForm2_Element_InputText('ime');
        $this->ime->setAttribute('size', 50);
        $this->ime->setLabel('Ime artikla:');
        $this->ime->addRule('required', 'Ime je obvezen podatek.');
        $this->ime->addRule('regex', 'Uporabljajte samo črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->ime->addRule('maxlength', 'Ime naj bo krajše od 45 znakov.', 45);
      
        $this->cena = new HTML_QuickForm2_Element_InputText('cena');
        $this->cena->setAttribute('size', 10);
        $this->cena->setLabel('Cena artikla:');
        $this->cena->addRule('required', 'Cena artikla je obvezen podatek.');
        $this->cena->addRule('callback', 'Cena more biti veljavno število.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_FLOAT]
                )
        );
        
        $this->opis = new HTML_QuickForm2_Element_Textarea('opis');
        $this->opis->setAttribute('rows', 5);
        $this->opis->setAttribute('cols', 50);
        $this->opis->setLabel('Opis artika:');
        $this->opis->addRule('required', 'Opis artikla je obvezen podatek');
        
        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Potrdi');
        
        $this->addElement($this->ime);
        $this->addElement($this->cena);
        $this->addElement($this->opis);
        $this->addElement($this->button);
        
        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }

}
class ToysInsertForm extends ToysAbstractForm {

    public function __construct($id) {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Dodaj artikel');
    }

}

class ToysEditForm extends ToysAbstractForm {

    public $id;

    public function __construct($id) {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Uredi artikel');
        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);
        
        /*$this->ime->setAttribute("value", $toyData["artikel_ime"]);
        $this->opis->setValue($toyData["artikel_opis"]);
        $this->cena->setAttribute("value", $toyData["artikel_cena"]);
        $this->id->setValue($toyData["artikel_id"]);*/
 
    }

}

class ToysDeleteForm extends HTML_QuickForm2 {

    public $id;

    public function __construct($id) {
        parent::__construct($id, "post", ["action" => BASE_URL . "toy/delete"]);

        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);
        
        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Izbriši artikel');
        $this->addElement($this->button);
    }

}

