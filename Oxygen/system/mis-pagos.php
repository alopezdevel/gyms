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
    
    CargarPagosSocio();

}
function CargarPagosSocio(){
    
    var usuario_actual = <?php echo json_encode($_SESSION['usuario_actual']);?>

    $.ajax({             
        type:"POST", 
        url:"funciones_socio.php", 
        data:{accion:"CargarPagosSocio", usuario_actual: usuario_actual},
                async : true,
                dataType : "json",
                success : function(data){                               
                    
                    switch (data.error){
                       case '0':
                             $("#monitor-container").empty().append(data.table); 
                       break;
                       case '1':
                            alert("Error:" + data.mensaje);
                       break; 
                        
                    }
 
                }
     });
}
</script>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Mi historial de pagos</h2>
        </div>
        <div id="monitor-container">                
            <table align="center" cellspacing="0">                              
                <tr>
                    <td class="head">ID</td>
                    <td class="head">NOMBRE</td>
                    <td class="head">STATUS DEL PAGO</td>
                    <td class="head">FECHA DE PAGO</td>
                    <td class="head">FECHA DE VENCIMIENTO</td>
                </tr>                          
            </table>
        </div>
    </div>
<?php include("footer.php"); ?>
</div> 
</body>
</html>
<?php }?>
