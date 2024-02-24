<?php
    include("../includes/Clases/claseUsuario.php");
    include_once ("../includes/funciones-comunes.php");
    include_once ("../includes/Clases/claseArticulo.php"); 
    session_start();

    $hoja_estilos = "../includes/css2/estilos.css";
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

    include ("../includes/head.php");
    include ("../includes/nav.php");
    include("../includes/seguridad.php");
    include_once("../db/conectar.php");

    $mensajeExito = isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito';
    $mensajeEliminado = isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado';
?>

<body class="text-center" style="background-color: aliceblue;">
    <?php if ($mensajeExito) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&#128588; Éxito:</strong> Se han modificado los datos de forma correcta
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($mensajeEliminado) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>&#128588; Éxito:</strong> Se ha eliminado el artículo correctamente
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h1 class="mt-5">Sesión de Editor</h1>
    <h2 class="text-purple">Bienvenido a tu Espacio, <?php echo $titulo_login; ?></h2>

    <div class="container mt-5 text-center">
        <form action="registroarticulos.php" method="get">
            <div class="acciones d-flex justify-content-between mt-5">
                <div id="botonAgregar">
                    <a class="btn btn-primary" href="formularioarticulos.php">Agregar Articulo</a>
                </div>
                <div id="botonAtras">
                    <a class="btn btn-secondary" href="sesioneditor.php">Volver a la Sesión Principal</a>
                </div>
                <div id="logout">
                    <a class="btn btn-dark" href="../logout.php">Salir de la sesión</a>
                </div>
            </div>

            <h2 class="mt-4">Articulos Disponibles</h2>

            <div class="ordenacion_nombre mt-4">
                <p>Ordenar:</p>
                <!-- Ordenación con enlaces -->
                <a href="registroarticulos.php?sort=nombre_asc" class="btn btn-link">Nombre Ascendente ▲</a>
                <a href="registroarticulos.php?sort=nombre_desc" class="btn btn-link">Nombre Descendente ▼</a>
            </div>

            <div class="buscar mt-4">
                <p>Buscar:</p>
                <input type="text" name="busqueda" placeholder="Buscar en articulos" class="form-control mb-2">
                <button type="submit" name="submit_busqueda" class="btn btn-primary">Buscar</button>
            </div>

            <input type='button' value='Volver' onclick='history.back()' class="btn btn-secondary mt-4">

                <table class="table table-striped mt-4">
                    <tr>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Codigo</th>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Nombre</th>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Descripción</th>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Categoria</th>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Subcategoria</th>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Precio</th>
                        <th style="background-color:white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px">Imagen</th>
                        <th style="background-color: #3282b8; color: white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Modificar</th>
                        <th style="background-color: #3282b8; color: white; font-size: 16px; padding:15px; margin:15px; border-radius: 5px;">Borrar</th>
                    </tr>
                
                    <?php
                        //Controla si se ha iniciado la sesión anteriormente
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        include("../db/conectar.php");
    
                        
                        $conn = conectar_DB();  

                        if (!$conn) {
                            die("Error al conectar a la base de datos");
                        }

                        $articulosPorPagina = 3;
                        $pagina = 1;
                        $inicio = 0;

                        if(isset($_GET["pagina"])){
                            $pagina = $_GET["pagina"];
                            $inicio = ($pagina - 1) * $articulosPorPagina;
                        }

                        try{ 
                            // Paginación y ordenacion
                            $stmt = $conn->prepare("SELECT * FROM articulos");
                            $stmt->execute();
                            $totalArticulos = $stmt->rowCount();
                            $totalPaginas = ceil($totalArticulos / $articulosPorPagina);
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
                            $stmt->bindParam(':articulosPorPagina', $articulosPorPagina, PDO::PARAM_INT);
                            $stmt->execute();
                        

                            while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>" . $datos["cod_articulo"] . "</td>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>" . $datos["nombre"] . "</td>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>" . $datos["descripcion"] . "</td>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>" . $datos["categoria"] . "</td>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>" . $datos["subcategoria"] . "</td>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>" . $datos["precio"] . '€' ."</td>
                                        <td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>
                                            <img src='" . $datos["imagen"] . "' alt='imagen' style='width: 250px; height: 250px; margin:0; padding: 0;'>
                                        <td style='background-color:white; font-size: 24px; padding: 20px;'><a href='articuloseditormodificar.php?cod_articulo=" . $datos["cod_articulo"] . "'>&#128221;</a></td>
                                        <td style='background-color:white; font-size: 24px; padding: 20px;'><a href='articuloseditoreliminar.php?cod_articulo=" . $datos["cod_articulo"] . "'>&#10060;</a></td>
                                        </td>
                                    </tr>";
                            }
                        
                            echo "</div>";
                        } catch(PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                    ?>
                </table>
                <div class="paginacion mt-4">
                    <ul class="pagination">
                        <?php
                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                $claseActiva = ($i == $pagina) ? 'active' : '';
                                echo "<li class='page-item $claseActiva'><a class='page-link' href='registroarticulos.php?pagina=" . $i . "'>$i</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </form>
        </div>
        
    </body>


    
<?php
    include("../includes/footer.php");
?>
