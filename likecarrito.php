
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    include("includes/Clases/claseArticulo.php");
    include("db/conectar.php");

    session_start();
//unset($_SESSION['like']);


    $titulo_pagina = "Vintage Music";
    $hoja_estilos = "includes/css2/estilos.css";
    $pagina_keywords = "discos, vinilos, cassettes, discografías, musica, grupos, cantante, accesorios, reproductores";
    $pagina_descripcion = "Encuentra lo último en música. En nuestra tienda online encontrarás una gran variedad de estilos musicales y novedades discográficas. Are you Ready?";
    $url_logo = "includes/imagenes/logo-empresa.jpg";
    $icono_empresa = "includes/imagenes/icono-empresa.ico";
    $bootstrap = "includes/css/bootstrap.min.css";
    $templatemo = "includes/css/templatemo.css";
    $fontawesome = "includes/css/fontawesome.min.css";
    $js_jquery1 = "includes/js/jquery-1.11.0.min.js";
    $js_jquery2 = "includes/js/jquery-migrate-1.2.1.min.js";
    $js_bootstrap = "includes/js/bootstrap.bundle.min.js";
    $js_templatemo = "includes/js/templatemo.js";
    $js_custom = "includes/js/custom.js";

    $pagina_index = "Pagina-Index.php";
    $pagina_tienda = "PaginaTienda.php";
    $pagina_contacto = "contacto.php";
    $ruta = "";

    
    if (isset($_SESSION["usuario"])) {
        $titulo_login = $_SESSION["usuario"]->getUsuario();
    } else {
        $titulo_login = "Registrate";
    }
    
    include ("includes/head.php");
    include ("includes/nav.php");
    include_once ("db/conectar.php");

    if(isset($_SESSION['like'])){
    $total_articulos = count($_SESSION['like']);
    
    
    }else {
        $_SESSION['like']= array();
        $titulo_carrito = "(0)";
    }$precio_total = 0;

