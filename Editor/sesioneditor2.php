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

    // Comprobar si está autentificado
    if (!isset($_SESSION["usuario"]) || !$_SESSION["autentificado"]) {
        //echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "Pagina-Index.php"; }, 2000);</script>';
        exit();
    }
    //Obtenemos el dni con la funcion de la clase
    if (isset($_SESSION["usuario"])) {
        $usuario = $_SESSION["usuario"];
    
        // Utilizar la clase Usuario para obtener el DNI del usuario
        $dni = Usuario::obtenerDniPorUsuario($usuario->getUsuario());
    
        // Verificar si se obtuvo el DNI
        if ($dni) {
            // Utilizar la clase Usuario para obtener el objeto Usuario correspondiente al DNI
            $usuarioSesion = Usuario::obtenerUsuarioPorDNI($dni);
    
            // Verificar si se obtuvo un objeto Usuario
            if ($usuarioSesion) {
                // Obtener los valores del objeto Usuario
                $usuario = $usuarioSesion->getUsuario();
                $nombre = $usuarioSesion->getNombre();
                $telefono = $usuarioSesion->getTelefono();
                $email = $usuarioSesion->getEmail();
                $password = $usuarioSesion->getPassword();
            } else {
                // Rsultado en el caso en que no se encuentre el usuario
                echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">No se ha podido obtener el usuario</div>';
                exit();
            }
        } else {
            // Resultado si no se haya obtenido el DNI
            echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">Error: No se pudo obtener el DNI.</div>';
            exit();
        }
    } else {
        // Resultado si no se ha proporcionado el valor de usuario
        echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">Falta el valor de Usuario.</div>';
        exit();
    }
    $mensajeExito = isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito';
?>

<body>
    <div id="contenedor" class="container mt-5">
        <div class="row">
        <div class="col-md-6">
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
                    <form method="POST" action="sesioneditor2.php">
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
            </div>
            <div class="col-md-6">
                <div id="accioneseditor">
                    <h2>¿Qué deseas hacer?</h2>
                    <div id="autoeliminado" class="mb-3">
                        <button class="btn btn-secondary w-100" type="button" onclick="eliminarUsuario()">Eliminar Mis Datos</button>
                    </div>
    
                    <div id="automodificado" class="mb-3">
                        <button class="btn btn-secondary w-100" type="button" onclick="modificarUsuario()">Modificar Mis Datos</button>
                    </div>
    
                    <div id="addarticulos" class="mb-3">
                        <button class="btn btn-secondary w-100" type="button" onclick="volverAtras()">Volver al Espacio Principal</button>
                    </div>
    
                    <div id="logout" class="mb-3">
                        <button class="btn btn-dark w-100" type="button" onclick="logout()">Salir de la sesión</button>
                    </div>
    
                    <script>
                        //Uso de funciones para redirigir a diferentes formularios con botones
                        function eliminarUsuario() {
                            window.location.href = "eliminareditor.php?dni=";
                        }
    
                        function modificarUsuario() {
                            window.location.href = "modificareditor.php?dni=";
                        }
    
                        function volverAtras() {
                            window.location.href = "sesioneditor.php?dni=";
                        }
    
                        function logout() {
                            window.location.href = "../logout.php";
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        include("../includes/footer.php");
    ?>
</body>
