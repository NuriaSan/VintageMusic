<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php parametro_plantilla("titulo_pagina");?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php parametro_plantilla("pagina_keywords");?>"> 
    <meta name="description" content="<?php parametro_plantilla("pagina_descripcion");?>">

    <link rel="logo-touch-icon" href="<?php parametro_plantilla("url_logo");?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php parametro_plantilla("icono_empresa");?>">

    <!--<link rel="stylesheet" href="includes/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="<?php parametro_plantilla("bootstrap");?>">
    <!--<link rel="stylesheet" href="includes/css/templatemo.css">-->
    <link rel="stylesheet" href="<?php parametro_plantilla("templatemo");?>">
    <link rel="stylesheet" href="<?php parametro_plantilla("hoja_estilos");?>" >

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="<?php parametro_plantilla("fontawesome");?>">

    <!-- Load map styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    
    <script src="<?php echo $js_jquery1; ?>"></script>
    <script src="<?php echo $js_jquery2; ?>"></script>
</head>