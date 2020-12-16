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

    public $name;
    public $price;
    public $description;
    //public $aktiviran;
    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->name = new HTML_QuickForm2_Element_InputText('name');
        $this->name->setAttribute('size', 50);
        $this->name->setLabel('Ime artikla:');
        $this->name->addRule('required', 'Ime je obvezen podatek.');
        $this->name->addRule('regex', 'Uporabljajte samo črke.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->name->addRule('maxlength', 'Ime naj bo krajše od 45 znakov.', 45);
      
        $this->price = new HTML_QuickForm2_Element_InputText('price');
        $this->price->setAttribute('size', 10);
        $this->price->setLabel('Cena artikla:');
        $this->price->addRule('required', 'Cena artikla je obvezen podatek.');
        $this->price->addRule('callback', 'Cena more biti veljavno število.', array(
            'callback' => 'filter_var',
            'arguments' => [FILTER_VALIDATE_FLOAT]
                )
        );
        
        $this->description = new HTML_QuickForm2_Element_Textarea('description');
        $this->description->setAttribute('rows', 5);
        $this->description->setAttribute('cols', 50);
        $this->description->setLabel('Opis artika:');
        $this->description->addRule('required', 'Opis artikla je obvezen podatek');
        
        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Potrdi');
        
        $this->addElement($this->name);
        $this->addElement($this->price);
        $this->addElement($this->description);
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
    }

}

class ToysDeleteForm extends HTML_QuickForm2 {

    public $id;

    public function __construct($id) {
        parent::__construct($id, "post", ["action" => BASE_URL . "toy/delete"]);

        $this->id = new HTML_QuickForm2_Element_InputHidden("id");
        $this->addElement($this->id);

        $this->confirmation = new HTML_QuickForm2_Element_InputCheckbox("confirmation");
        $this->confirmation->setLabel('Delete?');
        $this->confirmation->addRule('required', 'Tick if you want to delete this toy.');
        $this->addElement($this->confirmation);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Izbriši artikel');
        $this->addElement($this->button);
    }

}

