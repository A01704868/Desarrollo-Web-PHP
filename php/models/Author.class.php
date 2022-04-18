<?php

namespace models;

require_once(dirname(__FILE__) . "/../utils/DB.class.php");

//Extraer la clase DB del namespace y asignarle un alias
use DB\DB as DB;


require_once(dirname(__FILE__) . "/../utils/utils.php");

use function utils\dump as dump;

class Author{

    //Atributos de los objetos de la clase
    public $id;
    public $firstName;
    public $lastName;
    public $country;
    
    //Constructor: recibe un arreglo con los datos del autor y lo mapea a los atributos de la clase
    public function __construct($array){
            
        //Setear sus valores
        $this->id = $array["id"];
        $this->firstName = $array["first_name"];
        $this->lastName = $array["last_name"];
        $this->country = $array["country_id"];

    }

    /****************************
        Métodos de instancia
    *****************************/

    //Devuelve el nombre completo del autor instanciado
    public function getFullName(){
        return $this->firstName . " " . $this->lastName;
    }

    //Devuelve el nombre en formato apellido, nombre
    public function getLastFirst(){
        return $this->lastName . ", " . $this->firstName;
    }


    /***************************
    Métodos de tabla (estáticos)
    ****************************/

    //Devuelve todos los autores ordenados por apellido
    public static function getAll(){

        $result = DB::getInstance()->query("SELECT * 
            FROM authors 
            ORDER BY last_name, first_name ASC"
        );

        $authors = [];

        foreach($result as $author){
            $authors[] = new Author($author);
        }

        return $authors;
    }

    public static function getCountry(){
        $result = DB::getInstance()->query("SELECT authors.id, authors.first_name, authors.last_name, countries.name as country_id FROM authors JOIN countries ON authors.country_id=countries.id ORDER BY last_name, first_name ASC"
        );

        $authors = [];

        foreach($result as $author){
            $authors[] = new Author($author);
        }
        
        return $authors;
    }

    public static function insertAuthor($data){
        
        //dump($data);

        $query = "INSERT INTO authors (first_name, last_name, country_id) VALUES (?, ?, ?)";

        $authorId = DB::getInstance()->insert($query, [
            $data["first_name"],
            $data["last_name"],
            $data["country_id"]
        ]);

        return true;
    }

    public static function deleteAuthor($id){

        $temp = null;

        $consult = "SELECT authors_books.id, book_id, author_id, title FROM authors_books JOIN books ON authors_books.book_id=books.id";
        $books = DB::getInstance()->query($consult);

        foreach($books as $book){
            if($book["author_id"] === $id){
                $deleteBooks = "DELETE FROM books WHERE id=?";
                $temp = DB::getInstance()->delete($deleteBooks, [$book["book_id"]]);
            }
        }
        
        if($temp){
            $query = "DELETE FROM authors WHERE id=?";

            return DB::getInstance()->delete($query, [$id]);

        }else{
            return false;
        }
    }
}