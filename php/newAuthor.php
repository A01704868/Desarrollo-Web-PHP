<?php 
//Importar la clase del controller
require_once(dirname(__FILE__) . "/controllers/AuthorController.class.php");
//Extraer la clase de su namespace y asignarle un alias
use controllers\AuthorController as AuthorController;

$controller = new AuthorController;

extract($controller->newAuthor());

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Nuevo Autor</title>

        <!--
        ***********************************
                        CSS
        ***********************************
        -->
           
        <!-- Partial con los estilos generales -->
        <?php require_once(dirname(__FILE__) . "/partials/styles.php"); ?>

        <!-- Multiselect -->
        <link rel="stylesheet" href="./js/multiselect/css/multi-select.css" />

        <!-- Page CSS -->
        <link rel="stylesheet" href="./css/newBook.css" />
            
    </head>

    <body>

        <!-- Partial del header -->
        <?php require_once(dirname(__FILE__) . "/partials/header.php"); ?>

        <!-- Partial de navegación principal -->
        <?php require_once(dirname(__FILE__) . "/partials/main_nav.php"); ?>

        <main class="container-fluid py-5 mb-5">
            <h2>Nuevo Autor</h2>

            <?php
            if($message){

                $messageClass = ($message["type"] === "error") ? "danger" : "success";
            ?>

                <div class="alert alert-<?php echo($messageClass); ?>">
                    <?php echo($message["text"]); ?>
                </div>

            <?php } ?>

            <form action="./newAuthor.php" method="post" enctype="multipart/form-data" id="newAuthorForm" class="mx-auto mt-sm-5">

                <div class="form-group mb-3">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>

                <div class="form-group mb-3">
                    <label for="lastname">Apellido</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required />
                </div>

                <div class="form-group mb-3">
                    <label for="country">Pais</label>
                    <select class="form-select w-25" id="country" name="country" required>

                        <?php foreach($countries as $country){ ?>

                            <option value="<?php echo($country->id); ?>">
                                <?php echo($country->name); ?>
                            </option>
                        
                        <?php } ?>

                    </select>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>

        </main>

        <!-- Partial del footer -->
        <?php require_once(dirname(__FILE__) . "/partials/footer.php"); ?>

    </body>

    <!--
    *******************************
        JAVASCRIPT
    *******************************
    -->

    <!-- Partial con los scripts generales -->
    <?php require_once(dirname(__FILE__) . "/partials/scripts.php"); ?>

    <!-- Multiselect -->
    <script src="./js/multiselect/js/jquery.multi-select.js"></script>

    <script>
    //Configuración del multiselect
    $('#authors').multiSelect();
    </script>

</html>