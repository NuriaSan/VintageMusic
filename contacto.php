
<?php
    include_once ("includes/funciones-comunes.php");
    include("includes/Clases/claseUsuario.php");
    session_start();

    $hoja_estilos = "./includes/css/estilos.css";
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
    $ruta = "";
    

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'nombre_asc';
    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';


    if (isset($_SESSION["usuario"])) {
        $titulo_login = $_SESSION["usuario"]->getUsuario();
    } else {
        $titulo_login = "Registrate";
    }
    if(isset($_SESSION['carrito'])){
        $total_articulos = count($_SESSION['carrito']);
        $precio_total = 0;
        
    }else {
        $_SESSION['carrito']= array();
        $titulo_carrito = "(0)";
    }

    include ("includes/head.php");
    include ("includes/nav.php");
    include_once ("db/conectar.php");
    
?>

<!-- Contenido del Cuerpo -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Contacta con Nosotros</h1>
            <p>
                Si necesitas más información de nuestros productos puedes contactar con nosotros.
            </p>
        </div>
    </div>

    <!-- Mapa de Contacto -->
    <div class="container py-6">
        <div class="row py-5">
            <div class="form-group col-md-12 mb-3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3131.9810689512083!2d-0.7186971235694539!3d38.27993168290002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd63b7ad6e40fdc1%3A0x609104ad972f51c4!2sIES%20Severo%20Ochoa%20Elx!5e0!3m2!1ses!2ses!4v1706548425035!5m2!1ses!2ses" width="100%" height="450" style="border: 30px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <!-- Fin del Mapa -->

    <!-- Formulario de Contacto -->
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Nombre</label>
                        <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Nombre">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputsubject">Asunto</label>
                    <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="Asunto">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">Mensaje</label>
                    <textarea class="form-control mt-1" id="message" name="message" placeholder="Mensaje" rows="8"></textarea>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Fin del Formulario -->



  
    
<?php
    include("includes/footer.php");
?>
