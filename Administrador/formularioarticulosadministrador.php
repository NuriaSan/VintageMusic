<?php
    include("../includes/Clases/claseUsuario.php");
    include("../includes/Clases/claseArticulo.php");
    include_once ("../includes/funciones-comunes.php");
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
?>

<body class="text-center" style="background-color: aliceblue;">

    <div class="container mt-5">
        <h1>Artículos de la Tienda</h1>
        <div id="contenedor">
            <form name="formarticulos" method="post" action="formularioarticulosadministrador.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código del Artículo:</label>
                    <input name="codigo" type="text" id="codigo" maxlength="8" size="8" class="form-control" placeholder="Autogenerado" disabled>
                </div>

                <div class="mb-3">
                    <input name="nombre" type="text" id="tipo" maxlength="40" size="40" class="form-control" placeholder="Nombre" required>
                </div>

                <div class="mb-3">
                    <input name="precio" type="number" id="precio" maxlength="15" size="15" step="0.01" min="0" max="999999999999.99" class="form-control" placeholder="Precio €" required>
                </div>

                <div class="mb-3">
                    <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción" required></textarea>
                </div>

                <div class="mb-3">
                    <input name="categoria" type="text" id="categoria" maxlength="40" size="40" class="form-control" placeholder="Categoría" required>
                </div>

                <div class="mb-3">
                    <input name="subcategoria" type="text" id="subcategoria" maxlength="40" size="40" class="form-control" placeholder="Subcategoría" required>
                </div>

                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input name="imagen" id="imagen" type="file" accept=".jpeg, .jpg, .png, .gif" class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="submit" name="enviar" value="Enviar" class="btn btn-primary">
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-secondary">Volver Atrás</a>
                </div>
            </form>
        </div>
    </div>

    </body>
</html>

<?php
    include("../db/conectar.php");


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
        
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $subcategoria = $_POST['subcategoria'];
        $nombre_archivo = $_FILES['imagen']['name'];
        $imagen = "articulosImg/" . $nombre_archivo;
        $temp = $_FILES['imagen']['tmp_name'];
        $size = $_FILES['imagen']['size'];
        

        //Validación que comprueba si se insertan números positivos
        if (!is_numeric($precio) || $precio <= 0) {
            echo '<div style="color: red; text-align: center; font-size: 20px; margin-top: 50px;">elprecio debe ser un numero positivo.</div>';
        }

        //Validación de la exixtencia y tamaño para controlar que no sea excesivo
        if(isset($_FILES['imagen']) && ($_FILES['imagen']['size'] >0 )){

            if ($size >3000000){
                echo '<div style="color: red; text-align: center; font-size: 20px; margin-top: 50px;">El archivo introducido es demasiado pesado.</div>';
            }

        } else {
            //______________________Mejorar respuesta
            echo "No se ha podido cargar el archivo.";
        }

        // Validación del tipo de archivo
        $extensionesTipos = ['jpg', 'jpeg', 'png', 'gif'];
        $archivoExtension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));


        if (!in_array($archivoExtension, $extensionesTipos) || !exif_imagetype($_FILES['imagen']['tmp_name'])) {
            echo '<div><b>Por favor, seleccione un archivo de imagen válido.</b></div>';
            exit();
        }


        if (move_uploaded_file($temp,$imagen)) {

            $conn = conectar_DB();

            if($conn){

                // Crea una instancia de la clase Articulo
                $articulo = new Articulo('aaa00001', $nombre, $precio, $descripcion, $categoria, $subcategoria, $imagen);

                // Obtiene el código utilizando el método de la clase
                $codigoArticulo = $articulo->generarCodigo();

                // Actualiza el código del artículo
                $articulo->setCod_articulo($codigoArticulo);

                $stmt = $conn->prepare("INSERT INTO articulos(cod_articulo, nombre, precio, descripcion, categoria, subcategoria, imagen) VALUES (:cod_articulo, :nombre, :precio, :descripcion, :categoria, :subcategoria, :imagen)");
                $stmt->bindParam(':cod_articulo', $codigoArticulo);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':categoria', $categoria);
                $stmt->bindParam(':subcategoria', $subcategoria);
                $stmt->bindParam(':imagen', $imagen);

                if($stmt->execute()) {

                    echo '<div class="alert alert-success" role="alert" style="margin-top: 20px;">Datos insertados correctamente. Redirigiendo al registro.</div>';
                    
                    echo '<meta http-equiv="refresh" content="3;url=registroarticulosadministrador.php">';
                } else {
                    echo '<div><b>Ocurrió algún error al insertar en la base de datos.</b></div>';
                }
            } else{
                echo '<div style="color: red; text-align: center; font-size: 20px; margin-top: 50px;">Error en la conexión de la Base de Datos.</div>';
            }
            
        }
        else {
            //Respuesta en el caso de que no se haya podido subir la imagen, se muestra un mensaje de error
            echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
        }
    }
?>

</body>


    
<?php
    include("../includes/footer.php");
?>
