<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Usuarios</title>
<link href="lib/ui/jquery-ui.css" rel="stylesheet">    
<script src="lib/jquery/js/jquery.js" type="text/javascript"></script>  
<script src="lib/ui/jquery-ui.js" type="text/javascript"></script>  
<script type="text/javascript" src="lib/ui/jquery.ui.dialog.js"></script>
<style>

legend {
text-align:left; /* Puedes cambiarlo por center o right */
font-weight:bold; /* Estilo de la fuente del título */
color:#3e9ac1; /* Color del título */
}
body { font-size: 62.5%; }
label, input { display:block; }
input.text { margin-bottom:12px; width:95%; padding: .4em; }
fieldset { border:1px groove #C0C0FF; 
color:#000; /* Color del texto de todo el contenido */ }
h1 { font-size: 1.2em; margin: .6em 0; }
div#users-contain { width: 350px; margin: 20px 0; }
div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
.ui-dialog .ui-state-error { padding: .3em; }
.validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>
<script>
$(document).ready(inicio);
function inicio(){
    pagina_actual = "1";
    fillListado();
     $("#anc_Usuarios_nav tbody tr").hover(onHovera,onHoverb);//Cuando pasan el mouse :D
     var dialog, form
    dialog = $( "#edit_form_usuarios" ).dialog({autoOpen: false,
                                         height: 300,
                                         width: 575,
                                         modal: true,
                                         buttons: { //crear botón de cerrar
                                                    "Guardar": altaUsuario,
                                                    "Cancelar": function() {
                                                                $( this ).dialog( "close" );
                                                               }
                                                  },
                                         show: {
                                                effect: "blind",
                                                duration: 1000
                                                },
                                         
                                        });
     
    //set_params();
}
function altaUsuario(){
    var usuario_insert = $('#txtUsuario').val();
    var password_insert = $('#txtPassword').val();    
    var correo_insert = $('#txtCorreo').val();
    var nivel_usuario = $('#sNivelUsuario').val();
    
    $.post("funciones.php",{accion : "usuario_nuevo",usuario : usuario_insert,password : password_insert,correo : correo_insert,nivel : nivel_usuario}, onInsertar,'json' );
    
}
function onInsertar(respuesta ){
    if(respuesta.error == "0"){
    alert(respuesta.mensaje);
    $( "#edit_form_usuarios" ).dialog( "close" );
     fillListado();
    }else{
        //alert(respuesta.mensaje);
    }
    
}
function onHovera(){
    color = $(this).css('background-color');
    $(this).css({'cursor' : 'pointer','background-color':'#FBFDD0'}); 
}
function onHoverb(){
    $(this).css({'cursor' : '','background-color':'#FFFFC0'});
}
function fillListado(){
    
    
    var filtro = "";
    var filtroTipoUsuario = "";
    $.post("funciones.php",{
                               accion : "listado_usuarios", 
                               registros_por_pagina : "2", 
                               pagina_actual : pagina_actual, 
                               filtroInformacion : filtro, 
                               ordenar_por : "sUsuario"//no se que es aun   
                               },                         
            function(data){    
                            $("#anc_Usuarios_nav tbody").empty().append(data.tabla); 
                            $("#paginas_total_usuarios").val(data.total);
                            $("#pagina_actual_usuarios").val(data.pagina);
                            //alert(data.tabla));
                          },
           "json");
                                                        
}
function FiltraInformacion(condiciones,ordenado_por){ 
        pagina_actual=0;
        filtro="";
        ordenado_por = ordenado_por;
        if($('#flt_usr_nombre').val() !="")
        {
            filtro += "cu_control_acceso.sUsuario|" + $("#flt_usr_nombre").val() + ","
        }
        
        FillListado();
    }
function onDespliega(data){

    $("#anc_Usuarios_nav tbody").empty().append(data.tabla); //Limpia la tabla y agrega los registros de la consulta
    $("#anc_Usuarios_nav tbody tr:even").addClass('gray');    //agregar gris y blanco en pares y nones
    $("#anc_Usuarios_nav tbody tr:odd").addClass('white'); 
    $("#anc_Usuarios_nav tbody .boton").button().css({'width':"45%",'font-size':'0.8em','margin':'1px'});   
    //eliminaregistro();
    $("#anc_Usuarios_nav tbody .boton #paginas_total_usuarios").val(data.total);
    $("#anc_Usuarios_nav tbody .boton #pagina_actual_usuarios").val(data.pagina);fn_usuarios.pagina_actual = data.pagina;
   
    //set_edit();
}
function nuevousuario(){
  $("#edit_form_usuarios").dialog('open'); 
}

function onfirstPage(){
    if($("#pagina_actual_usuarios").val() != "1"){
        pagina_actual = "";
        fillListado();
    }                                         
}
function firstPage(){
     if($("#pagina_actual_usuarios").val() != "1"){
        pagina_actual = "";
        fillListado();
    }                                         
}
function previousPage(){
     if($("#pagina_actual_usuarios").val() != "1"){
        pagina_actual = (parseInt($("#pagina_actual_usuarios").val()) - 1) + "";
        fillListado();
    }                                         
}

function nextPage(){
      if($("#pagina_actual_usuarios").val() != $("#paginas_total_usuarios").val()){
        pagina_actual = (parseInt($("#pagina_actual_usuarios").val()) + 1) + "";
        fillListado();
    }                                         
}
function lastPage(){
      if($("#pagina_actual_usuarios").val() != $("#paginas_total_usuarios").val()){
        pagina_actual = $("#paginas_total_usuarios").val();
        fillListado();
    }                                         
}
        

</script>


<div id="fn_usuarios_domroot" title="ADMINISTRACION DE USUARIOS">
    <table class="section_header">
        <tbody>
            <tr>
              
                <td class="grid_tit">
                    <label>ADMINISTRACION DE USUARIOS</label>
                </td>
            </tr>
        </tbody>
    </table><br>
                         
    
    <div>
        <div class="boton" style="display: none;">Filtro Avanzado</div>
    </div>

    <div>
        <table id="anc_Usuarios_nav" cellspacing="0" width="100%" class="testilo1">
            <thead>
                <tr id="grid_header1">
                    <td align="center"><input  id="flt_usr_nombre" type="text"></td>
                    <td align="center"><input  id="flt_usr_user" type="text"></td>
                    <td align="center"><input  id="flt_usr_tipo" type="text"></td>
                    <td align="center"><div class="boton" onclick="fn_usuarios.filtraInformacion();">Filtrar/Limpiar Filtro</div></td>
                </tr>
                <tr id="grid_header2">
                    <td class="etiqueta_grid" align="center">Nombre Completo</td>
                    <td class="etiqueta_grid" align="center">Usuario</td>
                    <td class="etiqueta_grid" align="center">Tipo de Usuario</td>
                    <td class="etiqueta_grid" align="center"><div class="boton" onclick="nuevousuario();">Agregar</div></td>
                </tr>
            </thead>
            
            <tbody id"tabla_grid_usuarios"></tbody>
            
            
            <tfoot>
                <tr align="center">
                    <td colspan="5"><hr></td>
                </tr>
                <tr align="center">
                    <td colspan="5">
                        <div style="width: 100%;" align="center"> <label class="paginador">Pagina : </label><input class="paginador" id="pagina_actual_usuarios" type="text" readonly="readonly" size="3"><label class="paginador">de </label> 
                            <input id="paginas_total_usuarios" class="paginador" type="text" readonly="readonly" size="3"></div>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="5">
                        <div style="width: 100%;" align="center">
                            <button class="boton" style="font-size: 0.9em;" id="pgn-inicio" onclick="firstPage();">Inicio</button>
                            <button class="boton" style="font-size: 0.9em;" id="pgn-anterior" onclick="previousPage();">Anterior</button>
                            <button class="boton" style="font-size: 0.9em;" id="pgn-siguiente" onclick="nextPage();">Siguiente</button>
                            <button class="boton" style="font-size: 0.9em;" id="pgn-final" onclick="lastPage();">Final</button>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div id="edit_form_usuarios" class="forma_edicion" title="|  Administracion de Usuarios  |" role="dialog">
    
    <fieldset>
        <legend>Datos Generales</legend>

        <table cellpadding="0">
            <tr>
                <td><label>Nombre Completo: </label></td>
                <td><input type="text" id="txtUsuario" value="" class="text ui-widget-content ui-corner-all" size="80" /><input type="hidden" id="sNombreBD" value="" /></td>
            </tr>
            <tr>
                <td><label>Correo Electronico: </label></td>
                <td><input type="text" id="txtCorreo" value="" class="text ui-widget-content ui-corner-all" size="80" /></td>
            </tr>
            <tr>
                <td><label>Contrase&ntilde;a: </label></td>
                <td><input type="password" id="txtPassword" role="dialog" value="" size="15" /></td>
            </tr>
            <tr>
                <td><label>Tipo de Usuario: </label></td>
                <td><select id="sNivelUsuario">
                        <option value="U">Usuario</option>
                        <option value="A">Administrador</option>
                    </select></td>
            </tr>
        </table>
        
        
    </fieldset>

   
    
    
    <br><br>
           
</div>
</html>