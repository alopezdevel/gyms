<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Oxygen - FX Crossfit</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
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
</head>

<body>
<?php if(isset($_SESSION['acceso'])){ ?>
<div id="chat-contenedor" onclick="posision(1);" ondblclick="posision(2)">
    <h3 >Mensajes</h3>
    <iframe id="I2" border="0" frameborder="0" height="185" marginheight="0" marginwidth="0" name="iframechat" scrolling="no" src="chat_interno.php" width="250">
    Your browser does not support inline frames or is currently configured not to display inline frames.
    </iframe>
</div>
<?php }?> <!---- CHAT---->
<nav class="main-nav-outer" id="layer_menu"><!--main-nav-start-->
	<div class="container">
		<a href="#home" class="img-logo"><img  src="images/nav/img-logo.png" alt="logo"></a>
		<ul class="top-nav">
		<?php if(isset($_SESSION['usuario_actual'])){ ?> 
			<li><a href="#" class="icon user" title="Log In"><span><?php if(isset($_SESSION['usuario_actual'])){ ?></span></a></li>
			<li><a href="login.php" class="icon logout"title="Log Out"><span>Salir</span></a></li>
		<?php }else{}?> 
		</ul>
        <ul class="main-nav">
        	<li><a href="#">Registro de Entrada</a></li>
            <li class="submenu"><a href="#">Socios</a>
            </li>
            <li><a href="#">Mensaje del Día</a></li>
            <li><a href="#">Soporte Técnico</a></li>
        </ul>
        <!---<a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>--->
    </div>
</nav>
<!--main-nav-end-->
