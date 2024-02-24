
<?php
    include_once ("includes/funciones-comunes.php");

    $hoja_estilos = "../includes/css2/estilos1.css";
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
?>

<?php
    include ("includes/head.php");
    include ("includes/nav.php");
    include_once("../db/conectar.php");
?>

<!-- Contenido del Cuerpo -->
<div class="container py-5">
    <div class="row">

    <!-- Desplegable -->
        <div class="col-lg-3">
            <h1 class="h2 pb-4">Productos</h1>
            <ul class="list-unstyled templatemo-accordion">
                <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Vinilos
                        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul class="collapse show list-unstyled pl-3">
                        <li><a class="text-decoration-none" href="#">Internacional</a></li>
                        <li><a class="text-decoration-none" href="#">Español</a></li>
                        </ul>
                </li>
                <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Cassettes
                        <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                        <li><a class="text-decoration-none" href="#">Internacional</a></li>
                        <li><a class="text-decoration-none" href="#">Español</a></li>
                    </ul>
                </li>
                <li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        Reproductores / Accesorios
                        <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul id="collapseThree" class="collapse list-unstyled pl-3">
                        <li><a class="text-decoration-none" href="#">Reproductores</a></li>
                        <li><a class="text-decoration-none" href="#">Accesorios</a></li>
                        <li><a class="text-decoration-none" href="#">Custom</a></li>
                    </ul>
                </li>
            </ul>
        </div>        

        <!-- Migas de Pan -->
        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-inline shop-top-menu pb-3 pt-1">
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="#">Home</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none mr-3" href="#">Bloque1</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="h3 text-dark text-decoration-none" href="#">Bloque2</a>
                        </li>
                    </ul>
                </div>
                <!-- Cuadro de Mostrar por... -->
                <div class="col-md-6 pb-4">
                    <div class="d-flex">
                        <select class="form-control">
                            <option>Mostrar por...</option>
                            <option>Por Nombre</option>
                            <option>Por Precio</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

                
            <div class="row">
                    <!-- Card de Producto -->
                    <div class="col-md-4">
                        <div class="card mb-4 product-wap rounded-0">
                            <div class="card rounded-0">
                                <img class="card-img rounded-0 img-fluid" src="includes/imagenes/auriculares.jpg">
                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        <li><a class="btn btn-success text-white" href="favoritos.php"><i class="far fa-heart"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2" href="articulo.php"><i class="far fa-eye"></i></a></li>
                                        <li><a class="btn btn-success text-white mt-2" href="carrito.php"><i class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <a href="shop-single.html" class="h3 text-decoration-none">Nombre del articulo</a>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li>Código</li>
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
                                <p class="text-center mb-0">Precio €</p>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-2">
                <aside>
                    <div id="datosmostrados">
                        <div class="titulo">
                            <h1 style="color: purple;">Bienvenido a tu Espacio, <?php echo $nombre; ?></h1>
                        </div>
                        <div class="titulo2">
                            <h2>Estos son tus datos:</h2>
                        </div>
                        <?php if ($mensajeExito) : ?>
                        <div class="alert alert-success" role="alert">&#128588; Se han modificado los datos de forma correcta &#128588;</div>
                            <?php endif; ?>
                            <form method="POST" action="sesionusuario.php">
                                <div class="mb-3">
                                    <label for="dni" class="form-label">DNI:</label>
                                    <input type="text" id="dni" name="dni" class="form-control" value="<?php echo $dni; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono:</label>
                                    <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>" disabled>
                                </div>
                            </form>
                        </div>
                        <div class=aside2>
                            <div id="accionesusuario">
                                <h2>¿Qué deseas hacer?</h2>
                                <div id="autoeliminado" class="mb-3">
                                    <button class="btn btn-secondary w-100" type="button" onclick="eliminarUsuario()">Eliminar Datos</button>
                                </div>
                
                                <div id="automodificado" class="mb-3">
                                    <button class="btn btn-secondary w-100" type="button" onclick="modificarUsuario()">Modificar Datos</button>
                                </div>
                
                                <div id="addarticulos" class="mb-3">
                                    <button class="btn btn-secondary w-100" type="button" onclick="addArticulos()">Ver Articulos</button>
                                </div>
                
                                <div id="logout" class="mb-3">
                                    <button class="btn btn-dark w-100" type="button" onclick="logout()">Salir de la sesión</button>
                                </div>
                
                                <script>
                                    //Uso de funciones para redirigir a diferentes formularios con botones
                                    function eliminarUsuario() {
                                        window.location.href = "eliminarusuario.php?dni=";
                                    }
                
                                    function modificarUsuario() {
                                        window.location.href = "modificarusuario.php?dni=";
                                    }
                
                                    function addArticulos() {
                                        window.location.href = "articulosusuario.php?dni=";
                                    }
                
                                    function logout() {
                                        window.location.href = "logout.php";
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                <aside>
            </div>
        
            </div>

                <!-- Paginación -->
                <div div="row">
                    <ul class="pagination pagination-lg justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#">3</a>
                        </li>
                    </ul>
                </div>

    </div>
</div>
    <!-- Final del Cuerpo -->

    <!-- Start Brands -->
    <section class="bg-light py-5">
        <div class="container my-4">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Nuestras Marcas</h1>
                    <p>
                        Desde Vintage Music queremos ofrecerte la mejor calidad en nuestros productos, así que contamos con los mejores proveedores.
                    </p>
                </div>
                <div class="col-lg-9 m-auto tempaltemo-carousel">
                    <div class="row d-flex flex-row">
                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#multi-item-example" role="button" data-bs-slide="prev">
                                <i class="text-light fas fa-chevron-left"></i>
                            </a>
                        </div>
                        <!--End Controls-->

                        <!--Carousel Wrapper-->
                        <div class="col">
                            <div class="carousel slide carousel-multi-item pt-2 pt-md-0" id="multi-item-example" data-bs-ride="carousel">
                                <!--Slides-->
                                <div class="carousel-inner product-links-wap" role="listbox">

                                    <!--Primer Slide-->
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/gibson.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/ludwing.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/universal.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/marshall.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Fin del Primer Slide-->

                                    <!--Segundo Slide-->
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/gibson.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/ludwing.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/universal.png" alt="Brand Logo"></a>
                                            </div>
                                            <div class="col-3 p-md-5">
                                                <a href="#"><img class="img-fluid brand-img" src="includes/imagenes/marshall.png" alt="Brand Logo"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Fin del Segundo Slide-->
                                </div>
                                <!--End Slides-->
                            </div>
                        </div>
                        <!--End Carousel Wrapper-->

                        <!--Controls-->
                        <div class="col-1 align-self-center">
                            <a class="h1" href="#multi-item-example" role="button" data-bs-slide="next">
                                <i class="text-light fas fa-chevron-right"></i>
                            </a>
                        </div>
                        <!--End Controls-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Brands-->
    
    <?php
        include("includes/footer.php");
    ?>
