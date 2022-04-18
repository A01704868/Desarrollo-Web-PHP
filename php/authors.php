<?php
//Importar la clase del controller
require_once(dirname(__FILE__) . "/controllers/AuthorController.class.php");
//Extraer la clase de su namespace y asignarle un alias
use controllers\AuthorController as AuthorController;

require_once(dirname(__FILE__) . "/utils/utils.php");

use function utils\dump as dump;

$controller = new AuthorController;

extract($controller->authorsIndex());
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Listado de Autores</title>

        <!--
        ***********************************
                        CSS
        ***********************************
        -->

        <!-- Partial con los estilos generales -->
        <?php require_once(dirname(__FILE__) . "/partials/styles.php"); ?>

        <!-- Page CSS -->
        <link rel="stylesheet" href="./css/index.css" /> 
    </head>

    <body>
        <!-- Partial del header -->
        <?php require_once(dirname(__FILE__) . "/partials/header.php"); ?>

        <!-- Partial de navegación principal -->
        <?php require_once(dirname(__FILE__) . "/partials/main_nav.php"); ?>

        <!-- Contenido principal -->
        <main class="container-fluid py-5 mb-5">
        <h2>Lista de Autores</h2>
        
        <?php
            if(!empty($message)){

                $msgClass = ($message["type"] === "success") ? "success" : "danger";
            ?>

                <div class="alert alert-<?php echo($msgClass); ?>">
                    <?php echo($message["text"]); ?>
                </div>

            <?php } ?>

        <div class="container">
            <?php foreach($authors as $author){ ?>
                <div class="row">
                    <div class="col align-self-start">
                        <?php echo($author->getFullName()); ?>
                    </div>
                    <div class="col align-self-center">
                        <?php echo($author->country); ?>
                    </div>
                    <div class="col align-self-end">
                        <form action="./authors.php" method="POST" class="ms-3" >

                            <input type="hidden" value="<?php echo($author->id); ?>" name="id" />
                            <button type="submit" class="btn btn-danger">
                                Eliminar
                            </button>

                        </form>
                    </div>
                </div>
            </br>
            <?php } ?>
        </div>

        </main>

        <!-- Partial del footer -->
        <?php require_once(dirname(__FILE__) . "/partials/footer.php"); ?>
    </body>

    <!-- Partial con los scripts generales -->
    <?php require_once(dirname(__FILE__) . "/partials/scripts.php"); ?>
</html>