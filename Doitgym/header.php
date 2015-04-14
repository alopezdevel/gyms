

  <!DOCTYPE html>

<html>



<head>

<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<link rel="stylesheet" href="css/styles.css">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<title>Do it - Fitness and Muscle Factory</title>
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
<div id="chat-contenedor" onclick="posision(1);" ondblclick="posision(2)">
    <h3 >Mensajes</h3>
    <iframe id="I2" border="0" frameborder="0" height="185" marginheight="0" marginwidth="0" name="iframechat" scrolling="no" src="chat_interno.php" width="250">
    Your browser does not support inline frames or is currently configured not to display inline frames.
    </iframe>
</div>
<?php }?>
<div id="page">

    <div id="header">

        <div class="logo" style="left: 0px; top: 0px">

            <a href="index.php">

            <img src="images/content/img_logo.png" height="170px" width="324px" alt="Do it - Gym">

            </a>

        </div>
        
        <div id="nav_sup">
            
            <?php if(isset($_SESSION['usuario_actual'])){ ?>

            <div class="user">
                <img src="images/login/img_user.png" alt=""><?php echo $_SESSION['usuario_actual']; ?>&nbsp; /&nbsp;  <a href="login.php">Cerrar Sesión</a></div>
           
            <?php }else{?>
            
            <div id="btn" class="login"><a href="login.php"><img src="images/nav/up/btn_login.png" alt=""></a></div>
           
            <?php }?>
            
            <div id="btn" class="home"><a href="index.php"><img src="images/nav/up/btn_home.png" alt=""></a></div>

            <div id="btn" class="twitt"><a href="contacto.php"><img src="images/nav/up/btn_twit.png" alt=""></a></div>

            <div id="btn" class="fb"><a href="https://www.facebook.com/doitgym" target="_blank"><img src="images/nav/up/btn_face.png" alt=""></a></div>

        </div>
        

        <div id="nav_container"></div>
    
        <ul id="nav_first">

                <li class="sub">

                    <a href="quienes_somos.php">NOSOTROS</a>
                            <ul id="dropdown">
                                <li><a href="como_empezar.php"><div id="icon" class="pesa"></div>Como Empezar?</a></li>
                                <li><a href="membresia_doit.php"><div id="icon" class="memb"></div>Membresia Doit</a></li>
                                <li><a href="monitor_de_pago_por_usuario.php"><div id="icon" class="money"></div>Checa tus pagos</a></li>
                            </ul>

                </li>
                <li><a href="horarios.php">HORARIOS</a></li>
                <li><a href="galeria.php">GALERIA DE FOTOS</a></li>
                <?php if($_SESSION["acceso"] == "U"){?>
                         <li class="sub"><a href="#">RECEPCION</a>
                            <ul id="dropdown" class="admin">
                                <li style="width:200px;"><a href="socio_verificacion.php"><div id="icon" class="doit"></div>Verificacion del Socio</a></li>
                                <li style="width:230px;"><a href="monitor.php"><div id="icon" class="clock"></div>Log del dia</a></li>
                                <li style="width:230px;"><a href="postdeldia.php"><div id="icon" class="chat"></div>Mensaje del Dia</a></li>
                                <li style="width:230px;"><a href="comentarios.php"><div id="icon" class="chat"></div>Comentarios</a></li>
                                <li style="width:230px;"><a href="monitor_de_pago_por_usuario.php"><div id="icon" class="money"></div>Log de pagos por Socio</a></li>
                                <li style="width:230px;"><a href="soporte_sistema.php"><div id="icon" class="chat"></div>Ayuda - con Beto</a></li>
                                <li style="width:230px;"><a href="alta_socio.php"><div id="icon" class="chat"></div>Catalogo de socios</a></li>
                                <?php if(1){?>
                                    <li><a href="chat-copia.php"><div id="icon" class="pesa"></div>Chat</a></li>
                                <?php } ?>

                            </ul>

                </li>

                <?php }elseif($_SESSION["acceso"] == "A"){?>

                        <li class="sub"><a href="#">ADMINISTRADOR</a>

                            <ul id="dropdown" class="admin">
                                <li style="width:230px;"><a href="socio_verificacion.php"><div id="icon" class="key"></div>Verificacion del Socio</a></li>
                                <li style="width:230px;"><a href="monitor.php"><div id="icon" class="clock"></div>Log del dia</a></li>
                                <li style="width:230px;"><a href="monitor_usuario.php"><div id="icon" class="men"></div>Log por Socio</a></li>
                                <li style="width:230px;"><a href="monitor_de_pago_por_usuario.php"><div id="icon" class="money"></div>Log de pagos por Socio</a></li>
                                <li style="width:230px;"><a href="chat-copia.php"><div id="icon" class="chat"></div>Chat</a></li>
                                <li style="width:230px;"><a href="pagar_mensualidad.php"><div id="icon" class="dollar"></div>Pago de Mensualidad</a></li>
                                <li style="width:230px;"><a href="postdeldia.php"><div id="icon" class="chat"></div>Mensaje del Dia</a></li>
                                <li style="width:230px;"><a href="soporte_sistema.php"><div id="icon" class="chat"></div>Ayuda - con Beto</a></li>
                    <li style="width:230px;"><a href="alta_socio.php"><div id="icon" class="chat"></div>Catalogo de socios</a></li>

                                
                            </ul>

                        </li>

                <?php }else{?>

                        <li class="sub"><a href="contacto.php">CONTACTO</a></li>

                <?php }?>

                        

            </ul>

        
    </div>
    
        
    
    

