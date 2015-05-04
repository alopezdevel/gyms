<?php

session_start();       

include("funciones_consulta.php");

include("altas_1.php");

if ( 0 ){ //No ha iniciado session

    header("Location: index.php");

    exit;

}else {

        $arr_Socio = NULL;

        //Si se ejecuto el boton RecargarLista entonces..

        if($_POST['RecargarLista'] == "1"){

            $_POST['txtBusquedaNombre']="";

            $_POST['txtBusquedaAPaterno']="";

        }

      //Si los campos de busqueda de nombre y apellido paterno estan vacios entonces ca    

      if(trim($_POST['txtBusquedaNombre'])== "" && trim($_POST['txtBusquedaAPaterno'])=="" ){

              getSocios($_POST['txtBusquedaNombre'],$_POST['txtBusquedaAPaterno'],$arr_Socio); 

        }

      // Si el type es insertar socio entonces ejecutara las sentencias de registrar un nuevo socio.

      if( $_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio"))){

             //Si el boton tiene como valor 1 entonces realizo una inserci�n.

             if($_POST['btn_Aceptar_Cancelar'] =="1"){

                    //Validaciones necesarias.

                    $esInsert = TRUE;

                    if(ValidarSocio($_POST['txtNombre'],$_POST['txtApaterno'],$_POST['txtAmaterno'],$_POST['txtCalle'],$_POST['txtColonia'],$_POST['txtCorreo'],$_POST['txtComentarios'],$_POST['txtTelefono'],$_POST['genero'],$_POST['txtMensualidad'],$_POST['txtFechaNacimiento'],$esInsert)){

                        if(insertarNuevoSocio($_POST['txtNombre'],$_POST['txtApaterno'],$_POST['txtAmaterno'],$_POST['txtCalle'],$_POST['txtColonia'],$_POST['txtCorreo'],$_POST['txtComentarios'],$_POST['txtTelefono'],$_POST['genero'],$_POST['txtMensualidad'],$_POST['txtFechaNacimiento'])){

                        echo '<script language="javascript">alert(\'El Socio se registro correctamente.\')</script>';

                        $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio"));  

                    }else{

                            echo '<script language="javascript">alert(\'No se pudo registrar el socio favor de verificar los datos o intentarlo despues.\')</script>';

                            $_GET['type'] = sha1(md5("Insertar")).md5(sha1("Socio"));   

                         }

                         

                 }             

             }else{

                $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio"));  

             }

         }

      //Si el type es de tipo editar entonces busca el socio para poder editar sus datos.

      if( $_GET['type'] == sha1(md5("editar")).md5(sha1("Socio"))){

               $arr_Socio_edit = NULL;

               if($_POST['folio_socio'] != ""){ 

               //Si el usuario ejecuto el evento en el boton guardar entonces.. actualiza datos.

               if($_POST['btnEditar_Aceptar_Cancelar'] =="1"){

                   getSocio($_POST['folio_socio'],$arr_Socio_edit);

                   $esInsert = FALSE; 

                   if(ValidarSocio($_POST['txtNombre'],$_POST['txtApaterno'],$_POST['txtAmaterno'],$_POST['txtCalle'],$_POST['txtColonia'],$_POST['txtCorreo'],$_POST['txtComentarios'],$_POST['txtTelefono'],$_POST['genero'],$_POST['txtMensualidad'],$_POST['txtFechaNacimiento'],$esInsert)){ 

                   if(ActualizarSocio($_POST['folio_socio'],$_POST['txtNombre'],$_POST['txtApaterno'],$_POST['txtAmaterno'],$_POST['txtCalle'],$_POST['txtColonia'],$_POST['txtCorreo'],$_POST['txtComentarios'],$_POST['txtTelefono'],$_POST['genero'],$_POST['txtMensualidad'],$_POST['txtFechaNacimiento'])){

                          echo '<script language="javascript">alert(\'Los datos se guardaron correctamente.\')</script>';

                          $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio"));

                    }else{

                             echo '<script language="javascript">alert(\'No se pudo guardar los datos del socio favor de verificar los datos o intentarlo despues.\')</script>';

                             $_GET['type'] = sha1(md5("editar")).md5(sha1("Socio")); 

                         }

                   }     

                }else{

                     $_GET['type'] = sha1(md5("buscar")).md5(sha1("Socio")); 

                }

                

               }else{

                 $folio = $_GET['idSocio'];

                 getSocio($folio,$arr_Socio_edit);

               }                

         }

      //Si el type es de tipo eliminar entonces desactiva al socio.   

      if($_GET['type'] == sha1(md5("eliminar")).md5(sha1("Socio"))){

          $folio = $_GET['idSocio'];

          if(SocioInactivo($folio)){

              echo '<script language="javascript">alert(\'El socio se dio de baja correctamente.\')</script>';

              $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio"));

          }else{

                echo '<script language="javascript">alert(\'No se pudo dar de baja el socio favor de intentarlo despues.\')</script>';

                $_GET['type'] = sha1(md5("Buscar")).md5(sha1("Socio")); 

                }

                   

      }   

      //Si el type es de tipo buscar entonces..   

      if( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Socio"))  ){

            if($_POST['Nuevosocio'] == "1"){ 

                  $_GET['type'] = sha1(md5("Insertar")).md5(sha1("Socio"));

               }else{

                     getSocios($_POST['txtBusquedaNombre'],$_POST['txtBusquedaAPaterno'],$arr_Socio);

               }

        }

            

}

