<?php
    include("../includes/Clases/claseUsuario.php");
    include_once ("../includes/funciones-comunes.php");
    include_once ("../includes/Clases/claseArticulo.php"); 
    session_start();

    $hoja_estilos = "../includes/css2/estilos.css";
    $titulo_pagina = "Vintage Music";
    $pagina_keywords = "discos, vinilos, cassettes, discografías, musica, grupos, cantante, accesorios, reproductores";
    $pagina_descripcion = "Encuentra lo último en música. En nuestra tienda online encontrarás una gran variedad de estilos musicales y novedades discográficas. Are you Ready?";
    $url_logo = "../includes/imagenes/logo-empresa.jpg";
    $icono_empresa = "../includes/imagenes/icono-empresa.ico";
    $bootstrap = "../includes/css/bootstrap.min.css";
    $templatemo = "../includes/css/templatemo.css";
    $fontawesome = "../includes/css/fontawesome.min.css";

    $pagina_index = "../Pagina-Index.php";
    $pagina_tienda = "../PaginaTienda.php";
    $pagina_contacto = "../contacto.php";
    $titulo_carrito = "(0)";
    $ruta = "../";
    if (isset($_SESSION["usuario"])) {
        $titulo_login = $_SESSION["usuario"]->getUsuario();
    } else {
        $titulo_login = "Log In";
    }

    include ("../includes/head.php");
    include ("../includes/nav.php");
    include("../includes/seguridad.php");
    include_once("../db/conectar.php");

    $mensajeExito = isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito';
    $mensajeEliminado = isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado';



// Obtiene el articulo a modificar desde la URL
    if (isset($_GET["cod_articulo"])) {
        $codigo_articulo = $_GET["cod_articulo"];
        
        $articulo = Articulo::obtenerArticuloPorCodigo($codigo_articulo);

        // Verifica si se obtuvo un objeto Articulo
        if ($articulo) {
            // Obtiene los valores del objeto Articulo
            $cod_articulo = $articulo->getCod_articulo();
            $nombre = $articulo->getNombre();
            $precio = $articulo->getPrecio();
            $descripcion = $articulo->getDescripcion();
            $categoria = $articulo->getCategoria();
            $subcategoria = $articulo->getSubcategoria();
            $imagenActual = $articulo->getImagen();
            
        } else {
            // Maneja el caso en que no se encuentre el artículo
            echo "Error: No se pudo obtener el artículo.";
            exit();
        }
    } else {
        // Maneja el caso en que no se haya proporcionado un valor de artículo en la URL
        echo "Error: Falta el valor de artículo.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $descripcion = $_POST["descripcion"];
        $categoria = $_POST["categoria"];
        $subcategoria = $_POST["subcategoria"];
        $imagenActual = $_POST["imagen"];

        //Comprobar si se ha introducido una imagen nueva
        if (isset($_FILES["nuevaImagen"]) && $_FILES["nuevaImagen"]["name"]) {
            // Guarda la nueva imagen
            $directorioImagenes = "articulosImg/"; 
            $nombreImagen = basename($_FILES["nuevaImagen"]["name"]);
            $rutaNuevaImagen = $directorioImagenes . $nombreImagen;

            move_uploaded_file($_FILES["nuevaImagen"]["tmp_name"], $rutaNuevaImagen);

            // Actualiza la ruta de la imagen
            $imagen = $rutaNuevaImagen;

            /**______________OJO, Elimina la imagen anterior si existe 
                if ($imagenActual && file_exists($imagenActual)) {
                unlink($imagenActual);
            }*/
        } else {
            // Si no se sube una nueva imagen, conserva la imagen actual
            $imagen = $imagenActual;
        }

        $conn = conectar_DB(); 

        // Modifica el artículo actual
        $resultado = Articulo::modificarArticulo($codigo_articulo, $nombre, $precio, $descripcion, $categoria, $subcategoria, $imagen);
    
        if ($resultado) {
            // Redirige al usuario después de la modificación
            echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "articuloseditormodificar.php?cod_articulo=' . $codigo_articulo . '&mensaje=exito"; }, 0);</script>';
            exit();
        } else {
            echo "Error después de modificar el artículo.";
            exit();
        }
    }
    
?>
<body style="color: #1b262c; margin: 0;">
    <div id="contenedor" style="width: 100%">
        <?php if ($mensajeExito) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="text-align: center;">
                ¡El artículo se ha modificado exitosamente!
            </div>
        <?php endif; ?>


            <div class="formulario" style="width: 30%; margin: auto; padding: 20px 30px; background-color: #c8e0f0; text-align: left; border-radius: 5px;">
                <form method="POST" action="articuloseditormodificar.php?cod_articulo=<?php echo $codigo_articulo; ?>" enctype="multipart/form-data">

                    <label for="codigo">Codigo:</label>
                    <input type="text" name="cod_articulo" style="font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $codigo_articulo; ?>" readonly><br><br>
                    
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" maxlength="40" size="40" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $nombre; ?>"><br><br>
                    
                    <label for="precio">Precio:</label>
                    <input type="number" name="precio" maxlength="15" size="15" step="0.01" min="0" max="999999999999.99" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $precio;?>"><br><br>
                    
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" maxlength="255" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;"><?php echo $descripcion; ?></textarea><br><br>
                    
                    <label for="categoria">Categoria:</label>
                    <input type="text" name="categoria" maxlength="40" size="40" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $categoria; ?>"><br><br>
                    
                    <label for="subcategoria">Subcategoria:</label>
                    <input type="text" name="subcategoria" maxlength="40" size="40" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $subcategoria; ?>"><br><br>
                    
                    <label for="imagen">Imágen:</label>
                    <input type="text" name="imagen" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $imagenActual; ?>"><br><br>
                    
                    <!--Añadir un archivo para seleccionar en caso de cambiar a una nueva imagen -->
                    <label for="nuevaImagen">Nueva Imagen:</label>
                    <input type="file" name="nuevaImagen" accept="image/*"><br><br>
                    
                    <div style="text-align: center;">
                        <img src="<?php echo $imagenActual; ?>" alt="Vista previa de la imagen" style="width: 200px; height: 200px; margin: auto;">
                    </div>
                    
                    <br><br>
                    
                    <input type='submit' name='confirmar'  style="border: none; background-color: #3282b8; color: white; font-size: 16px; height: 50px; border-radius: 5px; width: 100%;" value='Confirmar'><br><br>
                    
                    <input type='button' value='Volver' style="border:none;background-color: #3282b8; color: white; font-size: 16px; height: 50px; border-radius: 5px; width: 100%;" onclick='window.location.href="registroArticulos.php";'>

                </form>
            </div>
        </div>
    </body>


    
<?php
    include("../includes/footer.php");
?>
