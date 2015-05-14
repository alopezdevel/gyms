<?php
  $codigo = $_GET['cuser'];   
?>
<script src="/js/jquery.1.8.3.min.js" type="text/javascript"></script> 
<script src="/../../../code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(inicio);
function inicio(){
    
    $.get = function(key)   {  
        key = key.replace(/[\[]/, '\\[');  
        key = key.replace(/[\]]/, '\\]');  
        var pattern = "[\\?&]" + key + "=([^&#]*)";  
        var regex = new RegExp(pattern);  
        var url = unescape(window.location.href);  
        var results = regex.exec(url);  
        if (results === null) {  
            return null;  
        } else {  
            return results[1];  
        }  
    }  
    var code = $.get("cuser");    
    confirmarUser(code);
    
}
function confirmarUser(code){
     $.post("funciones.php", { accion: "confirm_user", code: code },
        function(data){ 
             switch(data.error){
             case "0": $("#correct").show();
                    break;
             case "1":  
                       $("#error").show();
                                             
                    break;  
             case "2":
                       $("#error").show();
                       break;
             }
         }
         ,"json");
}
</script>
<!DOCTYPE>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Oxygen-Fx -Sistema de control interno</title>
<link rel="stylesheet" href="css/style_system.css" type="text/css">
<link rel="shortcut icon" href="images/favicon.png" type="img/x-icon">
</head>

<body>
  <div id="correct" class="container txt-center" style='display:none;'>
        <img src="/system/images/img-logo.png" border="0" alt="img-logo.png (6,517 bytes)">
        <h1>Registro Completo!</h1>
        <p>Bienvenido <strong id="usarname"></strong>,</p>
        <p>Estas a un solo paso de poder activar tu cuenta.</p>
        <p>Para poder terminar el proceso y poder activar tu cuenta. Lo unico que tienes que hacer es dar click en continuar</p>
        <br /><br />
        <p><a href="login.php" class="btn_4">Continuar</a></p>
  </div>
  
  
  <div id="error" class="container txt-center" style='display:none;'>
       <img src="/system/images/img-logo.png" border="0" alt="img-logo.png (6,517 bytes)">
        <h1>El codigo de certificacion caduco</h1>
        <p>Esta operacion no puede ser procesada.Posiblemente tu cuenta ya ha sido activada. </p>
        <br /><br />
        <p><a href="login.php" class="btn_4">Continuar</a></p>
  </div>
</body>

</html>
