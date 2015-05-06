<?php
session_start();
include("header.php");
include("funciones_consulta.php");
?>
<script>
function Validar_Verificacion() {         
    var forma = document.frmGenerarMonitor;
    if (forma.txtBusquedaSocio.value == ""){
        alert("Favor de llenar el ID.");
        return false;
    }
    else {
        return true;
    }
}
</script>
<?php
if ( 0  ){ //No ha iniciado session
    header("Location: index.php");
    exit;
}else {
    $arr_mes = NULL;
    $arr_year = NULL;
    $arr_mes[0]['descrpcion'] = "ENERO";
    $arr_mes[0]['folio'] = 1;
    $arr_mes[1]['descrpcion'] = "FEBRERO";
    $arr_mes[1]['folio'] = 2;
    $arr_mes[2]['descrpcion'] = "MARZO";
    $arr_mes[2]['folio'] = 3;
    $arr_mes[3]['descrpcion'] = "ABRIL";
    $arr_mes[3]['folio'] = 4;    
    $arr_mes[4]['descrpcion'] = "MAYO";
    $arr_mes[4]['folio'] = 5;    
    $arr_mes[5]['descrpcion'] = "JUNIO";
    $arr_mes[5]['folio'] = 6;    
    $arr_mes[6]['descrpcion'] = "JULIO";
    $arr_mes[6]['folio'] = 7;    
    $arr_mes[7]['descrpcion'] = "AGOSTO";
    $arr_mes[7]['folio'] = 8;    
    $arr_mes[8]['descrpcion'] = "SEPTIEMBRE";
    $arr_mes[8]['folio'] = 9;    
    $arr_mes[9]['descrpcion'] = "OCTUBRE";
    $arr_mes[9]['folio'] = 10;    
    $arr_mes[10]['descrpcion'] = "NOVIEMBRE";
    $arr_mes[10]['folio'] = 11;
    
    $arr_mes[11]['descrpcion'] = "DICIEMBRE";
    $arr_mes[11]['folio'] = 12;    
    $arr_year[0]['descrpcion'] = "2013";
    $arr_year[0]['folio'] = 2013;    
    $arr_year[1]['descrpcion'] = "2014";
    $arr_year[1]['folio'] = 2014;    
    $arr_year[2]['descrpcion'] = "2015";
    $arr_year[2]['folio'] = 2015;    
    $arr_year[3]['descrpcion'] = "2016";
    $arr_year[3]['folio'] = 2016;    
    $arr_year[4]['descrpcion'] = "2017";
    $arr_year[4]['folio'] = 2017;
if($_POST['txtBusquedaSocio'] != ""){
    $arr_consulta_socio = NULL;
    Consulta_pagos_socio($_POST['txtBusquedaSocio'], $_POST['txtBusquedaFecha'], $_POST['txtBusquedaFechaYear'],$arr_consulta_socio);
}

?>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Reporte de pagos por socio</h2>
        </div>
    <form name="frmGenerarMonitor" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Generar")).md5(sha1("Monitor")); ?>" method="POST" onSubmit="return Validar_Verificacion()">              
            <div class="txt-content">
               <div class="frm-buscar" align="left">
                    <input type="text" class="left" name="txtBusquedaSocio" maxlength="4" value="<?php echo $_POST['txtBusquedaSocio'];?>" placeholder="ID:"> 
                    <button class="left" style="height: 32px!important" name="btn_permitir_denegar" type="submit" value="0">Buscar</button>
                </div>
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
                    <?php   $total_de_asistencia_vencidos = 0;
                            $total_de_asistencia_no_vencidos = 0;
                            $total_de_asistencia = 0;
                             if(count($arr_consulta_socio)>0){
                            $i= 0;
                            $color_font_normal= "#000000";
                             foreach($arr_consulta_socio as $socio_log){
                                 if ($i % 2 == 0) {
                                     $color = "#d9d9d9";
                                 }else{
                                     $color = "#F0F0F0";
                                 }
                                 $i= $i + 1;
                                 if($socio_log['estatus_del_pago'] == "TERMINADO"){
                                     $color_font = "#cd1111";
                                     $total_de_asistencia_vencidos =  $total_de_asistencia_vencidos +1;
                                 }else{
                                     $total_de_asistencia_no_vencidos =  $total_de_asistencia_no_vencidos +1;
                                     $color_font = "#0acf0a";
                                 }
                                 ?>
                             <tr bgcolor="<?php echo $color?>">
                                <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo $socio_log['id_socio'];?></font></b></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['nombre_socio'];?></b></td>
                                <td align="center"><b><font color="<?php echo $color_font ;?>">&nbsp;<?php echo strtoupper($socio_log['estatus_del_pago']) ;?></b></font></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['fecha_pago'];?></b></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['fecha_vencimiento'];?></b></td>
                             </tr>
                             
                             <?php }?>
                                <td colspan="5">&nbsp;</td>
                             </tr>
                          <?php }else{?>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                             </tr>
                          <?php }
                    ?>
                    
                </table>
            </div>
   </form>
</div>
<?php include("footer.php"); ?>
</div> 
</body>
</html>
<?php }?>
