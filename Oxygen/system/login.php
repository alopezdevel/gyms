<?php
session_start();
session_unset();
session_destroy();
include("cn_usuarios.php");
?>                       
<script src="/js/jquery.1.8.3.min.js" type="text/javascript"></script> 
<script src="/../../../../code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style>
    .mensaje_valido { border: .5px solid transparent; padding: 0.1em; }
  </style>
<script>
var expr = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
var expr1 = /^[a-zA-Z]*$/;
$(document).ready(inicio);
function inicio(){  
    //variables
     mensaje = $( ".mensaje_valido" );
     usuario = $( "#loginUser" ),
     password = $( "#loginPassword" ),
     todosloscampos = $( [] ).add( usuario ).add( password );
     $("#loginUser").focus().css("background-color","#FFFFC0");     
     $("#button_aceptar").click(onValidarAcceso);
     $("#loginUser").focus(onFocus); 
     $("#loginPassword").focus(onFocus); 
     $("#loginUser").blur(onBlur);
     $("#loginPassword").blur(onBlur); 
}
 function onValidarAcceso(){ 
     //validaciones tamano
     todosloscampos.removeClass( "error" );
     var valid = true; 
     valid = valid && checkLength( $('#loginUser'), "Usuario", 5, 25 );
     valid = valid && checkLength( $('#loginPassword'), "Password", 6, 25 );
     
     //Validaciones de expresion regular
     valid = valid && checkRegexp( $('#loginUser'), /^[a-z]([0-9a-z_\s])+$/i, "user consiste en datos  de a-z, 0-9, sin espacios." );
     valid = valid && checkRegexp( $('#loginPassword'), /^[a-z]([0-9a-z_\s])+$/i, "password consiste en datos  de a-z, 0-9, sin espacios." );

     if ( valid ) {
        conexion($("#loginUser").val(), $("#loginPassword").val());
     }
 }
 function conexion(u, p){
     $.post("funciones.php", { accion: "conexion", usuario: u , password: p}, 
     function(data){ 
         switch(data.respuesta){
         case "0":  $("#loginPassword").val("");
                    $("input:text:visible:first").focus();
                break;
         case 1:    
                break;
         case 2:    $("#loginPassword").val("");
                    $("input:text:visible:first").focus();
                break;  
         }
     }
     ,"json");
 }
 function onFocus(){
     $(this).css("background-color","#FFFFC0");
 }
 function onBlur(){
    $(this).css("background-color","#FFFFFF");
 }
 function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        return false;
    } else {                     
        return true;        
    }
 }
 function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        actualizarMensajeAlerta( "El campo " + n + " debe contener entre " + min + " y " + max + " digitos." );
        o.addClass( "error" );
        o.focus();
        return false;    
    } else {             
        return true;                     
    }                    
 }
 
 function actualizarMensajeAlerta( t ) {
      mensaje
        .text( t )
        .addClass( "alertmessage" );
      setTimeout(function() {
        mensaje.removeClass( "alertmessage", 2500 );
      }, 500 );
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
<?php if ($conexion) {    ?>
<body>
<div id="layer_login">
    <img alt="" src="images/login/img-logo-login.png" alt="logo">
    <form method="post" action="" onSubmit="return Validar_Login()">
        <p class="mensaje_valido">Favor de capturar los datos.</p>
        <input id="loginUser" class="user" name="user" type="text" placeholder="User">
        <input id="loginPassword" class="pass" name="password" type="password" placeholder="Password">
        <button id="button_aceptar" class="btn_login" type="button">LOGIN</button>
        <p class="m_inf"><a href="#">Olvidaste tu contraseña?</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;         |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          
        <a href="#">Crear Cuenta</a></p>
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
</body>
<?php }else{ ?>
<?php  } ?>
</html>
