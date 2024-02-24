
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    session_start();

    $hoja_estilos = "./includes/css";
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
<div class="container py-5">
        <div class="row">
            
            <!-- Desplegable -->
            <div class="col-lg-3">
                <h1 class="h2 pb-4">Productos</h1>
                <ul class="list-unstyled templatemo-accordion">
                    <li class="pb-3">
                        <a id="link-vinilos" data-categoria="Vinilos" class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Vinilos
                            <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul class="collapse show list-unstyled pl-3">
                            <li><a data-subcategoria="Internacional" class="text-decoration-none" href="#">Internacional</a></li>
                            <li><a data-subcategoria="Nacional" class="text-decoration-none" href="#">Español</a></li>
                        </ul>
                    </li>
                    <li class="pb-3">
                        <a  id= "link-cassette" data-categoria="Cassette" class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Cassettes
                            <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                            <li><a data-subcategoria="Internacional" class="text-decoration-none" href="#">Internacional</a></li>
                            <li><a data-subcategoria="Nacional" class="text-decoration-none" href="#">Español</a></li>
                        </ul>
                    </li>
                    <li class="pb-3">
                        <a id="link-accesorios" data-categoria="Accesorios" class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                            Reproductores / Accesorios
                            <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                        </a>
                        <ul id="collapseThree" class="collapse list-unstyled pl-3">
                            <li><a data-subcategoria="Reproductores" class="text-decoration-none" href="#">Reproductores</a></li>
                            <li><a data-subcategoria="Accesorios" class="text-decoration-none" href="#">Accesorios</a></li>
                            <li><a data-subcategoria="Custom" class="text-decoration-none" href="#">Custom</a></li>
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
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">Todos los Articulos</a>
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
                            <select id="ordenarPor" class="form-control">
                                <option value="nombre_asc">Por Nombre (Ascendente)</option>
                                <option value="nombre_desc">Por Nombre (Descendente)</option>
                                <option value="precio_asc">Por Precio (Ascendente)</option>
                                <option value="precio_desc">Por Precio (Descendente)</option>
                            </select>
                            <button id="aplicarFiltro" class="btn btn-secondary ml-2">Aplicar</button>
                        </div>
                    </div>
                </div>
                <!-- Resultados de la consulta con paginación-->
                <div class="row" id="resultados">
                    <?php
                        // Conectar a la base de datos
                        include("db/conectar.php");
                        $conn = conectar_DB();

                        // Verificar la conexión
                        if (!$conn) {
                            die("Error en la conexión a la base de datos");
                        }

                        $productosPorPagina = 12;
                        $pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
                        $inicio = ($pagina - 1) * $productosPorPagina;

                        $categoriaSeleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';
                        
                        // Consulta SQL para obtener productos con paginación
                        $query = "SELECT * FROM articulos";

                        if (!empty($categoriaSeleccionada) && $categoriaSeleccionada !== 'todos') {
                            $query .= " WHERE categoria = :categoria";
                        }
                        $query .= " LIMIT :inicio, :productosPorPagina";

                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                        $stmt->bindParam(':productosPorPagina', $productosPorPagina, PDO::PARAM_INT);

                        if (!empty($categoriaSeleccionada) && $categoriaSeleccionada !== 'todos') {
                            $stmt->bindParam(':categoria', $categoriaSeleccionada, PDO::PARAM_STR);
                        }
                        
                        $stmt->execute();

                        // Mostrar resultados
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                // Recuperar datos del producto
                                $nombre = $row['nombre'];
                                $precio = $row['precio'];
                                $imagen = $row['imagen'];
                                $categoria = $row['categoria'];
                        
                                // Mostrar el producto
                                echo '<div class="col-md-4 product-wap" data-categoria="' . $categoria . '">';
                                echo '<div class="card mb-4 rounded-0">';
                                echo '<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-start justify-content-end">
                                            <ul class="list-unstyled">
                                                <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li>
                                                <li><a class="btn btn-success text-white mt-2" href="Tienda_Ind.php?cod_articulo=' . $row['cod_articulo'] . '" class="text-decoration-none"><i class="far fa-eye"></i></a></li>
                                                <li><a class="btn btn-success text-white mt-2" href="shop-single.html"><i class="fas fa-cart-plus"></i></a></li>
                                            </ul>
                                    </div>';
                                echo '<img class="card-img-top rounded-0 img-fluid" src="Editor/' . $imagen . '" alt="Product Image">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . $nombre . '</h5>';
                                echo '<p class="card-text">Precio: €' . $precio . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                
                            }
                        } else {
                            echo "No hay productos disponibles.";
                        }

                        // Cerrar la conexión a la base de datos
                        $conn = null;
                        ?>
                    </div>

                    <!-- Paginación -->
                    <?php
                    include("db/conectar.php");
                    $conn = conectar_DB();

                    // Consulta SQL para obtener el número total de productos
                    $queryTotal = "SELECT COUNT(*) as total FROM articulos";
                    $resultTotal = $conn->query($queryTotal);
                    $totalProductos = $resultTotal->fetch(PDO::FETCH_ASSOC)['total'];

                    // Calcular el número total de páginas
                    $totalPaginas = ceil($totalProductos / $productosPorPagina);

                    // Mostrar la paginación solo si hay más de una página
                    if ($totalPaginas > 1) {
                        echo '<div class="row">';
                        echo '<ul class="pagination pagination-lg justify-content-end">';

                        // Agregar enlaces "Anterior" y "Siguiente"
                        if ($pagina > 1) {
                            echo '<li class="page-item">';
                            echo '<a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="?pagina=' . ($pagina - 1) . '">Anterior</a>';
                            echo '</li>';
                        }

                        // Mostrar enlaces de paginación
                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            echo '<li class="page-item' . ($i == $pagina ? ' active disabled' : '') . '">';
                            echo '<a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="?pagina=' . $i . '">' . $i . '</a>';
                            echo '</li>';
                        }

                        // Enlace "Siguiente"
                        if ($pagina < $totalPaginas) {
                            echo '<li class="page-item">';
                            echo '<a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="?pagina=' . ($pagina + 1) . '">Siguiente</a>';
                            echo '</li>';
                        }

                        echo '</ul>';
                        echo '</div>';
                    }
                ?>
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
    <script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener todos los enlaces de categoría
            var categoryLinks = document.querySelectorAll('.templatemo-accordion a[data-categoria]');

            // Agregar controladores de eventos de clic a cada enlace de categoría
            categoryLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar que el enlace siga su comportamiento predeterminado

                    // Obtener la categoría del enlace
                    var categoria = this.dataset.categoria;

                    // Mostrar u ocultar productos basados en la categoría seleccionada
                    var productos = document.querySelectorAll('.product-wap');
                    productos.forEach(function(producto) {
                        if (categoria === 'todos' || producto.dataset.categoria === categoria) {
                            producto.style.display = 'block';
                        } else {
                            producto.style.display = 'none';
                        }
                    });
                });
            });
        });

    </script>
    <?php
        include("includes/footer.php");
    ?>
