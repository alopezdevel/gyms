<?php             
 session_start();
 if ($_SESSION['acceso'] != "A" ){ //No ha iniciado session
    header("Location: login.php");
 }else{
include("header.php");?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'Sabado'],
 dayNamesShort: ['Dom','Lun','Mar','Mi�','Juv','Vie','S�b'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
$("#fecha").datepicker();
});
</script>
<script>     
function llenadoGrid(){
    var filtro = "";  //DATE_FORMAT(dFechaIngreso,  '%m/%d/%Y')         
    if($('#filtro_fecha_creacion').val() !=""){     
        filtro += "DATE_FORMAT(dFecharegistro,  '%d/%m/%Y')|" + $("#filtro_fecha_creacion").val() + ",*"
    }
    if($('#filtro_id_socio').val() !=""){     
        filtro += "iIDSocio|" + $("#filtro_id_socio").val() + ",*"
    }                                                 
    if($('#filtro_correo_socio').val() !=""){     
        filtro += "sCorreoSocio|" + $("#filtro_correo_socio").val() + ",*"
    }            
    if($('#filtro_nombre_socio').val() !=""){     
        filtro += "Concat(sNombreSocio, ' ', sApellidoPaternoSocio, ' ', sApellidoMaternoSocio)|" + $("#filtro_nombre_socio").val() + ",*"
    }
    
    if($('#filtro_Estatus_Cuenta').val() !="" && $('#filtro_Estatus_Cuenta').val() != null && $('#filtro_Estatus_Cuenta').val() != "null"){     
        filtro += "bactivo|" + $("#filtro_Estatus_Cuenta").val() + ",*"
    }
    
        var fn_request_certificate = {
        domroot:"#fn_request_certificate",
        data_grid: "#data_grid_certificate",
        fillgrid: function(){
               $.ajax({             
                type:"POST", 
                url:"funciones.php", 
                data:{accion:"get_pagos_asinc", filtroInformacion : filtro},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $(fn_request_certificate.data_grid+" tbody").empty().append(data.tabla);
                    $(fn_request_certificate.data_grid+" tbody tr:even").addClass('gray');
                    $(fn_request_certificate.data_grid+" tbody tr:odd").addClass('white');
                                }
            }); 
        }    
    }
    fn_request_certificate.fillgrid();
}
$(document).ready(inicio);
function inicio(){
    
    var dialogo;
    //dialogo 1
    dialogo = $( "#dialog-user" ).dialog({
      autoOpen: false,
      height: 800,
      width: 1296,                                 
      modal: true,         
      close: function() {
       $("#body_historial").empty().append("<td></td><td></td><td></td><td></td><td></td><td></td>");
      }
    }); 
     //focus
     $( "#filtro_Estatus_Cuenta" ).selectmenu();
     $(".date").datepicker({
        onSelect: function() {
            $(this).change();
        }
    }); 
    $( "#tabs" ).tabs(); 
    //focus
     $( "#filtro_Estatus_Cuenta" ).selectmenu();
     $(".date").datepicker({
        onSelect: function() {
            $(this).change();
        }
    }); 
    $( "#filtro_fecha_creacion" ).datepicker({onSelect: function(){ onkeyup()},dateFormat: 'dd/mm/yy'}); 
    $('input.texto').focus(onFocus);
    //blur
    $('input.texto').blur(onBlur);    
    //filtros
    $( "#filtro_fecha_creacion" ).keyup(onkeyup);
    $( "#filtro_id_socio" ).keyup(onkeyup);
    $("#filtro_correo_socio").keyup(onkeyup);
    $("#filtro_nombre_socio").keyup(onkeyup);  
    $("#filtro_Estatus_Cuenta" ).selectmenu({ change: function( event, ui ) { onkeyup(); }});
    llenadoGrid();
     
     $("#tabs" ).tabs({                                                                  
            activate:function(event,ui){    
                     var $activeTab = $('#tabs').tabs('option', 'active');                      
                     if($activeTab == "1"){
                         
                     }
                    
                    }                                                                          
     });  
     $("#pago").keyup(onActualizarPago);
   $( "#check_promocion" ).button();  
}
function onkeyup(){
    llenadoGrid();
}   
function onActualizarPago(){
    if( $('#check_promo').attr('checked') ) {
    }else{
        $("#pago_final").val($("#pago").val());
    }
    
    
    
}
function onCargarHistorial(id_socio){
    if(id_socio != ""){
        $.post("funciones.php", { accion: "get_pago_asinc",id_socio:id_socio},
        function(data){ 
             switch(data.error){
             case "1": $("#body_historial").empty().append("<td></td><td></td><td></td><td></td><td></td><td></td>");  
                    break;
             case "0":  
                       $("#body_historial").empty().append(data.tabla);
                       $("#body_historial tr:even").addClass('gray');
                       $("#body_historial tr:odd").addClass('white');   
                    break;  
             }
         }
         ,"json");
    }
    
}
function onRegistrarMensualidad(){
}           
function onRegistrarPago(id){
    $("#id_pago").val(id);
    onCargarHistorial($("#id_pago").val());
    $( "#dialog-user" ).dialog("open"); 
    var index = "0";
    $( "#filtro_fecha_inicial" ).datepicker({ minDate: -30,defaultDate: "+1w",changeMonth: false,numberOfMonths: 1, onClose: function( selectedDate ) { $( "#filtro_fecha_final" ).datepicker( "option", "minDate", selectedDate ); },dateFormat: 'dd/mm/yy'});
    $( "#filtro_fecha_final" ).datepicker({defaultDate: "+1w",changeMonth: false, numberOfMonths: 1,onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      },dateFormat: 'dd/mm/yy'});
    //$( "#filtro_fecha_inicial" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
    $('#tabs').tabs("option", "active", 0);    
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


