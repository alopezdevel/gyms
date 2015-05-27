<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Laser Agencia Aduanal - Ejercicio empleo</title>
<link rel="shortcut icon" href="laser_images/favicon.ico" type="image/x-icon">
<link rel="icon" href="laser_images/favicon.png" type="image/png"> 
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
        <ul class="top-nav" style="display: none;"> 
            <li>
                <a href="#" title="Log In"><i class="fa fa-user"></i> <span> Bienvenido</span></a>
            </li>
            <li><a href="#" title="Salir"><i class="fa fa-sign-out"></i><span> Salir</span></a></li>
        </ul>
        <ul class="main-nav"> 
                    <li><a href="laser_index.php"><i class="fa fa-home" style="font-size: 1.5em;"></i></a></li> 
                    
                    <li class="submenu"><a href="#">C&aacute;talogos</a>
                        <ul> 
                            <li><a href="laser_empleados.php"><i class="fa fa-users"></i> Empleados</a></li>
                            <li><a href="laser_horarios.php"><i class="fa fa-clock-o"></i> Horarios</a></li>
                            <li><a href="#"><i class="fa fa-briefcase"></i> Puestos</a></li>    
                        </ul> 
                    </li>
                    
                    <li class="submenu"><a href="#">Reportes</a>
                        <ul> 
                           <li><a href="#"><i class="fa fa-folder-open"></i> Reporte General</a></li>     
                        </ul> 
                    </li>   
        </ul>
        <!---<a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>--->
    </div>
</nav>