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
     
}
function CargarHorarios(){

    var filtro_id = "";
    var filtro_entrada1 = "";
    var filtro_entrada2 = "";
    var filtro_salida1 = "";
    var filtro_salida2 = "";
    var filtro_tiposemana = "";
    
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
    if($('#filtro_tiposemana').val() != ""){
        
        filtro_tiposemana = $('#filtro_tiposemana').val();
    }
    $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"CargarHorarios", filtro_id: filtro_id, filtro_entrada1: filtro_entrada1, filtro_entrada2: filtro_entrada2, filtro_salida1: filtro_salida1, filtro_salida2:filtro_salida2, filtro_tiposemana: filtro_tiposemana},
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
  
    var entrada1 = $("#entrada1").val();    
    var entrada2 = $("#entrada2").val();
    var salida1 = $("#salida1").val();
    var salida2 = $("#salida2").val(); 
    var tiposemana = $("#tiposemana").val();
    
    todosloscampos = $( [] ).add( entrada1 ).add( entrada2 ).add( salida1 ).add( salida2 ).add( tiposemana );
    todosloscampos.removeClass( "error" );
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    //Entradas:
    valid = valid && checkLength( entrada1, "Entrada 1", 1 );
    valid = valid && checkLength( entrada2, "Entrada 2", 1 ); 
    
    //Salida:
    valid = valid && checkLength( salida1, "Salida 1", 1 ); 
    valid = valid && checkLength( salida2, "Salida 2", 1 ); 
    
    //tiposemana
    valid = valid && checkLength( tiposemana, "Salida 2", 1 );                                                                                                         

        
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
                        $('form select option[value=""]').attr("selected",true);                                                             
                         alert(data.mensaje);  
                         $('.mensaje_valido').removeClass( "error" ); 
                         cerrarventana('#frm_container');
                         mostrarventana('#data_grid_horarios');
                         CargarHorarios(); 
            break;  
            }
        }
     });
        
    }
    
     
} 
function onActualizarHorario(){
    
    var id = $("#id_horario").val(); 
    var entrada1 = $("#entrada1").val();    
    var entrada2 = $("#entrada2").val();
    var salida1 = $("#salida1").val();
    var salida2 = $("#salida2").val(); 
    var tiposemana = $("#tiposemana").val();
    
    todosloscampos = $( [] ).add( entrada1 ).add( entrada2 ).add( salida1 ).add( salida2 ).add( tiposemana );
    todosloscampos.removeClass( "error" );
    actualizarMensajeAlerta( "" );
    
    var valid = true;
    
    //Entradas:
    valid = valid && checkLength( entrada1, "Entrada 1", 1 );
    valid = valid && checkLength( entrada2, "Entrada 2", 1 ); 
    
    //Salida:
    valid = valid && checkLength( salida1, "Salida 1", 1 ); 
    valid = valid && checkLength( salida2, "Salida 2", 1 ); 
    
    //tiposemana
    valid = valid && checkLength( tiposemana, "Salida 2", 1 );
    

    if ( valid ) {
        
        $.ajax({             
        type:"POST", 
        url:"laser_funciones.php", 
        data:{accion:"ActualizarHorario", id: id, entrada1: entrada1, entrada2: entrada2, salida1: salida1, salida2: salida2,  tiposemana: tiposemana },
        async : true,
        dataType : "json",
        success : function(data){                               
            switch(data.error){
            case "1": alert(data.mensaje);
                         $("#entrada1").focus();
            break;
            case "0": actualizarMensajeAlerta("Favor de llenar los campos.");
                        $('form select option[value=""]').attr("selected",true);  
                        $('#id_horario').val("");                                                             
                         alert(data.mensaje);
                         $('.mensaje_valido').removeClass( "error" );    
                         cerrarventana('#frm_container');
                         mostrarventana('#data_grid_horarios');
                         CargarHorarios(); 
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
                    $("#entrada1 option[value='"+ data.entrada1 +"']").attr("selected",true);
                    $("#salida1 option[value='"+ data.salida1 +"']").attr("selected",true); 
                    $("#entrada2 option[value='"+ data.entrada2 +"']").attr("selected",true);
                    $("#salida2 option[value='"+ data.salida2 +"']").attr("selected",true);
                    $("#tiposemana option[value='"+ data.tiposemana +"']").attr("selected",true);         
                    break;
                }
                }
        });
       
}
function cerrarventana(ventana){
    
   $(ventana).hide('slow');
   $(ventana + ' select option[value=""]').attr("selected",true); 
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
function checkLength( o, n, min ) {
    if ( o.length < min ) {
        actualizarMensajeAlerta( "Favor de elegir un valor en el campo " + n + "." );
        $('.mensaje_valido').addClass( "error" );
        return false;    
    } else {             
        return true;                     
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
            <h1>C&aacute;talogos</h1>
            <h2>Horarios</h2>
        </div>
        <table id="data_grid_horarios" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td class="etiqueta_grid" nowrap="nowrap" ><input class="filtro" id="filtro_id_horario" type="text" placeholder="ID Horario:"></td>
                <td class="etiqueta_grid"><input  class="filtro" id="filtro_Entrada1" type="time" placeholder="Entrada 1:"></td>
                <td class="etiqueta_grid"><input  class="filtro" id="filtro_Salida1" type="time" placeholder="Salida 1:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_Entrada2" type="time" placeholder="Entrada 2:"></td> 
                <td class="etiqueta_grid"><input class="filtro" id="filtro_Salida2" type="time" placeholder="Salida 2:"></td>
                <td class="etiqueta_grid"><input class="filtro" id="filtro_tiposemana" type="text" placeholder="Semana laboral:"></td>
                <td class="etiqueta_grid"><span class="btn-icon btn-left limpiar" title="Limpiar Filtros" onclick="limpiarfiltros();"><i class="fa fa-undo"></i></span> <span class="btn-icon btn-left" title="Agregar empleado" onclick="cerrarventana('#data_grid_horarios');mostrarventana('#frm_container');mostrarformulario('nuevo_horario');"><i class="fa fa-plus-circle"></i> Nuevo</span></td>  
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
                <h2 class="txt-center">Nuevo</h2>
                <form id="frm_empleado" action="" method="post">
                  <p class="mensaje_valido">Favor de llenar los campos.</p>
                  <label>Entrada (1):</label> 
                  <select id="entrada1" class="hora" name="entrada1">
                  <option value="">Selecciona una opcion...</option> 
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?>
                  </select>
                  <label>Salida (1):</label> 
                  <select id="salida1" class="hora" name="entrada2">
                  <option value="">Selecciona una opcion...</option> 
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?> 
                  </select>
                  <label>Entrada (2):</label> 
                  <select id="entrada2" class="hora" name="salida1">
                  <option value="">Selecciona una opcion...</option> 
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?> 
                  </select>
                  <label>Salida (2):</label> 
                  <select id="salida2" class="hora" name="salida2">
                  <option value="">Selecciona una opcion...</option> 
                    <?php 
                        for ($i=0;$i<24;$i++) {
                            $h1=sprintf("%02d",$i).":00";
                            $h2=sprintf("%02d",$i).":30";
                    ?>
                    <option value="<?php echo $h1; ?>"><?php echo $h1; ?></option>
                    <option value="<?php echo $h2; ?>"><?php echo $h2; ?></option>
                    <?php } ?>
                  </select>
                  <label>Semana laboral:</label> 
                  <select id="tiposemana" name="tiposemana">
                  <option value="">Selecciona una opcion...</option> 
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