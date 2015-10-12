<?php
session_start();
if ( $_SESSION['acceso'] != "C" ){ //No ha iniciado session: Esta ventana es solo para socios...no administradores
    header("Location: index.php");
    exit;
}else {  
    include("header.php");
?>
<script type="text/javascript">
$(document).ready(inicio);
function inicio(){
    
    CargarAsistenciaSocio();
}
function CargarAsistenciaSocio(){
    
    var usuario_actual = <?php echo json_encode($_SESSION['usuario_actual']);?>

    $.ajax({             
        type:"POST", 
        url:"funciones_socio.php", 
        data:{accion:"CargarAsistenciaSocio", usuario_actual: usuario_actual},
                async : true,
                dataType : "json",
                success : function(data){                               
                    
                    $("#monitor-container tbody").empty().append(data.html_tabla);
                    $("#total").empty().append("<strong>Total de Asistencias: </strong>" + (data.total));
                }
     });
}
</script>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Mi Cuenta</h1>
            <h2>Asistencia a Oxygen</h2>
        </div>
        <div id="monitor-container">                
            <table align="center" cellspacing="0"> 
                <thead>                             
                    <tr>
                        <td class="head">ID</td>
                        <td class="head">SOCIO</td>
                        <td class="head">STATUS DEL PAGO</td>
                        <td class="head">FECHA</td>
                    </tr> 
                </thead>
                <tbody></tbody>
            </table>
            <div id="total" style="width:98%;margin: 5px auto; border-top: 1px solid #89b0fd;padding:5px;text-align: right;">
                <strong>Total de Asistencias:</strong><span></span>
            </div>
        </div>
</div>
<?php include("footer.php"); ?> 
</body>
</html>
<?php }?>
