<?php
function array2json($arr) { 
    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
    $parts = array(); 
    $is_list = false; 

    //Find out if the given array is a numerical array 
    $keys = array_keys($arr); 
    $max_length = count($arr)-1; 
    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1 
        $is_list = true; 
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
            if($i != $keys[$i]) { //A key fails at position check. 
                $is_list = false; //It is an associative array. 
                break; 
            } 
        } 
    } 

    foreach($arr as $key=>$value) { 
        if(is_array($value)) { //Custom handling for arrays 
            if($is_list) $parts[] = array2json($value); /* :RECURSION: */ 
            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */ 
        } else { 
            $str = ''; 
            if(!$is_list) $str = '"' . $key . '":'; 

            //Custom handling for multiple data types 
            if(is_numeric($value)) $str .= $value; //Numbers 
            elseif($value === false) $str .= 'false'; //The booleans 
            elseif($value === true) $str .= 'true'; 
            else $str .= '"' . addslashes($value) . '"'; //All other things 
            // :TODO: Is there any more datatype we should be in the lookout for? (Object?) 

            $parts[] = $str; 
        } 
    } 
    $json = implode(',',$parts); 
     
    if($is_list) return '[' . $json . ']';//Return numerical JSON 
    return '{' . $json . '}';//Return associative JSON 
} 
$_POST["accion"] and  $_POST["accion"]!= "" ? call_user_func_array($_POST["accion"],array()) : "";
function validacion_usuario(){
    session_start();
    include("cn_usuarios.php");
    $usuario = trim($_POST["usuario"]);
    $clave = trim($_POST["password"]);
    //CONSULTA DEL USUARIO
    $queryUsuario = "SELECT eTipoUsuario FROM cu_control_acceso WHERE sUsuario = '".$usuario."' AND hClave = sha1('".$clave."') AND hActivado = '1'";    
    $resultadoUsuario = @mysql_query($queryUsuario, $dbconn);
    $Usuario = mysql_fetch_array($resultadoUsuario);
    $NUM_ROWs_Usuario = mysql_num_rows($resultadoUsuario);
    mysql_close($dbconn);
    //Agregando registro a la bitacora de acceso
    if ( $NUM_ROWs_Usuario == 1){
         include("cn_usuarios.php"); 
         $sql = "INSERT INTO cu_intentos_acceso SET sUsuario = '".$usuario."', sClave = '".$clave."', dFechaIngreso = NOW(), sIP = '".$_SERVER['REMOTE_ADDR']."', bEntroSistema = '1'";
         @mysql_query($sql, $dbconn); 
         $acceso = $Usuario['eTipoUsuario'];
         mysql_close($dbconn);
         $_SESSION["acceso"] = $acceso;
         $_SESSION["usuario_actual"] = $usuario;
         echo "1";
     }else{
         include("cn_usuarios.php"); 
         $sql = "INSERT INTO cu_intentos_acceso SET sUsuario = '".$usuario."', sClave = '".$clave."', dFechaIngreso = ".$FECHA_ACCESO.", sIP = '".$_SERVER['REMOTE_ADDR']."', bEntroSistema = '0'";
         @mysql_query($sql, $dbconn);
         mysql_close($dbconn);
         session_unset();
         session_destroy();
         echo  "0";
     }
}  
function listado_usuarios(){
    include("cn_usuarios.php");                
    $registros_por_pagina = $_POST["registros_por_pagina"];
    $pagina_actual = $_POST["pagina_actual"];
    $registros_por_pagina == "" ? $registros_por_pagina = 5 : false;
    $pagina_actual == "" ? $pagina_actual = 1 : false;
    $order_por = $_POST["ordenar_por"];
    $array_filtros = explode(",",$_POST["filtroInformacion"]); 
    $filtroQuery .= " WHERE cu_control_acceso.sUsuario != '' ";
    
    foreach($array_filtros as $key => $valor){
        if($array_filtros[$key] != ""){
            $campo_valor = explode("|",$array_filtros[$key]);
            if ($campo_valor[0] =='iConsecutivoPatio'){
                    $filtroQuery.= " AND  ".$campo_valor[0]."='".$campo_valor[1]."' ";
            }else{
                    $filtroQuery == "" ? $filtroQuery.= " AND  ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'": $filtroQuery.= " AND ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'";
            }
        }
    }
    
    $query = "SELECT count(cu_control_acceso.sUsuario) as total FROM  cu_control_acceso   ".$filtroQuery;        
    $count = mysql_fetch_array(mysql_query($query, $dbconn)); 
    mysql_close($dbconn);                
    if($count['total'] == "0"){
        $pagina_actual = 0;
    }    
    $paginas_total = ceil($count['total'] / $registros_por_pagina);        
    if($count['total']== "0"){
        $limite_superior = 0;
        $limite_inferior = 0;
    }else{
        $pagina_actual == "0" ? $pagina_actual = 1 : false;
        $limite_superior = $registros_por_pagina;
        $limite_inferior = ($pagina_actual*$registros_por_pagina)-$registros_por_pagina;  
        //Consulta para llenar el grid de usuario
        include("cn_usuarios.php");    
        $query = "SELECT cu_control_acceso.sUsuario  FROM  cu_control_acceso   ".$filtroQuery." ORDER BY ".$order_por." LIMIT ".$limite_inferior.",".$limite_superior;   
        $result = mysql_query($query, $dbconn);
             if (mysql_num_rows($result) > 0){
                while ($Recordset = mysql_fetch_array($result)){  
                    $arr_[] = array("usuario" => $Recordset['sUsuario'],
                                    "nombre" => stripslashes($Recordset['sUsuario'])
                                    );
                    }
                    
             }
        $htmlTabla = "";
        foreach($arr_ as $i => $l){
            if($arr_[$i]["usuario"] != ""){
                if($arr_[$i]["usuario"] != ''){
                    //$td_asignacion= '<td><font face="Verdana" size="2" color="#336699"> &nbsp;</td>';                           
             }else{
                  //$td_asignacion= '<td><font face="Verdana" size="2" color="#336699"> &nbsp;<img border="0" src="images/ico_return.gif" width="15" height="15">   </td>';
             }
             $htmlTabla .= '<tr>'.$td_asignacion.'<td><font face="Verdana" size="2" color="#336699">'.str_replace("Ñ","&Ntilde;",$arr_[$i]["usuario"]).'</td><td><font face="Verdana" size="2" color="#336699">'.$arr_[$i]["nombre"].'</font></td><td><font face="Verdana" size="2" color="#336699">'.$arr_[$i]["nombre"].'</font></td><td width="3%" valign="top" align="center" nowrap="nowrap"><font size="2" face="Verdana"> <a href="#" title="Consultar Registro" class="boton_forma" Onclick="fn_listado_refrigerado.AbrirConsultaRegistro('.$arr_[$i]["consecutivo"].');"><img border="0" src="images/ico_c.gif" width="15" height="15"></a>    </font>  </td><td width="3%" valign="top" align="center" nowrap="nowrap"><font size="2" face="Verdana"> <a href="#" title="Editar Registro" class="boton_forma" Onclick="fn_listado_refrigerado.abrirPopUp('.$arr_[$i]["consecutivo"].');"><img border="0" src="images/ico_e.gif" width="15" height="15"></a>    </font>  </td><td width="3%" valign="top" align="center" nowrap="nowrap"><font size="2" face="Verdana"> <a href="#" title="Editar Registro" class="boton_forma" Onclick="fn_listado_refrigerado.abrirPopUp('.$arr_[$i]["consecutivo"].');"><img border="0" src="images/ico_tacha.gif" width="15" height="15"></a>    </font>  </td></tr>';
                                                                                                            
            }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
        }                                                                                                                                                                                                                     
        $htmlTabla .='<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td colspan="3">&nbsp;</td></tr>';
        mysql_free_result($result);
        mysql_close($dbconn);
        }
        $response = array("total"=>"$paginas_total","pagina"=>"$pagina_actual","tabla"=>"$htmlTabla");   
        echo array2json($response);    
}                 
function usuario_nuevo(){ //TIPOS_CAMBIO.PHP
    $usuario = trim($_POST["usuario"]);
    $password = sha1(md5(trim($_POST["password"])));
    $tipo = strtoupper(trim($_POST["nivel"]));
    $correo = strtoupper(trim($_POST["correo"]));
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT sUsuario FROM cu_control_acceso WHERE sUsuario = '".$usuario."' LOCK IN SHARE MODE";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
        $mensaje = "El usuario: $usuario ya existe. Favor de verificar los datos.";
        $error = "1";
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                
    } else {
        @mysql_free_result($result);
        $sql = "INSERT INTO cu_control_acceso SET sUsuario = '".$usuario."', hClave ='".$password."', eTipousuario ='".$tipo."', sDescripcion ='".$correo."'  ";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
            $error = "1";
        }                
        if ($transaccion_exitosa) {
            $mensaje = "El usuario $usuario se registro con exito";
            $error = "0";
            mysql_query("COMMIT");     
            mysql_close($dbconn);
        } else {
            $mensaje = "Error al guardar los datos. Favor de verificarlos.";
            $error = "1";  
            mysql_query("ROLLBACK");
            mysql_close($dbconn);
        }
    }
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
} 
function alta_usuario(){        
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $email = $_POST['email'];
    $correo = $_POST['email'];
    $calle = $_POST['calle'];
    $colonia = $_POST['colonia'];
    $telefono = $_POST['telefono'];
    $mensualidad = $_POST['mensualidad'];
    $sexo = $_POST['sexo'];
    $nivel = $_POST['nivel'];
    function generaPass(){
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);     
        $pass = "";
        $longitudPass=10;
        for($i=1 ; $i<=$longitudPass ; $i++){
            $pos=rand(0,$longitudCadena-1);             
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }  
    $codigo1 = generaPass();
    $codigo2 = substr( md5(microtime()), 1, 8).$codigo1.substr( md5(microtime()), 1, 5);
    $codigoconfirm = $codigo1.$codigo2;
    $password = generaPass();          //
    include("cn_usuarios_2.php");        
    //$conexion->begin_transaction();
    $conexion->autocommit(FALSE);
    $transaccion_exitosa = true;
    $sql = "SELECT sCorreoSocio FROM ct_socio WHERE sCorreoSocio = '".$email."' LOCK IN SHARE MODE";
    $result = $conexion->query($sql);
    $NUM_ROWs_Usuario = $result->num_rows;
    if ($NUM_ROWs_Usuario > 0) {
        $mensaje = "Error: $email ya fue registrado.";
        $error = "1";
        $conexion->rollback();
        $conexion->close();                                                                                                                                                                       
    } else {   
        $sql = "INSERT INTO ct_socio set sNombreSocio='".$nombre."',sApellidoPaternoSocio='".$apellido_paterno."',sApellidoMaternoSocio='".$apellido_materno."',sCalleSocio='".$calle."',sColoniaSocio='".$colonia."', sCorreoSocio='".$email."', sComentariosGeneralesSocio='".$ComentariosGenerales."', sTelefonoSocio='".$telefono."',   eGenero='".$sexo."',  sCantidadPago='".$mensualidad."', sCodigoVal = '".$codigoconfirm."', dFechaRegistro=NOW(), sUsuarioCreacionRegistro='".$_SESSION['acceso']."'";  
        $conexion->query($sql);   
        if ($conexion->affected_rows < 1 ) {
            $error = "1";
               
        }   
        $id = $conexion->insert_id;
        //$mensaje = "entro2";                      
        $sql = "INSERT INTO cu_control_acceso SET  sUsuario = '".$email."',  sCorreo ='".$correo."',eTipoUsuario ='".$nivel."', sDescripcion ='".$nombre."', hActivado  ='0', sCodigoVal = '".$codigoconfirm."' , hClave = sha1('".$password."') ";
        $conexion->query($sql);   
        if ($conexion->affected_rows < 1 ) {
            $error = "1";
            $mensaje = $sql;
            $transaccion_exitosa = false;
            //        
        }  
                  
         $ruta = "http://oxygen-fx.laredo2.net/system/confirm_mail_user.php?cuser=$codigoconfirm";
        if ($transaccion_exitosa) {
            //Proceso para enviar correo                 
            require_once("./lib/mail.php");
            $cuerpo = "
                    <div style=\"font-size:12px;border:1px solid #6191df;border-radius:3px;padding:10px;width:95%; margin:5px auto;font-family: Arial, Helvetica, sans-serif;\">
                         <h2 style=\"color:#313131;text-transform: uppercase; text-align:center;\">Bienvenido a Oxygen-FX Gym!</h2> \n 
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\"><strong>$correo</strong><br>Gracias por elegirnos. A continuacion se creara un acceso para que puedas verificar tus pagos y la vigencia de tu mensualidad!</p>\n 
                         <br><br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Te recomendamos que mantengas tus claves en algun lugar seguro.Una vez activada tu cuenta podras cambiar tu password</p>
                         <br><br>
                         <ul style=\"color:#010101;line-height:15px;\">
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">ID: </strong>$id</li>
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Login User: </strong>$correo</li>
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Password: </strong>$password</li>
                         </ul>
                         <br><br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Para poder activar tu cuenta solo da click en el boton de confirmar:</p><br>
                         <p style=\"margin:5px auto; text-align:center;\"><a href='$ruta' style='color:#ffffff;background:#6191df;padding:5px 8px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-decoration:none;'>Confirmar</a></p>
                         <br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Si este correo te ha llegado por error o no deseas acceder a tu cuenta da click en cancelar:</p>
                         <p style=\"margin:5px auto; text-align:center;\"><a href='oxygen-fx.laredo2.net' style='color:#ffffff;background:#8d0c0c;padding:5px 8px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-decoration:none;'>Cancelar</a></p>
                    </div>";
             $mail = new Mail();                                    
             $mail->From = "soporte@oxygen-fx.com";
             $mail->FromName = "oxygen-fx team";
             $mail->Host = "oxygen-fx.com";
             $mail->Mailer = "sendmail";
             $mail->Subject = "Tu nueva cuenta de acceso "; 
             $mail->Body  = $cuerpo;                                                                                            
             $mail->ContentType ="Content-type: text/html; charset=iso-8859-1";
             $mail->IsHTML(true);
             $mail->WordWrap =150;
             $mail_error = false;
             $mail->AddAddress(trim($correo));
             if (!$mail->Send()) {
                $mail_error = true;
                $mail->ClearAddresses();
             }        
            if(!$mail_error){
                $mensaje = "El usuario $usuario se registro con exito";
                $error = "0";
                $conexion->commit();
                $conexion->close();
            }else{
                $mensaje = "Error e-mail.";
                $error = "1";  
                $conexion->rollback();
                $conexion->close();           
            }            
        } else {
            $mensaje = "Error al guardar los datos. Favor de verificarlos.";
            $error = "1";  
            $conexion->rollback();
            $conexion->close();           
        }
    }
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);    
} 
 function confirm_user(){
      $code = trim($_POST["code"]);
      include("cn_usuarios_2.php");
      //$conexion->begin_transaction();
      $conexion->autocommit(FALSE);
      $transaccion_exitosa = true;
      $error = "0";
      $sql = "SELECT sUsuario, hActivado, sDescripcion FROM cu_control_acceso WHERE sCodigoVal = '".$code."'  LOCK IN SHARE MODE";
      $result = $conexion->query($sql);
      $NUM_ROWs_Usuario = $result->num_rows;
      if ($NUM_ROWs_Usuario > 0) {
           while ($usuario = $result->fetch_assoc()) {
               if($usuario['hActivado']  == "0"){
                   $sql = "UPDATE cu_control_acceso SET  hActivado = '1' WHERE sCodigoVal = '".$code."'";
                   $conexion->query($sql);   
                   if ($conexion->affected_rows < 1 ) {
                        $error = "1";
                        $mensaje = "Error de sistema general : Error interno";                        
                   }else{
                       $conexion->commit();
                       $mensaje = "1"; //correct
                       $usuario = $usuario['sDescripcion'];
                       $correo =  $usuario['sUsuario'];
                   }
                   
               }else{                     
                   $mensaje = "Error: El codigo de validacion ha expirado ";
                   $error = "2";
               }
               
           }
          
      }else{
          $mensaje = "Error: Usuario no existe";
          $error = "1";
      }
      $conexion->close();
      
      $response = array("mensaje"=>"$mensaje","error"=>"$error");   
      echo array2json($response);
      
  }
?>