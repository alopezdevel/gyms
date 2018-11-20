<?php

session_start();

session_unset();

session_destroy();

include("cn_usuarios.php");

if ($dbconn && $dbselect) {  

?>

<script>

function Validar_Login() {                //CONTROL_ACCESO.PHP

    var forma = document.form-login;

    if (forma.txtUsuario.value == "" || forma.txtClaveSecreta.value == ""){

        alert("Favor de llenar ambos campos.");

        return false;

    }

    else {

        return true;

    }

}

</script>

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
<body>
<!--- nuevo login --->
<div id="layer_login">
    <form id="form-login" name="form-login" method="POST" action="acceso.php" onSubmit="return Validar_Login()">
         <img alt="" src="images/login/img-logo-login.png" alt="logo">
        <p class="mensaje_valido">&nbsp;Favor de llenar todos los campos.</p>
        <div class="user"><input id="loginUser" class="user" name="txtUsuario" type="text" placeholder="Usuario"></div>
        <div class="password"><input id="loginPassword" class="pass" name="txtClaveSecreta" type="password" placeholder="Contrase&ntilde;a"></div>
        <button name="btn_accept" class="btn_accept" >Aceptar</button>
        <p class="m_inf"><a href="#">Olvidaste tu contraseÃ±a?</a></p>
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
<footer class="footer">
    <div class="container"> 
        Oxygen-FX Crossfit.  © Copyright 2015.        
       </div>
</footer>

<?php }else{

    echo '<script language="javascript"> alert (\'El sistema esta fuera de servicio. \')</script>';

}

?>
</body> 
</html>  

