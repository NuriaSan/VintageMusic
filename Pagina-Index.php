<?php
    include ("includes/funciones-comunes.php");
    include ("includes/Clases/claseArticulo.php"); 
    include("includes/Clases/claseUsuario.php");
    if (!isset($_SESSION)) {
        session_start();
    }

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
    $ruta = "";
    

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
?>

    <div id="cuerpo">
        
        <div class="fondo">
        <img src="includes/imagenes/borde-logo.png">
        <h2>Déjate llevar por la nostalgia</h2>
        </div>

        <div class="acceso-tienda">
            <h2>Descubre los artículos que tenemos preparados para ti</h2>
            <p class="texto-grande">Desde Vintage Music atendemos a los enamorados de la musica y a los que se emocionan con los matices del sonido vintage que aportan los casettes, vinilos y dispositivos de reproducción relacionados.<p>
            <br>
            <p class="texto-grande">¿Quieres descubrir lo que tenemos preparado para ti?</p>
            <button><a class="nav-link" href="PaginaTienda.php">Tienda</a></button>
        </div>
        <div class="acceso-login">
            <h2>¿Quieres disfrutar de todas las ventajas?</h2>
            <p class="texto-grande">Puedes Registrarte y poder gestionar tus compras recibiendo tus pedidos en solo 3 dias.<p>
            <br>
            <p class="texto-grande">¡Registrate!</p>
            <button><a class="nav-link" href="login.php">Registrate</a></button>
        </div>

        <div class="slider">
            <input class="slider__dot" type="radio" name="slider" title="slide1" checked="checked"/>
            <input class="slider__dot" type="radio" name="slider" title="slide2"/>
            <input class="slider__dot" type="radio" name="slider" title="slide3"/>
            <input class="slider__dot" type="radio" name="slider" title="slide4"/>
            <div class="slider__inner">
                <div class="slider__body">
                    <img src="includes/imagenes/torre-vinilos.jpg" alt="torreVinilos" width="310" height="260">
                    <h2 class="slider__caption">Vinilos</h2>
                    <p class="slider__text">
                        Si eres un nostálgico como nosotros, tienes que echarle un vistazo a nuestra colección de vinilos.
                        Sabemos que el toque Retro siempre vuelve, porque núnca ha pasado de moda. 
                    </p>
                </div>
                <div class="slider__body">
                    <img src="includes/imagenes/retro-cassette.jpg" alt="retroCassette" width="310" height="260">
                    <h2 class="slider__caption">Cassettes</h2>
                    <p class="slider__text">                            
                        Disfruta del encanto de escuchar música con el toque del Cassette.
                        Descubre el regalo con el que acompañamos cada compra. Tranquilo, no será nada estram-BOLI-co.
                        </p>
                </div>
                <div class="slider__body">
                <img src="includes/imagenes/walkman.jpg" alt="walkman" width="310" height="260">
                    <h2 class="slider__caption">Reproductores</h2>
                    <p class="slider__text">
                        Ya seas de escuchar Vinilos o Cassettes, necesitas un reproductor que acompañe tu experiéncia.
                        Busca entre nuestra selección y sueña que es tuyo.
                    </p>
                </div>
                <div class="slider__body">
                    <img src="includes/imagenes/auriculares.jpg" alt="retroCassette" width="310" height="260">
                    <h2 class="slider__caption">Accesorios</h2>
                    <p class="slider__text">
                        No hay nada que haga mas Match que nuestros accesorios.
                        ¿Quieres saber de que hablamos?
                        Busca en nuestra sección de Accesorios y preparate pa todo un descubrimiento.
                    </p>
                </div>
            </div>
        </div>


    </div>
    
<?php
    include("includes/footer.php");
?>
