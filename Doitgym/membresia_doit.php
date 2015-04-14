<?php   

session_start();       

include("funciones_consulta.php");

if( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))  ){

         $arr_membresia = NULL;

         getMembresia($_POST['txtBusquedaMembresia'],$_POST['txtBusquedaNombre'],$_POST['txtBusquedaAPaterno'],$arr_membresia);   

         if (count($arr_membresia) > 0) {//que si existe el socio

            include("cn_usuarios.php");//Conexion

            mysql_query("BEGIN");//Transaccion inica

            $transaccion_exitosa = true;

            if($_SESSION['acceso'] != "U" && $_SESSION['acceso'] != "A")

                $_SESSION['acceso'] = "G";

                

            $descripcion = "Consulta de membresia por Folio :".$_POST['txtBusquedaMembresia']."Nombre :".$_POST['txtBusquedaNombre']."APaterno : ".$_POST['txtBusquedaAPaterno'];



             $sql = "insert into cb_transacciones_generales set usuario='".$_SESSION['acceso']."',fechalog=".$_SESSION['fecha_actual_server'].",tipoOperacion='C',descripcion='".$descripcion."',ip='".$_SERVER['REMOTE_ADDR']."'";

            mysql_query($sql, $dbconn);

            if ( mysql_affected_rows() < 1 ) {

                $transaccion_exitosa = false;

                $mensaje_error="No se pudo insertar el registro en la tabla de transacciones del socio. Favor de verificar los datos.";

               

            }

            

            if ($transaccion_exitosa) {

                mysql_query("COMMIT");

                mysql_close($dbconn);

                //echo '<script language="javascript">alert(\'Acceso Registrado.\')</script>'; 

            } else {

                echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';

                mysql_query("ROLLBACK");

                mysql_close($dbconn);

            }

         }else{

             

             

         }

     }

?> 

<script>

function Validar_Verificacion() {         

    var forma = document.frmBuscarMembresia;

    var ckMembresiackd = document.getElementById("chkIdMembresia").checked;

    var ckNombreckd = document.getElementById("chkNombre").checked;

    var ckAPaternockd = document.getElementById("chkapellidoPaterno").checked;

    

    if(ckMembresiackd)

        {

            if (forma.txtBusquedaMembresia.value == ""){

                alert("Favor de llenar el ID de la membresia.");

                return false;

            } 

        }

        

     if(ckNombreckd)

        {

            if (forma.txtBusquedaNombre.value == ""){

                alert("Favor de llenar el campo de nombre");

                return false;

            }  

        }

        

      if(ckAPaternockd)

        {

            if (forma.txtBusquedaAPaterno.value == ""){

                alert("Favor de llenar el campo de apellido paterno.");

                return false;

            }

        }

        

      if(ckMembresiackd==false && ckNombreckd==false && ckAPaternockd==false){

                alert("Favor de seleccionar al menos una opci�n de busqueda.");

                return false;

            }

            else {

                return true;

            }

            

}

</script>

<?php include("header.php");?>

    <div id="content">

        <h1 class="user">Membres&iacute;a Doit</h1>

        <div class="txt-content">
            <div class="col1">
            <form id="form_consulta" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Socio"));?>" method="POST" name="frmBuscarMembresia" onSubmit="return Validar_Verificacion()">
                    <div id="caja-gris" style="width:400px;">

                    <label>Consulta la fecha de vencimiento de tu membres&iacute;a: </label><br><br>
                    <input class="left" id="chkIdMembresia" type="checkbox" name="chkIdMembresia" checked="" value="" 
                    <?php

                         include("usuarioguest.php");

                    ?>
                    ><input name="txtBusquedaMembresia" type="text"  value="" maxlength="5"  placeholder="ID Membresia"/><br>
                    <input class="left" id="chkNombre" type="checkbox" name="chkNombre" value="" 

                    <?php

                         include("usuarioguest.php");

                    ?>

                    ><input name="txtBusquedaNombre"  type="text"  value="" maxlength="30"  placeholder="Nombre"   

                    <?php

                         include("usuarioguest.php");

                    ?>

                    /><br>                                                                                                                                             
                    <input class="left" id="chkapellidoPaterno" type="checkbox" name="chkapellidoPaterno" value="" 

                    <?php

                         include("usuarioguest.php");

                    ?>

                    ><input name="txtBusquedaAPaterno" type="text"  value="" maxlength="30"  placeholder="Apellido Paterno" 

                    <?php

                         include("usuarioguest.php");

                    ?>

                    /><br>
                    <div class="txt-center"><button type="submit">Buscar</button></div> 
                    </div> 
            </form>
            </div>
            <div class="col1" style="text-align:right;">
               <img src="images/content/img-membresia.png" border="0" alt="img-membresia.png">
            </div>
            <br>
            <div id="monitor-container" style=" 

                <?php

                       if(count($arr_membresia)<=0 || $arr_membresia == NULL)

                       {

                          echo 'visibility:hidden';

                       }

                       else

                       {

                          echo 'style=""';

                       } 

                ?>

                ">

                <table align="center" cellspacing="0">

                    <tr>

                        <td class="head">ID</td>

                        <td class="head">NOMBRE</td>

                        <td class="head">FECHA VENCIMIENTO</td>

                    </tr>

                    <?php if(count($arr_membresia)>0){

                            $i= 0;

                            $color_font_normal= "#000000";

                             foreach($arr_membresia as $socio){

                                 if ($i % 2 == 0) {

                                     $color = "#C0C0C0";

                                 }else{

                                     $color = "#F0F0F0";

                                 }

                                 ?>

                             <tr bgcolor="<?php echo $color?>">

                                <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo $socio['id_socio'];?></font></b></td>

                                <td align="center"><b>&nbsp;<?php echo $socio['nombre'].'  '.$socio['apellido_paterno'];?></b></td>

                                <td align="center"><b>&nbsp;<?php echo $socio['fecha_vencimiento'];?></b></td>

                             </tr>

                             <?php }

                          }else{?>

                              <tr>

                                <td align="center" colspan="3">Datos no encontrados.</td>

                             </tr>

                          <?php }

                    ?>

                    

                </table>

            </div>

            

              

        </div>     

    </div> 

</div>

<?php include("footer.php"); ?>