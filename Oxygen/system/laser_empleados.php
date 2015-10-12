<?php
    session_start();  
    include("laser_header.php");
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="lib/jNotify/jNotify.jquery.css"> 
<script src="lib/jNotify/jNotify.jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(inicio);
function inicio(){
    
    CargarEmpleados();
    
    $( "#filtro_fecha_creacion" ).datepicker({onSelect: function(){ CargarEmpleados()},dateFormat: 'dd/mm/yy'}); 
    $('#grid-head1 input').keyup(CargarEmpleados); 
    $( "#filtro_fecha_creacion" ).keyup(CargarEmpleados);
    //focus
    $('form input').focus(onFocus);
    //blur
    $('form input').blur(onBlur);

    $("form .numeros").keydown(inputnumero);
    //$('#btn-nuevoempleado').click(onNuevoEmpleado); 
}
function CargarEmpleados(){

    var filtro_id = "";
    var filtro_nombre = "";
    var filtro_correo = "";
    var filtro_fecha_creacion = "";
    
    if($('#filtro_fecha_creacion').val() != ""){
        
        filtro_fecha_creacion = $('#filtro_fecha_creacion').val();
    }
    if($('#filtro_id_empleado').val() != ""){
        
        filtro_id = $('#filtro_id_empleado').val();
    }
    if($('#filtro_nombre').val() != ""){
        
        filtro_nombre = $('#filtro_nombre').val();
    }
    if($('#filtro_correo').val() != ""){
        
        filtro_correo = $('#filtro_correo').val();
    }
    $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarEmpleados", filtro_id : filtro_id, filtro_nombre: filtro_nombre, filtro_correo: filtro_correo, filtro_fecha_creacion: filtro_fecha_creacion},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $("#data_grid_empleados tbody").empty().append(data.tabla);
                    $("#data_grid_empleados tbody tr:even").addClass('gray');
                    $("#data_grid_empleados tbody tr:odd").addClass('white');
                }
     });            
}
function onBorrarEmpleado(id){
   if(confirm("estas seguro que desea borrar al empleado con el ID: " + id + "?")){ 
    $.post("laser_funciones.php", { accion: "BorrarEmpleado", id:id},
        function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("El empleado se ha borrado de manera satisfactoria.");
                         CargarEmpleados();
                    break;  
             }
         }
         ,"json");           
   }
}
function onNuevoEmpleado(){
  
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/; 
    var nombre = $("#Nombre");    
    var apellido_paterno = $("#ApellidoPaterno");
    var apellido_materno = $("#ApellidoMaterno");
    var telefono = $("#Telefono"); 
    var direccion = $("#Direccion");
    var colonia = $("#Colonia");
    var email = $("#CorreoElectronico");
    var edad = $("#Edad");
    
    todosloscampos = $( [] ).add( nombre ).add( apellido_paterno ).add( apellido_materno ).add( telefono ).add( direccion ).add( colonia ).add( email ).add( edad );
    todosloscampos.removeClass( "error" );
    $("#nombre").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    //Nombre 
    valid = valid && checkLength( nombre, "Nombre", 2, 25 );
    valid = valid && checkRegexp( nombre, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    //Apellidos
    valid = valid && checkLength( apellido_paterno, "Apellido Paterno", 2, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    valid = valid && checkLength( apellido_materno, "Apellido Materno", 2, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    
    //Telefono:
    valid = valid && checkLength( telefono, "Telefono", 6, 25 );
    
    //Direccion:
    valid = valid && checkLength( direccion, "Direccion", 6, 25 );
    
    //Colonia:
    valid = valid && checkLength( colonia, "Colonia", 6, 25 );
    
    //email
    valid = valid && checkLength( email, "Correo electronico", 6, 80 );                                                                                                           
    valid = valid && checkRegexp( email, emailRegex, "ej. ui@hotmail.com" );
    
    //Edad:
    valid = valid && checkLength( edad, "Edad", 2, 10 );
    
    
    
    if ( valid ) {
        
        $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"nuevo_empleado", nombre: nombre.val(), apellidopaterno: apellido_paterno.val(), apellidomaterno: apellido_materno.val(), telefono: telefono.val(), direccion: direccion.val(), colonia: colonia.val(), email: email.val(), edad: edad.val() },
        async : true,
        dataType : "json",
        success : function(data){                               
            switch(data.error){
            case "1": alert(data.mensaje);
                         $("#Nombre").focus();
            break;
            case "0": actualizarMensajeAlerta("Favor de llenar los campos.");
                        $('form input').val("");                                                             
                         alert(data.mensaje);   
                         cerrarventana('#frm_container');
                         mostrarventana('#data_grid_empleados');
                         CargarEmpleados(); 
            break;  
            }
        }
     });
        
    }
    
     
} 
function onActualizarEmpleado(){
   
   var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/; 
    var id = $('#id_empleado').val();
    var nombre = $("#Nombre");    
    var apellido_paterno = $("#ApellidoPaterno");
    var apellido_materno = $("#ApellidoMaterno");
    var telefono = $("#Telefono"); 
    var direccion = $("#Direccion");
    var colonia = $("#Colonia");
    var email = $("#CorreoElectronico");
    var edad = $("#Edad");
    
    todosloscampos = $( [] ).add( nombre ).add( apellido_paterno ).add( apellido_materno ).add( telefono ).add( direccion ).add( colonia ).add( email ).add( edad );
    todosloscampos.removeClass( "error" );
    $("#nombre").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    //Nombre 
    valid = valid && checkLength( nombre, "Nombre", 2, 25 );
    valid = valid && checkRegexp( nombre, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    //Apellidos
    valid = valid && checkLength( apellido_paterno, "Apellido Paterno", 2, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    valid = valid && checkLength( apellido_materno, "Apellido Materno", 2, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    
    //Telefono:
    valid = valid && checkLength( telefono, "Telefono", 6, 25 );
    
    //Direccion:
    valid = valid && checkLength( direccion, "Direccion", 6, 25 );
    
    //Colonia:
    valid = valid && checkLength( colonia, "Colonia", 6, 25 );
    
    //email
    valid = valid && checkLength( email, "Correo electronico", 6, 80 );                                                                                                           
    valid = valid && checkRegexp( email, emailRegex, "ej. ui@hotmail.com" );
    
    //Edad:
    valid = valid && checkLength( edad, "Edad", 2, 10 );
    
    
    
    if ( valid ) {
        
        $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"actualizar_empleado", id: id, nombre: nombre.val(), apellidopaterno: apellido_paterno.val(), apellidomaterno: apellido_materno.val(), telefono: telefono.val(), direccion: direccion.val(), colonia: colonia.val(), email: email.val(), edad: edad.val() },
        async : true,
        dataType : "json",
        success : function(data){                               
            switch(data.error){
            case "1": alert(data.mensaje);
                         $("#Nombre").focus();
            break;
            case "0": actualizarMensajeAlerta("Favor de llenar los campos.");
                        $('form input').val("");                                                             
                         alert(data.mensaje);   
                         cerrarventana('#frm_container');
                         mostrarventana('#data_grid_empleados');
                         CargarEmpleados(); 
            break;  
            }
        }
     });
        
    } 
}
function onCargarEmpleado(id){
        
       cerrarventana('#data_grid_empleados');
       mostrarventana('#frm_container');
       mostrarformulario('editar_empleado');
       //cargando los datos del empleado:
       $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarEmpleado", id : id},
                async : true,
                dataType : "json",
                success : function(data){                               
                switch(data.error){
                    case "1":   
                        break;
                    case "0":    
                    $('#id_empleado').val(id);
                    $("#Nombre").val(data.nombre);
                    $("#ApellidoPaterno").val(data.apellidopaterno);
                    $("#ApellidoMaterno").val(data.apellidomaterno);
                    $("#Telefono").val(data.telefono);
                    $("#Direccion").val(data.direccion);
                    $("#Colonia").val(data.colonia);
                    $("#CorreoElectronico").val(data.correo);
                    $("#Edad").val(data.edad);
                    break;
                }
                }
        });
       
}
function cerrarventana(ventana){
    
   $(ventana).hide('slow');
   $(ventana + ' input').val(""); 
} 
function mostrarventana(ventana){
    $(ventana).show('slow');
}
function mostrarformulario(formulario){
    
    switch (formulario){
        case 'nuevo_empleado': $('#frm_container h2').empty().text('Nuevo Empleado');
        $('#btn-nuevoempleado').show('fast');
        $('#btn-editarempleado').hide('fast'); 
        break;
        case 'editar_empleado': $('#frm_container h2').empty().text('Editar Empleado');
        $('#btn-nuevoempleado').hide('fast');
        $('#btn-editarempleado').show('fast');
        break;    
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
function inputnumero(){
    
        if(event.shiftKey)
            {
                event.preventDefault();
            }
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9){}
        else {
                if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                        event.preventDefault();
                    }
                } 
                else {
                    if (event.keyCode < 96 || event.keyCode > 105) {
                        event.preventDefault();
                    }
                }
      }
}  
function limpiarfiltros(){
    $('.filtro').val("");
    CargarEmpleados();
}    
</script>
<div id="layer_content" class="main-section">  
    <div class="container">
        <div class="page-title">
            <h1>Empleados</h1>
            <h2>Catalogo de Empleados</h2>
        </div>
        <table id="data_grid_empleados" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td class="etiqueta_grid" nowrap="nowrap" ><input class="filtro" id="filtro_fecha_creacion" type="text"></td>
                <td class="etiqueta_grid"><input  class="filtro" id="filtro_id_empleado" type="text" placeholder="ID Empleado:"></td>
                <td class="etiqueta_grid"><input  class="filtro" id="filtro_nombre" type="text" placeholder="Nombre Completo:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_correo" type="text" placeholder="Correo electronico:"></td> 
                <td class="etiqueta_grid"><span class="btn-icon btn-left limpiar" title="Limpiar Filtros" onclick="limpiarfiltros();"><i class="fa fa-undo"></i></span> <span class="btn-icon btn-left" title="Agregar empleado" onclick="cerrarventana('#data_grid_empleados');mostrarventana('#frm_container');mostrarformulario('nuevo_empleado');"><i class="fa fa-user-plus"></i></span></td>  
            </tr>
            <tr id="grid-head2">                            
                <td class="etiqueta_grid" nowrap="nowrap" >Fecha de registro</td>
                <td class="etiqueta_grid">ID Empleado</td>
                <td class="etiqueta_grid">Nombre Completo</td> 
                <td class="etiqueta_grid">Correo Electronico</td>
                <td class="etiqueta_grid">&nbsp;</td> 
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
                <td></td>
            </tr>
        </tfoot>
        </table>
        <div id="frm_container" class="frm-dialog" style="display: none;">
                <div id="btn_cerrar_frm" class="right" onclick="cerrarventana('#frm_container');mostrarventana('#data_grid_empleados');"><i class="fa fa-times-circle"></i></div>
                <h2 class="txt-center">Nuevo Empleado</h2>
                <form id="frm_empleado" action="" method="post">
                  <p class="mensaje_valido">Favor de llenar los campos.</p> 
                  <input id="Nombre" type="text" name="NombreEmpleado" placeholder="Nombre:" maxlength="50">  
                  <input id="ApellidoPaterno" type="text" name="ApellidoPaterno" placeholder="Apellido paterno:" maxlength="50">
                  <input id="ApellidoMaterno" type="text" name="ApellidoMaterno" placeholder="Apellido materno:" maxlength="50">
                  <input id="Telefono" type="tel" name="Telefono" placeholder="Telefono:" class="numeros" maxlength="10">
                  <input id="Direccion" type="text" name="Direccion" placeholder="Direccion:" maxlength="200"> 
                  <input id="Colonia" type="text" name="Colonia" placeholder="Colonia:" maxlength="100">
                  <input id="CorreoElectronico" type="text" name="CorreoElectronico" placeholder="Correo electronico:" maxlength="50">
                  <input id="Edad" type="text" name="Edad" placeholder="Edad:" class="numeros" maxlength="2">
                  <button id="btn-nuevoempleado" type="button" class="btn_4" onclick="onNuevoEmpleado();" style="display: none;">Guardar</button>
                  <button id="btn-editarempleado" type="button" class="btn_4" onclick="onActualizarEmpleado();" style="display: none;">Guardar</button>  
                  <input id="id_empleado" type="hidden">
                </form>
        </div>
    </div>
 <?php include("laser_footer.php"); ?>
</div>
</body>
</html>