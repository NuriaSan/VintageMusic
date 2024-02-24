
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
        $nuevoPassword = $_POST["nuevopassword"];
        $confirmarPasword = $_POST["confirmarpassword"];

        

        // Verifica si las contraseñas coinciden
        if ($nuevoPassword != $confirmarPasword) {
            mostrarError("Las contraseñas no coinciden. Vuelve a intentarlo.");
            exit();
        }

        // Obtiene el objeto Usuario desde la base de datos
        $usuarioSesion = Usuario::obtenerUsuarioPorDNI($dni);

        if ($usuarioSesion && $usuarioSesion->getEmail() == $email) {
            // Actualiza la contraseña en la base de datos
            $usuarioSesion->actualizarPassword($nuevoPassword); 

            // Muestra mensaje de éxito y elimina los datos
            session_destroy();
            mostrarExito("Contraseña modificada correctamente. Serás redirigido al login para iniciar sesión");
            echo   " <script>
                // Redirigir a login.php después de 3 segundos usando JavaScript
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 3000);
                </script>";

        } else {
            // Muestra mensaje de error si el usuario no coincide
            mostrarError("No se pudo modificar la contraseña. Verifica tu DNI y correo electrónico.");
        }
    } else {
        // Recupera los parámetros del DNI y el correo electrónico de la URL
        $dni = $_GET['dni'];
        $email = $_GET['email'];

        // Formulario para la nueva contraseña
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title> Modificar Contraseña </title>
            <style>
                body {
                    text-align: center;
                    margin-top: 50px;
                    background-color: aliceblue;
                }

                h2 {
                    font-size: 24px;
                }

                form {
                    width: 50%;
                    margin: auto;
                    text-align: center;
                }

                label {
                    font-size: 16px;
                }

                input {
                    padding: 8px;
                    width: 30%;
                    font-size: 16px;
                    border-radius: 5px;
                    margin-bottom: 10px;
                }

                button {
                    width: 50%;
                    padding: 10px 20px;
                    font-size: 16px;
                    background-color: #3282b8;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                button:hover {
                    background-color:gray;
                }
            </style>
        </head>
        <body style="text-align: center; margin-top: 50px;">
            <h2>Modificar Contraseña</h2>
            <form action="nuevoPassword.php" method="POST">
                <label for="nuevopassword">Nueva Contraseña:</label>
                <input type="password" name="nuevopassword" required><br><br>

                <label for="confirmarpassword">Confirmar Contraseña:</label>
                <input type="password" name="confirmarpassword" required><br><br>

                <input type="hidden" name="dni" value="' . $dni . '">
                <input type="hidden" name="email" value="' . $email . '">

                <button type="submit">Cambiar Contraseña</button>
            </form>
        </body>
        </html>';
    }
?>
    
    <?php
        include("includes/footer.php");
    ?>