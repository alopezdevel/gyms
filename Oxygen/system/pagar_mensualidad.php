<?php
session_start();       
include("funciones_consulta.php");
include("altas_1.php");
if ( $_SESSION['acceso'] != "U" && $_SESSION['acceso'] != "A" ){ //No ha iniciado session
    header("Location: index.php");
    exit;
}else {
    function borrarPago($folio_pago){
        include("cn_usuarios.php");
        @mysql_query("BEGIN");
        $transaccion_exitosa = true;
    
        $sql = "DELETE FROM cb_pagos_socio WHERE iFolio = '".$folio_pago."'  ";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 0 ) {
            $transaccion_exitosa = false;
        }
        if ($transaccion_exitosa) {
            mysql_query("COMMIT");
            mysql_close($dbconn);
        return true;        
        } else {
            echo '<script language="javascript">alert(\'Error al eliminar los datos. Favor de verificarlos.\')</script>';
            mysql_query("ROLLBACK");
            mysql_close($dbconn);
            return false;
        }
    }
      if( $_GET['type'] == sha1(md5("Permitir")).md5(sha1("Socio"))){
            if($_POST['btn_pagar_cancelar'] =="1"){
                //Proceso pago Mensualidad
                //Variables                               
                $id_socio = $_POST['folio_socio'];
                $FechaPagado = $_POST['txtMesPagado'];
                $FechaPagadoFinal = $_POST['txtMesPagadoFinal'];
                $MontoaPagar = $_POST['txtMontoaPagar'];
                if(insertarPagoMensualidad($id_socio,$_POST['txtMontoaPagar'],$_POST['txtMesPagado'],$_POST['txtMesPagadoFinal'])){
                    echo '<script language="javascript">alert(\'Pago realizado correctamente.\')</script>';
                }else{
                     $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio"));  
                     $_POST['txtBusquedaSocio'] = $_POST['folio_socio'] ;
                     $_POST['folio_socio']= "";
                }
               
            }
      }
      if( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))){
          if($_POST['folio_socio'] == "" ){
               if(trim($_POST['txtBusquedaSocio'])!="" && is_numeric($_POST['txtBusquedaSocio'])) 
                  {
                    $arr_socio = NULL;  
                    $arr_consulta_socio = NULL;    
                    getSocio($_POST['txtBusquedaSocio'],$arr_socio);
                    Consulta_pagos_socio($_POST['txtBusquedaSocio'], "", "",$arr_consulta_socio);
                  }
                  else
                  {
                     header("Location: pagar_mensualidad.php"."?type=".sha1(md5("nueva")).md5(sha1("busqueda")));
                  }
          }else{
            echo $_POST['btn_pagar_cancelar'];
          }    
          
      }     
      if ( $_GET['type'] == sha1(md5("borrar")).md5(sha1("pago")) ){ //borrar
           
            if ( borrarPago($_GET["cve"]) ) {
                echo '<script language="javascript">alert(\'Cancelacion de pago realizado correctamente.\')</script>';
                //header("Location: ".$_SERVER['PHP_SELF']."?type=".sha1(4)."&cve=".sha1('-'));
                //exit;
            }else{
                     $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio"));  
                     $_POST['txtBusquedaSocio'] = $_POST['folio_socio'] ;
                     $_POST['folio_socio']= "";
                }
         }
}
   
