<?php
// Iniciar una nueva sesión
session_start();

    include_once("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");

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
    include("includes/head.php");
    include("includes/nav.php");
    include_once("db/conectar.php");
?>

<body>

<div class="container py-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-6">
            <div class="card rounded-3 text-black">
                <div class="card-body p-md-5 mx-md-4">

                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $usuario = $_POST["usuario"];
                        $password = $_POST["password"];

                        // Validar el usuario y la contraseña
                        $usuarioObj = Usuario::nombreClave($usuario, $password);
                        $estadoAdmin = Usuario::obtenerAdminPorUsuario($usuario);
                        $estadoEdit = Usuario::obtenerEditPorUsuario($usuario);

                        if ($usuarioObj) {
                            $_SESSION["autentificado"] = true;
                            $_SESSION["usuario"] = $usuarioObj;

                            if ($estadoAdmin == 1) {
                                echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "Administrador/sesionadministrador.php?usuario="; }, 0);</script>';
                                exit();
                            } elseif ($estadoEdit == 1) {
                                echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "Editor/sesioneditor.php?usuario="; }, 0);</script>';
                                exit();
                            } else {
                                echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "Usuario/sesionusuario.php?usuario="; }, 0);</script>';
                                exit();
                            }
                        } else {
                            // Establecer mensaje de error
                            echo '<div class="alert alert-danger m-0" role="alert">Usuario o contraseña incorrectos. ¿No estás registrado?</div>';
                        }
                    }
                    ?>

                    <div class="text-center">
                        <img src="./includes/imagenes/logo-empresa.jpg" style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-1">Vintage Music</h4>
                    </div>

                    <form id="loginform" action="login.php" method="POST">
                        <p>LogIn</p>

                        <div class="form-outline mb-4">
                            <input type="usuario" name="usuario" id="usuario" class="form-control" placeholder="&#128100; Usuario " required/>
                            <label class="form-label" for="usuario">Usuario</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="password" name="password" id="password" class="form-control" placeholder="&#128273; Password" required/>
                            <label class="form-label" for="password">Password</label>
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                            <button class="btn btn btn-outline-primary btn-lg fa-lg gradient-custom-2 mb-3" type="submit">Log in</button>
                            <a class="text-muted" href="recuperarpassword.php">¿Has olvidado tu contraseña?</a>
                        </div>

                        <div class="d-flex align-items-center justify-content-center pb-4">
                            <p class="mb-0 me-2">¿No tienes cuenta? REGISTRATE</p>
                            <a href="nuevousuario.php">Crea tu cuenta</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-center">
            <div class="text-black px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Queremos ofrecerte los mejores artículos</h4>
                <p class="small mb-0">Para poder ofrecerte lo mejor, puedes registrarte en nuestra página. Somos
                    muy cuidadosos con los datos de nuestros clientes, así que valoraremos cada información que nos
                    cedas como si fuera la nuestra.</p>
            </div>
        </div>
    </div>
</div>


<?php
    include("includes/footer.php");
?>

