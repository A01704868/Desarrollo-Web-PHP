<?php

//Definición de namespace para evitar la colisión de nombres
namespace controllers;

require_once(dirname(__FILE__) . "/../models/Author.class.php");

//Extraer la clase Author
use models\Author as Author;

require_once(dirname(__FILE__) . "/../models/Country.class.php");
//Extraer la clase Country
use models\Country as Country;

require_once(dirname(__FILE__) . "/../utils/utils.php");

use function utils\dump as dump;

class AuthorController{
    //Constructor por omisión
    public function __construct(){}

    //Método de la clase para manejar la vista "authorsIndex"
    public function authorsIndex(){

        $message = null;
        
        if(strtolower($_SERVER["REQUEST_METHOD"]) === "post"){

            $id = $_POST["id"];
            
            //Pedir al model que borre el autor
            $result = Author::deleteAuthor($id);

            if($result){
                $message = ["type" => "success", "text" => "El autor se borró exitosamente"];
            }
            else{
                $message = ["type" => "error", "text" => "Error al borrar el autor"];
            }

        }

        $authors = Author::getCountry();

        //dump($authors);

        return [
            "authors" => $authors,
            "pageName" => "authors",
            "message" => $message
        ];

    }

    private function saveAuthor(){
        $name = $_POST["name"];
        $lastname = $_POST["lastname"];
        $country = $_POST["country"];

        $result = Author::insertAuthor([
            "first_name" => $name,
            "last_name" => $lastname,
            "country_id" => $country
        ]);

        if(!$result){
            return false;
        }

        return true;

    }

    public function newAuthor(){

        $message = null;

        if(strtolower($_SERVER["REQUEST_METHOD"]) === "post"){

            $result = $this->saveAuthor();

            if(!$result){
                //Mandar mensaje de error
                $message = [
                    "type" => "error",
                    "text" => "Ha ocurrido un error al guardar el registro de autor"
                ];
            }
            else{
                //Mandar mensaje de éxito
                $message = [
                    "type" => "success",
                    "text" => "El autor se ha registrado exitosamente"
                ];
            }

        }

        $countries = Country::getCountries();

        return [
            "countries" => $countries,
            "pageName" => "Nuevo Autor",
            "message" => $message
        ];
    }

}