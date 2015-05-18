<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Oxygen - FX Crossfit</title>
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

    
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>--->
    <script type="text/javascript" src="../js/jquery.1.8.3.min.js"></script> 
    <link href="../css/form.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style_system.css" type="text/css"> 
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"> 
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <link href="css/data_grid.css" rel="stylesheet" type="text/css">
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
<nav class="main-nav-outer" id="layer_menu"><!--main-nav-start-->
	<div class="container">
		<a href="#home" class="img-logo"><img  src="images/img-logo.png" alt="logo"></a>
		<ul class="top-nav"> 
			<li>
			<?php if(isset($_SESSION['usuario_actual'])){ ?>
				<a href="#" title="Log In"><i class="fa fa-user"></i> <span> <?php echo $_SESSION['usuario_actual']; ?></span></a>
			<?php }else{?>
				<a href="#" title="Log In"><i class="fa fa-user"></i> <span> Nombre de Usuario</span></a>
			<?php }?>
			</li>
			<li><a href="login.php" title="Log Out"><i class="fa fa-sign-out"></i><span> Salir</span></a></li>
		</ul>
        <ul class="main-nav">
            <?php if($_SESSION["acceso"] == "A"){?> 
                    <li><a href="index.php">Inicio</a></li> 
                    
                    <li class="submenu"><a href="#">Reportes</a>
                        <ul> 
                            <li><a href="monitor_usuario.php">Monitor por Socio</a></li>
                            <li><a href="monitor_de_pago_por_usuario.php">Pagos por Socio</a></li>
                            <li><a href="monitor.php">Asistencias del Dia</a></li>    
                        </ul> 
                    </li>
                    
                    <li class="submenu"><a href="#">Utilerias</a>
                        <ul> 
                           <li><a href="postdeldia.php">Mensaje del Día</a></li>    
                        </ul> 
                    </li>
                    <li class="submenu"><a href="#">Socios</a>
                        <ul> 
                           <li><a href="socio_verificacion.php">Asistencia del socio</a></li> 
                           <li><a href="alta_socio_2.php">Catalogo de socios</a></li>
                           <li><a href="registro_socio.php">Nuevo Socio</a></li>
                           <li><a href="pagar_mensualidad_2.php">Registrar Pago del socio</a></li>    
                        </ul> 
                    </li>
                   <li><a href="soporte_sistema.php">Soporte Técnico</a></li>
                    
            <?php } ?>
            <?php if($_SESSION["acceso"] == "U"){?> 
                    <li><a href="index.php">Inicio</a></li> 
                    <li class="submenu"><a href="#">Reportes</a>
                        <ul> 
                            <li><a href="monitor.php">Asistencias del Dia</a></li>    
                        </ul> 
                    </li>
                    <li class="submenu"><a href="#">Socios</a>
                        <ul> 
                           <li><a href="socio_verificacion.php">Asistencia del socio</a></li> 
                           <li><a href="alta_socio.php">Catalogo de socios</a></li>
                        </ul> 
                    </li>
                    
                   <li><a href="soporte_sistema.php">Soporte Técnico</a></li>
                    
            <?php } ?>
            <?php if($_SESSION["acceso"] == "C"){?> 
                     <li><a href="index.php">Inicio</a></li> 
                     <li><a href="membresia_doit.php">Socios</a></li> 
                     <li><a href="comentarios.php">Comentarios</a></li>
                     <li><a href="soporte_sistema.php">Soporte Técnico</a></li>
                    
            <?php } ?>
        	
        </ul>
        <!---<a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>--->
    </div>
</nav>

    
        
    
    