?>
<script src="lib/jquery/jquery-1.10.2.js"></script>
<script type="text/javascript" src="lib/jquery/jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui-1.10.4.custom.css">
<script>
function SubmitFormaPaginacion(forma,accion) {
    forma.action=accion;
    forma.submit();
}
function confirmarBorrar(registro) {
    confirmacion = confirm ("�Est� seguro que desea borrar " + registro + "?");
    return confirmacion;
}
</script>
<?php include("header.php");?>
<div id="layer_content" class="main-section">
    <div class="container"> 
    <div class="page-title">
            <h1>Administracion</h1>
            <h2>Registrar mensualidad</h2>
    </div>
        <div class="txt-content">
            <form name="frmPago" method="POST"   action="
                        <?php 
                            if ( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){
                                echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Permitir")).md5(sha1("Socio"));
                            } else {
                                echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Socio"));
                            }
                        ?>">
            <div>
                    <div class="txt-left"><label> Favor de Capturar el ID del Socio: </label></div><br>                                                                                                                   
                        <div class="frm-buscar"> 
                        <input class="left" style="height: 32px!important;" placeholder="Escribe el ID:"  name="txtBusquedaSocio" type="text" maxlength="6"  value="<?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){ echo $_POST['txtBusquedaSocio'];}else{ echo $_POST['folio_socio'];}?>"
                        <?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){
                            echo 'disabled';
                        }else{
                            echo 'enabled';
                        }?>
                        />   
                        <button class="left" type="submit" onClick="Validar_Verificacion();"  
                        <?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))){
                            echo 'disabled';
                        }else{
                            echo 'enabled';
                        }?>>Buscar</button>
                        </div>
            </div>
              <div>  
                <?php if(count($arr_socio)>0){ ?> 
                <div class="box-blue center">
                    <div> 
                          <label><b>ID:  </b><?php echo $arr_socio[0]['id_socio'];?></label><br> 
                          <label><b>Nombre:  </b><?php echo $arr_socio[0]['nombre'].' '.$arr_socio[0]['apellido_paterno'].' '.$arr_socio[0]['apellido_materno'];?></label><br>                          
                          <label><b>Mes Inicial: </b><input type="text"  name="txtMesPagado" maxlength="10" id="datepicker" size="14" value="<?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){ echo $_POST['txtMesPagado'];}?>">(dd/mm/yyyy)</label><br> 
                          <label><b>Mes   Final: </b><input type="text"  name="txtMesPagadoFinal" maxlength="10" id="datepicker" size="14" value="<?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){ echo $_POST['txtMesPagadoFinal'];}?>">(dd/mm/yyyy)</label><br> 
                          <label><b>Monto a pagar: </b><input name="txtMontoaPagar" type="text" maxlength="3"  placeholder="Monto a Pagar" value="<?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){ echo $_POST['txtMontoaPagar'];}?>"></label><br>   
                          <input type="hidden" name="folio_socio"  value="<?= $arr_socio[0]['id_socio']; ?>">  
                          <label><button name="btn_pagar_cancelar" type="submit" onClick="ValidarDatosPago();"  value="1">Pagar</button> &nbsp; <button name="btn_pagar_cancelar"  type="submit" value="0">Cancelar</button></label>
                     </div>
                </div>
                </div>
                <div id="monitor-container">               
                <table align="center" cellspacing="0">                              
                    <tr>
                        <td class="head">ID - Cantidad de pago</td>
                        <td class="head">NOMBRE</td>
                        <td class="head">STATUS DEL PAGO</td>
                        <td class="head">FECHA DE PAGO</td>
                        <td class="head">FECHA DE VENCIMIENTO</td>
                        <td class="head" style="width: 40px;"></td>
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
                                <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo $socio_log['id_socio'].' - $',$socio_log['pago'];?></font></b></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['nombre_socio'];?></b></td>
                                <td align="center"><b><?php echo $socio_log['folio_pago'].'-' ?><font color="<?php echo $color_font ;?>">&nbsp;<?php echo strtoupper($socio_log['estatus_del_pago']) ;?></b></font></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['fecha_pago'];?></b></td>
                                <td align="center"><b>&nbsp;<?php echo $socio_log['fecha_vencimiento'];?></b></td>
                                <td width="40px!important" valign="top" align="center" nowrap="nowrap"><font size="2" face="<?php echo $_SESSION["disenofolio_pagotipo_letra"] ?>">
                                <?php $url=$_SERVER['PHP_SELF']."?type=".sha1(md5("borrar")).md5(sha1("pago"))."&cve=".$socio_log["folio_pago"] ?>
                                <a title="Borrar Registro" href="javascript: if (confirmarBorrar('el pago')) { SubmitFormaPaginacion(document.frmPago, '<?= $url ?>'); }"><img border="0" src="images/ico_tacha.gif" width="15" height="15"></a></font></td>
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
                <?php } else if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))){
                $color_font = "#FF0000";
                $estatus = "El Socio No Existe.";  
                ?>
                 <div id="caja-gris">
                    <div>
                    <label><b>ID:  </b><?php echo $_POST['txtBusquedaSocio'];?></label><br> 
                    <label><b>Estatus:  </b><font color="<?php echo $color_font;?> " size="4"><?php echo $estatus;?></font></label><br>
                    <label><button name="btn_pagar_cancelar" type="submit" value="0">Regresar</button>
                    </div>
                 </div>
                <?php }?>
            </form>  
            </div>    
    <?php include("footer.php"); ?>    
</div>
</body>
</html>