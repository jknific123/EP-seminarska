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
                "toy" => ToysDB::get($data["id"])
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

        if (isset($_SESSION["uporabnik"])) { //lahko samo ce je logiran not
            if ($form->validate()) {
                $id = ToysDB::insert($form->getValue());
                ViewHelper::redirect(BASE_URL . "store");
            } else { // GET request or invalid data - show form
                self::showAddForm([
                    "form" => $form
                ]);
            }
        }
        else {
            ViewHelper::redirect(BASE_URL . "log-in");
        }

    }
 
    // Use with data sources
    private static function convertParamNames($toy) {
        $toy = [
            "id" => $toy["artikel_id"],
            "ime" => $toy["artikel_ime"],
            "cena" => $toy["artikel_cena"],
            "opis" => $toy["artikel_opis"],
        ];
        
        return $toy;
    }

    public static function showEditForm($toy, $form) {
        
       
        //$dataSource = new HTML_QuickForm2_DataSource_Array($toy);
        //$form->addDataSource($dataSource);
              
        echo ViewHelper::render("view/uredi-izbrisi-artikel.php", [
                "form" => $form,
                "toy" => $toy
            ]);
    }

    public static function edit() {
        //var_dump($_GET);
        //var_dump($_POST);exit();
        $toyId = htmlspecialchars(isset($_GET["id"]) ? $_GET["id"] : $_POST["id"]);
         //var_dump($toyId);

        if (isset($_SESSION["uporabnik"])) { //lahko samo ce je logiran not

            $toyData = ToysDB::get($toyId);
            if ($toyData === null) {
                ViewHelper::redirect(BASE_URL . "store");
            }
            //var_dump($toyData);exit();
            $form = new ToysEditForm("edit_form");

            if ($form->isSubmitted() && $form->validate()) { //popravi vnesene podatke

                $data = $form->getValue();
                ToysDB::update($data);
                ViewHelper::redirect(BASE_URL . "toy?id=" . $data["id"]);

            } else {
                $dataSource = new HTML_QuickForm2_DataSource_Array(self::convertParamNames($toyData));
                $form->addDataSource($dataSource);

                self::showEditForm($toyData, $form);
            }
        }
        else {
            ViewHelper::redirect(BASE_URL . "log-in");
        }

    }

    public static function delete() {
        $form = new ToysDeleteForm("delete_form");

        if (isset($_SESSION["uporabnik"])) { //lahko samo ce je logiran not
            $toyId = htmlspecialchars($_GET["id"]);
            ToysDB::delete($toyId);

            echo ViewHelper::redirect(BASE_URL . "store");
        }
        else {
            ViewHelper::redirect(BASE_URL . "log-in");
        }

    }
    
    
}
