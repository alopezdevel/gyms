<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Oxygen - FX Crossfit</title>
<link rel="stylesheet" href="css/style_system.css" type="text/css">
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

<!--<script type="text/javascript">   
        function posision(value){
        
            if(value == 1){
            elem = document.getElementById('chat-contenedor');
             elem.style.marginTop = "35%";
             }
            if(value == 2){
            elem = document.getElementById('chat-contenedor');
             elem.style.marginTop = "48%";
            }
        };        
</script> -->

    <!--- slider --- galeria instalaciones --->
    <link href="js/gallery/demo/css/shCore.css" rel="stylesheet" type="text/css" />
    <link href="js/gallery/demo/css/shThemeDefault.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="js/gallery/demo/css/demo.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/gallery/demo/css/flexslider.css" type="text/css" media="screen" />
    
    <!-- Modernizr -->
    <script src="js/gallery/js/modernizr.js"></script>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script><!-- Galeria -->
    <script>
        !window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
    </script>
    <script type="text/javascript" src="js/galeria/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="js/galeria/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="js/galeria/funcion.js"></script>    
    <link rel="stylesheet" type="text/css" href="js/galeria/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <link rel="stylesheet" href="js/galeria/style.css" />
    <!--- SLIDER - INDEX ---->
    <script src="js/slider-index/slider.js" type="text/javascript"></script>  
    <script src="js/slider-index/billy.carousel.jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/slider-index/demonstration.css" type="text/css" media="screen" />
    

</head>



<body> 
   <?php if(isset($_SESSION['acceso'])){ ?>
		<div id="chat-contenedor" onclick="posision(1);" ondblclick="posision(2)" style="display:none;">
    	<h3 >Mensajes</h3>
    	<iframe id="I2" border="0" frameborder="0" height="185" marginheight="0" marginwidth="0" name="iframechat" scrolling="no" src="chat_interno.php" width="250">
    Your browser does not support inline frames or is currently configured not to display inline frames.
    </iframe>
</div>
<?php }?>
<div id="page">
<nav class="main-nav-outer" id="layer_menu"><!--main-nav-start-->
	<div class="container">
		<a href="#home" class="img-logo"><img  src="images/img-logo.png" alt="logo"></a>
		<ul class="top-nav"> 
			<li>
			<?php if(isset($_SESSION['usuario_actual'])){ ?>
				<a href="#" class="icon user" title="Log In"><span><?php echo $_SESSION['usuario_actual']; ?></span></a>
			<?php }else{?>
				<a href="#" class="icon user" title="Log In"><span>Nombre de Usuario</span></a>
			<?php }?>
			</li>
			<li><a href="login.php" class="icon logout"title="Log Out"><span>Salir</span></a></li>
		</ul>
        <ul class="main-nav">
        	<li><a href="#">Registro de Entrada</a></li>
            <li class="submenu"><a href="#">Socios</a></li>
            <li><a href="#">Mensaje del Día</a></li>
            <?php if($_SESSION["acceso"] == "U"){?>
            <li class="submenu"><a href="#">RECEPCION</a>
            	<ul  class="admin">
               		<li><a href="socio_verificacion.php">Verificacion del Socio</a></li>
                    <li><a href="monitor.php">Log del dia</a></li>
                    <li><a href="postdeldia.php">Mensaje del Dia</a></li>
                    <li><a href="comentarios.php">Comentarios</a></li>
                    <li><a href="monitor_de_pago_por_usuario.php">Log de pagos por Socio</a></li>
                    <li><a href="alta_socio.php">Catalogo de socios</a></li>
                    <?php if(1){?><li><a href="chat-copia.php">Chat</a></li><?php } ?>
				</ul>
            </li>
            <?php }elseif($_SESSION["acceso"] == "A"){?>
            <li class="submenu"><a href="#">ADMINISTRADOR</a>
            	<ul class="admin">
                	<li><a href="socio_verificacion.php">Verificacion del Socio</a></li>
                    <li><a href="monitor.php">Log del dia</a></li>
                    <li><a href="monitor_usuario.php">Log por Socio</a></li>
                    <li><a href="monitor_de_pago_por_usuario.php">Log de pagos por Socio</a></li>
                    <li><a href="chat-copia.php">Chat</a></li>
                    <li><a href="pagar_mensualidad.php">Pago de Mensualidad</a></li>
                    <li><a href="postdeldia.php">Mensaje del Dia</a></li>
                    <li><a href="alta_socio.php">Catalogo de socios</a></li>
                </ul>
            </li>
           	<?php }else{?>
				<li><a href="#">Socios</a></li>
			<?php }?>
            <li><a href="soporte_sistema.php">Soporte Técnico</a></li>
        </ul>
        <!---<a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>--->
    </div>
</nav>

    
        
    
    

