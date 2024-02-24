
<?php
    session_start();
    include_once ("includes/funciones-comunes.php");

    $hoja_estilos = "includes/css2/estilos1.css";
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
    include_once ("db/conectar.php");
?>
<?php
    
    include("includes/Clases/claseUsuario.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $dni = $_POST["dni"];
        $usuario = $_POST["usuario"];
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $admin = $_POST["admin"];
        $edit = $_POST["edit"];

        //Validación del DNI

            //Comprobar números y la tletra
        $numeros = substr($dni, 0, -1);
        $letra = substr($dni, -1);


            //Cambiar letra a mayúscula
        $dni_mayuscula = strtoupper($dni);

            //Comprobar que la letra corresponde con los números
        function validacion_dni($dni){
            $dni_mayuscula = strtoupper($dni);
            $letra = substr($dni_mayuscula, -1);
            $numeros = substr($dni, 0, -1);

            if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8){

                return true;
            }
            else {
                echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">DNI no válido.</div>';
                return false;
            }
        }

        //Función de validación de teléfono
        function validarTelefono($telefono) {
            // Utilizar una expresión regular para verificar que el teléfono sea numérico
            if (preg_match('/^[0-9]+$/', $telefono)) {
                // El teléfono es correcto
                return true;
            } else {
                // El teléfono no es válido
                return false;
            }
        }

        if (validacion_dni($dni) && validarTelefono($telefono)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            if (Usuario::registrarUsuario($dni, $usuario, $nombre, $telefono, $email, $hashedPassword, $admin, $edit)) {
                // Almacenar en variables de sesión
                $_SESSION["dni"] = $dni;
                $_SESSION["usuario"] = $usuario;
                $_SESSION["nombre"] = $nombre;
                $_SESSION["telefono"] = $telefono;
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $hashedPassword;
                $_SESSION["admin"] = $admin;
                $_SESSION["edit"] = $edit;

                echo '<div class="alert alert-success text-center" role="alert" style="font-size: 30px; margin-top: 50px;">
                            Usuario registrado con éxito.
                        </div>';
                echo '<meta http-equiv="refresh" content="2;url=login.php">';
                exit;
            } else {
                echo '<div style="color: red; text-align: center; font-size: 30px; margin-top: 50px;">No se ha podido registrar el usuario correctamente.</div>';
            }
        }
    }        
?>

<body style="font-family:'Courier New', Courier, monospace; color: #1b262c; margin: 0;">
        <div id="contenedor" style="width: 100%">
            <div id="formularionu" style="width: 30%; margin: 20px auto; padding: 20px 30px; background-color:#EEEEEE ; text-align: center; border-radius: 5px;">
                <h2>Datos de nuevo Usuario</h2>
                <form method="POST" action="nuevousuario.php" style="margin:40px; text-align:center;">
                    <input type="text" name="dni" placeholder="Dni" style="border:none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" required><br><br>
                    <input type="text" name="usuario" placeholder="Usuario" style="border:none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" required><br><br>
                    <input type="text" name="nombre" placeholder="Nombre" style="border:none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" required><br><br>
                    <input type="text" name="telefono" placeholder="Teléfono" style="border:none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" required><br><br>
                    <input type="email" name="email" placeholder="Email" style="border:none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" required><br><br>
                    <input type="password" name="password" placeholder="Password" style="border:none; font-size: 16px; height: 30px; border-radius: 5px; width: 100%;" required><br><br>
                    <input type="hidden" name="admin" value="0">
                    <input type="hidden" name="edit" value="0">

                    <input type="submit" value="Agregar Usuario" style="border:none; background-color:purple; color: white; font-size: 16px; height: 50px; border-radius: 5px; width: 100%;"><br><br>
                    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Atrás</a>

                </form>
            </div>
        </div>
        
    </body>


    </div>
    
    <?php
        include("includes/footer.php");
    ?>
