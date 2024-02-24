
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    include("includes/Clases/claseArticulo.php");
    include("db/conectar.php");

    session_start();
//unset($_SESSION['carrito']);


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

    if(isset($_SESSION['carrito'])){
    $total_articulos = count($_SESSION['carrito']);
    $precio_total = 0;
    
    }else {
        $_SESSION['carrito']= array();
        $titulo_carrito = "(0)";
    }

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
                                    
                            <?php if(isset($_SESSION["usuario"])){
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
                    
                    <h1>Carrito de compras</h1>
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = conectar_DB(); 

                        $codigo_articulo = isset($_GET['cod_articulo']) ? $_GET['cod_articulo'] : (isset($_GET['codigo_articulo']) ? $_GET['codigo_articulo'] : null);

                        $cod_articulospedido = "COD-".$codigo_articulo."-".time();

                        if (!isset($_SESSION['carrito'])) {
                            $_SESSION['carrito'] = array();
                        }
        
                        if(isset($_SESSION['carrito'])) {
                            
                            if(isset($_GET['cod_articulo']) || isset($_GET['codigo_articulo'])){    

                                $articulo = Articulo::obtenerArticuloPorCodigo($codigo_articulo);
                                //echo $codigo_articulo;
                                //echo $cod_articulospedido; 
                                $_SESSION['carrito'][] = $articulo;


                                if (!empty($cod_articulospedido)) {
                                    $articulo = Articulo::obtenerArticuloPorCodigo($codigo_articulo);

                                        $nombre = $articulo->getNombre();
                                        $precio = $articulo->getPrecio();
                                        $cantidad = 1;

                                    if (isset($_SESSION["usuario"])) {
                                        $usuario = $_SESSION["usuario"]->getUsuario();
                                        $dni = Usuario::obtenerDniPorUsuario($usuario);
                                        //echo $dni;

                                        $conn = conectar_DB(); 
                                        
                                        // Preparar la consulta SQL
                                        $sql = "INSERT INTO articulos_pedido (cod_articulospedido, dni, nombre, precio, cantidad) VALUES (?,?,?,?,?)";
                                        $stmt = $conn->prepare($sql);
                                        
                                        // Vincular los parámetros
                                            $stmt->bindParam(1, $cod_articulospedido, PDO::PARAM_STR);
                                            $stmt->bindParam(2, $dni, PDO::PARAM_STR);
                                            $stmt->bindParam(3, $nombre, PDO::PARAM_STR);
                                            $stmt->bindParam(4, $precio, PDO::PARAM_STR);
                                            $stmt->bindParam(5, $cantidad, PDO::PARAM_INT);
                                
                                            // Ejecutar la consulta
                                            $stmt->execute();
                                        
                                            // Verificar si la modificación fue exitosa
                                            $filasAfectadas = $stmt->rowCount();
                                        
                                                    // Cerrar la conexión
                                            $conn = null;
                                    
                                        // Actualizar el total de artículos en el carrito
                                        $total_articulos = count($_SESSION['carrito']);
                                    }
                                    
                                }

                            }
                            foreach ($_SESSION['carrito'] as $articulo) {
                                // Mostrar cada artículo en la tabla
                                
                                $codigo_articulo = $articulo->getCod_articulo();
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
                                    if (empty($datos_pedido)) {
                                        echo '<a href="accionesCarrito.php?action=removeCartItem&nombre='.$nombre.'&cod_articulospedido='.$cod_articulospedido.'" class="btn btn-danger" onclick="return confirm(\'¿Esta seguro de eliminar el articulo?\')">Eliminar<i class="glyphicon glyphicon-trash"></i></a>';
                                    }else {
                                            echo 'En Pedido';
                                    }    
                                    echo '</td>
                                </tr>';
                                    
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
                            <td colspan="2">
                                <h3>Total de Artículos: <?php 
                                    $total_articulos = count($_SESSION['carrito']);
                                    echo $total_articulos; 
                                    echo "</h3></td> <td>";
                                    echo "<h3>Precio Total:"; 
                                    $precio_total = isset($precio_total) ? $precio_total : 0;
                                    echo $precio_total; 
                                ?></h3>
                            </td>
                                <?php
                                $conn = conectar_DB(); 
                                //_____print_r($_SESSION["carrito"]);
                                //Buscar si existe pedido realizado
                                if (isset($_SESSION["usuario"])) {
                        
                                        $dni = $_SESSION["usuario"]->getDni();
                                    
                                    
                                    $sql2 = "SELECT * FROM pedidos WHERE cod_usuario = :cod_usuario";

                                    // Preparar la declaración
                                    $stmt = $conn->prepare($sql2);

                                    // Enlazar parámetros
                                    $stmt->bindParam(':cod_usuario', $dni);

                                    // Ejecutar la consulta
                                    $stmt->execute();

                                    $datos_pedido = array();
                                    
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $datos_pedido[] = array(
                                            'cod_pedido' => $row['cod_pedido'],
                                            'cod_usuario' => $row['cod_usuario'],
                                            'estatus' => $row['estatus'],
                                            'pago' => $row['pago'],
                                            'fecha_pedido' => $row['fecha_pedido'],
                                            'fecha_envio' => $row['fecha_envio'],
                                            'total' => $row['total']
                                        );
                                    }

                                    // Cerrar conexión
                                    $conn = null;

                                }
                                if (!empty($datos_pedido)) {
                                    //Obtener cod_pedido del array
                                    foreach ($datos_pedido as $pedido) {
                                        // Accede al valor de 'cod_pedido' y guárdalo en una variable
                                        $cod_pedido = $pedido['cod_pedido'];
                                        // Muestra el valor de 'cod_pedido'
                                        echo "<h3>El siguiente pedido con codigo $cod_pedido: En Proceso. </h3>";
                                    }
                                }else {
                                    echo '<td class="text-center"><a href="Pagos.php" class="btn btn-success btn-block">Pagar <i class="glyphicon glyphicon-menu-right"></i></a></td>';
                                }
                                ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="panel-footer">
                <?php       if (!empty($datos_pedido)) {
                                echo '<a href="PaginaTienda.php" class="btn btn-secondary"><i class="glyphicon glyphicon-menu-left"></i> Volver a la Tienda</a>';
                            }else {
                                echo '<a href="PaginaTienda.php" class="btn btn-secondary"><i class="glyphicon glyphicon-menu-left"></i> Seguir Comprando</a>';
                            }
                ?>
                </div>
            </div>
        </div><!--Panek cierra-->
    </div>



<?php
    include("includes/footer.php");
?>
<script>

    function removeCartItem(nombre){
        $.get("accionesCarrito.php", {action:"removeCartItem", nombre}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('No se ha podido actualizar. Inténtelo de nuevo.');
            }
        });
    }
</script>