<?php

require_once("model/ToysDB.php");
require_once("ViewHelper.php");
require_once("forms/ToysForm.php");

// skopirano iz cart-mvc projekta


class ToysController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules); //tle dobimo id k je 3
       
        if ($data["id"]) {
            //var_dump($data);
            //var_dump($data["id"]);
            //$data_array = ToysDB::get($data);
            //var_dump($data_array);
            echo ViewHelper::render("view/uredi-artikel.php", [
                "toy" => ToysDB::get($data)
            ]);
        } else {
            echo ViewHelper::render("view/index-trgovina.php", ["toys" => ToysDB::getAll()]);
        }
    }

    public static function showAddForm($values) { //ta dela
        echo ViewHelper::render("view/dodaj-artikel.php", $values);
    }

    public static function add() { //ta dela
        $form = new ToysInsertForm("new_toy");
        
        if ($form->validate()) {
            $id = ToysDB::insert($form->getValue());
            ViewHelper::redirect(BASE_URL . "store");
        } else { // GET request or invalid data - show form
            self::showAddForm([
                "form" => $form
            ]);
        }
    }
 
    public static function showEditForm($toy = [], $form) {
        
        if (empty($toy)) {
                $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $data = filter_input_array(INPUT_GET, $rules);
            $toy = ToysDB::get($data);
        }
        $dataSource = new HTML_QuickForm2_DataSource_Array($toy);
        $form->addDataSource($dataSource);
              
        echo ViewHelper::render("view/uredi-izbrisi-artikel.php", [
                "form" => $form,
                "toy" => $toy
            ]);
    }

    public static function edit() {
        $form = new ToysEditForm("edit_form");
        if ($form->isSubmitted()) { //popravi vnesene podatke
            
            if ($form->validate()) { //vse ok potrdi spremembe
                
                $data = $form->getValue();
                ToysDB::update($data);
                ViewHelper::redirect(BASE_URL . "toy?id=" . $data["artikel_id"]);
            } else {
                echo "Submitted";
                echo ViewHelper::render("view/uredi-izbrisi-artikel.php", [
                    "form" => $form,
                    "toy" => $toy
                ]);
            }
        } else { 
            self::showEditForm($_POST, $form);
        }
    }

    public static function delete() {
        $form = new ToysDeleteForm("delete_form");
        
        if (!isset($toy)) {
                $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $data = filter_input_array(INPUT_GET, $rules);
            $toy = ToysDB::get($data);
        }
        $dataSource = new HTML_QuickForm2_DataSource_Array($toy);
        $form->addDataSource($dataSource);
        
        echo ViewHelper::redirect(BASE_URL . "store");
        
    }
    
    
}
