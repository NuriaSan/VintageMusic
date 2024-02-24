<?php
include("../includes/Clases/claseUsuario.php");

session_start();
include_once("../includes/funciones-comunes.php");

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
$titulo_login = isset($_SESSION["usuario"]) ? $_SESSION["usuario"]->getUsuario() : "Log In";

include("../includes/head.php");
include("../includes/nav.php");

include("../db/conectar.php");
include("../includes/seguridad.php");
?>


<?php

$nombre = "";

if (isset($_SESSION["usuario"])) {
    $sesionAdmin = $_SESSION["usuario"];
}
// Obtiene el usuario a eliminar desde la URL
if (isset($_GET["dni"])) {
    $dni = $_GET["dni"];
    
    // Utiliza la clase Usuario para obtener el objeto Usuario correspondiente al DNI
    $usuariofila = Usuario::obtenerUsuarioPorDNI($dni);

    // Verifica si se obtuvo un objeto Usuario
    if ($usuariofila) {
        // Obtiene los valores del objeto Usuario
        $dniusu = $usuariofila->getDni();
        $usuario = $usuariofila->getUsuario();
        $nombre = $usuariofila->getNombre();
        $telefono = $usuariofila->getTelefono();
        $email = $usuariofila->getEmail();
        $password = $usuariofila->getPassword();

    } else {
        // Rsultado en el caso en que no se encuentre el usuario
        echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">No se ha podido obtener el usuario</div>';
        exit();
    }
} else {
    // Resultado si no se haya obtenido el DNI
    echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">Error: No se pudo obtener el DNI del Cliente.</div>';
}


$mensajeExito = isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito';



    if (isset($_POST['confirmacionForm'])){
            
        
        Usuario::eliminarUsuario($dniusu);
        echo '<div style="color: green; text-align: center; font-size: 30px; margin-top: 50px;">Usuario eliminado correctamente</div>';

        //pasar dato de dni a eliminar por la url xq no encuentra $dni al actualizar el form
            
            echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "mantenimientousuarios.php?mensaje=eliminado"; }, 3000);</script>';
            exit();
    
    }
    

?>


<body>
    <div id="contenedor" class="container text-center">
        <div class = "row">
            <div class="col-md-12 text-center mb-5">
                <h1 style="color: purple;">Esta intentando eliminar al Usuario:  <?php echo $nombre; ?></h1>
                <p>Si confirma la eliminación del usuario perderá todos sus datos</p>
            </div>
        </div>
        <form id="confirmacionForm" method="POST" action="administradoreliminar.php">
            <input type="hidden" name="dni" value="<?php echo $dniusu; ?>">
            <button type="button" id="confirmarEliminar" class="btn btn-danger">Confirmar Eliminación</button>
        </form>
    </div>
    <script>
        document.getElementById('confirmarEliminar').addEventListener('click', function() {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario? Si acepta no podrá recuperar los datos.')) {
                document.getElementById('confirmacionForm').submit();
            }
        });
    </script>

<?php
include("../includes/footer.php");
?>
</html>

