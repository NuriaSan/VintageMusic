<?php
    include("../includes/Clases/claseUsuario.php");

    session_start();
    include_once ("../includes/funciones-comunes.php");

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
    include ("../includes/head.php");
    include ("../includes/nav.php");
?>
<?php
    include("../db/conectar.php");
    
    include("../includes/seguridad.php");

// Obtiene el usuario a modificar desde la URL
if (isset($_GET["dni"])) {
    $dni = $_GET["dni"];
    
    // Utiliza la clase Usuario para obtener el objeto Usuario correspondiente al DNI
    $usuarioSesion = Usuario::obtenerUsuarioPorDNI($dni);

    // Verifica si se obtuvo un objeto Usuario
    if ($usuarioSesion) {
        // Obtiene los valores del objeto Usuario
        $dni = $usuarioSesion->getDni();
        $nombre = $usuarioSesion->getNombre();
        $telefono = $usuarioSesion->getTelefono();
        $email = $usuarioSesion->getEmail();
        
    } else {
        // Maneja el caso en que no se encuentre el usuario
        echo "Error: No se pudo obtener el usuario.";
        exit();
    }
} else {
    // Maneja el caso en que no se haya proporcionado un valor de usuario en la URL
    echo "Error: Falta el valor de usuario.";
    exit();
}

// Obtiene el usuario a modificar desde la URL
if (isset($_GET["dni"])) {
    $dni = $_GET["dni"];
    
    // Utiliza la clase Usuario para obtener el objeto Usuario correspondiente al DNI
    $usuarioSesion = Usuario::obtenerUsuarioPorDNI($dni);

    // Verifica si se obtuvo un objeto Usuario
    if ($usuarioSesion) {
        // Obtiene los valores del objeto Usuario
        $dni = $usuarioSesion->getDni();
        $nombre = $usuarioSesion->getNombre();
        $telefono = $usuarioSesion->getTelefono();
        $email = $usuarioSesion->getEmail();
        
    } else {
        // Maneja el caso en que no se encuentre el usuario
        echo "Error: No se pudo obtener el usuario.";
        exit();
    }
} else {
    // Maneja el caso en que no se haya proporcionado un valor de usuario en la URL
    echo "Error: Falta el valor de usuario.";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar"])) {
    $dni = $_GET["dni"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $nuevaPassword = $_POST["password"];
    
    // Verificar si se ha ingresado una nueva contraseña
    $hashedNuevaPassword = !empty($nuevaPassword) ? password_hash($nuevaPassword, PASSWORD_DEFAULT) : null;

    // Modificar al usuario actual
    if (Usuario::modificarUsuario($dni, $nombre, $telefono, $email, $hashedNuevaPassword)) {
        // Redirige al usuario después de la modificación
        echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "mantenimientousuarios.php?mensaje=exito"; }, 0);</script>';
        exit();
    } else {
        echo "Error al modificar el usuario.";
    }
}
?>
<body style="font-family:'Courier New', Courier, monospace; color: #1b262c; margin: 0;">
        <div id="contenedor"style="width: 100%">
            <div class="titulo" style="text-align:center; color:blue">
                <h2>Sesión para Actualizar los Datos de Usuario</h2>
            </div>
            <div class="formulario" style="width: 30%; margin: auto; padding: 20px 30px; background-color: #c8e0f0; text-align: left; border-radius: 5px;">
                <form method="POST" action="administradormodificar.php?dni=<?php echo $dni; ?>">
                    <label for="dni">Dni:</label>
                    <input type="text" name="dni" style="font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $dni; ?>" disabled><br><br>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $nombre; ?>"><br><br>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $telefono; ?>"><br><br>
                    <label for="email">Email:</label>
                    <input type="text" name="email" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $email; ?>"><br><br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" style="border: none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" value="<?php echo $password; ?>"><br><br>
                    <input type='submit' name='confirmar'  style="border: none; background-color: #3282b8; color: white; font-size: 16px; height: 50px; border-radius: 5px; width: 100%;" value='Confirmar'><br><br>
                    <input type='button' value='Volver' style="border:none;background-color: #3282b8; color: white; font-size: 16px; height: 50px; border-radius: 5px; width: 100%;" onclick='history.back()'>
                </form>
            </div>
        </div>
        <!-- Bloque de Confirmación--> 
    <div class="modal fade" id="confirmarModal" tabindex="-1" aria-labelledby="confirmarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarModalLabel">Confirmar Cambios</h5>
                    <button type="submit" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas realizar estos cambios?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" onclick="confirmarCambios()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
                <div class="col-md-12 mt-5 text-center align-self-center">
                    <button type="button" class="btn btn-secondary col-12" onclick="window.location.href='mantenimientousuarios.php'">
                        Ir a la página de usuario
                    </button>
                </div>
        </div>
    </div>
    <?php
        include("../includes/footer.php");
    ?>