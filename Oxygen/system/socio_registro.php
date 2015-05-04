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
    $("#name").focus().css("background-color","#FFFFC0");
    //focus
    $("#name").focus(onFocus);
    $("#apellido_paterno").focus(onFocus);
    $("#apellido_materno").focus(onFocus);
    $("#calle").focus(onFocus);
    $("#colonia").focus(onFocus);
    $("#email").focus(onFocus);
    $("#telefono").focus(onFocus);    
    $("#genero").focus(onFocus);
    $("#mensualidad").focus(onFocus);
    //blur
    $("#name").focus(onBlur);
    $("#apellido_paterno").focus(onBlur);
    $("#apellido_materno").focus(onBlur);
    $("#calle").focus(onBlur);
    $("#colonia").focus(onBlur);
    $("#email").focus(onBlur);
    $("#telefono").focus(onBlur);    
    $("#genero").focus(onBlur);
    $("#mensualidad").focus(onBlur);
    
}
function onInsertarUsuario(){
    //Variables
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    var phoneNumber = /^[0-9-()+]{3,20}/;
    var floatRegex = /[-+]?([0-9]*\.[0-9]+|[0-9]+)/;
    var name = $("#name");
    var apellido_paterno = $("#apellido_paterno");
    var apellido_materno = $("#apellido_materno");
    var calle = $("#calle");
    var colonia = $("#colonia");
    var email = $("#email");
    var telefono = $("#telefono");
    var genero = $("#genero");
    var mensualidad = $("mensualidad");
    todosloscampos = $( [] ).add( name ).add( apellido_paterno ).add( apellido_materno ).add( calle ).add( colonia ).add( email ).add( telefono ).add( genero ).add( mensualidad );
    todosloscampos.removeClass( "error" );
    
    
    $("#name").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );     
    
    //validaciones
    var valid = true;
    
    //tamano
    valid = valid && checkLength( name, "Nombre del socio", 5, 25 );
    valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Nombre del socio requiere a-z, 0-9, espacios,y debe iniciar con una letra." );
    
    valid = valid && checkLength( apellido_paterno, "apellido paterno", 1, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "apellido paterno del socio requiere a-z, 0-9, espacios,y debe iniciar con una letra." );
    
    valid = valid && checkLength( apellido_materno, "apellido materno", 1, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "apellido materno del socio requiere a-z, 0-9, espacios,y debe iniciar con una letra." );
    
    valid = valid && checkLength( calle, "calle", 1, 50 );
    valid = valid && checkRegexp( calle, /^[a-z]([0-9a-z_\s])+$/i, "calle del socio requiere a-z, 0-9, espacios,y debe iniciar con una letra." );
    
    valid = valid && checkLength( colonia, "colonia", 1, 50 );
    valid = valid && checkRegexp( colonia, /^[a-z]([0-9a-z_\s])+$/i, "colonia del socio requiere a-z, 0-9, espacios,y debe iniciar con una letra." );
    
    valid = valid && checkLength( email, "E-mail", 6, 80 );
    valid = valid && checkRegexp( email, emailRegex, "eg. ui@oxygen.com" );
    
    valid = valid && checkLength( telefono, "telefono", 10, 80 );
    valid = valid && checkRegexp( telefono, phoneNumber, "telefono del socio requiere 0-9." );
    
    valid = valid && checkLength( mensualidad, "mensualidad", 1, 80 );
    valid = valid && checkRegexp( mensualidad, floatRegex, "telefono solo cantidades" );
    
     
    
    //exp
    
    
    
    
 
    
    if ( valid ) {
        $.post("funciones.php", { accion: "alta_usuario", name: name.val() , email: email.val(), password: password.val(), nivel: "C"},
        function(data){ 
             switch(data.error){
             case "1":   actualizarMensajeAlerta( data.mensaje);
                         $("#email").focus();
                         email.addClass( "error" ); 
                    break;
             case "0":   actualizarMensajeAlerta("All form fields are required.");
                         $("#name").val("");
                         $("#email").val("");
                         $("#password").val("");
                         $("#recapturapassword").val("");
                         $("#name").focus();
                    break;  
             }
         }
         ,"json"); 
    }          
   
}


 function onFocus(){     
     $(this).css("background-color","#FFFFC0");
 }               ``
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
        actualizarMensajeAlerta( "Tamaño de: " + n + " debe ser entre " + min + " y " + max + "."  );
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
            <h1>Socio</h1>
            <h2>Nuevo Socio</h2>
        </div>
		<form method="post" action="">
            <p class="mensaje_valido">&nbsp;Favor de llenar los campos obligatorios.</p>
			<input  id = "name"   name="name" type="text" placeholder="Nombre del socio:">
            <input  id = "apellido_paterno"   name="apellido_paterno" type="text" placeholder="Apellido paterno del socio:">
            <input  id = "apellido_materno"   name="apellido_materno" type="text" placeholder="Apellido materno del socio:">
            <input  id = "calle"   name="calle" type="text" placeholder="calle:">
            <input  id = "colonia"   name="colonia" type="text" placeholder="colonia:">
			<input  id = "email"name="email" type="email" placeholder="E-mail:">
            <input  id = "telefono" name="telefono" type="email" placeholder="Telefono:">
            <input  id = "genero"name="genero" type="email" placeholder="Genero:">
            <input  id = "mensualidad" name="mensualidad" type="email" placeholder="mensualidad programada:">
			<button id = "btn_register" class="btn_register btn_4" type="button">Register</button>
		</form>
	</div>
</div>
<!---- FOOTER ----->
<?php include("footer.php"); ?> 

</body>

</html>
