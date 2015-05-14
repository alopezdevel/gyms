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

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(inicio);
function inicio(){  
 var mensaje = $( ".mensaje_valido" );       
    var dialogo;
    dialogo = $( "#dialog-user" ).dialog({
      autoOpen: false,
      height: 800,
      width: 1296,                                 
      modal: true,  
       buttons: {
        "Crear nuevo usuario": onInsertarUsuario,
        Cancel: function() {
          dialogo.dialog( "close" );
        }
      },    
      close: function() {
        //form[ 0 ].reset();
        //allFields.removeClass( "ui-state-error" );
      }
    }); 
     //focus
    $('input.texto').focus(onFocus);
    //blur
    $('input.texto').blur(onBlur);
    $("#Nuevosocio").click(onAltaCliente);    
    
}
function onInsertarUsuario(){    
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    var floatRegex = /[-+]?([0-9]*.[0-9]+|[0-9]+)/; 
    var name = $("#nombre");    
    var apellido_paterno = $("#apellido_paterno");
    var apellido_materno = $("#apellido_materno");
    var email = $("#email");
    var calle = $("#calle");
    var colonia = $("#colonia");
    var telefono = $("#telefono");
    var sexo = $("#sexo");
    var mensualidad = $("#mensualidad");
    todosloscampos = $( [] ).add( name ).add( apellido_paterno ).add( apellido_materno ).add( apellido_materno ).add( email ).add( calle ).add( colonia ).add( telefono ).add( sexo ).add( mensualidad );
    todosloscampos.removeClass( "error" );
    $("#name").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
     //validaciones
    var valid = true;
    
    //Nombre socio
    valid = valid && checkLength( name, "Nombre del socio", 2, 25 );
    valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Nombre del socio debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido paterno
    valid = valid && checkLength( apellido_paterno, "Apellido paterno", 2, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido paterno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido materno
    valid = valid && checkLength( apellido_materno, "Apellido materno", 2, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido materno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //email
    valid = valid && checkLength( email, "E-mail", 6, 80 );                                                                                                           
    valid = valid && checkRegexp( email, emailRegex, "ej. ui@hotmail.com" );
    //calle
    valid = valid && checkLength( calle, "Calle", 5, 25 );
    valid = valid && checkRegexp( calle, /^[a-z]([0-9a-z_\s])+$/i, "Calle debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //colonia
    valid = valid && checkLength( colonia, "Colonia", 5, 25 );
    valid = valid && checkRegexp( colonia, /^[a-z]([0-9a-z_\s])+$/i, "Colonia debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    
    valid = valid && checkLength( telefono, "Telefono", 6, 25 );
    valid = valid && checkRegexp( telefono, /[0-9-()+]{3,20}/, "Telefono solo permite numeros: 0-9" );
    
    if($("#sexo").val() == ""){
        valid = false;
        actualizarMensajeAlerta( 'Favor de seleccionar un genero para el socio' );  
    }
    
    if($("#mensualidad").val()!= ""){
        valid = valid && checkLength( mensualidad, "Mensualidad", 1, 25 );
        valid = valid && checkRegexp( mensualidad, floatRegex , "Mensualidad solo permite numeros: 0-9" );
    }
    if ( valid ) {
        $.post("funciones.php", { accion: "alta_usuario", nombre: name.val() , apellido_paterno: apellido_paterno.val(),
                                                          apellido_materno: apellido_materno.val() , email: email.val(),
                                                          calle: calle.val() , colonia: colonia.val(), 
                                                          telefono: telefono.val() , mensualidad: mensualidad.val(), 
                                                          sexo: sexo.val() ,nivel: "C"},
        function(data){ 
             switch(data.error){
             case "1":   actualizarMensajeAlerta( data.mensaje);
                         $("#nombre").focus();
                         email.addClass( "error" ); 
                    break;
             case "0":   actualizarMensajeAlerta("Favor de llenar los campos.");
                         $('input.texto').val("");
                         $("#sexo").val("");
                         $("#name").focus();                                                                          
                         alert("Gracias. El usuario " + name.val() + " se ha registrado de manera satisfactoria.");   
                         actualizarMensajeAlerta("Gracias. El usuario " + name.val() + " se ha registrado de manera satisfactoria.");
                         //location.href= "inicio.php";
                    break;  
             }
         }
         ,"json");
       
    }
}
function onFocus(){
     $(this).css("background-color","#FFFFC0");
 }
 function onBlur(){
    $(this).css("background-color","#FFFFFF");
 }
 function actualizarMensajeAlerta( t ) {
      var mensaje = $( ".mensaje_valido" );
      mensaje
        .text( t )
        .addClass( "alertmessage" );
      setTimeout(function() {
        mensaje.removeClass( "alertmessage", 2500 );
      }, 700 );
 }
 function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        actualizarMensajeAlerta( n );
        o.addClass( "error" );
        o.focus();
        return false;
    } else {                     
        return true;        
    }
 }
 function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        actualizarMensajeAlerta( "La longitud del campo " + n + " debe contener por lo menos entre " + min + " y " + max + ". caracteres"  );
        o.addClass( "error" );
        o.focus();
        return false;    
    } else {             
        return true;                     
    }                    
 }
