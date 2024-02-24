
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    include("includes/Clases/claseArticulo.php");
    include("db/conectar.php");
    session_start();


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
    $ruta = "";
    if (isset($_SESSION["usuario"])) {
        $titulo_login = $_SESSION["usuario"]->getUsuario();
    } else {
        $titulo_login = "Registrate";
    }
    
?>

<?php
    include ("includes/head.php");
    include ("includes/nav.php");
    include_once ("db/conectar.php");

// Obtiene el articulo a modificar desde la URL
if (isset($_GET["cod_articulo"])) {
    $codigo_articulo = $_GET["cod_articulo"];

    $articulo = Articulo::obtenerArticuloPorCodigo($codigo_articulo);

    // Verifica si se obtuvo un objeto Articulo
    if ($articulo) {
        // Obtiene los valores del objeto Articulo
        $codigo_articulo = $articulo->getCod_articulo();
        $nombre = $articulo->getNombre();
        $precio = $articulo->getPrecio();
        $descripcion = $articulo->getDescripcion();
        $categoria = $articulo->getCategoria();
        $subcategoria = $articulo->getSubcategoria();
        $imagen = $articulo->getImagen();
        
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

?>

<!-- Contenido del Cuerpo -->

<section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="<?php echo "Editor/" .$imagen; ?>" alt="Card image cap" id="product-detail">
                    </div>
                    <div class="row">
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-dark fas fa-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                        </div>
                        <!--End Controls-->
                        <!--Start Carousel Wrapper-->
                        <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                            <!--Start Slides-->
                            <div class="carousel-inner product-links-wap" role="listbox">

                                <!--First slide-->
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="includes/imagenes/kiss_crea_2.jpg" alt="Product Image 1">
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="includes/imagenes/kiss_crea_3.jpg" alt="Product Image 2">
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="includes/imagenes/kiss_crea_5.jpg" alt="Product Image 3">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--/.First slide-->

                                <!--Second slide-->
                                <div class="carousel-item">
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="includes/imagenes/kiss.png" alt="Product Image 4">
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="includes/imagenes/kiss_crea_5.jpg" alt="Product Image 5">
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#">
                                                <img class="card-img img-fluid" src="includes/imagenes/kiss_crea_3.jpg" alt="Product Image 6">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--/.Second slide-->
                            </div>
                            <!--End Slides-->
                        </div>
                        <!--End Carousel Wrapper-->
                        <!--Start Controls-->
                        <div class="col-1 align-self-center">
                            <a href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-dark fas fa-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">

                    <!-- Contenido especifico del Articulo seleccionado -->
                    <?php

                    // Mostrar resultados detallados
                    if (isset($_GET["cod_articulo"])) {
                        $codigo_articulo = $_GET["cod_articulo"];
                    }
                    //echo "Código de Artículo2: $codigo_articulo";
                    
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h1 class="h2">' . $nombre . '</h1>';
                        echo '<p class="h3 py-2">Precio €' . $precio . '</p>';
                        echo '<p class="py-2">';
                        echo '<i class="fa fa-star text-warning"></i>';
                        echo '<i class="fa fa-star text-warning"></i>';
                        echo '<i class="fa fa-star text-warning"></i>';
                        echo '<i class="fa fa-star text-warning"></i>';
                        echo '<i class="fa fa-star text-secondary"></i>';
                        echo '<span class="list-inline-item text-dark">Valoración 4.8 | 36 Comentarios</span>';
                        echo '</p>';
                        echo '<ul class="list-inline">';
                        echo '<li class="list-inline-item"><h6>Categoria:</h6></li>';
                        echo '<li class="list-inline-item"><p class="text-muted"><strong>' . $categoria . '</strong></p></li>';
                        echo '</ul>';
                        echo '<ul class="list-inline">';
                        echo '<li class="list-inline-item"><h6>Subcategoria:</h6></li>';
                        echo '<li class="list-inline-item"><p class="text-muted"><strong>' . $subcategoria . '</strong></p></li>';
                        echo '</ul>';
                        echo '<h6>Descripción:</h6>';
                        echo '<p>' . $descripcion . '</p>';
                        echo '<ul class="list-inline">';
                        echo '<li class="list-inline-item"><h6>Código :</h6></li>';
                        echo '<li class="list-inline-item"><p class="text-muted"><strong>' . $codigo_articulo . '</strong></p></li>';
                        echo '</ul>';
                    
                        echo '<form action="accionCarrito.php" method="GET">';
                        echo '<input type="hidden" name="cod_articulo" value="' . $codigo_articulo . '">';
                        echo '<div class="row">';
                        echo '<div class="col-auto">';
                        echo '<ul class="list-inline pb-3">';
                        echo '<li class="list-inline-item text-right">Cantidad <input type="hidden" name="product-quanity" id="product-quanity" value="1"></li>';
                        //echo '<li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>';
                        echo '<li class="list-inline-item"><span class="badge bg-secondary" id="cantidad">1</span></li>';
                        //echo '<li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '<div class="row pb-3">';
                        echo '<div class="col d-grid">';
                        echo '<form id="like_articulo" name="like_articulo" method="GET" action="likecarrito.php">';
                        echo '<input name="cod_articulo" type="hidden" id="cod_articulo" value='. $codigo_articulo .'>';
                        echo '<input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2">';
                        echo '<button type="submit" class="btn btn-success btn-lg text-white mt-2" name="submit">Lista de Deseos</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '<div class="col d-grid">';
                        

                        echo '<form id="formulario_articulo" name="formulario_articulo" method="GET" action="verCarta.php">';
                        echo '<input name="cod_articulo" type="hidden" id="cod_articulo" value="'. $codigo_articulo .'">';
                        echo '<input name="cantidad" type="hidden" id="cantidad" class="pl-2">';
                        echo '<button type="submit" class="btn btn-success btn-lg text-white mt-2" name="submit">Añadir al Carrito</button>';
                        echo '</form>';

                        echo '</div>';
                        echo '</div>';
                    
                        echo '</div>';
                        echo '</div>';

                    ?>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    <!-- Start Article -->
    <section class="py-5">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h4>Productos Recomendados</h4>
            </div>

            <!--Start Carousel Wrapper-->
            <div id="carousel-related-product">
                <div class="p-2 pb-3">
                    <div class="product-wap card rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="includes/imagenes/cassette_guardianes.jpg">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <!--<ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="far fa-eye"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="fas fa-cart-plus"></i></a></li>
                                </ul>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="shop-single.html" class="h3 text-decoration-none">Cassette Guardianes</a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                            </ul>
                            <p class="text-center mb-0">12,99€</p>
                        </div>
                    </div>
                </div>

                <div class="p-2 pb-3">
                    <div class="product-wap card rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="includes/imagenes/walkman.jpg">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <!--<ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="far fa-eye"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="fas fa-cart-plus"></i></a></li>
                                </ul>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="shop-single.html" class="h3 text-decoration-none">Walkman</a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                            </ul>
                            <p class="text-center mb-0">25.00 €</p>
                        </div>
                    </div>
                </div>

                <div class="p-2 pb-3">
                    <div class="product-wap card rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="includes/imagenes/kiss_destroy_2.jpg">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <!--<ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="far fa-eye"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="fas fa-cart-plus"></i></a></li>
                                </ul>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="shop-single.html" class="h3 text-decoration-none">Vinilo Kiss Destroy</a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                </li>
                            </ul>
                            <p class="text-center mb-0">45.00 €</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Article -->
    
    <?php
        include("includes/footer.php");
    ?>
