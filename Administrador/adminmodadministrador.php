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
    $js_jquery1 = "../includes/js/jquery-1.11.0.min.js";
    $js_jquery2 = "../includes/js/jquery-migrate-1.2.1.min.js";
    $js_bootstrap = "../includes/js/bootstrap.bundle.min.js";
    $js_templatemo = "../includes/js/templatemo.js";
    $js_custom = "../includes/js/custom.js";

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
                $hashedPassword = $usuarioSesion->getPassword();
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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmar"])) {
        $dniUsuario = $usuarioSesion->getDni();
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $nuevaPassword = $_POST["password"];

        // Verificar si se ha ingresado una nueva contraseña
        if (!empty($nuevaPassword)) {
            
            $hashedNuevaPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        } else {
            
            $hashedNuevaPassword = $hashedPassword;
        }

        // Modificar al usuario actual
        if (Usuario::modificarUsuario($dniUsuario, $nombre, $telefono, $email, $hashedNuevaPassword)) {
            // Redirige al usuario después de la modificación
            echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "adminmodadministrador.php?mensaje=exito"; }, 0);</script>';
        
            exit();
        } else {
            echo "Error al modificar el usuario.";
        }
    }


    $mensajeExito = isset($_GET['mensaje']) && $_GET['mensaje'] === 'exito';
?>

<body>
    <div class = "row">
        <div class="col-md-12 text-center">
            <?php if ($mensajeExito) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>&#128588; Éxito:</strong> Se han modificado los datos de forma correcta
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="contenedor" class="container mt-5">
        <div class = "row">
            <div class="col-md-12 text-center mb-5">
                <h1 style="color: purple;">Bienvenido a tu Espacio, <?php echo $nombre; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="datosmostrados">
                    
                    <div class="titulo2">
                        <h2>Datos registrados:</h2>
                    </div>
                    <form>
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" name="dni" class="form-control" value="<?php echo $dni; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" disabled>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div id="accionesadmin">
                    <div id="datosamodificar">
                    <div class="titulo2">
                        <h2>Estos son los datos que puedes modificar:</h2>
                    </div>
                </div>
                <form id="formularioModificar" method="POST" action="adminmodadministrador.php">
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" id="dni" name="dni" class="form-control" value="<?php echo $dni; ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmarModal">
                                Confirmar Cambios
                            </button>
                        </div>
                        <button type="submit" id="submitBtn" name='confirmar' value='Confirmar' style="display: none;"></button>
                    </form>
                    
                </div>
            </div>
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
                    <button type="button" class="btn btn-secondary col-12" onclick="window.location.href='sesionadministrador2.php'">
                        Ir a la página de usuario
                    </button>
                </div>
        </div>
    </div>

    <?php
        include("../includes/footer.php");
    ?>

<!-- Gestión de Formulario en JS-->
<script>
    function confirmarCambios() {
        // Obtener el formulario por su ID
        document.getElementById('submitBtn').click();
    }
</script>    