function onAltaCliente(){
  
    $( "#dialog-user" ).dialog("open");
}   

function  addUser(){
}

     

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

<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Catalogo de Socios</h2>
        </div>

        <div class="txt-content">
        <?php if( $_GET['type'] != sha1(md5("Insertar")).md5(sha1("Socio")) && $_GET['type'] != sha1(md5("editar")).md5(sha1("Socio"))  && $_GET['type'] != sha1(md5("eliminar")).md5(sha1("Socio"))){ ?> 
        <form id="form_consulta" action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Socio"));?>" method="POST" name="frmConsultarSocio" onSubmit="return Validaciones()">
                <div class="frm-buscar3">
                    <div><label class="txt-center allcorners">Buscar socio por:</label></div>
                    <input class="left rborders-right" name="txtBusquedaNombre"  type="text"  value="" maxlength="30"  placeholder="Nombre"  />                                                                                                                                          
                    <input class="left rborders-left" name="txtBusquedaAPaterno" type="text"  value="" maxlength="30"  placeholder="Apellido Paterno" />
                    <br><br><br>
                    <div class="frm-btns clearfix">
                        <button type="submit">Buscar</button> 
                        <button type="submit" name="RecargarLista" value="1">Actualizar lista</button>
                         <?php if($_SESSION["acceso"] == "A"){?> 
                        <button id="Nuevosocio" name="Nuevosocio" type="button" value="1" >Nuevo socio</button> 
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
                                <td class="head" colspan="2"></td>
                            </tr>
                            <?php if(count($arr_Socio)>0){

                                    $i= 0;

                                    $color_font_normal= "#000000";

                                     foreach($arr_Socio as $socio){

                                         if ($i % 2 == 0) {

                                             $color = "transparent";

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
        <div id="caja-gris" class="clearfix">
            <h2>Nuevo Socio</h2>
            <input name="txtNombre" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtNombre'];}?>" maxlength="30"  placeholder="Nombre"/>
            <input name="txtApaterno" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtApaterno'];}?>" maxlength="30"  placeholder="Apellido Paterno"/>
            <input name="txtAmaterno" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtAmaterno'];}?>" maxlength="30"  placeholder="Apellido Materno"/>
            <input name="txtCalle" type="text" value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtCalle'];}?>"   maxlength="30"  placeholder="Calle"/>
            <input name="txtColonia" type="text" value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtColonia'];}?>"   maxlength="30"  placeholder="Colonia"/>
            <input name="txtCorreo" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtCorreo'];}?>" maxlength="30"  placeholder="Correo"/>
            <input name="txtTelefono" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtTelefono'];}?>" maxlength="30"  placeholder="Tel&eacute;fono"/>
            <fieldset class="txt-center">
            <label>Masculino</label><input type="radio" name="genero" id="GeneroM" value="<?php  

                            if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ 

                                

                                if ($_POST['genero']!=""){

                                    echo $_POST['genero'];

                                } else{

                                    echo 'M';

                                }

                            }?>">
            <label>Femenino</label><input type="radio" name="genero" id="GeneroF"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ if ($_POST['genero']!=""){echo $_POST['genero'];} else{echo 'F';}}?>">
            </fieldset>
            <input id="datepicker" name="txtFechaNacimiento" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtFechaNacimiento'];}?>" maxlength="10"  placeholder="Fecha Nacimiento: (ej. dd/mm/yy)"/>
            <input name="txtMensualidad" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtMensualidad'];}?>" maxlength="5"  placeholder="Mensualidad"/>
            <input name="txtComentarios" type="text"  value="<?php  if($_GET['type'] == sha1(md5("Insertar")).md5(sha1("Socio")) ){ echo $_POST['txtComentarios'];}?>" maxlength="250"  placeholder="Comentarios Generales"/>
            <div class="txt-center">
                <button class="btn-aceptar" name="btn_Aceptar_Cancelar" type="submit" value="1">Guardar</button>
                <button class="btn-cancelar" name="btn_Aceptar_Cancelar" type="submit" value="0" >Cancelar</button>
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
                <fieldset class="txt-center">
                    <label>Masculino</label><input type="radio"  value="M" <?php echo ($arr_Socio_edit[0]['genero_socio']=='M')?'checked':'' ?>  name="genero" id="GeneroM" >
                    <label>Femenino</label><input type="radio"   value="F" <?php echo ($arr_Socio_edit[0]['genero_socio']=='F')?'checked':'' ?>  name="genero" id="GeneroF" >
                </fieldset>
                <input id="datepicker" name="txtFechaNacimiento" type="text" value="<?php  if($_POST['txtFechaNacimiento']==""){ echo $arr_Socio_edit[0]['fecha_nacimiento_socio'];}else{ echo $_POST['txtFechaNacimiento'];}?>"   maxlength="10"  placeholder="Fecha Nacimiento"/>
                <input name="txtMensualidad" type="text" value="<?php  if($_POST['txtMensualidad']==""){ echo $arr_Socio_edit[0]['cantidadPago_socio'];}else{ echo $_POST['txtMensualidad'];}?>"  maxlength="5"  placeholder="Mensualidad"/>
                <input name="txtComentarios" type="text" value="<?php  if($_POST['txtComentarios']==""){ echo $arr_Socio_edit[0]['comentarios_generales_socio'];}else{ echo $_POST['txtComentarios'];}?>"  maxlength="250"  placeholder="Comentarios Generales"/>
                <input type="hidden" name="folio_socio"  value="<?= $arr_Socio_edit[0]['id_socio']; ?>"> 
                <div class="txt-center"> 
                    <button class="btn-aceptar" name="btnEditar_Aceptar_Cancelar" type="submit" value="1">Guardar</button>
                    <button class="btn-cancelar" name="btnEditar_Aceptar_Cancelar" type="submit" value="0" >Cancelar</button>
                </div>
            </div>
          <br><br> 
          </form>

          <?php } ?>
        
        </div>             
        <div id="dialog-user" title="Alta Socio" class="ui-widget" >
      <div class="container">
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Nuevo Socio</h2>
        </div>
        <form method="post" action="">
            <p class="mensaje_valido">&nbsp;Favor de llenar los campos.</p>
            <input  id = "nombre"   class="texto" name="nombre" type="text" placeholder="Nombre del socio:">
            <input  id = "apellido_paterno" class="texto"  name="apellido_paterno" type="text" placeholder="Apellido paterno:">
            <input  id = "apellido_materno" class="texto"  name="apellido_materno" type="text" placeholder="Apellido materno:">
            <input  id = "email" name="email" class="texto" type="text" placeholder="E-mail:">         
            <input  id = "calle" name="calle" class="texto" type="text" placeholder="Calle:">
            <input  id = "colonia" name="colonia" class="texto" type="text" placeholder="Colonia:">
            <input  id = "telefono" name="Telefono" class="texto" type="text" placeholder="telefono:">
            <select name="sexo" id="sexo" class="texto">
                <option value=""><-Seleccione Genero-></option>
                <option value="M">Masculino</option>
                <option value="F">Femeino</option>
            </select>            
            <input  id = "mensualidad"  class="texto" name="mensualidad" type="text" placeholder="Mensualidad sugerida (opcional):">
           
        </form>
    </div> 
    </div>
    </div> 
     
</body>
</html>