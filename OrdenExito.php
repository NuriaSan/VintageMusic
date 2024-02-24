
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    session_start();

    $hoja_estilos = "./includes/css/estilos.css";
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
    $ruta = "";

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'nombre_asc';
    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';


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
<div class="row">
    <div class="col-1">
    </div>
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
                                    echo '<a class="btn btn-outline-danger mb-2" href="Usuario/sesionusuario.php?usuario='.$usuario.'">Datos de Usuario</a>';
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
    <div class="col-8">
        <div class="panel panel-default">
            <div class="panel-heading"> 

                <ul class="nav nav-pills">
                <li role="presentation"><a href="PaginaTienda.php">Inicio</a></li>
                </ul>
            </div>

            <div class="panel-body">

                <h1>Estado de su Orden</h1>
                <p>Su pedido ha sido enviado exitosamente. El ID del pedido es #<?php echo $_GET['cod_pedido']; ?></p>
            </div>
            <div class="panel-footer"></div>
        </div>
</div>
    
<?php
    include("includes/footer.php");
?>
