<?php
    // Conectar a la base de datos
    include("db/conectar.php");
    $conn = conectar_DB();

    // Obtener los parámetros de la solicitud GET
    $categoria = isset($_GET['cat']) ? $_GET['cat'] : '';
    $subcategoria = isset($_GET['subcat']) ? $_GET['subcat'] : '';

    // Construir la consulta SQL para seleccionar los artículos correspondientes
    $consulta = "SELECT * FROM articulos WHERE 1=1"; 

    if (!empty($categoria)) {
        $consulta .= " AND categoria = :categoria";
    }

    if (!empty($subcategoria)) {
        $consulta .= " AND subcategoria = :subcategoria";
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($consulta);

    if (!empty($categoria)) {
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    }

    if (!empty($subcategoria)) {
        $stmt->bindParam(':subcategoria', $subcategoria, PDO::PARAM_STR);
    }

    $stmt->execute();

    // Mostrar los resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                                                    echo '<form id="like_articulo" name="like_articulo" method="POST" action="likecarrito.php">';
                                                        echo '<input name="cod_articulo" type="hidden" id="cod_articulo" value='. $cod_articulo .'>';
                                                        echo '<input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2">';
                                                        echo '<a class="btn btn-success text-white" href="likecarrito.php?cod_articulo=' . $cod_articulo . '" class="text-decoration-none"><i class="far fa-heart"></i></a>';
                                                    echo '</form>';
                                                echo '</li>';
                                                echo '<li><a class="btn btn-success text-white mt-2" href="Tienda_Ind.php?cod_articulo=' . $cod_articulo . '" class="text-decoration-none"><i class="far fa-eye"></i></a></li>';
                                                echo '<li>';
                                                    echo '<form id="formulario_articulo" name="formulario_articulo" method="POST" action="verCarta.php">';
                                                        echo '<input name="cod_articulo" type="hidden" id="cod_articulo" value='. $cod_articulo .'>';
                                                        echo '<input name="cantidad" type="hidden" id="cantidad" value="1" class="pl-2">';
                                                        echo '<a class="btn btn-success text-white mt-2" href="verCarta.php?cod_articulo=' . $cod_articulo . '" class="text-decoration-none"><i class="fas fa-cart-plus"></i></a>';
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

    // Cerrar la conexión a la base de datos
    $conn = null;
?>
