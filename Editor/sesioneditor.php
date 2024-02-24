<?php
    include("../includes/Clases/claseUsuario.php");

    session_start();
    include_once ("../includes/funciones-comunes.php");
    include_once ("../includes/Clases/claseArticulo.php"); 

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
    <div id="contenedor" class="container mt-12">
        <div class="row">
        <div class="col-md-12">
                <div id="datosmostrados">
                    <div class="titulo">
                        <h1 style="color: purple;">Bienvenido a tu Espacio, <?php echo $nombre; ?></h1>
                    </div>
                    
                    <h2>¿Qué deseas hacer?</h2>
                    <div id="verdatos" class="mb-3">
                        <button class="btn btn-secondary w-100" type="button" onclick="verUsuario()">Ver Mis Datos</button>
                    </div>
                    <div id="espacioeditor" class="mb-3">
                        <button class="btn btn-secondary w-100" type="button" onclick="registroArticulos()">Gestión de Articulos</button>
                    </div>
                    <div id="salir" class="mb-3">
                        <button class="btn btn-dark w-100" type="button" onclick="logout()">Salir de la Sesión</button>
                    </div>
    
                    <script>
                        //Uso de funciones para redirigir a diferentes formularios con botones
                        function verUsuario() {
                            window.location.href = "sesioneditor2.php?dni=";
                        }
    
                        function registroArticulos() {
                            window.location.href = "registroArticulos.php?dni=";
                        }
    
    
                        function logout() {
                            window.location.href = "../logout.php";
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>    
    <?php
        include("../includes/footer.php");
    ?>

