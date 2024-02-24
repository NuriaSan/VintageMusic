
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

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'nombre_asc';
    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

    $ruta = "";

    if (isset($_SESSION["usuario"])) {
        $titulo_login = $_SESSION["usuario"]->getUsuario();
    } else {
        $titulo_login = "Registrate";
    }
    if(isset($_SESSION['carrito'])){
        $total_articulos = count($_SESSION['carrito']);
        $precio_total = 0;
        
        }else {
            $_SESSION['carrito']= array();
            $titulo_carrito = "(0)";
        }
    

    include ("includes/head.php");
    include ("includes/nav.php");
    include_once ("db/conectar.php");
    
?>

<!-- Contenido del Cuerpo -->
<div class="container py-5">
        <div class="row">
            <div class="col-3 d-flex flex-column">

                <!-- Desplegable -->
                <div id="accordionContainer" class="col-lg-12">
                    <div class ="desplegable">
                        <h1 class="h2 pb-4">Productos</h1>
                        <ul class="list-unstyled templatemo-accordion">
                            <li class="pb-3">
                                <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="mostrar_categorias1.php?cat=Vinilos">
                                    Vinilos
                                    <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                                </a>
                                <ul class="collapse show list-unstyled pl-3">
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=V-Internacional">Internacional</a></li>
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=V-Nacional">Español</a></li>
                                </ul>
                            </li>
                            <li class="pb-3">
                                <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="mostrar_categorias1.php?cat=Cassette">
                                    Cassettes
                                    <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                                </a>
                                <ul id="collapseTwo" class="collapse list-unstyled pl-3">
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=Internacional">Internacional</a></li>
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=Nacional">Español</a></li>
                                </ul>
                            </li>
                            <li class="pb-3">
                                <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="mostrar_categorias1.php?cat=Accesorios">
                                    Reproductores / Accesorios
                                    <i class="pull-right fa fa-fw fa-chevron-circle-down mt-1"></i>
                                </a>
                                <ul id="collapseThree" class="collapse list-unstyled pl-3">
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=Reproductores">Reproductores</a></li>
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=Accesorios">Accesorios</a></li>
                                    <li><a class="text-decoration-none" href="mostrar_categorias1.php?subcat=Custom">Custom</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    

                </div>

                <div class="col-lg-12">
                    <aside class="menu-usuario">
                        <div class="card">
                            <div class="card-header d-flex flex-column align-items-center">
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
                                <div class="d-flex flex-column align-items-center">
                                    <div class="d-grid h-1 gap-4">
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
                    </aside>
                </div>
            </div>
            <!-- Cuerpo Tienda -->
        
            <div class="col-lg-9">
                <div class="row">
                    <!-- Cuadro de Mostrar por... -->
                    <div class="ordenacion_nombre col-6 d-flex justify-content-start align-items-center">
                        <!-- Ordenación con enlaces -->
                        <a href="PaginaTienda.php?sort=nombre_asc" class="btn btn-outline-secondary m-3" style="text-decoration: none;">Nombre Ascendente ▲</a>
                        <a href="PaginaTienda.php?sort=nombre_desc" class="btn btn-outline-secondary" style="text-decoration: none;">Nombre Descendente ▼</a>
                    </div>

                    <div class="col-6 d-flex justify-content-end align-items-center">
                        <form action="PaginaTienda.php" method="GET" class="buscar">
                            <div class="input-group">
                                <input type="text" name="busqueda" placeholder="Buscar en articulos" class="form-control-lg mx-2">
                                <div class="input-group-append">
                                    <button type="submit" name="submit_busqueda" class="btn btn-outline-secondary btn-lg">Buscar</button>
                                </div>
                            </div>
                        </form>
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
                        $pagina = 1;
                        $inicio = 0;

                        if(isset($_GET["pagina"])){
                            $pagina = $_GET["pagina"];
                            $inicio = ($pagina - 1) * $productosPorPagina;
                        }

                        try {
                            
                            // Paginación y ordenacion
                                $stmt = $conn->prepare("SELECT * FROM articulos");
                                $stmt->execute();
                                $totalArticulos = $stmt->rowCount();
                                $totalPaginas = ceil($totalArticulos / $productosPorPagina);
                                $stmt = $conn->prepare("SELECT * FROM articulos LIMIT :inicio, :articulosPorPagina");

                            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'nombre_asc';
                            $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

                            switch ($sort) {
                                case 'nombre_asc':
                                    $consulta = "SELECT * FROM articulos WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda ORDER BY nombre ASC LIMIT :inicio, :articulosPorPagina";
                                    break;
                                case 'nombre_desc':
                                    $consulta = "SELECT * FROM articulos WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda ORDER BY nombre DESC LIMIT :inicio, :articulosPorPagina";
                                    break;
                                default:
                                    $consulta = "SELECT * FROM articulos WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda LIMIT :inicio, :articulosPorPagina";
                            }


                            $stmt = $conn->prepare($consulta);
                            $stmt->bindValue(':busqueda', '%' . $busqueda . '%', PDO::PARAM_STR);
                            $stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
                            $stmt->bindParam(':articulosPorPagina', $productosPorPagina, PDO::PARAM_INT);

                            $stmt->execute();

                            // Mostrar resultados
                        
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                // Recuperar datos del producto
                                $cod_articulo = $row['cod_articulo'];
                                $nombre = $row['nombre'];
                                $precio = $row['precio'];
                                $descripcion = $row['descripcion'];
                                $categoria = $row['categoria'];
                                $subcategoria = $row['subcategoria'];
                                $imagen = $row['imagen'];

                                // Mostrar tarjeta de producto con los datos recuperados
                                
                                echo '<div class="col-md-4" id="resultados">';
                                
                                echo '<div class="card mb-4 product-wap rounded-0">';
                                echo '<div class="card rounded-0">';
                                
                                echo '<img class="card-img rounded-0 img-fluid" src="Editor/' . $imagen . '"style="height: 200px; object-fit: cover;">';
                                echo '<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">';
                                echo '<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-start justify-content-end">';
                                            echo '<ul class="list-unstyled">';
                                                echo '<li>';
                                                    echo '<form id="like_articulo" name="like_articulo" method="POST" action="likecarrito.php?cod_articulo=' . $cod_articulo . '">';
                                                        echo '<input name="cod_articulo" type="hidden" id="cod_articulo" value='. $cod_articulo .'>';
                                                        echo '<input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2">';
                                                        echo '<a class="btn btn-success text-white" href="likecarrito.php?cod_articulo=' . $cod_articulo . '" class="text-decoration-none"><i class="far fa-heart"></i></a>';
                                                    echo '</form>';
                                                echo '</li>';
                                                echo '<li><a class="btn btn-success text-white mt-2" href="Tienda_Ind.php?cod_articulo=' . $cod_articulo . '" class="text-decoration-none"><i class="far fa-eye"></i></a></li>';
                                                echo '<li>';
                                                    echo '<form id="formulario_articulo" name="formulario_articulo" method="POST" action="VerCarta.php">';
                                                        echo '<input name="cod_articulo" type="hidden" id="cod_articulo" value='. $cod_articulo .'>';
                                                        echo '<input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2">';
                                                        echo '<a class="btn btn-success text-white mt-2" href="VerCarta.php?cod_articulo=' . $cod_articulo . '" class="text-decoration-none"><i class="fas fa-cart-plus"></i></a>';
                                                    echo '</form>';
                                                echo '</li>';
                                            echo '</ul>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="card-body">';
                                echo '<a href="#" class="h3 text-decoration-none">' . $nombre . '</a>';
                                echo '<p class="text-center mb-0" style="font-weight: bold; font-size: 1.2em;">Precio: €' . $precio . '</p>';
                                //echo '<p class="text-center mb-0">Código: ' . $row['cod_articulo'] . '</p>';
                                //echo '<p class="text-center mb-0">Categoria: ' . $categoria . '</p>';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</a>';
                            }
                        } catch(PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
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
    <script>
    $(document).ready(function() {
        // Manejar clic en las categorías o subcategorías
        $('#accordionContainer').on('click', 'a', function(event) {
            event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
            var url = $(this).attr('href'); // Obtener la URL del enlace
            cargarArticulos(url); // Cargar los artículos correspondientes a la categoría o subcategoría
        });

        // Función para cargar los artículos utilizando AJAX
        function cargarArticulos(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html',
                success: function(data) {
                    $('#resultados').html(data); // Insertar los resultados en el contenedor de resultados
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Manejar errores si los hay
                }
            });
        }
    });
</script>

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
