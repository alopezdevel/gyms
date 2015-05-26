<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Laser Agencia Aduanal - Ejercicio empleo</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.png" type="image/png"> 
<?php 
if(1){
    $_SESSION['fecha_actual_server'] = " DATE_ADD( NOW(), interval '-9' HOUR) ";
}else{
    $_SESSION['fecha_actual_server'] = " NOW() ";
    
}
//echo $sql = "SELECT ".$_SESSION['fecha_actual_server']." as fecha , MONTH(".$_SESSION['fecha_actual_server'].") as mes ";
?>

    <script src="laser_js/jquery.1.8.3.min.js" type="text/javascript"></script> 
    <link href="laser_css/form.css" rel="stylesheet" type="text/css">
    <link href="laser_css/style_system.css" rel="stylesheet" type="text/css"> 
    <link href="laser_css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="laser_css/bootstrap.css" rel="stylesheet" type="text/css"> 
    <script src="laser_js/bootstrap.js" type="text/javascript"></script>
    <link href="laser_css/data_grid.css" rel="stylesheet" type="text/css">
</head>



<body> 
<nav class="main-nav-outer" id="layer_menu"><!--main-nav-start-->
    <div class="container">
        <a href="#home" class="img-logo"><img  src="laser_images/img-logo.png" alt="logo"></a>
        <ul class="top-nav"> 
            <li>
                <a href="#" title="Log In"><i class="fa fa-user"></i> <span> Bienvenido</span></a>
            </li>
            <li><a href="#" title="Salir"><i class="fa fa-sign-out"></i><span> Salir</span></a></li>
        </ul>
        <ul class="main-nav"> 
                    <li><a href="index.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a></li> 
                    
                    <li class="submenu"><a href="#">Reportes</a>
                        <ul> 
                            <li><a href="monitor_usuario.php"><i class="fa fa-user"></i> Monitor por Socio</a></li>
                            <li><a href="monitor_de_pago_por_usuario.php"><i class="fa fa-usd"></i> Pagos por Socio</a></li>
                            <li><a href="monitor.php"><i class="fa fa-check-square-o"></i> Asistencias del Dia</a></li>    
                        </ul> 
                    </li>
                    
                    <li class="submenu"><a href="#">Utilerias</a>
                        <ul> 
                           <li><a href="postdeldia.php"><i class="fa fa-comment"></i> Mensaje del Día</a></li>    
                           <li><a href="utileria_recordar_pago.php"><i class="fa fa-usd"></i> Recordatorio Pago</a></li>   
                        </ul> 
                    </li>
                    <li class="submenu"><a href="#">Socios</a>
                        <ul> 
                           <li><a href="socio_verificacion_2"><i class="fa fa-user"></i> Asistencia del socio</a></li> 
                           <li><a href="alta_socio_2"><i class="fa fa-users"></i> Catalogo de socios</a></li>
                           <li><a href="registro_socio"><i class="fa fa-user-plus"></i> Nuevo Socio</a></li>
                           <li><a href="pagar_mensualidad_2"><i class="fa fa-usd"></i> Registrar Pago del socio</a></li>    
                        </ul> 
                    </li>
                    <li class="submenu"><a href="#">Blog y Noticias</a>
                        <ul> 
                           <li><a href="post_nuevo"><i class="fa fa-plus-circle"></i> Nueva Entrada</a></li>    
                           <li><a href="blog"><i class="fa fa-book"></i> Blog</a></li>
                           <li><a href="noticias"><i class="fa fa-newspaper-o"></i> Noticias</a></li>    
                        </ul> 
                    </li>
                   <li><a href="soporte_sistema.php"><i class="fa fa-question-circle"></i> Soporte Técnico</a></li>    
        </ul>
        <!---<a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>--->
    </div>
</nav>