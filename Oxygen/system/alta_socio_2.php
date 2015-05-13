<?php 
 session_start();
include("header.php");?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(inicio);
function inicio(){
    var dialogo;
    dialogo = $( "#dialog-user" ).dialog({
      autoOpen: false,
      height: 800,
      width: 1296,                                 
      modal: true,  
       buttons: {
        "Crear nuevo usuario": onInsertarUsuario,
        Cancel: function() {
          dialogo.dialog( "close" );
        }
      },    
      close: function() {
        //form[ 0 ].reset();
        //allFields.removeClass( "ui-state-error" );
      }
    }); 
     //focus
    $('input.texto').focus(onFocus);
    //blur
    $('input.texto').blur(onBlur);
    $("#Nuevosocio").click(onAltaCliente);
}
function onInsertarUsuario(){    
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
      var mensaje = $( ".mensaje_valido" );
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
function onAltaCliente(){
  
    $( "#dialog-user" ).dialog("open");
} 
</script>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Catalogo de Socios</h2>
        </div>
        <div class="txt-content"> 
            <div class="frm-buscar3">
                <div class="frm-btns clearfix">
                        <button type="submit">Buscar</button> 
                        <button type="submit" name="RecargarLista" value="1">Actualizar lista</button>
                        <button id="Nuevosocio" name="Nuevosocio" type="button" value="1" >Nuevo socio</button> 
                </div>                    
            </div>
        </div> 
        
        <table id="data_grid_certificate" class="data_grid">
        <thead id="grid-head2">                                                                                       
            <tr>                            
                <td align="center" class="etiqueta_grid" nowrap="nowrap" ><input class="inp"  id="filtro_CreatedDate" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_InsuredName" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_email" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_CertificateHolder" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  align="center" id="filtro_DescriptionOperations" type="text"></td>
                <td align="center" class="etiqueta_grid" nowrap="nowrap"><select   id="filtro_Status" ><option value="">Select<option value="0">IN PROCESS</option><option value="1">COMPLETED</option></td>
                <td align="center" class="etiqueta_grid"><input class="inp"   id="filtro_SendingDate" type="text"></td>
                <td></td> 
            </tr>
            <tr>                            
                <td align="center" class="etiqueta_grid" nowrap="nowrap" >Created Date</td>
                <td align="center" class="etiqueta_grid">Insured Name</td>
                <td align="center" class="etiqueta_grid">E-mail</td>
                <td align="center" class="etiqueta_grid">Certificate Holder</td>
                <td align="center" class="etiqueta_grid"  nowrap="nowrap" >Description of Operations</td>
                <td align="center" class="etiqueta_grid">Status</td>
                <td align="center" class="etiqueta_grid" nowrap="nowrap">Sending Date </td>
                <td></td> 
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
        </table>
        
        
    </div> 
</div>    
<div id="dialog-user" title="Alta Socio" class="ui-widget" >
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
        </form>
    </div> 
</div>
</body>
</html>
                