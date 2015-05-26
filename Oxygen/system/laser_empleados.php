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
    $('#btn_agregar').click(AgregarEmpleado);
    $('#grid-head1 input').keyup(CargarEmpleados);
}
function CargarEmpleados(){

    var filtro_id = "";
    var filtro_nombre = "";
    var filtro_correo = "";
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
        data:{accion:"CargarEmpleados", filtro_id : filtro_id, filtro_nombre: filtro_nombre, filtro_correo: filtro_correo},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $("#data_grid_empleados tbody").empty().append(data.tabla);
                    $("#data_grid_empleados tbody tr:even").addClass('gray');
                    $("#data_grid_empleados tbody tr:odd").addClass('white');
                }
     });            
}
function AgregarEmpleado(){
    
       $('#data_grid_empleados').hide('fast');
       $('#nuevo_empleado').show('slow');
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
                <td class="etiqueta_grid" nowrap="nowrap" ><input class="inp"  id="filtro_fecha_creacion" type="text"></td>
                <td class="etiqueta_grid"><input  id="filtro_id_empleado" type="text" placeholder="ID Empleado:"></td>
                <td class="etiqueta_grid"><input  id="filtro_nombre" type="text" placeholder="Nombre Completo:"></td>
                <td class="etiqueta_grid"><input  id="filtro_correo" type="text" placeholder="Correo electronico:"></td> 
                <td class="etiqueta_grid"><span id="btn_agregar" class="btn-icon" title="Agregar empleado"><i class="fa fa-user-plus"></i></span></td>  
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
        <div id="nuevo_empleado" style="display: none;">
                <h2 class="txt-center">Nuevo Empleado</h2>
                <form action="" method="post" ></form>
        </div>
    </div>
 <?php include("laser_footer.php"); ?>
</div>
</body>
</html>