<?php session_start();    
if ( !(  ($_SESSION["acceso"] == 'U' || $_SESSION["acceso"] == 'A' ) && $_SESSION["usuario_actual"] != "" && $_SESSION["usuario_actual"] != NULL  )  ){ //No ha iniciado session, redirecciona a la pagina de login
    header("Location: login.php");
    exit;
}else{ ?>
<!---- HEADER ----->
<?php include("header.php"); ?> 
<script src="/js/jquery.1.8.3.min.js" type="text/javascript"></script> 
<script src="/../../../code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(inicio);
function inicio(){
    //variable 
    mensaje = $( ".mensaje_valido" );
    $("#btn_register").click(onInsertarUsuario);      
    //focus
    $('input.texto').focus(onFocus);
    //blur
    $('input.texto').blur(onBlur);    
}
function onInsertarUsuario(){
    //Variables
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    var floatRegex = /[-+]?([0-9]*.[0-9]+|[0-9]+)/; 
    var name = $("#nombre");    
    var apellido_paterno = $("#apellido_paterno");
    var apellido_materno = $("#apellido_materno");
    var email = $("#email");
    var calle = $("#calle");
    var colonia = $("#colonia");
    var telefono = $("#telefono");
    var sexo = $("#sexo");
    var mensualidad = $("#mensualidad");

    
    todosloscampos = $( [] ).add( name ).add( apellido_paterno ).add( apellido_materno ).add( apellido_materno ).add( email ).add( calle ).add( colonia ).add( telefono ).add( sexo ).add( mensualidad );
    todosloscampos.removeClass( "error" );
    
    
    $("#name").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );     
    
    //validaciones
    var valid = true;
    
    //Nombre socio
    valid = valid && checkLength( name, "Nombre del socio", 2, 25 );
    valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Nombre del socio debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido paterno
    valid = valid && checkLength( apellido_paterno, "Apellido paterno", 2, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido paterno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido materno
    valid = valid && checkLength( apellido_materno, "Apellido materno", 2, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido materno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //email
    valid = valid && checkLength( email, "E-mail", 6, 80 );                                                                                                           
    valid = valid && checkRegexp( email, emailRegex, "ej. ui@hotmail.com" );
    //calle
    valid = valid && checkLength( calle, "Calle", 5, 25 );
    valid = valid && checkRegexp( calle, /^[a-z]([0-9a-z_\s])+$/i, "Calle debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //colonia
    valid = valid && checkLength( colonia, "Colonia", 5, 25 );
    valid = valid && checkRegexp( colonia, /^[a-z]([0-9a-z_\s])+$/i, "Colonia debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    
    valid = valid && checkLength( telefono, "Telefono", 6, 25 );
    valid = valid && checkRegexp( telefono, /[0-9-()+]{3,20}/, "Telefono solo permite numeros: 0-9" );
    
    if($("#sexo").val() == ""){
        valid = false;
        actualizarMensajeAlerta( 'Favor de seleccionar un genero para el socio' );  
    }
    
    if($("#mensualidad").val()!= ""){
        valid = valid && checkLength( mensualidad, "Mensualidad", 1, 25 );
        valid = valid && checkRegexp( mensualidad, floatRegex , "Mensualidad solo permite numeros: 0-9" );
    }
    
    
   
    
    //exp
   
    if ( valid ) {
        $.post("funciones.php", { accion: "alta_usuario", nombre: name.val() , apellido_paterno: apellido_paterno.val(),
                                                          apellido_materno: apellido_materno.val() , email: email.val(),
                                                          calle: calle.val() , colonia: colonia.val(), 
                                                          telefono: telefono.val() , mensualidad: mensualidad.val(), 
                                                          sexo: sexo.val() ,nivel: "C"},
        function(data){ 
             switch(data.error){
             case "1":   actualizarMensajeAlerta( data.mensaje);
                         $("#nombre").focus();
                         email.addClass( "error" ); 
                    break;
             case "0":   actualizarMensajeAlerta("Favor de llenar los campos.");
                         $('input.texto').val("");
                         $("#sexo").val("");
                         $("#name").focus();                                                                          
                         alert("Gracias. El usuario " + name.val() + " se ha registrado de manera satisfactoria.");   
                         actualizarMensajeAlerta("Gracias. El usuario " + name.val() + " se ha registrado de manera satisfactoria.");
                         //location.href= "inicio.php";
                    break;  
             }
         }
         ,"json"); 
    }          
   
}


 function onFocus(){
     $(this).css("background-color","#FFFFC0");
 }
 function onBlur(){
    $(this).css("background-color","#FFFFFF");
 }
 function actualizarMensajeAlerta( t ) {
      mensaje
        .text( t )
        .addClass( "alertmessage" );
      setTimeout(function() {
        mensaje.removeClass( "alertmessage", 2500 );
      }, 700 );
 }
 function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        actualizarMensajeAlerta( n );
        o.addClass( "error" );
        o.focus();
        return false;
    } else {                     
        return true;        
    }
 }
 function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        actualizarMensajeAlerta( "La longitud del campo " + n + " debe contener por lo menos entre " + min + " y " + max + ". caracteres"  );
        o.addClass( "error" );
        o.focus();
        return false;    
    } else {             
        return true;                     
    }                    
 }
</script>
<div id="layer_content" class="main-section">
    <div class="container">
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Nuevo Socio</h2>
        </div>
        <form method="post" action="">
            <p class="mensaje_valido">&nbsp;Favor de llenar los campos.</p>
            <input  id = "nombre"   class="texto" name="nombre" type="text" placeholder="Nombre del socio:">
            <input  id = "apellido_paterno" class="texto"  name="apellido_paterno" type="text" placeholder="Apellido paterno:">
            <input  id = "apellido_materno" class="texto"  name="apellido_materno" type="text" placeholder="Apellido materno:">
            <input  id = "email" name="email" class="texto" type="text" placeholder="E-mail:">         
            <input  id = "calle" name="calle" class="texto" type="text" placeholder="Calle:">
            <input  id = "colonia" name="colonia" class="texto" type="text" placeholder="Colonia:">
            <input  id = "telefono" name="Telefono" class="texto" type="text" placeholder="telefono:">
            <select name="sexo" id="sexo" class="texto">
                <option value=""><-Seleccione Genero-></option>
                <option value="M">Masculino</option>
                <option value="F">Femeino</option>
            </select>            
            <input  id = "mensualidad"  class="texto" name="mensualidad" type="text" placeholder="Mensualidad sugerida (opcional):">
            <button id = "btn_register" class="btn_register btn_4" type="button">Register</button>
        </form>
    </div>
</div>
<!---- FOOTER ----->
<?php //include("footer.php"); ?> 

</body>

</html>
<?php }?>
