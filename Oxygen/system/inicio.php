<?php

session_start();       

include("funciones_consulta.php");

if ( $_SESSION['acceso'] != "U" && $_SESSION['acceso'] != "A" ){ //No ha iniciado session

    header("Location: index.php");

    exit;

}else {

    

    if( $_GET['type'] == sha1(md5("Permitir")).md5(sha1("Socio"))  ){

        if($_POST['btn_permitir_denegar'] =="1"){

            $arr_socio_pago = NULL;      

            getSocioPago($_POST['folio_socio'],$arr_socio_pago); 

            include("cn_usuarios.php");//Conexion

            mysql_query("BEGIN");//Transaccion inica

            $transaccion_exitosa = true;

            $estatus_socio_pago = ""; 

            if($arr_socio_pago[0]['dias_restantes'] > 0){//vigente

                $estatus_socio_pago ="vigente";                        

            }else{//vencido

                $estatus_socio_pago ="vencido";                        

            }

            //LOG como admin

            $usuario_actual = "";

            if($_SESSION['usuario_actual'] == "BETO"){

                $usuario_actual = "ADMIN";

            }else{

                $usuario_actual = $_SESSION['usuario_actual'];

            }

            $sql = "INSERT INTO cb_transacciones_socio SET sUsuario = '".$usuario_actual."' , eTipoTransaccion= '".$estatus_socio_pago."', iIDSocio= '".$arr_socio_pago[0]['id_socio']."',dFechaVisitaSocio = DATE_ADD( NOW(), interval '-1' HOUR) ";

            mysql_query($sql, $dbconn);

            if ( mysql_affected_rows() < 1 ) {

                $transaccion_exitosa = false;

                $mensaje_error="No se pudo insertar el registro en la tabla de transacciones del socio. Favor de verificar los datos.";

            }

            if ($transaccion_exitosa) {

                mysql_query("COMMIT");

                mysql_close($dbconn);

                echo '<script language="javascript">alert(\'Acceso Registrado.\')</script>';

            } else {

                echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';

                mysql_query("ROLLBACK");

                mysql_close($dbconn);

            }

        }

             header("Location: socio_verificacion.php"."?type=".sha1(md5("nueva")).md5(sha1("busqueda")));

    }

    

     if( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))  ){

         if($_POST['folio_socio'] == ""){ 

             $arr_socio_pago = NULL;      

             getSocioPago($_POST['txtBusquedaSocio'],$arr_socio_pago);   

             if (count($arr_socio_pago) > 0) {//que si existe el socio

                //include("cn_usuarios.php");//Conexion

                //mysql_query("BEGIN");//Transaccion inica

                $transaccion_exitosa = true;

                $estatus_socio_pago = ""; 

                if($arr_socio_pago[0]['dias_restantes'] > 0){//vigente

                    $estatus_socio_pago ="vigente";                        

                }else{//vencido

                    $estatus_socio_pago ="vencido";                        

                }

                /*$sql = "INSERT INTO cb_transacciones_socio SET eTipoTransaccion= '".$estatus_socio_pago."', iIDSocio= '".$arr_socio_pago[0]['id_socio']."',dFechaVisitaSocio = DATE_ADD( NOW(), interval '-9' HOUR)";

                mysql_query($sql, $dbconn);

                if ( mysql_affected_rows() < 1 ) {

                    $transaccion_exitosa = false;

                    $mensaje_error="No se pudo insertar el registro en la tabla de transacciones del socio. Favor de verificar los datos.";

                }

                if ($transaccion_exitosa) {

                    mysql_query("COMMIT");

                    mysql_close($dbconn);

                } else {

                    echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';

                    mysql_query("ROLLBACK");

                    mysql_close($dbconn);

                }*/

             }else{

             }

         }else{

             echo $_POST['btn_permitir_denegar'];

         }

     }

}

?>

<script>

function Validar_Verificacion() {         

    var forma = document.frmBuscarSocio;

    if (forma.txtBusquedaSocio.value == ""){

        alert("Favor de llenar el ID.");

        return false;

    }

    else {

        return true;

    }

}

</script>
<!---- HEADER ----->
<?php include("header.php"); ?> 