</script>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Pagos</h2>
        </div>
        
        
        <table id="data_grid_certificate" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td align="center" class="etiqueta_grid" nowrap="nowrap" ><input class="inp"  id="filtro_fecha_creacion" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_id_socio" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_correo_socio" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_nombre_socio" type="text"></td>
                <td align="center" class="etiqueta_grid" nowrap="nowrap"><select   id="filtro_Estatus_Cuenta" size="3" multiple ><option value="">&nbsp;<option value="0">Pendiente</option><option value="1">Activado</option></td>
                <td class="etiqueta_grid" colspan = "2">&nbsp;</td> 
            </tr>
            <tr id="grid-head2">                            
                <td align="center" class="etiqueta_grid" nowrap="nowrap" >Fecha de registro</td>
                <td align="center" class="etiqueta_grid">ID socio</td>
                <td align="center" class="etiqueta_grid">Correo socio</td>
                <td align="center" class="etiqueta_grid">Nombre socio</td>
                <td align="center" class="etiqueta_grid">Estatus cuenta</td>
                <td class="etiqueta_grid" colspan = "2">&nbsp;</td> 
                
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
        
        
    </div> 
</div>    
<div id="dialog-user" title="Registrar pago" class="ui-widget" >
    <div class="container">
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Registrar Pago</h2>
        </div>
        <input  id = "id_pago" name="id_pago" class="texto" type="hidden" > 
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Registro de pago socio</a></li>
                <li><a href="#tabs-2">Historial de pago</a></li>
            </ul>
            <div id="tabs-1">
                <form method="post" action="">
                    <p class="mensaje_valido">&nbsp;Favor de llenar los campos.</p>
                    <fieldset>
                        <input  id="filtro_fecha_inicial" class="texto" type="text" placeholder="Fecha inicial">
                        <input   id="filtro_fecha_final"  class="texto"  type="text" placeholder="Fecha final">
                        <input  id = "pago" name="pago" class="texto" type="text" placeholder="Monto a pagar $$$">
                        <br />
                        <br />  
                        <input type="checkbox" id="check_promo"><label for="check1">Promocion</label>                          
                        <input  id = "promocion" name="promocion" class="texto" type="text" placeholder="Cantidad promocion $$$">                        
                        <br />
                        <br />
                        <label>Total a pagar </label>
                        <input  id = "pago_final" name="pago_final" class="texto" type="text" placeholder="Pago Calculado" readonly disabled>
                        <input  id = "id_edicion" name="id_edicion" class="texto" type="hidden" >                             
                        <fieldset>                             
                            <input  id = "button_aceptar" name="button_aceptar" class="btn_register btn_4" type="button" value="Registrar Pago">
                            <input  id = "button_cancelar" name="button_cancelar" class="btn_register btn_4" type="button" value="Cancelar Pago">
                        </fieldset>
                    </fieldset>
                        
                </form>
            </div>
            <div id="tabs-2">
                <table id="data_grid_pagos" class="data_grid"> 
                    <thead>                                                                                       
                        <tr id="grid-head2"> 
                            <td align="center" class="etiqueta_grid">Folio del Pago</td>
                            <td align="center" class="etiqueta_grid">Correo</td>
                            <td align="center" class="etiqueta_grid">Nombre</td>
                            <td align="center" class="etiqueta_grid">Fecha de pago</td>
                            <td align="center" class="etiqueta_grid">Cantidad</td>
                            <td align="center" class="etiqueta_grid">Fecha de vencimiento</td>
                        </tr>
                    </thead>   
                    <form id="form_pagos_socio">
                        <tbody id="body_historial">
                            <tr > 
                                <td align="center" >&nbsp;</td>
                                <td align="center" >&nbsp;</td>
                                <td align="center" >&nbsp;</td>
                                <td align="center" >&nbsp;</td>
                            </tr>
                        </tbody>  
                    </form>
                </table>
            </div>
            
        </div>
    </div> 
</div>
</body>
</html>
<?php }?>
                