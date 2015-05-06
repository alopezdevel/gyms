<?php
session_start();
include("header.php");
include("funciones_consulta.php");

if ( $_SESSION['acceso'] != "A" && $_SESSION['acceso'] != "U" ){ //No ha iniciado session
    header("Location: index.php");
    exit;
}else {
$arr_consulta_socio = NULL;
Consulta_Log_Del_Dia("",$arr_consulta_socio);

?>
   <script language="JavaScript" type="text/javascript">
    <?php   if ( 1 ) { ?>
                setTimeout('document.frmGenerarMonitor.submit()', '60000');
    <?php   } ?>
</script> 
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Asistencias del dia</h2>
        </div>
        <div class="txt-content">
            <form name="frmGenerarMonitor" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Generar")).md5(sha1("Monitor")); ?>" method="POST"> 
        	<div id="monitor-container">
        		<table align="center" cellspacing="0">
					<tr>
						<td class="head">ID</td>
						<td class="head">NOMBRE</td>
						<td class="head">STATUS</td>
						<td class="head">FECHA</td>
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
                                <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo $socio_log['id_socio'];?></font></b></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['nombre_socio'];?></b></td>
                                <td align="center"><b><font color="<?php echo $color_font ;?>">&nbsp;<?php echo strtoupper($socio_log['estatus']) ;?></b></font></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['fecha_visita_socio'];?></b></td>
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
        	
        	
        	</div>

    </div>
   </form>
   </div>
<?php include("footer.php"); ?>
</div> 
</body>
</html>
<?php }?>
