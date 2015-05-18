<?php
session_start();
include("header.php");
include("funciones_consulta.php");

if ( $_SESSION['acceso'] != "A"){ //No ha iniciado session
    header("Location: index.php");
    exit;
}else {
    function Consulta_pago_socio(&$arr_){
        
    include("cn_usuarios.php");
    $sql = "SELECT DATE_FORMAT(pago.dFechaVencimiento,  '%d/%m/%Y') as dFechaVencimiento, 
            ct_socio.iIDSocio as ID, 
            sCorreoSocio as correo, 
            CONCAT(sNombreSocio,' ',sApellidoPaternoSocio,' ', sApellidoMaternoSocio)  as nombre,
            pago.dias_restantes  as dias        
            FROM ct_socio 
            LEFT JOIN (SELECT  iIDSocio, max(cb_pagos_socio.dFechaVencimiento) as dFechaVencimiento,  DATEDIFF( max(cb_pagos_socio.dFechaVencimiento),NOW()) as dias_restantes
            FROM cb_pagos_socio 
            
            GROUP BY iIDSocio
            Order BY dFechaVencimiento DESC   ) as pago ON pago.iIDSocio = ct_socio.iIDSocio WHERE pago.dias_restantes <= 5 ";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
        while ($Recordset = mysql_fetch_array($result)) {
           $arr_[] = array("fecha_vencimiento" => stripslashes($Recordset['dFechaVencimiento']),
                           "id" => stripslashes($Recordset['ID']),        
                           "nombre" => stripslashes($Recordset['nombre']),
                           "correo" => stripslashes($Recordset['correo']),
                           "dias" => stripslashes($Recordset['dias']));
        }
    }
    mysql_free_result($result);
    mysql_close($dbconn);    
    }
$arr_consulta_socio = NULL;
Consulta_pago_socio($arr_consulta_socio);

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(inicio);
function inicio(){
    $("#boton_enviar_correo").click(onEnviarCorreo);
}                           
function onEnviarCorreo(){
    if(confirm("estas seguro que desea enviar un correo de recordatorio a todos los socios de el reporte?")){ 
    $.post("funciones.php", { accion: "enviar_recordatorio_pago"},
        function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("Los recordatorios se han enviado de  manera satisfactoria.");
                    break;  
             }
         }
         ,"json");           
   }
}
</script>  
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Utilerias</h1>
            <h2>Recordatorio Pago</h2>
        </div>
        <div class="txt-content">
            <form name="frmGenerarMonitor" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Generar")).md5(sha1("Monitor")); ?>" method="POST"> 
            <div id="monitor-container">
                <table align="center" cellspacing="0">
                    <tr>
                        <td class="head">Fecha de Vencimiento</td>
                        <td class="head">Correo socio</td>
                        <td class="head">Nombre</td>
                        <td class="head">Dias Restantes</td>
                    </tr>
                    <?php if(count($arr_consulta_socio)>0){
                            $i= 0;
                            $color_font_normal= "#000000";
                             foreach($arr_consulta_socio as $socio_log){
                                 if ($i % 2 == 0) {
                                     $color = "#d9d9d9";
                                 }else{
                                     $color = "#F0F0F0";
                                 }
                                 $i= $i + 1;
                                 if($socio_log['estatus'] == "vencido"){
                                     $color_font = "#cd1111";
                                 }else{
                                     $color_font = "#0acf0a";
                                 }
                                 ?>
                             <tr bgcolor="<?php echo $color?>">
                                <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo $socio_log['fecha_vencimiento'];?></font></b></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['correo'];?></b></td>
                                <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo strtoupper($socio_log['nombre']) ;?></b></font></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['dias'];?></b></td>
                             </tr>
                             <?php }
                          }else{?>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                             </tr>
                          <?php }
                    ?>
                    
                </table>
            
              <p><input type="button" id="boton_enviar_correo" value="Enviar correo"></p>
            </div>

    </div>
   </form>
   </div>
<?php include("footer.php"); ?>
</div> 
</body>
</html>
<?php }?>
