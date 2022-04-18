<?php

namespace models;

require_once(dirname(__FILE__) . "/../utils/DB.class.php");

//Extraer la clase DB del namespace y asignarle un alias
use DB\DB as DB;

class Country{

    //Atributos de los objetos de la clase
    public $id;
    public $name;
    public $description;


    //Constructor: recibe un arreglo con los datos del pais y lo mapea a los atributos de la clase
    public function __construct($array){
            
        //Setear sus valores
        $this->id = $array["id"];
        $this->name = $array["name"];
        $this->description = $array["description"];

    }

    /***************************
    Métodos de tabla (estáticos)
    ****************************/

    //Devuelve todos los autores ordenados por apellido
    public static function getCountries(){

        $result = DB::getInstance()->query("SELECT * FROM countries ORDER BY name ASC");

        $contries = [];

        foreach($result as $country){
            $countries[] = new Country($country);
        }

        return $countries;
    }

}