?>
<body>
    <div class="row row justify-content-evenly">
        <div class="col-2">
            <div class="menu-usuario">
                <div class="card">
                    <div class="card-header">
                        <span class="me-2"> 
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="me-2">

                            <?php 
                            if (isset($_SESSION["usuario"])) {
                                $usuario = $_SESSION["usuario"]->getUsuario();
                                echo "<h3>Usuario: ".$usuario. "<h3>";
                            } else {
                                echo "Usuario no Registrado";
                            }
                            ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="d-grid gap-2">     
                            <?php 
                                if(isset($_SESSION["usuario"])){
                                    $usuario = $_SESSION["usuario"]->getUsuario();
                                    $estadoAdmin = Usuario::obtenerAdminPorUsuario($usuario);
                                    $estadoEdit = Usuario::obtenerEditPorUsuario($usuario);
                                    if ($usuario) {
                                                    
                                        if ($estadoAdmin == 1) {
                                            echo '<a class="btn btn-outline-danger mb-2" href="Administrador/sesionadministrador.php?usuario='.$usuario.'">Datos de Usuario</a>';
                                                        
                                        } elseif ($estadoEdit == 1) {
                                            echo '<a class="btn btn-outline-danger mb-2" href="Editor/sesioneditor.php?usuario='.$usuario.'">Datos de Usuario</a>';
                                                    
                                        } else {
                                            echo '<a class="btn btn-outline-danger mb-2" href="Usuario/sesionusuario.php?usuario='.$usuario.'">Datos de Usuario</a>';
                                        }
                                    } 
                                                
                                } else {
                                    echo '<p>¡Registrate!</p>';
                                }
                            ?>

                                <?php if(isset($_SESSION["usuario"])){
                                    $usuario = $_SESSION["usuario"]->getUsuario();
                                    echo '<a class="btn btn-outline-danger mb-2" href="VerCarta.php?usuario='.$usuario.'">Carrito de Compra</a>';
                                } else {
                                    echo '<a class="btn btn-outline-danger mb-2" href="VerCarta.php">Carrito de Compra</a>';
                                }
                                ?>

                                <?php if(isset($_SESSION["usuario"])){
                                    $usuario = $_SESSION["usuario"]->getUsuario();
                                    echo '<a class="btn btn-outline-danger mb-2" href="likecarrito.php?usuario='.$usuario.'">Lista de Deseos</a>';
                                } else {
                                    echo '<a class="btn btn-outline-danger mb-2" href="likecarrito.php">Lista de Deseos</a>';
                                }
                                ?>

                                <?php if(isset($_SESSION["usuario"])): ?> 
                                    <a href="logout.php" class="btn btn-outline-danger mb-2"> 
                                        Cerrar Sesión
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-dark mb-2"> 
                                        Registro/Iniciar Sesión
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <ul class="nav nav-pills">
                        <li role="presentation"><a href="PaginaTienda.php">Tienda</a></li>
                        <li role="presentation" class="active"><a href="VerCarta.php">Compras</a></li>
                    </ul>
                </div>

                <div class="panel-body">
                    
                    <h1>Lista de Deseos</h1>
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th class="text-center">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = conectar_DB(); 

                        $cod_articulo = isset($_GET['cod_articulo']) ? $_GET['cod_articulo'] : (isset($_GET['codigo_articulo']) ? $_GET['codigo_articulo'] : null);

                        $cod_articulos_like = "LIKE-".$cod_articulo."-".time();

                        if (!isset($_SESSION['like'])) {
                            $_SESSION['like'] = array();
                        }
        
                        if(isset($_SESSION['like'])) {
                            
                            if(isset($_GET['cod_articulo']) || isset($_GET['codigo_articulo'])){    

                                
                                $articulo = Articulo::obtenerArticuloPorCodigo($cod_articulo);
                                //echo $cod_articulo;
                                //echo $cod_articulospedido; 
                                $_SESSION['like'][] = $articulo;

                                    if (isset($_SESSION["usuario"])) {
                                        $usuario = $_SESSION["usuario"]->getUsuario();
                                        $dni = Usuario::obtenerDniPorUsuario($usuario);
                                        //echo $dni;
                                        $articulo = Articulo::obtenerArticuloPorCodigo($cod_articulo);

                                        
                                        $nombre = $articulo->getNombre();
                                        $precio = $articulo->getPrecio();
                                        $cantidad = 1;

                                        //echo $cod_articulo;
                                        $conn = conectar_DB(); 
                                        
                                        // Preparar la consulta SQL
                                        $sql = "INSERT INTO articulos_like (cod_articulos_like, cod_articulo, nombre, precio, dni) VALUES (?,?,?,?,?)";
                                        $stmt = $conn->prepare($sql);
                                        
                                        // Vincular los parámetros
                                            $stmt->bindParam(1, $cod_articulos_like, PDO::PARAM_STR);
                                            $stmt->bindParam(2, $cod_articulo, PDO::PARAM_STR);
                                            $stmt->bindParam(3, $nombre, PDO::PARAM_STR);
                                            $stmt->bindParam(4, $precio, PDO::PARAM_STR);
                                            $stmt->bindParam(5, $dni, PDO::PARAM_STR);
                                
                                            // Ejecutar la consulta
                                            $stmt->execute();
                                        
                                            // Verificar si la modificación fue exitosa
                                            $filasAfectadas = $stmt->rowCount();
                                        
                                                    // Cerrar la conexión
                                            $conn = null;
                                    
                                        // Actualizar el total de artículos en el carrito
                                        $total_articulos = count($_SESSION['like']);
                                    }
                                    
                                

                            }
                            foreach ($_SESSION['like'] as $articulo) {
                                // Comprueba si el elemento es un objeto
                                if(is_object($articulo) && method_exists($articulo, 'getNombre') && method_exists($articulo, 'getPrecio')) {
                                    // Obtén el nombre y precio del artículo usando sus métodos
                                    $nombre = $articulo->getNombre();
                                    $precio = $articulo->getPrecio();
                                    $cantidad = 1;
                                    $subtotal = $precio * $cantidad;
                                    $precio_total += $subtotal;
                                    echo '<tr>
                                        <td>'.$nombre.'</td>
                                        <td>'.$precio.' €</td>
                                        <td class="text-center"> '.$cantidad.'</td>
                                        <td class="text-center">';
                                        
                                        echo '<a href="actualizarCarrito.php?action=removeCartItem&nombre='.$nombre.'" class="btn btn-danger" onclick="return confirm(\'¿Esta seguro de eliminar el articulo?\')">Eliminar<i class="glyphicon glyphicon-trash"></i></a>';
                            
                                        echo '</td>
                                    </tr>';
                                }        
                            }    
                                
                            }
                            
                        ?>
                        <script>
                        // Eliminar el parámetro cod_articulo de la URL para que no se añada al recargar la pagina
                        history.pushState({}, document.title, window.location.pathname);
                        </script>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><h3>Total de Artículos: <?php
                                $total_articulos = count($_SESSION['like']);
                                echo $total_articulos; ?></h3></td>
                                <td><h2>Total <?php echo $precio_total.' €'; ?></h2></td>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div><!--Panek cierra-->
    </div>



<?php
    include("includes/footer.php");
?>
<script>

    function removeCartItem(cod_articulo){
        $.get("accionesCarrito.php", {action:"removeCartItem", cod_articulo}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('No se ha podido actualizar. Inténtelo de nuevo.');
            }
        });
    }
</script>