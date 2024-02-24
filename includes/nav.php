<?php
    $tituloCarrito = isset($titulo_carrito) ? $titulo_carrito : "(0)";
    $tituloLogin = isset($titulo_login) ? $titulo_login : "Registrate";
    $ruta = isset($ruta) ? $ruta : "";
?>
<body>
    <!-- Parte Superior del Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@vintagemusic.com">info@vintagemusic.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:657.029.433">657-029-433</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/Vintage Music" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Cierre de Parte Superior del Nav -->


    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container d-flex justify-content-between align-items-center">

            <a class="navbar-brand text-success logo h1 align-self-center" href="Pagina-Index.php">
            <img src="<?php parametro_plantilla("url_logo");?>" alt="LogoEmpresa" width="100" height="100">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php parametro_plantilla("pagina_index");?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php parametro_plantilla("pagina_tienda");?>">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php parametro_plantilla("pagina_contacto");?>">Contacto</a>
                        </li>
                    </ul>
                </div>
                <div class="navbar align-self-center d-flex">
                    
                    <a class="nav-icon position-relative text-decoration-none" href="<?php parametro_plantilla("ruta");?>VerCarta.php?usuario=<?php $usuario;?>">
                        
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-3" style="font-size: 34px;"></i>
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark" style="font-size: 14px;"><?php echo isset($titulo_carrito) ? $titulo_carrito : ''; ?></span>
                        <p>Carrito</p>
                    </a>
                    <a class="nav-icon position-relative text-decoration-none" href="<?php parametro_plantilla("ruta");?>logout.php">
                        
                        <i class="fa fa-fw fa-user text-dark mr-3" style="font-size: 34px;"></i>
                        <span class="position-absolute top-0 left-100 translate-middle-top badge rounded-pill bg-light text-dark" style="font-size: 14px;"><?php echo isset($titulo_login) ? $titulo_login : ''; ?></span>
                        <p>Usuario</p>
                    </a>
                </div>
            </div>

        </div>
    </nav>
    <!-- Cierre de Header -->

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
