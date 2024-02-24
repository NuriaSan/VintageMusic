
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    include_once ("db/conectar.php");
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

<!-- Contenido del Cuerpo -->
<body>
<div class="container">
<div class="panel panel-default">
<div class="panel-heading"> 

<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="indexcarrito.php">Inicio</a></li>
  <li role="presentation"><a href="VerCarta.php">Ver Carta</a></li>
  <li role="presentation"><a href="Pagos.php">Pagos</a></li>
</ul>
</div>

<div class="panel-body">
    <h1>Mis Productos</h1>
    <a href="VerCarta.php" class="cart-link" title="Ver Carta"><i class="glyphicon glyphicon-shopping-cart"></i></a>
    <div id="products" class="row list-group">
        <?php
        //get rows query
        $conn = conectar_DB(); 
        $query = $conn->query("SELECT * FROM articulos ORDER BY cod_articulo DESC LIMIT 10");
        if($query->rowCount() > 0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="item col-lg-4">
            <div class="thumbnail">
                <div class="caption">
                    <h4 class="list-group-item-heading"><?php echo $row["nombre"]; ?></h4>
                    <p class="list-group-item-text"><?php echo $row["descripcion"]; ?></p>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="lead"><?php echo '$'.$row["precio"].' €'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-success" href="accionCarrito.php?action=addToCart&id=<?php echo $row["cod_articulo"]; ?>">Agregar a la Carta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } }else{ ?>
        <p>Producto(s) no existe.....</p>
        <?php } ?>
    </div>
        </div>
 <div class="panel-footer">Carrito</div>
 </div><!--Panek cierra-->
 
</div>

    
    <?php
        include("includes/footer.php");
    ?>
