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
    <div id="contenedor" class="container mt-12">
        <div class="row">
        <div class="col-md-12 text-center">
            <?php if ($mensajeExito) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>&#128588; Éxito:</strong> Se han modificado los datos de forma correcta
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
            <div class="titulo">
                <h1 style="color: purple;">Bienvenido a tu Espacio, <?php echo $nombre; ?></h1>
        </div>
        
        <div id="formularioad">
            <form action="nuevousuarioadmin.php" method="get">
                
                <table style="width:100%; height:100%; border-radius: 5px; font-size: 16px; height: 30px;">
                    <tr>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">DNI</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Usuario</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Nombre</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Teléfono</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Email</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Password</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Admin</th>
                        <th style="background-color:orange; font-size: 16px; height: 30px;">Editor</th>
                        <th style="background-color:lime; font-size: 16px; height: 30px;">Modificar</th>
                        <th style="background-color:red; font-size: 16px; height: 30px;">Borrar</th>
                    </tr>
                    
                    <?php
                        //Controla si se ha iniciado la sesión anteriormente
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $conn = conectar_DB();  

                        if (!$conn) {
                            die("Error al conectar a la base de datos");
                        }
                        try{ 
                            // Consulta para obtener los clientes
                            
                            $stmt = $conn->prepare("SELECT * FROM usuarios");
                            $stmt->execute();
                        
                            while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $datos["dni"] . "</td>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $datos["usuario"] . "</td>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $datos["nombre"] . "</td>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $datos["telefono"] . "</td>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $datos["email"] . "</td>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $datos["password"] . "</td>";
                                //Obtener si o no como respuesta de los campos admin y editor
                                $adminText = ($datos["admin"] == 1) ? 'Sí' : 'No';
                                $editText = ($datos["edit"] == 1) ? 'Sí' : 'No';
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $adminText . "</td>";
                                echo "<td style='background-color:white; font-size: 16px; height: 30px;'>" . $editText . "</td>";
                                echo "<td style='background-color:white; font-size: 24px; height: 30px; '><a href='administradormodificar.php?dni=" . $datos["dni"] . "'>&#128221;</a></td>";
                                
                                if ($usuario == $datos["usuario"]){
                                    echo "<td style='background-color:white; font-size: 8px; height: 30px;'>No disponible</td>";
                                } else {
                                    echo "<td style='background-color:white; font-size: 24px; height: 30px;'><a href='administradoreliminar.php?dni=" . $datos["dni"] . "'>&#10060;</a></td>";
                                }
                                echo "</tr>";
                            }
                        } catch(PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                    
                    ?>
                </table>
            </form>
        </div>
        <br>
        <br>
        <div class="col-md-12">
                <div id="accionesadmin">

                    <div id="verdatos" class="mb-3">
                        <button class="btn btn-secondary w-100" type="button" onclick="verUsuario()">Volver</button>
                    </div>
                    <div id="salir" class="mb-3">
                        <button class="btn btn-dark w-100" type="button" onclick="logout()">Salir de la Sesión</button>
                    </div>
                </div>
        </div>
    
                    <script>
                        //Uso de funciones para redirigir a diferentes formularios con botones
                        function verUsuario() {
                            window.location.href = "sesionadministrador.php?dni=";
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

