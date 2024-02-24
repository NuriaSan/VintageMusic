
<?php
    session_start();
    include_once ("includes/funciones-comunes.php");

    $hoja_estilos = "includes/css2/estilos1.css";
    $titulo_pagina = "Vintage Music";
    $pagina_keywords = "discos, vinilos, cassettes, discografías, musica, grupos, cantante, accesorios, reproductores";
    $pagina_descripcion = "Encuentra lo último en música. En nuestra tienda online encontrarás una gran variedad de estilos musicales y novedades discográficas. Are you Ready?";
    $url_logo = "includes/imagenes/logo-empresa.jpg";
    $icono_empresa = "includes/imagenes/icono-empresa.ico";
    $bootstrap = "includes/css/bootstrap.min.css";
    $templatemo = "includes/css/templatemo.css";
    $fontawesome = "includes/css/fontawesome.min.css";

    $pagina_index = "Pagina-Index.php";
    $pagina_tienda = "PaginaTienda.php";
    $pagina_contacto = "contacto.php";
    $ruta = "";
?>

<?php
    include ("includes/head.php");
    include ("includes/nav.php");
    include_once ("db/conectar.php");
?>
<?php
    
    include("includes/Clases/claseUsuario.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $usuario = $_POST["usuario"];
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["apellidos"];
        $direccion = $_POST["direccion"];
        $localidad = $_POST["localidad"];
        $provincia = $_POST["provincia"];
        $cp = $_POST["cp"];
        $pais = $_POST["pais"];

        //echo $usuario;

        //Insertar datos en la BD
        $conn = conectar_DB();
            
            if ($conn) {
                try {
            
                    $stmt = $conn->prepare("INSERT INTO usuario_datosenvio (usuario, nombre, apellidos, direccion, localidad, provincia, cp, pais) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    $stmt->bindParam(1, $usuario, PDO::PARAM_STR);
                    $stmt->bindParam(2, $nombre, PDO::PARAM_STR);
                    $stmt->bindParam(3, $apellidos, PDO::PARAM_STR);
                    $stmt->bindParam(4, $direccion, PDO::PARAM_STR);
                    $stmt->bindParam(5, $localidad, PDO::PARAM_STR);
                    $stmt->bindParam(6, $provincia, PDO::PARAM_STR);
                    $stmt->bindParam(7, $cp, PDO::PARAM_INT);
                    $stmt->bindParam(8, $pais, PDO::PARAM_STR);
                    
                    if ($stmt->execute()) {
                        echo '<div class="alert alert-success text-center" role="alert" style="font-size: 30px; margin-top: 50px;">
                                Inserción de Datos correcta.
                            </div>';
                        echo "<script>window.location.href = 'Pagos.php';</script>";
                    } else {
                        echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">Error al insertar los datos.</div><br><br>';
                    }
                } catch (PDOException $e) {
                    echo "Error al preparar o ejecutar la consulta: " . $e->getMessage() . "<br><br>";
                } finally {
                    $conn = null;
                }
            }

    }        
?>


    </div>
    
    <?php
        include("includes/footer.php");
    ?>
