
<?php
    include_once("db/conectar.php");
    session_start();


    include_once ("includes/funciones-comunes.php");

    $hoja_estilos = "./includes/css2/estilos1.css";
    $titulo_pagina = "Vintage Music";
    $pagina_keywords = "discos, vinilos, cassettes, discografías, musica, grupos, cantante, accesorios, reproductores";
    $pagina_descripcion = "Encuentra lo último en música. En nuestra tienda online encontrarás una gran variedad de estilos musicales y novedades discográficas. Are you Ready?";
    $url_logo = "includes/imagenes/logo-empresa.jpg";
    $icono_empresa = "includes/imagenes/icono-empresa.ico";
    $bootstrap = "includes/css/bootstrap.min.css";
    $templatemo = "includes/css/templatemo.css";
    $fontawesome = "includes/css/fontawesome.min.css";

    $pagina_index = "Pagina-Index.php";
    $pagina_tienda = "PaginaTienda.php";
    $pagina_contacto = "contacto.php";
?>

<?php
    include ("includes/head.php");
    include ("includes/nav.php");
    include("includes/Clases/claseUsuario.php");


function mostrarError($mensaje)
{
    echo '<div style="color: red; text-align: center; font-size: 16px; margin-top: 10px;">' . $mensaje . '</div>';
}

// Función para mostrar mensajes de éxito
function mostrarExito($mensaje)
{
    echo '<div style="color: green; text-align: center; font-size: 16px; margin-top: 10px;">' . $mensaje . '</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $email = $_POST["email"];

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



    if ($usuarioSesion && $usuarioSesion->getEmail() == $email) {

        //Verificar que el usuario se ha autentificado para controlar la seguridad
    
        $_SESSION["autentificado"] = true;

        //Acciones en caso de encontrar el usuario y contraseña
        mostrarExito("Usuario encontrado. Puedes restablecer tu contraseña.");
        //Redirigir a la pagina de modificación de contraseña
        echo "<script>window.location.href = 'nuevoPassword.php?dni=" . urlencode($dni) . "&email=" . urlencode($email) . "';</script>";
    } else {
        mostrarError("Usuario no encontrado. Verifica tu DNI y correo electrónico.");
    }
}
?>

<body>

    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <div>
                    <h2 class="mb-4">Obtener Contraseña</h2>
                    <form action="recuperarpassword.php" method="POST">
                        <div class="mb-3">
                            <input type="text" name="dni" class="form-control" placeholder="DNI" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-3">Obtener Contraseña</button>
                        <div id="volver">
                            <button type="button" onclick="volver()" class="btn btn-secondary">
                                Volver Atrás
                            </button>
                        </div>
                        <script>
                            function volver() {
                                window.location.href = "login.php";
                            }
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
    
    <?php
        include("includes/footer.php");
    ?>