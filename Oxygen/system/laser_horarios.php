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
    
    CargarHorarios();
    
    //$( "#filtro_fecha_creacion" ).datepicker({onSelect: function(){ CargarHorarios()},dateFormat: 'dd/mm/yy'}); 
    $('#grid-head1 input').keyup(CargarHorarios); 
    //$( "#filtro_fecha_creacion" ).keyup(CargarHorarios);
    //focus
    $('form input').focus(onFocus);
    //blur
    $('form input').blur(onBlur);

    $("form .numeros").keydown(inputnumero);
     
}
function CargarHorarios(){

    var filtro_id = "";
    var filtro_entrada1 = "";
    var filtro_entrada2 = "";
    var filtro_salida1 = "";
    var filtro_salida2 = "";
    
    if($('#filtro_id_horario').val() != ""){
        
        filtro_id = $('#filtro_id_horario').val();
    }
    if($('#filtro_Entrada1').val() != ""){
        
        filtro_entrada1 = $('#filtro_Entrada1').val();
    }
    if($('#filtro_Entrada2').val() != ""){
        
        filtro_entrada2 = $('#filtro_Entrada2').val();
    }
    if($('#filtro_Salida1').val() != ""){
        
        filtro_salida1 = $('#filtro_Salida1').val();
    }
    if($('#filtro_Salid21').val() != ""){
        
        filtro_salida2 = $('#filtro_Salida2').val();
    }
    $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarHorarios", filtro_id: filtro_id, filtro_entrada1: filtro_entrada1, filtro_entrada2: filtro_entrada2, filtro_salida1: filtro_salida1, filtro_salida2:filtro_salida2},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $("#data_grid_horarios tbody").empty().append(data.tabla);
                    $("#data_grid_horarios tbody tr:even").addClass('gray');
                    $("#data_grid_horarios tbody tr:odd").addClass('white');
                }
     });            
}
function onBorrarHorario(id){
   if(confirm("Esta seguro que desea borrar el horario con el ID: " + id + "?")){ 
    $.post("laser_funciones.php", { accion: "BorrarHorario", id:id},
        function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("El Horario se ha borrado de manera satisfactoria.");
                         CargarHorarios();
                    break;  
             }
         }
         ,"json");           
   }
}
function onNuevoHorario(){
  
    //var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/; 
    var entrada1 = $("#entrada1 option").val();    
    var entrada2 = $("#entrada2 option").val();
    var salida1 = $("#salida1 option").val();
    var salida2 = $("#salida2 option").val(); 
    var tiposemana = $("#tiposemana").val();
;
    
    todosloscampos = $( [] ).add( entrada1 ).add( entrada2 ).add( salida1 ).add( salida2 ).add( tiposemana );
    todosloscampos.removeClass( "error" );
   // $("#nombre").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    //Entradas:
    //valid = valid && checkLength( entrada1, "Entrada 1", 3, 25 );
    //valid = valid && checkLength( entrada2, "Entrada 2", 3, 25 );
    
    //Salida:
    //valid = valid && checkLength( salida1, "Salida 1", 3, 25 );
    //valid = valid && checkLength( salida1, "Salida 2", 3, 25 );
    
    //tiposemana
    //valid = valid && checkLength( tiposemana, "Tipo de Semana", 6, 80 );                                                                                                           

        
    if ( valid ) {
        
        $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"nuevo_horario", entrada1: entrada1, entrada2: entrada2, salida1: salida1, salida2: salida2,  tiposemana: tiposemana },
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
                         mostrarventana('#data_grid_horarios');
                         CargarHorarios(); 
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
function onCargarHorario(id){
        
       cerrarventana('#data_grid_horarios');
       mostrarventana('#frm_container');
       mostrarformulario('editar_horario');
       //cargando los datos del horario:
       $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarHorario", id : id},
                async : true,
                dataType : "json",
                success : function(data){                               
                switch(data.error){
                    case "1":   
                        break;
                    case "0":  
                      
                    $('#id_horario').val(id);
                    $("#entrada1 option[value="+ data.entrada1 +"]").attr("selected",true);
                    $("#salida1 option[value="+ data.salida1 +"]").attr("selected",true); 
                    $("#entrada2 option[value="+ data.entrada2 +"]").attr("selected",true);
                    $("#salida2 option[value="+ data.salida2 +"]").attr("selected",true);
                    $("#tiposemana option[value="+ data.tiposemana +"]").attr("selected",true);         
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
        case 'nuevo_horario': $('#frm_container h2').empty().text('Nuevo Horario');
        $('#btn-nuevohorario').show('fast');
        $('#btn-editarhorario').hide('fast'); 
        break;
        case 'editar_horario': $('#frm_container h2').empty().text('Editar Horario');
        $('#btn-nuevohorario').hide('fast');
        $('#btn-editarhorario').show('fast');
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
    CargarHorarios();
}    
</script>  
<div id="layer_content" class="main-section">  
    <div class="container">
        <div class="page-title">
            <h1>Horarios</h1>
            <h2>Catalogo de Horarios</h2>
        </div>
        <table id="data_grid_horarios" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td class="etiqueta_grid" nowrap="nowrap" ><input class="filtro" id="filtro_id_horario" type="text" placeholder="ID Horario:"></td>
                <td class="etiqueta_grid"><input  class="filtro" id="filtro_Entrada1" type="time" placeholder="Entrada 1:"></td>
                <td class="etiqueta_grid"><input  class="filtro" id="filtro_Salida1" type="time" placeholder="Salida 1:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_Entrada2" type="time" placeholder="Entrada 2:"></td> 
                <td class="etiqueta_grid"><input class="filtro" id="filtro_Salida2" type="time" placeholder="Salida 2:"></td>
                <td class="etiqueta_grid"></td>
                <td class="etiqueta_grid"><span class="btn-icon btn-left limpiar" title="Limpiar Filtros" onclick="limpiarfiltros();"><i class="fa fa-undo"></i></span> <span class="btn-icon btn-left" title="Agregar empleado" onclick="cerrarventana('#data_grid_horarios');mostrarventana('#frm_container');mostrarformulario('nuevo_horario');"><i class="fa fa-plus-circle"></i></span></td>  
            </tr>
            <tr id="grid-head2">                            
                <td class="etiqueta_grid" nowrap="nowrap" >ID Horario</td>
                <td class="etiqueta_grid">Entrada (1)</td>
                <td class="etiqueta_grid">Salida (1)</td> 
                <td class="etiqueta_grid">Entrada (2)</td>
                <td class="etiqueta_grid">Salida (2)</td> 
                <td class="etiqueta_grid">Tipo de Semana</td>
                <td class="etiqueta_grid"></td>
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
                <div id="btn_cerrar_frm" class="right" onclick="cerrarventana('#frm_container');mostrarventana('#data_grid_horarios');"><i class="fa fa-times-circle"></i></div>
                <h2 class="txt-center">Nuevo Empleado</h2>
                <form id="frm_empleado" action="" method="post">
                  <p class="mensaje_valido">Favor de llenar los campos.</p> 
                  <select id="entrada1" class="hora" name="entrada1">
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?>
                  </select>
                  <select id="entrada2" class="hora" name="entrada2">
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?> 
                  </select>
                  <select id="salida1" class="hora" name="salida1">
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?> 
                  </select>
                  <select id="salida2" class="hora" name="salida2">
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?>
                  </select>
                  <select id="tiposemana" name="tiposemana">
                    <option value="1">Inglesa</option>
                    <option value="2">Completa</option>
                  </select>
                  <button id="btn-nuevohorario" type="button" class="btn_4" onclick="onNuevoHorario();" style="display: none;">Guardar</button>
                  <button id="btn-editarhorario" type="button" class="btn_4" onclick="onActualizarHorario();" style="display: none;">Guardar</button>  
                  <input id="id_horario" type="hidden">
                </form>
        </div>
        
    </div>
 <?php include("laser_footer.php"); ?>
</div>
</body>
</html>