<div id="layer_content" class="main-section">
	<div class="container">
		<h2>Registro de Entrada</h2>
		<form action="

        <?php 

            if ( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){

                echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Permitir")).md5(sha1("Socio"));

            } else {

                echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Socio"));

            }

        ?>"

             action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Socio"));?>" method="POST" name="frmBuscarSocio" onSubmit="return Validar_Verificacion()">
             <div>
                    <div id="caja-roja" style="width: 450px;min-height:100px!important;">
                    <div class="txt-left"><label> Favor de Capturar el ID del Socio: </label></div><br>
                        <div class="frm-buscar">
                        <input class="left" style="height: 32px!important" placeholder="ID:" name="txtBusquedaSocio" type="text" maxlength="4"  value="<?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){ echo $_POST['txtBusquedaSocio'];}else{ echo "";}?>"

                        <?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){

                            echo 'disabled';

                        }else{

                            echo 'enabled';

                        }?>

                        />   

                        <button class="btn-aceptar left" type="submit"  <?php  if($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio")) ){

                            echo 'disabled';

                        }else{

                            echo 'enabled';

                        }?>>Buscar</button>                                 
                        </div>
                    </div>  
                    <br><br>
                <?php if(count($arr_socio_pago)>0){ ?> 
                </div>
                <div>
                <div id="caja-roja">

                    <div>
                    <?php if($arr_socio_pago[0]['dias_restantes'] <= 0){

                            if($arr_socio_pago[0]['dias_restantes'] == 0){

                                $estatus ="HOY SE VENCE TU MEMBRESIA";

                                $color_font = "#FF0000";

                                $dias_palabra = "Restantes"; 

                            }else{

                                $estatus ="DENEGADO";

                                $color_font = "#fb6f6e";

                                $dias_palabra = "Vencidos"; 

                                $arr_socio_pago[0]['dias_restantes'] = $arr_socio_pago[0]['dias_restantes']*-1;

                            }                    

                          }else{

                            $estatus = "PERMITIDO";

                            $color_font = "#00FF00";

                            $dias_palabra = "Restantes";

                          }?>

                            <label><b>ID:  </b><?php echo $arr_socio_pago[0]['id_socio'];?></label><br>

                            <label><b>Nombre:  </b><?php echo $arr_socio_pago[0]['nombre_socio'].' '.$arr_socio_pago[0]['apellido_paterno_socio'].' '.$arr_socio_pago[0]['apellido_materno_socio'];?></label><br>

                          <label><b>Fecha de Vencimiento:  </b><?php echo $arr_socio_pago[0]['fecha_vencimiento'];?></label><br>

                          <label><b>Dias <?php echo $dias_palabra ?> de tu mensualidad:  </b><?php echo $arr_socio_pago[0]['dias_restantes'];?></label><br>

                          <label><b>Estatus:  </b><font color="<?php echo $color_font;?> " size="4"><?php echo $estatus;?></font></label><br>

                          <input type="hidden" name="folio_socio"  value="<?= $arr_socio_pago[0]['id_socio']; ?>">
                          <br>
                          <label><button class="btn-aceptar" name="btn_permitir_denegar" type="submit" value="1">Permitir</button> &nbsp; <button class="btn-cancelar" name="btn_permitir_denegar"  type="submit" value="0">Cancelar</button></label> 

                     </div>

                </div>

                <?php }elseif($_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))){

                $color_font = "#e1e246";

                $estatus = "El Socio No Existe.";  

                ?>
                </div>
                <div> 
                 <div id="caja-roja">
                    <div>
                    <label><b>ID:  </b><?php echo $_POST['txtBusquedaSocio'];?></label><br> 
                    <label><b>Estatus:  </b><font color="<?php echo $color_font;?> " size="4"><?php echo $estatus;?></font></label><br>
                    <br>
                    <label><button name="btn_permitir_denegar" type="submit" value="0">Regresar</button>

                    </div>

                 </div>

                <?php }?>                
             </div>
            </form>
	</div>
</div>
<!--- FOOTER ---->
<?php include("footer.php"); ?>  
</body>
</html>
