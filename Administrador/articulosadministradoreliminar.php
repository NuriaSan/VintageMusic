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



// Obtiene el articulo a modificar desde la URL
    if (isset($_GET["cod_articulo"])) {
        $codigo_articulo = $_GET["cod_articulo"];
        
        $articulo = Articulo::obtenerArticuloPorCodigo($codigo_articulo);

        if ($articulo) {
            
                
            // Muestra los datos del articulo
            echo "<body style='text-align:center; display:block; justify-content: center; align-items: center; background-color: aliceblue;'>";
            echo "<h2 style='font-size: 35px;'>Confirmar Eliminación</h2>";
            echo "<p style= 'font-size:20px;'>¿Estás seguro de que deseas eliminar el articulo?</p>";
            echo "<div style='background-color:#3282b8'>";
            echo "<table border='0' style= 'width:100%; background-color:#3282b8; align-items: center; text-align:center;'>";
            echo "<tr>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Codigo</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Nombre</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Descripción</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Categoria</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Subcategoria</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Precio</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Imagen Ruta</th>
                    <th style='background-color:orange; font-size: 16px; height: 30px;'>Imagen</th>
                </tr>";
            echo "<tr>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$codigo_articulo}</td>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$articulo->getNombre()}</td>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$articulo->getDescripcion()}</td>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$articulo->getCategoria()}</td>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$articulo->getSubcategoria()}</td>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$articulo->getPrecio()}</td>";
            echo "<td style='background-color:white; font-size: 16px; height: 30px;'>{$articulo->getImagen()}</td>";
            echo "<td style='background-color:white; font-size: 16px; padding:15px; margin:15px;'>
                                    <img src='" . $articulo->getImagen() . "' alt='imagen' style='width: 250px; height: 250px; margin:0; padding: 0;'>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
            echo "</body>";
            echo "<br>";            
                
            // Confirmación de eliminación
            echo "<form action='articulosadministradoreliminar.php' method='post'>";
            echo "<input type='hidden' name='codigo' value='{$codigo_articulo}'>";
            echo "<input type='submit' name='confirmar' style='font-family:Courier New, Courier, monospace;font-size: 18px; height: 40px; width: 250px; margin-right: 20px; border-radius: 8px; background-color: #3282b8; border: none; color: white;' value='Sí, Eliminar'>";
            echo "<button type='button' style='font-family:Courier New, Courier, monospace; font-size: 18px; height: 40px; width: 250px; border-radius: 8px; background-color: #3282b8; border:none; color: white;' onclick='history.back()'>No, Volver Atrás</button>";
            echo "</form>";
            echo "</body>";
            echo "<br>";

                        
        } 
    
} elseif (isset($_POST['confirmar'])) {
    // Confirmación de eliminación
    $codigo_articulo = $_POST['codigo'];

    
    // Elimina el artículo con el código proporcionado
    $resultado = Articulo::eliminarArticulo($codigo_articulo);

    if ($resultado) {
        // Redirige al usuario después de la eliminación
        echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "registroarticulosadministrador.php?mensaje=eliminado"; }, 0);</script>';
        exit();
    } else {
        echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">Error al eliminar el artículo.</div>';
        header("refresh:3;url=registroarticulos.php");
        exit();
    }

}
?>

    
<?php
    include("../includes/footer.php");
?>