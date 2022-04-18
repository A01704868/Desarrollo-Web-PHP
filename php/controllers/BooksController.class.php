<?php

//Definición de namespace para evitar la colisión de nombres
namespace controllers;

//Importar el modelo
require_once(dirname(__FILE__) . "/../models/Book.class.php");

//Extraer la clase Book
use models\Book as Book;

require_once(dirname(__FILE__) . "/../models/Language.class.php");

//Extraer la clase Language
use models\Language as Language;

require_once(dirname(__FILE__) . "/../models/Author.class.php");

//Extraer la clase Author
use models\Author as Author;

require_once(dirname(__FILE__) . "/../models/Category.class.php");

//Extraer la clase Category
use models\Category as Category;

require_once(dirname(__FILE__) . "/../models/Publisher.class.php");

//Extraer la clase Publisher
use models\Publisher as Publisher;

require_once(dirname(__FILE__) . "/../utils/utils.php");

use function utils\dump as dump;


//Definición de la clase
class BooksController{

    //Definición de variables de instancia
    private $controllerName = "BooksController";

    //Constructor por omisión
    public function __construct(){}

    //Método de la clase para manejar la vista "index"
    public function index(){

        $message = null;

        if(strtolower($_SERVER["REQUEST_METHOD"]) === "post"){

            $id = $_POST["id"];
            
            //Pedir al model que borre el libro
            $result = Book::delete($id);

            if($result){
                $message = ["type" => "success", "text" => "El libro se borró exitosamente"];
            }
            else{
                $message = ["type" => "error", "text" => "Error al borrar el libro"];
            }

        }

        $books = Book::getBooks();

        //dump($books);

        return [
            "books" => $books,
            "pageName" => "index",
            "message" => $message
        ];

    }

    //Método que controlará la vista del detalle de libros
    public function book(){

        //Obtener el ID
        $id = $_GET["id"];

        //Buscar el libro en la BD (modelo)
        $book = Book::find($id);

        //dump($book->categories);
        
        return [
            "book" => $book,
            "pageName" => "book"
        ];

    }

    private function validate($data){
        //Validar los datos
        // if(empty($isbn)){
        //     return [
        //         "success" => false,
        //         "message" => "El isbn está vacío"
        //     ];
        // }
    }

    private function saveBook(){

        //Extraer la información
        $isbn = $_POST["isbn"];
        $title = $_POST["title"];
        $publisher = $_POST["publisher"];
        $edition = $_POST["edition"];
        $year = $_POST["year"];
        $summary = $_POST["summary"];
        $language = $_POST["language"];
        $authors = $_POST["authors"];
        $categories = $_POST["category"];
        $price = $_POST["price"];

        //Validar los datos
        // $validation = $this->validate(["isbn" => $isbn ...]);

        // if(!$validation["success"]){
        //     return $validation;
        // }

        //Guardar el libro
        /*
        Opción 1: Crear una instancia y pedirle que se guarde a sí misma
        $book = new Book([
            "id" => null,
            "isbn" => $isbn,
            "title" => $title,
            "publisher_id" => $publisher,
            "edition" => $edition,
            "year" => $year,
            "summary" => $summary,
            "authors" => $authors,
            "categories" => $categories
        ]);
        
        $book->save();
        */

        //Guardar la portada
        $fileContent = file_get_contents($_FILES["cover"]["tmp_name"]);
        $fileExtension = explode(".", $_FILES["cover"]["name"])[1];
        $fileName = uniqid() . "." . $fileExtension;
        $filePath = dirname(__FILE__) . "/../img/books_covers/" . $fileName;

        //Guardar el archivo
        file_put_contents($filePath, $fileContent);

        //Opción 2: método estático que guarde los datos
        $result = Book::insert([
            "isbn" => $isbn,
            "title" => $title,
            "publisher_id" => $publisher,
            "language_id" => $language,
            "price" => $price,
            "cover" => $fileName,
            "edition" => $edition,
            "year" => $year,
            "summary" => $summary,
            "authors" => $authors,
            "categories" => $categories
        ]);

        //Borrar el archivo si falló
        if(!$result){
            unlink($filePath);
        }

        return $result;

    }

    public function newBook(){

        $message = null;

        if(strtolower($_SERVER["REQUEST_METHOD"]) === "post"){

            $result = $this->saveBook();    
            
            if(!$result){
                //Mandar mensaje de error
                $message = [
                    "type" => "error",
                    "text" => "Ha ocurrido un error al guardar el libro"
                ];
            }
            else{
                //Mandar mensaje de éxito
                $message = [
                    "type" => "success",
                    "text" => "El libro se ha guardado exitosamente"
                ];
            }
        }

        $languages = Language::getAll();
        $authors = Author::getAll();
        $categories = Category::getAll();
        $publishers = Publisher::getAll();

        //dump($authors);

        return [
            "languages" => $languages,
            "authors" => $authors,
            "categories" => $categories,
            "publishers" => $publishers,
            "pageName" => "newBook",
            "message" => $message
        ];

    }

}