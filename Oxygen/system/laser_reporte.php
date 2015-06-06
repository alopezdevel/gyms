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
    
    CargarReporte();
    $('#grid-head1 input').keyup(CargarReporte); 

    //focus
    $('form input').focus(onFocus);
    //blur
    $('form input').blur(onBlur);

    $(".numeros").keydown(inputnumero);
}
function CargarReporte(){

    var filtro_id_empleado = "";
    var filtro_nombre_empleado = "";
    var filtro_telefono = "";
    var filtro_direccion = "";
    var filtro_correo = "";
    var filtro_edad = "";
    var filtro_puesto = "";
    var filtro_area = "";
    var filtro_horario = "";
    
    if($('#filtro_id_empleado').val() != ""){
        
        filtro_id_empleado = $('#filtro_id_empleado').val();
    }
    if($('#filtro_nombre_empleado').val() != ""){
        
        filtro_nombre_empleado = $('#filtro_nombre_empleado').val();
    }
    if($('#filtro_telefono').val() != ""){
        
        filtro_telefono = $('#filtro_telefono').val();
    }
    if($('#filtro_direccion').val() != ""){
        
        filtro_direccion = $('#filtro_direccion').val();
    }
    if($('#filtro_correo').val() != ""){
        
        filtro_correo = $('#filtro_correo').val();
    } 
    if($('#filtro_edad').val() != ""){
        
        filtro_edad = $('#filtro_edad').val();
    }
    if($('#filtro_puesto').val() != ""){
        
        filtro_puesto = $('#filtro_puesto').val();
    }
    if($('#filtro_area').val() != ""){
        
        filtro_area = $('#filtro_area').val();
    }
    if($('#filtro_horario').val() != ""){
        
        filtro_horario = $('#filtro_horario').val();
    }
    $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarReporte",filtro_id_empleado: filtro_id_empleado, filtro_nombre_empleado:filtro_nombre_empleado, filtro_telefono:filtro_telefono, filtro_direccion:filtro_direccion, filtro_correo:filtro_correo,filtro_edad:filtro_edad, filtro_puesto : filtro_puesto, filtro_area: filtro_area, filtro_horario: filtro_horario},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $("#data_grid_reporte tbody").empty().append(data.tabla);
                    $("#data_grid_reporte tbody tr:even").addClass('gray');
                    $("#data_grid_reporte tbody tr:odd").addClass('white');
                }
     });            
}
function onBorrarPuesto(id){
   if(confirm("estas seguro que desea borrar el registro del puesto?")){ 
    $.post("laser_funciones.php", { accion: "BorrarPuesto", id:id},
        function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("El registro se ha borrado de manera satisfactoria.");
                         CargarPuestos();
                    break;  
             }
         }
         ,"json");           
   }
}
function onNuevoPuesto(){
  
    var puesto = $("#Puesto");    
    var area = $("#Area");
    var horario = $("#horario");
    var empleado = $("#empleados");
    
    todosloscampos = $( [] ).add( puesto ).add( area ).add( horario ).add( empleado );
    todosloscampos.removeClass( "error" );
    $("#Puesto").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    valid = valid && checkLength( puesto, "Puesto", 2, 25 );
    valid = valid && checkRegexp( puesto, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    
    valid = valid && checkLength( area, "Area", 2, 25 );
    valid = valid && checkRegexp( area, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    
    valid = valid && checkLength( horario, "Horario", 1, 100 );
    
    valid = valid && checkLength( empleado, "Empleado", 1, 100 );
    
    
    if ( valid ) {
        
        $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"NuevoPuesto", puesto: puesto.val(), area: area.val(), horario: horario.val(), empleado: empleado.val() },
        async : true,
        dataType : "json",
        success : function(data){                               
            switch(data.error){
            case "1": alert(data.mensaje);
                         $("#Puesto").focus();
            break;
            case "0": actualizarMensajeAlerta("Favor de llenar los campos.");
                        $('form input').val("");                                                             
                         alert(data.mensaje);   
                         cerrarventana('#frm_container');
                         mostrarventana('#data_grid_puestos');
                         CargarPuestos(); 
            break;  
            }
        }
     });
        
    }
    
     
} 
function onActualizarPuesto(){
   
    var id = $("#id_puesto").val();
    var puesto = $("#Puesto");    
    var area = $("#Area");
    var horario = $("#horario");
    var empleado = $("#empleados");
    
    todosloscampos = $( [] ).add( puesto ).add( area ).add( horario ).add( empleado );
    todosloscampos.removeClass( "error" );
    $("#Puesto").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    valid = valid && checkLength( puesto, "Puesto", 2, 25 );
    valid = valid && checkRegexp( puesto, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    
    valid = valid && checkLength( area, "Area", 2, 25 );
    valid = valid && checkRegexp( area, /^[a-z]([0-9a-z_\s])+$/i, "Este campo puede contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." ); 
    
    valid = valid && checkLength( horario, "Horario", 1, 100 );
    
    valid = valid && checkLength( empleado, "Empleado", 1, 100 );
    
    
    
    if ( valid ) {
        
        $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"ActualizarPuesto", id: id, puesto: puesto.val(), area: area.val(), horario: horario.val(), empleado: empleado.val() },
        async : true,
        dataType : "json",
        success : function(data){                               
            switch(data.error){
            case "1": alert(data.mensaje);
                         $("#Puesto").focus();
            break;
            case "0": actualizarMensajeAlerta("Favor de llenar los campos.");
                        $('form input').val("");  
                        $('form select option[value=""]').attr("selected",true);                                                              
                         alert(data.mensaje);   
                         cerrarventana('#frm_container');
                         mostrarventana('#data_grid_puestos');
                         CargarPuestos(); 
            break;  
            }
        }
     });
        
    } 
}
function onCargarPuesto(id){
        
       cerrarventana('#data_grid_puestos');
       mostrarventana('#frm_container');
       mostrarformulario('editar_puesto');
       //cargando los datos del empleado:
       $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarPuesto", id : id},
                async : true,
                dataType : "json",
                success : function(data){                               
                switch(data.error){
                    case "1":   
                        break;
                    case "0":    
                    $('#id_puesto').val(id);
                    $("#Puesto").val(data.puesto);
                    $("#Area").val(data.area);
                    $("#horario option[value='"+ data.horario +"']").attr("selected",true);
                    $("#empleados option[value='"+ data.empleado +"']").attr("selected",true);
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
    
    cargarhorarios();
    cargarempleados();
    switch (formulario){
        case 'nuevo_puesto': $('#frm_container h2').empty().text('Nuevo puesto');
            $('#btn-nuevopuesto').show('fast');
            $('#btn-editarpuesto').hide('fast'); 
        break;
        case 'editar_puesto': $('#frm_container h2').empty().text('Editar puesto');
        $('#btn-nuevopuesto').hide('fast');
        $('#btn-editarpuesto').show('fast');
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
    CargarReporte();
}    
</script>
<div id="layer_content" class="main-section">  
    <div class="container">
        <div class="page-title">
            <h1>Reportes</h1>
            <h2>Reporte General</h2>
        </div>
        <table id="data_grid_reporte" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td class="etiqueta_grid"><input class="filtro numeros" id="filtro_id_empleado" type="text" placeholder="ID:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_nombre_empleado" type="text" placeholder="Nombre:"></td>
                <td class="etiqueta_grid"><input class="filtro numeros" id="filtro_telefono" type="text" placeholder="Telefono:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_direccion" type="text" placeholder="Direccion:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_correo" type="text" placeholder="Correo electronico:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_edad" type="text" placeholder="Edad:"></td> 
                <td class="etiqueta_grid"><input class="filtro" id="filtro_puesto" type="text" placeholder="Puesto:"></td> 
                <td class="etiqueta_grid"><input class="filtro" id="filtro_area" type="text" placeholder="Area:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_horario" type="text" placeholder="Horario:"></td>    
                <td class="etiqueta_grid"><span class="btn-icon btn-left limpiar" title="Limpiar Filtros" onclick="limpiarfiltros();"><i class="fa fa-undo"></i></span></td>  
            </tr>
            <tr id="grid-head2">
                <td class="etiqueta_grid">ID Empleado</td>                            
                <td class="etiqueta_grid" nowrap="nowrap" >Nombre del empleado</td>
                <td class="etiqueta_grid">Telefono</td>
                <td class="etiqueta_grid">Direccion</td> 
                <td class="etiqueta_grid">Correo electronico</td> 
                <td class="etiqueta_grid">Edad</td> 
                <td class="etiqueta_grid">Puesto</td> 
                <td class="etiqueta_grid">Area</td>
                <td class="etiqueta_grid" colspan="2" nowrap="nowrap">Horario del Puesto</td>  
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="100%"></td>
            </tr>
        </tfoot>
        </table>
        <div id="frm_container" class="frm-dialog" style="display: none;">
                <div id="btn_cerrar_frm" class="right" onclick="cerrarventana('#frm_container');mostrarventana('#data_grid_puestos');"><i class="fa fa-times-circle"></i></div>
                <h2 class="txt-center">Nuevo</h2>
                <form id="frm_puesto" action="" method="post">
                  <p class="mensaje_valido">Favor de llenar los campos.</p> 
                  <input id="Puesto" type="text" name="Puesto" placeholder="Nombre del Puesto:" maxlength="50">  
                  <input id="Area" type="text" name="Area" placeholder="Area:" maxlength="50">
                  <label>Horario:</label>
                  <select id="horario" name="horario">
                    <option value="">Selecciona una opcion...</option> 
                  </select>
                  <label>Empleado:</label>
                  <select id="empleados" name="empleados">
                    <option value="">Selecciona una opcion...</option>
                  </select>
                  <button id="btn-nuevopuesto" type="button" class="btn_4" onclick="onNuevoPuesto();" style="display: none;">Guardar</button>
                  <button id="btn-editarpuesto" type="button" class="btn_4" onclick="onActualizarPuesto();" style="display: none;">Guardar</button>  
                  <input id="id_puesto" type="hidden">
                </form>
        </div>
    </div>
 <?php include("laser_footer.php"); ?>
</div>
</body>
</html>