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
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
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
        filtro += "DATE_FORMAT(pago.dFechaVencimiento,  '%d/%m/%Y')|" + $("#filtro_fecha_creacion").val() + ",*"
    }
    if($('#filtro_id_socio').val() !=""){     
        filtro += "ct_socio.iIDSocio|" + $("#filtro_id_socio").val() + ",*"
    }                                                 
    if($('#filtro_correo_socio').val() !=""){     
        filtro += "ct_socio.sCorreoSocio|" + $("#filtro_correo_socio").val() + ",*"
    }            
    if($('#filtro_nombre_socio').val() !=""){     
        filtro += "Concat(ct_socio.sNombreSocio, ' ', ct_socio.sApellidoPaternoSocio, ' ', ct_socio.sApellidoMaternoSocio)|" + $("#filtro_nombre_socio").val() + ",*"
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
                data:{accion:"get_asistencia_asinc", filtroInformacion : filtro},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $(fn_request_certificate.data_grid+" tbody").empty().append(data.tabla);
                    //$(fn_request_certificate.data_grid+" tbody tr:even").addClass('gray');
                    //$(fn_request_certificate.data_grid+" tbody tr:odd").addClass('white');
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
     //resizable: false,
     autoOpen: false,
      height: 350,
      width: 800,
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      },      
      close: function() {       
       //onLimpiarRegistroPago();  
       llenadoGrid();
      }
    }); 
     //focus     
     $(".date").datepicker({
        onSelect: function() {
            $(this).change();
        }
    });     
    //focus     
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
     
      
   //check promociones
  
}
function onRegistrarAsistencia(id,correo, estatus){
    $("#id_asis").val(id);
    confimacion = confirm("Desea Registrar asistencia del socio \n \n ID: "  + id + " \n EMAIL: " + correo + "\n Estatus: " + estatus ) ;
    if(confimacion){
        $.post("funciones.php", { accion: "registrar_asistencia", id:id, estatus:estatus},
        function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("Se ha registrado la asistencia satisfactoria.");
                         llenadoGrid();
                    break;  
             }
         }
         ,"json");           
        }
    }


function onkeyup(){
    llenadoGrid();
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
            <h2>Asistencia del socio</h2>
        </div>
        
        
        <table id="data_grid_certificate" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td align="center" class="etiqueta_grid" nowrap="nowrap" ><input class="inp"  id="filtro_fecha_creacion" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_id_socio" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_correo_socio" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_nombre_socio" type="text"></td>
                <td align="center" class="etiqueta_grid" nowrap="nowrap">&nbsp;</td>
                <td class="etiqueta_grid" colspan = "2">&nbsp;</td> 
            </tr>
            <tr id="grid-head2">                            
                <td align="center" class="etiqueta_grid" nowrap="nowrap" >Fecha de Vencimiento</td>
                <td align="center" class="etiqueta_grid">ID socio</td>
                <td align="center" class="etiqueta_grid">Correo socio</td>
                <td align="center" class="etiqueta_grid">Nombre socio</td>
                <td align="center" nowrap="nowrap" class="etiqueta_grid">Dias restantes</td>
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
<div id="dialog-user" title="Verificar asistencia" class="ui-widget" >
    <div class="container">
    <div class="page-title">
            <h1>Socios</h1>
            <h2>Editar Socio</h2>
        </div>
        <p>Socio <input  id = "emaile" name="email" class="texto" type="text" placeholder="E-mail:" readonly  disabled></p>
        <p>Nombre<input  id = "emaile" name="email" class="texto" type="text" placeholder="E-mail:" readonly  disabled></p>
        <p>dias restantes <input  id = "emaile" name="email" class="texto" type="text" placeholder="E-mail:" readonly  disabled></p>
        <p>estatus <input  id = "emaile" name="email" class="texto" type="text" placeholder="E-mail:" readonly  disabled> </p>
        <input  id = "id_asis" name="id_asis" class="texto" type="hidden" > 
         
    </div> 
</div>
</body>
</html>
<?php }?>
                