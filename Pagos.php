<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    include("includes/Clases/claseArticulo.php");
    include("db/conectar.php");

    //Comprobación de sesion activa
    if (session_status() == PHP_SESSION_NONE) {
        // Si no está activa, activar la sesión
        session_start();
    }


    //$hoja_estilos = "includes/css2/estilos1.css";
    $titulo_pagina = "Vintage Music";
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
    $titulo_carrito = "(0)";
    if (isset($_SESSION["usuario"])) {
        $titulo_login = $_SESSION["usuario"]->getUsuario();
    } else {
        $titulo_login = "Log In";
    }
    
    include ("includes/head.php");
    include ("includes/nav.php");
    include_once ("db/conectar.php");

?>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading"> 

                <ul class="nav nav-pills">
                    <li role="presentation"><a href="indexcarrito.php">Inicio</a></li>
                    <li role="presentation"><a href="VerCarta.php">Ver Carta</a></li>
                    <li role="presentation" class="active"><a href="Pagos.php">Pagos</a></li>
                </ul>
            </div>

        <div class="panel-body">
            <h1>Vista previa de la Orden</h1>
            <?php if (isset($_SESSION["usuario"])) {
                $usuario = $_SESSION["usuario"]->getUsuario();
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Debes iniciar sesión para completar la compra.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }?>
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
                $precio_total = 0;
                $total_articulos = count($_SESSION['carrito']);
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
                        
                    </tr>';
                }
                ?>
                    <tr>
                        <td colspan="2"><h3>Total de Artículos: <?php echo $total_articulos; ?></h3></td>
                        <td><h2>Total <?php echo $precio_total.' €'; ?></h2></td>
                        
                    </tr>
                </tbody>
            </table>
            <div class="shipAddr">
                
                <?php
                    if (isset($_SESSION["usuario"])) {
                        $usuario = $_SESSION["usuario"]->getUsuario();
                        //Sesion usuario
                        // Utilizar la clase Usuario para obtener el DNI del usuario
                            $dni = Usuario::obtenerDniPorUsuario($usuario);
                        
                            // Verificar si se obtuvo el DNI
                            if ($dni) {
                                // Utilizar la clase Usuario para obtener el objeto Usuario correspondiente al DNI
                                $usuarioSesion = Usuario::obtenerUsuarioPorDNI($dni);
                        
                                // Verificar si se obtuvo un objeto Usuario
                                if ($usuarioSesion) {
                                    // Obtener los valores del objeto Usuario
                                    $dni = $usuarioSesion->getDni();
                                    $usuario = $usuarioSesion->getUsuario();
                                    $nombre = $usuarioSesion->getNombre();
                                    $telefono = $usuarioSesion->getTelefono();
                                    $email = $usuarioSesion->getEmail();
                                    $password = $usuarioSesion->getPassword();
                                    echo '<h4>Datos del usuario '.$usuario.':</h4>';
                                    echo '<table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Telefono</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            echo '<tr>';
                                            echo '<td>'. $nombre.'</td>';
                                            echo '<td>'. $telefono.'</td>';
                                            echo '<td>'. $email.'</td>';
                                            echo '</tr>';
                                    echo '</table>';

                                    $datos_envio_usuario = Usuario::obtenerDatosEnvio($usuario);

                                    if (!empty($datos_envio_usuario)) {
                                        echo '<h4>Datos de Envío:</h4>';
                                        echo '<p>Nombre: ' . $datos_envio_usuario[0]['nombre'] . '</p>';
                                        echo '<p>Apellidos: ' . $datos_envio_usuario[0]['apellidos'] . '</p>';
                                        echo '<p>Dirección: ' . $datos_envio_usuario[0]['direccion'] . '</p>';
                                        echo '<p>Localidad: ' . $datos_envio_usuario[0]['localidad'] . '</p>';
                                        echo '<p>Provincia: ' . $datos_envio_usuario[0]['provincia'] . '</p>';
                                        echo '<p>C.p.: ' . $datos_envio_usuario[0]['cp'] . '</p>';
                                        echo '<p>Pais: ' . $datos_envio_usuario[0]['pais'] . '</p>';
                                        $cod_pedido ="COD-".date('YmdHis');
                                        $cod_usuario = $dni;
                                        $estatus = "en proceso";
                                        $pago = "Pendiente";
                                        $fecha_pedido = date("Y-m-d");
                                        $fecha_envio = "Pendiente";
                                        $total = $precio_total;
                                        // Insertar en la tabla
                                        $conn = conectar_DB();
                                            $sql = "INSERT INTO pedidos (cod_pedido, cod_usuario, estatus, pago, fecha_pedido, fecha_envio, total) VALUES (?, ?, ?, ?, ?, ?, ?)";

                                            // Preparar la declaración
                                            $stmt = $conn->prepare($sql);

                                            // Enlazar parámetros
                                            $stmt->bindParam(1, $cod_pedido, PDO::PARAM_STR);
                                            $stmt->bindParam(2, $cod_usuario, PDO::PARAM_STR);
                                            $stmt->bindParam(3, $estatus, PDO::PARAM_STR);
                                            $stmt->bindParam(4, $pago, PDO::PARAM_STR);
                                            $stmt->bindParam(5, $fecha_pedido, PDO::PARAM_STR);
                                            $stmt->bindParam(6, $fecha_envio, PDO::PARAM_STR); 
                                            $stmt->bindParam(7, $total, PDO::PARAM_STR);

                                            $stmt->execute();
                                            
                                        $conn = null;
                                        unset($_SESSION['carrito']);

                                    } else {
                                        echo '<p>Aún no has ingresado tus datos de envío.</p>';
                                        echo '<h4>Datos de Envio:</h4>';
                                        //echo $usuario;
                                        echo '<form action="datos_envio.php" method="POST">
                                                <input type="hidden" class="form-control" id="usuario" name="usuario" value="' . $usuario . '">
                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="apellidos" class="form-label">Apellidos</label>
                                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="direccion" class="form-label">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="localidad" class="form-label">Localidad</label>
                                                <input type="text" class="form-control" id="localidad" name="localidad" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="provincia" class="form-label">Provincia</label>
                                                <input type="text" class="form-control" id="provincia" name="provincia" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="cp" class="form-label">C.p.</label>
                                                <input type="text" class="form-control" id="cp" name="cp" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pais" class="form-label">Pais</label>
                                                <input type="text" class="form-control" id="pais" name="pais" rows="3" required>
                                            </div>
                                            <button type="submit" class="btn btn-secondary">Guardar Datos</button>
                                        </form>';
                                    }
                                } else {
                                    // Rsultado en el caso en que no se encuentre el usuario
                                    echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">No se ha podido obtener el usuario</div>';
                                    exit();
                                }
                            } else {
                                // Resultado si no se haya obtenido el DNI
                                echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">Error: No se pudo obtener el DNI.</div>';
                                exit();
                            }
                            
                        } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        No puedes obtener los datos del envio ni procesar la compra.
                        Para realizar todas estas acciones deberás registrarte.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Debes iniciar sesión para completar la compra.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <a href="login.php" class="btn btn-secondary">Iniciar Sesión</a>
                        </div>';
                }?>
                
            </div>
            <div class="footBtn">
                <a href="PaginaTienda.php" class="btn btn-secondary"><i class="glyphicon glyphicon-menu-left"></i> Continuar Comprando</a>
                <a href="OrdenExito.php?action=placeOrder&cod_pedido=<?php echo $cod_pedido; ?>" class="btn btn-success orderBtn">Realizar Pago del Pedido<i class="glyphicon glyphicon-menu-right"></i></a>
            </div>
        </div>
        <div class="panel-footer">Datos Factura</div>
        </div><!--Panek cierra-->
    </div>
<?php
    include("includes/footer.php");
?>