?>

<?php include("header.php");?>

<script>

    $(function() {

        $( "#datepicker" ).datepicker({

            dateFormat : 'dd/mm/yy',

            changeMonth : true,

            changeYear : true,

            yearRange: '-100y:c+nn',

            maxDate: '-1d'

        });

    });

</script>

    <div id="content">

        <h1>Catalogo de Socios</h1>

        <div class="txt-content">

        <?php if( $_GET['type'] != sha1(md5("Insertar")).md5(sha1("Socio")) && $_GET['type'] != sha1(md5("editar")).md5(sha1("Socio"))  && $_GET['type'] != sha1(md5("eliminar")).md5(sha1("Socio"))){ ?> 

        <form id="form_consulta" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Socio"));?>"

         method="POST" name="frmConsultarSocio" onSubmit="return Validaciones()">

                <div class="frm-buscar3">

                    <div class="txt-left">Buscar socio por:</div>
                    <input class="left rborders-right" name="txtBusquedaNombre"  type="text"  value="" maxlength="30"  placeholder="Nombre"  />                                                                                                                                          
                    <input class="left rborders-left" name="txtBusquedaAPaterno" type="text"  value="" maxlength="30"  placeholder="Apellido Paterno" />
                    <br><br><br>
                    <div class="frm-btns clear">
                        <button type="submit">Buscar</button> 
                        <button type="submit" name="RecargarLista" value="1">Actualizar lista</button>
                         <?php if($_SESSION["acceso"] == "A"){?> 
                        <button  name="Nuevosocio" type="submit" value="1" >Nuevo socio</button> 
                        <?php }?>
                    </div>

                </div> 

                <br>

                <br>

                <div id="monitor-container"> 

                        <table align="center" cellspacing="0">

                            <tr>

                                <td class="head">ID</td>

                                <td class="head">NOMBRE</td>

                                <td class="head">APELLIDO</td>

                                <td class="head">DIRECCION</td>

                                <td class="head">EDITAR</td>

                                <td class="head">ELIMINAR</td>

                            </tr>

                            <?php if(count($arr_Socio)>0){

                                    $i= 0;

                                    $color_font_normal= "#000000";

                                     foreach($arr_Socio as $socio){

                                         if ($i % 2 == 0) {

                                             $color = "#C0C0C0";

                                         }else{

                                             $color = "#F0F0F0";

                                         }

                                         ?>

                                     <tr bgcolor="<?php echo $color?>">

                                        <td align="center"><b><font color="<?php echo $color_font_normal ;?>">&nbsp;<?php echo $socio['id_socio'];?></font></b></td>

                                        <td align="center"><b>&nbsp;<?php echo $socio['nombre_socio'];?></b></td>

                                        <td align="center"><b>&nbsp;<?php echo $socio['apellido_paterno'].'  '.$socio['apellido_materno'];?></b></td>

                                        <td align="center"><b>&nbsp;<?php echo $socio['calle_socio'];?></b></td>
                                        <?php if($_SESSION["acceso"] == "A"){?>
                                        <td align="center"><a class="editar" href="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("editar")).md5(sha1("Socio"))."&idSocio=".$socio['id_socio'];?>">Editar</a></td>

                                        <td align="center"><a class="eliminar" href="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("eliminar")).md5(sha1("Socio"))."&idSocio=".$socio['id_socio'];?>" onclick="return confirm('Estas seguro de eliminar este socio?');">Eliminar</a></td>
<?php }else{?>  <td align="center"> &nbsp; </td>  <td align="center"> &nbsp; </td>
<? }?>
                                     </tr>

                            <?php }

                                  }else{?>

                                  <tr>

                                        <td align="center" colspan="6">Datos no encontrados.</td>

                                  </tr>

                                  <?php }

                            ?>

                        </table>      

                </div>

        </form>

        <?php } ?>

        <?php if( $_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ ?>        

        <form id="form_Captura" class="frm-altas" action="

        <?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Insertar")).md5(sha1("Socio"));?>" method="POST" name="frmInsertSocio" onSubmit="return Validaciones()" >
        <div id="caja-gris" class="clear">
            <h2>Nuevo Socio</h2>
            <input class="clear" name="txtNombre" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtNombre'];}?>" maxlength="30"  placeholder="Nombre"/>
            <input name="txtApaterno" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtApaterno'];}?>" maxlength="30"  placeholder="Apellido Paterno"/>
            <input name="txtAmaterno" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtAmaterno'];}?>" maxlength="30"  placeholder="Apellido Materno"/>
            <input name="txtCalle" type="text" value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtCalle'];}?>"   maxlength="30"  placeholder="Calle"/>
            <input name="txtColonia" type="text" value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtColonia'];}?>"   maxlength="30"  placeholder="Colonia"/>
            <input name="txtCorreo" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtCorreo'];}?>" maxlength="30"  placeholder="Correo"/>
            <input name="txtTelefono" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtTelefono'];}?>" maxlength="30"  placeholder="Tel&eacute;fono"/>
            <label>Genero:</label>
            <label>Masculino:</label><input type="radio" name="genero" id="GeneroM" value="<?php  

                            if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ 

                                

                                if ($_POST['genero']!=""){

                                    echo $_POST['genero'];

                                } else{

                                    echo 'M';

                                }

                            }?>">
            <label>Femenino:</label><input type="radio" name="genero" id="GeneroF"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ if ($_POST['genero']!=""){echo $_POST['genero'];} else{echo 'F';}}?>">
            <input id="datepicker" name="txtFechaNacimiento" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtFechaNacimiento'];}?>" maxlength="10"  placeholder="Fecha Nacimiento: (ej. dd/mm/yy)"/>
            <input name="txtMensualidad" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtMensualidad'];}?>" maxlength="5"  placeholder="Mensualidad"/>
            <input name="txtComentarios" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtComentarios'];}?>" maxlength="250"  placeholder="Comentarios Generales"/>
            <div class="frm-btns">
                <button class="btn-aceptar" name="btn_Aceptar_Cancelar" type="submit" value="1">Guardar</button>
                <button class="btn-aceptar" name="btn_Aceptar_Cancelar" type="submit" value="0" >Cancelar</button>
            </div>
          <br><br> 
          </div> 
          </form>
         <br><br> 
          <?php } ?>

          

        <?php if( $_GET['type'] == sha1(md5("editar")).md5(sha1("Socio")) ){ ?>        

        <form id="form_Captura_edicion" class="frm-altas" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("editar")).md5(sha1("Socio"));?>" method="POST" name="frmeditarSocio" onSubmit="return Validaciones()" >
            <div id="caja-gris">
                <h2>Editar Socio</h2>
                <input name="txtNombre" type="text"  value="<?php  if($_POST['txtNombre']==""){ echo $arr_Socio_edit[0]['nombre'];}else{ echo $_POST['txtNombre'];}?>" maxlength="30"  placeholder="Nombre"/>
                <input name="txtApaterno" type="text" value="<?php  if($_POST['txtApaterno']==""){ echo $arr_Socio_edit[0]['apellido_paterno'];}else{ echo $_POST['txtApaterno'];}?>"   maxlength="30"  placeholder="Apellido Paterno"/>
                <input name="txtAmaterno" type="text" value="<?php  if($_POST['txtAmaterno']==""){ echo $arr_Socio_edit[0]['apellido_materno'];}else{ echo $_POST['txtAmaterno'];}?>"  maxlength="30"  placeholder="Apellido Materno"/>
                <input name="txtCalle" type="text" value="<?php  if($_POST['txtCalle']==""){ echo $arr_Socio_edit[0]['calle_socio'];}else{ echo $_POST['txtCalle'];}?>"  maxlength="30"  placeholder="Calle"/>
                <input name="txtColonia" type="text"  value="<?php  if($_POST['txtColonia']==""){ echo $arr_Socio_edit[0]['colonia_socio'];}else{ echo $_POST['txtColonia'];}?>"   maxlength="30"  placeholder="Colonia"/>
                <input name="txtCorreo" type="text" value="<?php  if($_POST['txtCorreo']==""){ echo $arr_Socio_edit[0]['correo_socio'];}else{ echo $_POST['txtCorreo'];}?>"  maxlength="30"  placeholder="Correo"/>
                <input name="txtTelefono" type="text" value="<?php  if($_POST['txtTelefono']==""){ echo $arr_Socio_edit[0]['telefono_socio'];}else{ echo $_POST['txtTelefono'];}?>"  maxlength="30"  placeholder="Tel�fono"/>
                <label>Genero:</label>
                    <label>Masculino:</label><input type="radio"  value="M" <?php echo ($arr_Socio_edit[0]['genero_socio']=='M')?'checked':'' ?>  name="genero" id="GeneroM" >
                    <label>Femenino:</label><input type="radio"   value="F" <?php echo ($arr_Socio_edit[0]['genero_socio']=='F')?'checked':'' ?>  name="genero" id="GeneroF" >
                <input id="datepicker" name="txtFechaNacimiento" type="text" value="<?php  if($_POST['txtFechaNacimiento']==""){ echo $arr_Socio_edit[0]['fecha_nacimiento_socio'];}else{ echo $_POST['txtFechaNacimiento'];}?>"   maxlength="10"  placeholder="Fecha Nacimiento"/>
                <input name="txtMensualidad" type="text" value="<?php  if($_POST['txtMensualidad']==""){ echo $arr_Socio_edit[0]['cantidadPago_socio'];}else{ echo $_POST['txtMensualidad'];}?>"  maxlength="5"  placeholder="Mensualidad"/>
                <input name="txtComentarios" type="text" value="<?php  if($_POST['txtComentarios']==""){ echo $arr_Socio_edit[0]['comentarios_generales_socio'];}else{ echo $_POST['txtComentarios'];}?>"  maxlength="250"  placeholder="Comentarios Generales"/>
                <input type="hidden" name="folio_socio"  value="<?= $arr_Socio_edit[0]['id_socio']; ?>"> 
                <div class="frm-btns"> 
                    <button class="btn-aceptar" name="btnEditar_Aceptar_Cancelar" type="submit" value="1">Guardar</button>
                    <button class="btn-aceptar" name="btnEditar_Aceptar_Cancelar" type="submit" value="0" >Cancelar</button>
                </div>
            </div>
          <br><br> 
          </form>

          <?php } ?>
        
        </div>     

    </div> 

<?php include("footer.php"); ?>