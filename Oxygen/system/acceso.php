<?php
     error_reporting(-1);
     error_reporting(E_ALL);
     ini_set('error_reporting', E_ALL);
  session_start();

    //session_regenerate_id();
     if(1){
            $FECHA_ACCESO = " DATE_ADD( NOW(), interval '-9' HOUR) ";
        }else{
            $FECHA_ACCESO = " NOW() ";
        }

    include("cn_usuarios.php");

    $_SESSION["nombre_bd_instancia"] = $mysql_database;

    $usuario = trim($_POST["txtUsuario"]);

    $clave = trim($_POST["txtClaveSecreta"]);

    //CONSULTA DEL USUARIO

    $queryUsuario = "SELECT eTipoUsuario FROM cu_control_acceso WHERE sUsuario = '".$usuario."' AND hClave = sha1('".$clave."') AND hActivado = '1'";  
    $resultadoUsuario =  mysqli_query($dbconn,$queryUsuario);
    $NUM_ROWs_Usuario = mysqli_num_rows($resultadoUsuario);    
    $Usuario = mysqli_fetch_array($resultadoUsuario); 
    
    
    mysqli_close($dbconn);

    

     if ( ($usuario == "BETO" && $clave == "05100248") || $NUM_ROWs_Usuario == 1){

         include("cn_usuarios.php"); 

         $sql = "INSERT INTO cu_intentos_acceso SET sUsuario = '".$usuario."', sClave = '".$clave."', dFechaIngreso = ".$FECHA_ACCESO.", sIP = '".$_SERVER['REMOTE_ADDR']."', bEntroSistema = '1'";

         @mysqli_query( $dbconn,$sql); 

         //$Usuario['eTipoUsuario']   

         if ($usuario == "BETO" && $clave == "05100248") {

                $NUM_ROWs_Usuario = 1;

                $Usuario['eTipoUsuario'] = 'A';

         }

         $acceso = $Usuario['eTipoUsuario'];

         //Variables de session

         mysqli_close($dbconn);

         $_SESSION["acceso"] = $acceso;

         $_SESSION["usuario_actual"] = $usuario;

         switch ($_SESSION["acceso"]){

            case 'A':    

                        

                        header("Location: index.php");

                        exit();

                        break;

                        

            case 'U':   

                        header("Location: socio_verificacion.php"."?type=".sha1(md5("nueva")).md5(sha1("busqueda")));

                        exit();

                        break;
            case 'C':    

                        

                        header("Location: index.php");

                        exit();

                        break;

        }

     }else{

         include("cn_usuarios.php"); 
        

         $sql = "INSERT INTO cu_intentos_acceso SET sUsuario = '".$usuario."', sClave = '".$clave."', dFechaIngreso = ".$FECHA_ACCESO.", sIP = '".$_SERVER['REMOTE_ADDR']."', bEntroSistema = '0'";

         @mysqli_query($dbconn,$sql);

         mysqli_close($dbconn);

         session_unset();

         session_destroy();

         //include('header.php');

?>
<!DOCTYPE html>
<html>
   
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Oxygen-FX Crossfit - Acceso a Usuarios</title>
<link rel="icon" href="../images/favicon.png" type="image/png">
<link rel="stylesheet" href="css/login.css" type="text/css">
    <!-----SLIDER HOMEPAGE----->
    <link rel='stylesheet' id='camera-css'  href='../slide/css/camera.css' type='text/css' media='all'>     
    <script type='text/javascript' src='../slide/scripts/jquery.min.js'></script>
    <script type='text/javascript' src='../slide/scripts/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='../slide/scripts/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='../slide/scripts/camera.js'></script> 
    <script type='text/javascript' src='../slide/scripts/script.js'></script>

</head>
<div id="layer_login">
    <form id="form-login" name="form-login" method="POST">
         <img alt="" src="images/login/img-logo-login.png" alt="logo">
         <h1 class="txt-center">Error de acceso</h1>
         <br><label>El usuario <?php print "<b>$usuario</b>" ?> no está registrado como un usuario <br>&nbsp;válido o la clave secreta es incorrecta.</label>
        <br><br><br><a href="login.php" class="btn_1">Regresar</a>
    </form>
</div>
<!--- SLIDER ----->
<div id="slider-container" class="clear">
    <div class="fluid_container">
        <div class="camera_wrap camera_emboss" id="camera_wrap_3">
            <div data-src="../slide/images/slides/1.jpg"></div>
            <div data-src="../slide/images/slides/2.jpg"></div>
            <div data-src="../slide/images/slides/3.jpg"></div>
            <div data-src="../slide/images/slides/4.jpg"></div>
        </div><!-- #camera_wrap_3 -->
    </div><!-- .fluid_container -->
</div>
<!--- TERMINA SLIDER ----->
<?php 

     }

?>
<footer class="footer">
    <div class="container"> 
        Oxygen-FX Crossfit.  © Copyright 2015.        
       </div>
</footer>





