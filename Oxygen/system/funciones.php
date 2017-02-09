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
                  
         $ruta = "http://www.oxygencrossfit.com/system/confirm_mail_user.php?cuser=$codigoconfirm";
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
                         <p style=\"margin:5px auto; text-align:center;\"><a href='http://www.oxygencrossfit.com' style='color:#ffffff;background:#8d0c0c;padding:5px 8px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;text-decoration:none;'>Cancelar</a></p>
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
function actualizar_usuario(){        
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $id = $_POST['id'];
    $calle = $_POST['calle'];
    $colonia = $_POST['colonia'];
    $telefono = $_POST['telefono'];
    $mensualidad = $_POST['mensualidad'];
    $sexo = $_POST['sexo'];
    $nivel = $_POST['nivel'];
    //Workouts
    $fran = $_POST['fran'];
    $helen = $_POST['helen'];
    $filthy = $_POST['filthy'];
    $grace = $_POST['grace'];
    $row = $_POST['row'];
    $sprint = $_POST['sprint'];
    $run = $_POST['run'];
    //Skills
    $eRope = $_POST['eRope'];
    $eDu = $_POST['eDu'];
    $eHspu = $_POST['eHspu'];
    $ePulls = $_POST['ePulls'];
    $eMtsWalk = $_POST['eMtsWalk'];
    $iBoxJump = $_POST['iBoxJump'];
    $eRingMuscle = $_POST['eRingMuscle'];
    //Maxer pr
    $iCleanJerk = $_POST['iCleanJerk'];
    $iSnatch = $_POST['iSnatch'];
    $iDeadlift = $_POST['iDeadlift'];
    $iBackSquat = $_POST['iBackSquat'];
    $iMaxPullUps = $_POST['iMaxPullUps'];
    $iMaxMuscleUp = $_POST['iMaxMuscleUp'];
    $iMaxBurpeesMin = $_POST['iMaxBurpeesMin'];
    //Datos personales
    $edad = $_POST['edad'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    
    $error = "0";
    include("cn_usuarios_2.php");        
    //$conexion->begin_transaction();
    $conexion->autocommit(FALSE);
    $transaccion_exitosa = true;
    $sql = "SELECT iIDSocio FROM ct_socio WHERE iIDSocio = '".$id."' LOCK IN SHARE MODE";
    $result = $conexion->query($sql);
    $NUM_ROWs_Usuario = $result->num_rows;
    if ($NUM_ROWs_Usuario > 0) {         
        $sql = "UPDATE ct_socio set sNombreSocio='".$nombre."',sApellidoPaternoSocio='".$apellido_paterno."',sApellidoMaternoSocio='".$apellido_materno."',sCalleSocio='".$calle."',sColoniaSocio='".$colonia."', sTelefonoSocio='".$telefono."',   eGenero='".$sexo."',  sCantidadPago='".$mensualidad."' ";        
        $fran = $_POST['fran'];
        $helen = $_POST['helen'];
        $filthy = $_POST['filthy'];
        $grace = $_POST['grace'];
        $row = $_POST['row'];
        $sprint = $_POST['sprint'];
        $run = $_POST['run'];
        //Workouts
        if($fran != ""){ $sql = $sql." ,  sWFran='".$fran."' ";}
        if($helen != ""){ $sql = $sql." , sWHelen='".$helen."' ";}
        if($filthy != ""){ $sql = $sql." , sWFilthy50='".$filthy."' ";}
        if($grace != ""){ $sql = $sql." , sWGrace='".$grace."' ";}
        if($row != ""){ $sql = $sql." , sWRow500m='".$row."' ";}
        if($sprint != ""){ $sql = $sql." , sWSprint400m='".$sprint."' ";}
        if($run != ""){ $sql = $sql." , sWRun5k='".$run."' ";}        
        //Skills
        if($eRope != ""){ $sql = $sql." ,  eS_ropeclaims='".$eRope."' ";}
        if($eDu != ""){ $sql = $sql." ,  eS_du='".$eDu."' ";}
        if($eHspu != ""){ $sql = $sql." ,  eS_hspu='".$eHspu."' ";}
        if($ePulls != ""){ $sql = $sql." ,  eS_pullups='".$ePulls."' ";}
        if($eMtsWalk != ""){ $sql = $sql." ,  eS_walkhs='".$eMtsWalk."' ";}
        if($iBoxJump != ""){ $sql = $sql." ,  iS_boxjumpmax='".$iBoxJump."' ";}
        if($eRingMuscle != ""){ $sql = $sql." ,  eS_ringmuscleup='".$eRingMuscle."' ";}
        //Maxe
        if($iCleanJerk != ""){ $sql = $sql." ,  iMP_cleanandjerk='".$iCleanJerk."' ";}
        if($iSnatch != ""){ $sql = $sql." ,  iMP_snatch='".$iSnatch."' ";}
        if($iDeadlift != ""){ $sql = $sql." ,  iMP_deadlift='".$iDeadlift."' ";}
        if($iBackSquat != ""){ $sql = $sql." ,  iMP_backsquat='".$iBackSquat."' ";}
        if($iMaxPullUps != ""){ $sql = $sql." ,  iMP_maxpullups='".$iMaxPullUps."' ";}
        if($iMaxMuscleUp != ""){ $sql = $sql." ,  iMP_maxmuscleup='".$iMaxMuscleUp."' ";}
        if($iMaxBurpeesMin != ""){ $sql = $sql." ,  iMP_maxburpeesmin='".$iMaxBurpeesMin."' ";}
        //Datos personales
        if($edad != ""){ $sql = $sql." ,  iEdad='".$edad."' ";}
        if($altura != ""){ $sql = $sql." ,  iAltura='".$altura."' ";}
        if($peso != ""){ $sql = $sql." ,  iPeso='".$peso."' ";}
        $sql = $sql."WHERE iIDSocio = '".$id."'";  
        $conexion->query($sql);   
        
        if ($conexion->affected_rows < 1 ) {
            $error = "1";
            $transaccion_exitosa = false;
            $error = "2";
            $mensaje = "El usuario no ha sufrido ninguna modificacion";
            
        }   
    } else {   
        $mensaje = "Error: $id no existe.";
        $error = "1";
        
        $transaccion_exitosa = false;   
    }
    if($transaccion_exitosa){
         $mensaje = "Se actualizo correctamente el socio.";
         $conexion->commit();
         $conexion->close();
    }else{
         $conexion->rollback();
         $conexion->close(); 
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
                   $sql = "UPDATE ct_socio SET  bActivo = '1' WHERE sCodigoVal = '".$code."'";
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
function get_socios_asinc(){    
    include("cn_usuarios_2.php");
    //$conexion->begin_transaction();
    $conexion->autocommit(FALSE);
    $transaccion_exitosa = true;
    $array_filtros = explode(",*",$_POST["filtroInformacion"]); 
    $filtroQuery .= " WHERE iIDSocio != '' AND sNombreSocio != ''";  
    foreach($array_filtros as $key => $valor){
        if($array_filtros[$key] != ""){
            $campo_valor = explode("|",$array_filtros[$key]);
            if ($campo_valor[0] =='bactivo'){
                    $filtroQuery.= " AND  ".$campo_valor[0]."='".$campo_valor[1]."' ";
            }else{
                    $filtroQuery == "" ? $filtroQuery.= " AND  ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'": $filtroQuery.= " AND ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'";
            }
        }
    }
    
    $sql = "SELECT DATE_FORMAT(dFecharegistro,  '%d/%m/%Y')    as dFechaIngreso, iIDSocio as ID, sCorreoSocio as correo, CONCAT(sNombreSocio,' ',sApellidoPaternoSocio,' ', sApellidoMaternoSocio)  as nombre,CASE WHEN  bactivo = '0' THEN 'Pendiente'  ELSE 'Activado' END  as eEstatus FROM ct_socio ".$filtroQuery;
    $result = $conexion->query($sql);
    $NUM_ROWs_socios = $result->num_rows;    
    if ($NUM_ROWs_socios > 0) {
        //$items = mysql_fetch_all($result);      
        while ($socios = $result->fetch_assoc()) {
           if($socios["ID"] != ""){
                 $htmlTabla .= "<tr>                            
                                    <td>".$socios['dFechaIngreso']."</td>".             
                                    "<td>".$socios['ID']."</td>".
                                   "<td>".$socios['correo']."</td>".
                                   "<td>".$socios['nombre']."</td>".                                                  
                                   "<td>".$socios['eEstatus']."</td>".
                                   "<td nowrap='nowrap' ><span onclick='Onborrar(\"".$socios['ID']."\")' class='ui-icon ui-icon-circle-close'></span></td>".
                                   "<td nowrap='nowrap' ><span onclick='onEditarCliente(\"".$socios['ID']."\")' class='ui-icon ui-icon-mail-open'></span></td>".
                                "</tr>"   ;
             }else{                             
                 $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".                       
                                   "<td>&nbsp;</td>".                      
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;
             }    
        }
       // $htmlTabla .="<tr>
         //                           <td>&nbsp;</td>".
           //                        "<td>&nbsp;</td>".                          
             //                      "<td>&nbsp;</td>".
               //                    "<td>&nbsp;</td>".
                 //"</tr>"   ;
        
        $conexion->rollback();
        $conexion->close();                                                                                                                                                                       
    } else { 
    $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;    
        
    }
    $html_tabla = utf8_encode($html_tabla); 
     $response = array("mensaje"=>"$mensaje","error"=>"$error","tabla"=>"$htmlTabla");   
     echo array2json($response);
}  
function get_pagos_asinc(){    
    include("cn_usuarios_2.php");
    //$conexion->begin_transaction();
    $conexion->autocommit(FALSE);
    $transaccion_exitosa = true;
    $array_filtros = explode(",*",$_POST["filtroInformacion"]); 
    $filtroQuery .= " WHERE ct_socio.iIDSocio != '' ";  
    foreach($array_filtros as $key => $valor){
        if($array_filtros[$key] != ""){
            $campo_valor = explode("|",$array_filtros[$key]);
            if ($campo_valor[0] =='bactivo'){
                    $filtroQuery.= " AND  ".$campo_valor[0]."='".$campo_valor[1]."' ";
            }else{
                    $filtroQuery == "" ? $filtroQuery.= " AND  ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'": $filtroQuery.= " AND ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'";
            }
        }
    }
    
    $sql = "SELECT DATE_FORMAT(pago.dFechaVencimiento,  '%d/%m/%Y')    as dFechaIngreso, 
            ct_socio.iIDSocio as ID, 
            sCorreoSocio as correo, 
            CONCAT(sNombreSocio,' ',sApellidoPaternoSocio,' ', sApellidoMaternoSocio)  as nombre,
            pago.dias_restantes  as eEstatus        
            FROM ct_socio 
            LEFT JOIN (SELECT  iIDSocio, max(cb_pagos_socio.dFechaVencimiento) as dFechaVencimiento,  DATEDIFF( max(cb_pagos_socio.dFechaVencimiento),NOW()) as dias_restantes
            FROM cb_pagos_socio 
            GROUP BY iIDSocio
            Order BY dFechaVencimiento DESC   ) as pago ON pago.iIDSocio = ct_socio.iIDSocio ".$filtroQuery;
    $result = $conexion->query($sql);
    $NUM_ROWs_socios = $result->num_rows;    
    if ($NUM_ROWs_socios > 0) {
        //$items = mysql_fetch_all($result);      
        while ($socios = $result->fetch_assoc()) {
           if($socios["ID"] != ""){
               $leyenda = "";
               if($socios['eEstatus'] != ""){               
                   if($socios['eEstatus'] <0){
                      $socios['eEstatus'] = $socios['eEstatus'] *-1;
                      $socios['eEstatus'] = $socios['eEstatus'].' dias vencido';
                      $leyenda = $socios['eEstatus'];
                   }else{               
                       $socios['eEstatus'] = $socios['eEstatus'].' dias restantes';
                       $leyenda = $socios['eEstatus'];
                   }
               }
             
                 $htmlTabla .= "<tr>                            
                                    <td>".$socios['dFechaIngreso']."</td>".             
                                    "<td>".$socios['ID']."</td>".
                                   "<td>".$socios['correo']."</td>".
                                   "<td>".$socios['nombre']."</td>".                                                  
                                   "<td>".$leyenda."</td>".
                                   "<td nowrap='nowrap' colspan='2' ><span onclick='onRegistrarPago(\"".$socios['ID']."\" , \"".$socios['dFechaIngreso']."\" )' class='ui-icon print'></span></td>".
                                "</tr>"   ;
             }else{                             
                 $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".                       
                                   "<td>&nbsp;</td>".                      
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;
             }    
        }
       // $htmlTabla .="<tr>
         //                           <td>&nbsp;</td>".
           //                        "<td>&nbsp;</td>".                          
             //                      "<td>&nbsp;</td>".
               //                    "<td>&nbsp;</td>".
                 //"</tr>"   ;
        
        $conexion->rollback();
        $conexion->close();                                                                                                                                                                       
    } else { 
    $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;    
        
    }
    $html_tabla = utf8_encode($html_tabla); 
     $response = array("mensaje"=>"$mensaje","error"=>"$error","tabla"=>"$htmlTabla");   
     echo array2json($response);
}  
function borrar_socio(){    
     $id = $_POST['id'];
     $error = "0";
     include("cn_usuarios_2.php");
     $conexion->autocommit(FALSE);
     $transaccion_exitosa = true;
     $sql = "DELETE FROM ct_socio WHERE iIDSocio = '".$id."'";
     $conexion->query($sql);   
     if ($conexion->affected_rows < 1 ) {
        $transaccion_exitosa =false;
     }
     if($transaccion_exitosa){
        $conexion->commit();
        $conexion->close();
     }else{
        $conexion->rollback();
        $conexion->close();
        $mensaje = "A general system error ocurred : internal error";
        $error = "1";
     }
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
}
function consulta_socio_edicion(){
    $id = $_POST['id'];
    $filtroQuery = " WHERE iIDSocio ='".$id."'";
    include("cn_usuarios_2.php");
    $conexion->autocommit(FALSE);
    $transaccion_exitosa = true;
    $sql = "SELECT sCorreoSocio,sNombreSocio,sApellidoPaternoSocio,sApellidoMaternoSocio,sCalleSocio,sColoniaSocio,sTelefonoSocio,eGenero,sCantidadPago, 
                   sWFran,sWHelen,sWGrace,sWFilthy50,sWRow500m,sWSprint400m,sWRun5k,
                   eS_ropeclaims,
                   eS_du,
                   eS_hspu,
                   eS_pullups,
                   eS_walkhs,
                   iS_boxjumpmax,
                   eS_ringmuscleup,
                   iMP_cleanandjerk,
                   iMP_snatch,
                   iMP_deadlift,
                   iMP_backsquat,
                   iMP_maxpullups,
                   iMP_maxmuscleup,
                   iMP_maxburpeesmin,
                   sFotoPerfilRuta,
                   iEdad,
                   iAltura,
                   iPeso                   
    FROM ct_socio  ".$filtroQuery;
    $result = $conexion->query($sql);
    $NUM_ROWs_socios = $result->num_rows;   
    $error = "0";
    if ($NUM_ROWs_socios > 0) {     
        while ($socios = $result->fetch_assoc()) {
            $correo = $socios['sCorreoSocio'];
            $nombre = $socios['sNombreSocio'];
            $apellido_paterno = $socios['sApellidoPaternoSocio'];
            $apellido_materno = $socios['sApellidoMaternoSocio'];   
            $calle = $socios['sCalleSocio'];
            $colonia = $socios['sColoniaSocio'];
            $telefono = $socios['sTelefonoSocio'];
            $genero = $socios['eGenero'];
            $cantidad = $socios['sCantidadPago'];
            //Workouts
            $sWFran = $socios['sWFran'];
            $sWHelen = $socios['sWHelen'];     
            $sWGrace = $socios['sWGrace'];
            $sWFilthy50 = $socios['sWFilthy50'];
            $sWRow500m = $socios['sWRow500m'];
            $sWSprint400m = $socios['sWSprint400m'];
            $sWRun5k = $socios['sWRun5k'];
            //Skills
            $eS_ropeclaims = $socios['eS_ropeclaims'];
            $eS_du = $socios['eS_du'];
            $eS_hspu = $socios['eS_hspu'];
            $eS_pullups = $socios['eS_pullups'];
            $eS_walkhs = $socios['eS_walkhs'];
            $iS_boxjumpmax = $socios['iS_boxjumpmax'];
            $eS_ringmuscleup = $socios['eS_ringmuscleup'];
            //Maxer Pr
            $iMP_cleanandjerk = $socios['iMP_cleanandjerk'];
            $iMP_snatch = $socios['iMP_snatch'];                             
            $iMP_deadlift = $socios['iMP_deadlift'];
            $iMP_backsquat = $socios['iMP_backsquat'];
            $iMP_maxpullups = $socios['iMP_maxpullups'];
            $iMP_maxmuscleup = $socios['iMP_maxmuscleup'];
            $iMP_maxburpeesmin = $socios['iMP_maxburpeesmin'];
            //Foto de perfil
            $foto_perfil = $socios['sFotoPerfilRuta'];
            //Datos personales
            $edad = $socios['iEdad'];
            $altura = $socios['iAltura'];        
            $peso = $socios['iPeso'];
                                                                 
        }
    }else{
        $error = "1";
    }
    $response = array("mensaje"=>"$mensaje",
                      "error"=>"$error",
                      "correo"=>"$correo",
                      "nombre"=>"$nombre",
                      "apellido_paterno"=>"$apellido_paterno",
                      "apellido_materno"=>"$apellido_materno",
                      "calle"=>"$calle",    
                      "colonia"=>"$colonia",
                      "telefono"=>"$telefono",
                      "genero"=>"$genero",
                      "cantidad"=>"$cantidad",
                      "sWFran"=>"$sWFran",
                      "sWHelen"=>"$sWHelen",
                      "sWGrace"=>"$sWGrace",
                      "sWFilthy50"=>"$sWFilthy50",
                      "sWRow500m"=>"$sWRow500m",
                      "sWSprint400m"=>"$sWSprint400m",
                      "sWRun5k"=>"$sWRun5k",
                      "eS_ropeclaims"=>"$eS_ropeclaims",
                      "eS_du"=>"$eS_du",
                      "eS_hspu"=>"$eS_hspu",
                      "eS_pullups"=>"$eS_pullups",
                      "eS_walkhs"=>"$eS_walkhs",
                      "iS_boxjumpmax"=>"$iS_boxjumpmax",
                      "eS_ringmuscleup"=>"$eS_ringmuscleup",
                      "iMP_cleanandjerk"=>"$iMP_cleanandjerk",
                      "iMP_snatch"=>"$iMP_snatch",
                      "iMP_deadlift"=>"$iMP_deadlift",        
                      "iMP_backsquat"=>"$iMP_backsquat",
                      "iMP_maxpullups"=>"$iMP_maxpullups",
                      "iMP_maxmuscleup"=>"$iMP_maxmuscleup",
                      "iMP_maxburpeesmin"=>"$iMP_maxburpeesmin",
                      "ruta"=>"$foto_perfil",
                      "edad"=>"$edad",
                      "altura"=>"$altura",
                      "peso"=>"$peso",
                      );   
    echo array2json($response);
}
function get_pago_asinc(){    
    include("cn_usuarios_2.php");
    $id = $_POST['id_socio'];
    //$conexion->begin_transaction();
    $conexion->autocommit(FALSE);                        
    $transaccion_exitosa = true;   
    $sql = "SELECT cb_pagos_socio.iIDSocio, cb_pagos_socio.iFolio as id_pago,ct_socio.sCorreoSocio as correo, iCantidadPago as pago_cant,  CONCAT(ct_socio.sNombreSocio,' ',ct_socio.sApellidoPaternoSocio,' ', ct_socio.sApellidoMaternoSocio)  as nombre, DATE_FORMAT(cb_pagos_socio.dFechaPago, '%d/%m/%Y') as fecha_pago, DATE_FORMAT(cb_pagos_socio.dFechaVencimiento, '%d/%m/%Y') as fecha_vencimiento FROM cb_pagos_socio LEFT JOIN ct_socio ON cb_pagos_socio.iIDSocio = ct_socio.iIDSocio WHERE cb_pagos_socio.iIDSocio='".$id."' ";
    $result = $conexion->query($sql);
    $NUM_ROWs_pagos = $result->num_rows; 
    $error = "0";
    if ($NUM_ROWs_pagos > 0) {        
        while ($pagos = $result->fetch_assoc()) {
           if($pagos["id_pago"] != ""){                                                                 
                 $htmlTabla .= "<tr>                            
                                    <td>".$pagos['id_pago']."</td>".             
                                   "<td>".$pagos['correo']."</td>".
                                   "<td>".$pagos['nombre']."</td>".
                                   "<td>".$pagos['fecha_pago']."</td>".
                                   "<td> \$ ".$pagos['pago_cant']."</td>".
                                   "<td>".$pagos['fecha_vencimiento']."</td>". 
                                   "<td nowrap='nowrap' colspan='2' ><span onclick='onBorrarPago(\"".$pagos['id_pago']."\" , \"".$pagos['iIDSocio']."\" )' class='ui-icon ui-icon-circle-close'></span></td>".                                             
                                "</tr>"   ;
             }else{// el pago esta mal registrado                             
                 $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".                       
                                   "<td>&nbsp;</td>".                      
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;
                 $error = "1";
             }    
        }
    
        $conexion->rollback();
        $conexion->close();                                                                                                                                                                       
    } else { //No encontro registro
    $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;    
                 $error = "1";
        
    }
    //$mensaje = "";
    $html_tabla = utf8_encode($html_tabla); 
    $response = array("mensaje"=>"$mensaje","error"=>"$error","tabla"=>"$htmlTabla");   
     echo array2json($response);
}  
function guardar_pago_socio(){    
    include("cn_usuarios_2.php");
    //variables              
    $error = "0";    
    $id = $_POST['id_socio'];    
    $fecha_inicial = $_POST['filtro_fecha_inicial'];
    $fecha_final = $_POST['filtro_fecha_final'];
    $pago_final = $_POST['pago_final'];
    $promocion = $_POST['promo'];
    $fecha_inicial_formato = substr($fecha_inicial,6,4).'/'.substr($fecha_inicial,3,2).'/'.substr($fecha_inicial,0,2);
    $fecha_final_formato = substr($fecha_final,6,4).'/'.substr($fecha_final,3,2).'/'.substr($fecha_final,0,2);
    include("cn_usuarios_2.php");
    $conexion->autocommit(FALSE);                        
    $transaccion_exitosa = true;   
    $sql = "SELECT ct_socio.iIDSocio, ct_socio.sCorreoSocio FROM ct_socio WHERE ct_socio.iIDSocio='".$id."' ";                                                                                                                                             
    $result = $conexion->query($sql);                                                                                                                                                                              
    $NUM_ROWs_pagos = $result->num_rows;                                                                                                                                                                                             
    $error = "0";
    while ($socios = $result->fetch_assoc()) {
        $correo_socio =  $socios['sCorreoSocio'];
    }
    if ($NUM_ROWs_pagos > 0) {
        $sql = "INSERT INTO cb_pagos_socio set iIDSocio='".$id."' , dFechaPago='".$fecha_inicial_formato."', iCantidadPago='".$pago_final."', dFechaCreacionRegistro=NOW(), dFechaVencimiento='".$fecha_final_formato."', sUsuarioCreacionRegistro='".$_SESSION['acceso']."' , sIPCreacionRegistro='".$_SERVER['REMOTE_ADDR']."' ";  
        $conexion->query($sql);   
        if ($conexion->affected_rows < 1 ) {
            $error = "1";    
            $transaccion_exitosa = false;
            $mensaje = "Error de sistema: Favor de comunicarse con el area de soporte del sistema";           
        }
    }else{
        $error = "1";                                                                                         
        $transaccion_exitosa = false;           
        $mensaje = "El socio no existe. Favor de validar los datos";           
    } 
    // envio de correo
    if ($transaccion_exitosa) {
            //Proceso para enviar correo                 
            $id_pago = $conexion->insert_id;
            //fecha de pago
            $now = time();
            $num = date("w");
            if ($num == 0)
            { $sub = 6; }
            else { $sub = ($num-1); }
            $WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));
            $todayh = getdate($WeekMon);
            $d = $todayh[mday];
            $m = $todayh[mon];
            $y = $todayh[year];
            $fecha_actual ="$d/$m/$y";
            require_once("./lib/mail.php");
            $cuerpo = "
                    <div style=\"font-size:12px;border:1px solid #6191df;border-radius:3px;padding:10px;width:95%; margin:5px auto;font-family: Arial, Helvetica, sans-serif;\">
                         <h2 style=\"color:#313131;text-transform: uppercase; text-align:center;\">Registro de pago - Oxygen-FX Gym!</h2> \n 
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\"><strong>$correo</strong><br>Se ha registrado un pago en tu membresia.</p>\n 
                         <br><br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">A continuacion te presentamos la informacion correspondiente a tu pago.</p>
                         <br><br>
                         <ul style=\"color:#010101;line-height:15px;\">                                                           
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Folio: </strong>$id_pago</li>
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Fecha de registro: </strong>$fecha_actual</li>
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Fecha Inicial: </strong>$fecha_inicial</li>
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Fecha de Vencimiento: </strong>$fecha_final</li>
                            <li style=\"line-height:15px;\"><strong style=\"color:#044e8d;\">Cantidad: </strong>$pago_final</li>
                         </ul>
                         <br><br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Recuerda que puedes verificar en cualquier momento todos tus pagos, solo debes ingresar en nuestra pagina web, en la seccion de historial de pagos.</p><br>
                         <br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Favor de no responder este correo.</p>                         
                    </div>";
             $mail = new Mail();                                    
             $mail->From = "soporte@oxygen-fx.com";
             $mail->FromName = "oxygen-fx team";
             $mail->Host = "oxygen-fx.com";
             $mail->Mailer = "sendmail";    
             $mail->Subject = "Registro de pago - Comprobante"; 
             $mail->Body  = $cuerpo;                                                                                            
             $mail->ContentType ="Content-type: text/html; charset=iso-8859-1";
             $mail->IsHTML(true);
             $mail->WordWrap =150;
             $mail_error = false;
             $mail->AddAddress(trim($correo_socio));
             if (!$mail->Send()) {
                $mail_error = true;
                $mail->ClearAddresses();
             }        
            if(!$mail_error){
                $mensaje = "El pago al socio :".$correo_socio." se registro con exito";
                $error = "0";
                $conexion->commit();
                $conexion->close();
            }else{
                $mensaje = "Error e-mail.";
                $error = "1";  
                $transaccion_exitosa = false;
            }            
        }
    if($transaccion_exitosa){    
        $conexion->commit();
        $conexion->close();
    }else{                        
        $conexion->rollback();
        $conexion->close();           
    }
    $html_tabla = utf8_encode($html_tabla); 
    $response = array("mensaje"=>"$mensaje","error"=>"$error");   
    echo array2json($response);                                              
}
function borrar_pago_socio(){    
     $id = $_POST['id'];
     $error = "0";
     include("cn_usuarios_2.php");
     $conexion->autocommit(FALSE);
     $transaccion_exitosa = true;
     $sql = "DELETE FROM cb_pagos_socio WHERE iFolio = '".$id."'";
     $conexion->query($sql);   
     if ($conexion->affected_rows < 1 ) {
        $transaccion_exitosa =false;
     }
     if($transaccion_exitosa){
        $conexion->commit();
        $conexion->close();
     }else{
        $conexion->rollback();
        $conexion->close();
        $mensaje = "A general system error ocurred : internal error";
        $error = "1";
     }
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
} 
function get_asistencia_asinc(){    
    include("cn_usuarios_2.php");
    //$conexion->begin_transaction();
    $conexion->autocommit(FALSE);
    $transaccion_exitosa = true;
    $array_filtros = explode(",*",$_POST["filtroInformacion"]); 
    $filtroQuery .= " WHERE ct_socio.iIDSocio != '' AND pago.dFechaVencimiento is not null";  
    foreach($array_filtros as $key => $valor){
        if($array_filtros[$key] != ""){
            $campo_valor = explode("|",$array_filtros[$key]);
            if ($campo_valor[0] =='pago.dias_restantes'){
                if($campo_valor[1] == "A"){
                    $filtroQuery.= " AND  ".$campo_valor[0]."> 0 ";
                }else{
                    $filtroQuery.= " AND  ".$campo_valor[0]."<= 0 ";
                }
                    
            }else{
                    $filtroQuery == "" ? $filtroQuery.= " AND  ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'": $filtroQuery.= " AND ".$campo_valor[0]." LIKE '%".$campo_valor[1]."%'";
            }
        }
    }    
        $sql = " SELECT      
                 DATE_FORMAT(pago.dFechaVencimiento,  '%d/%m/%Y')    as dFechaIngreso, 
                 ct_socio.iIDSocio as ID, 
                 sCorreoSocio as correo, 
                 CONCAT(sNombreSocio,' ',sApellidoPaternoSocio,' ', sApellidoMaternoSocio)  as nombre,                 
                 pago.dias_restantes  as eEstatus,
                 DATE_FORMAT(MAX(cb_transacciones_socio.dFechaVisitaSocio),  '%d/%m/%Y') as ultima_visita,                      
                 CASE WHEN  DATE_FORMAT(MAX(cb_transacciones_socio.dFechaVisitaSocio),  '%d/%m/%Y')  = DATE_FORMAT( DATE_SUB( NOW(),INTERVAL 1 HOUR),  '%d/%m/%Y')  THEN '1' else '0' end as asistencia ";
    $sql = $sql."FROM ct_socio 
                 LEFT JOIN (SELECT  iIDSocio, max(cb_pagos_socio.dFechaVencimiento) as dFechaVencimiento,  DATEDIFF( max(cb_pagos_socio.dFechaVencimiento),NOW()) as dias_restantes
                 FROM cb_pagos_socio 
                 GROUP BY iIDSocio
                 Order BY dFechaVencimiento DESC   ) as pago ON pago.iIDSocio = ct_socio.iIDSocio         
                 LEFT JOIN cb_transacciones_socio ON cb_transacciones_socio.iIDSocio = ct_socio.iIDSocio ";
    $sql = $sql. $filtroQuery;                      
    $sql = $sql. " GROUP BY ct_socio.iIDSocio ORDER BY asistencia ASC, eEstatus ASC  LIMIT 30";
    $result = $conexion->query($sql);
    $NUM_ROWs_socios = $result->num_rows;    
    if ($NUM_ROWs_socios > 0) {
        //$items = mysql_fetch_all($result);      
        while ($socios = $result->fetch_assoc()) {
           if($socios["ID"] != ""){
               $leyenda = "";
               $leyenda = "";  
               $color_fondo = "#69e569";   
               if($socios['eEstatus'] <=0){
                $estatus = "vencido";
               }else{
                $estatus =  "vigente";
               }
               if($socios['eEstatus'] <=5){
                   $color_fondo = "#f7f764";
               }
               
               if($socios['eEstatus'] == 0){
                   $color_fondo = "#ff5252";
               }                   
               if($socios['eEstatus'] != ""){               
                   if($socios['eEstatus'] <0){
                      $socios['eEstatus'] = $socios['eEstatus'];
                      $socios['eEstatus'] = $socios['eEstatus'].'';
                      $leyenda = $socios['eEstatus'];
                      $color_fondo = "#ff5252"; 
                   }else{               
                       $socios['eEstatus'] = $socios['eEstatus'].'';
                       $leyenda = $socios['eEstatus'];
                   }
               }
               if($socios['eEstatus'] == ""){
                   $color_fondo = "#C0C0C0";
               }
             
                 $htmlTabla .= "<tr bgcolor='".$color_fondo."'>                            
                                    <td ><font size='3'>".$socios['dFechaIngreso']."</font></td>".             
                                    "<td ><font size='3'>".$socios['ID']."</font></td>".
                                   "<td ><font size='3'>".$socios['correo']."</font></td>".                                                                                          
                                   "<td nowrap='nowrap'  ><font size='3'>".$socios['nombre']."</font></td>".                                                  
                                   "<td ><font size='3'>".$leyenda."</font></td>";
                 if($socios['asistencia'] == "0"){
                    $htmlTabla .= "<td nowrap='nowrap' colspan='2' ><span onclick='onRegistrarAsistencia(\"".$socios['ID']."\" , \"".$socios['correo']."\", \"".$estatus."\" )' class='btn_2 right' style='padding: 2px 5px;cursor: pointer;'><i class='fa fa-check-circle'></i></span></td>";
                 }else{
                     $htmlTabla .= "<td nowrap='nowrap' colspan='2' >&nbsp;</td>";
                 }
                                "</tr>"   ;                                         
             }else{                             
                 $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".                       
                                   "<td>&nbsp;</td>".                      
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;
             }    
        }
       // $htmlTabla .="<tr>
         //                           <td>&nbsp;</td>".
           //                        "<td>&nbsp;</td>".                          
             //                      "<td>&nbsp;</td>".
               //                    "<td>&nbsp;</td>".
                 //"</tr>"   ;
        
        $conexion->rollback();
        $conexion->close();                                                                                                                                                                       
    } else { 
    $htmlTabla .="<tr>
                                    <td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                                   "<td>&nbsp;</td>".
                 "</tr>"   ;    
        
    }
    $html_tabla = utf8_encode($html_tabla); 
     $response = array("mensaje"=>"$mensaje","error"=>"$error","tabla"=>"$htmlTabla");   
     echo array2json($response);
}  
function registrar_asistencia(){                                                                                  
     $id = $_POST['id'];
     $estatus = $_POST['estatus'];
     $error = "0";
     include("cn_usuarios_2.php");
     $conexion->autocommit(FALSE);          
     $transaccion_exitosa = true;
     $sql = "INSERT INTO cb_transacciones_socio SET iIDSocio = '".$id."', dFechaVisitaSocio = DATE_SUB( NOW(),INTERVAL 1 HOUR) , eTipoTransaccion ='".$estatus."' ";
     $conexion->query($sql);   
     if ($conexion->affected_rows < 1 ) {
        $transaccion_exitosa =false;
     }
     if($transaccion_exitosa){
        $conexion->commit();
        $conexion->close();
     }else{
        $conexion->rollback();
        $conexion->close();
        $mensaje = "A general system error ocurred : internal error";
        $error = "1";
     }
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
} 
function enviar_recordatorio_pago(){
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT sComentario FROM cb_comentario_del_dia WHERE DATE_FORMAT(dFecha,  '%d/%m/%Y')  = DATE_FORMAT( DATE_SUB( NOW(),INTERVAL 1 HOUR),  '%d/%m/%Y') ";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) == 0) {
        mysql_free_result($result);
        $sql = "INSERT INTO  cb_comentario_del_dia SET  dFecha =   DATE_SUB( NOW(),INTERVAL 1 HOUR) , sUsuario = 'CORREODIARIO', sComentario = 'CORREODIARIO'";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 0 ) {
            $transaccion_exitosa = false;
        }
       
        $arr_  = NULL;
        $correo = "";
        $sql = "SELECT 
            sCorreoSocio as correo, 
            pago.dias_restantes  as dias        
            FROM ct_socio 
            LEFT JOIN (SELECT  iIDSocio, max(cb_pagos_socio.dFechaVencimiento) as dFechaVencimiento,  DATEDIFF( max(cb_pagos_socio.dFechaVencimiento),NOW()) as dias_restantes
            FROM cb_pagos_socio 
            GROUP BY iIDSocio
            Order BY dFechaVencimiento DESC   ) as pago ON pago.iIDSocio = ct_socio.iIDSocio  WHERE pago.dias_restantes <= 0 ";
            $result = mysql_query($sql, $dbconn);
            if (mysql_num_rows($result) > 0) {
                while ($Recordset = mysql_fetch_array($result)) {
                    $arr_[] = array("correo" => $Recordset['correo'],
                                    "dias" => stripslashes($Recordset['dias']));
                }
            }
            mysql_free_result($result);
            if ($transaccion_exitosa) {
                mysql_query("COMMIT");
                mysql_close($dbconn);
            } else {
                mysql_query("ROLLBACK");
                mysql_close($dbconn);            
            }
            
            if(count($arr_)>0){
                foreach($arr_ as $corre_envio){
                    if($correo == ""){
                        $correo = $corre_envio['correo'];  
                        $mensajesssssddds = "oa";
                    }else{
                        $correo= $correo.','.$corre_envio['correo'];
                    }
                    
                }
                require_once("./lib/mail.php");
                $cuerpo = "
                    <div style=\"font-size:12px;border:1px solid #6191df;border-radius:3px;padding:10px;width:95%; margin:5px auto;font-family: Arial, Helvetica, sans-serif;\">
                         <h2 style=\"color:#313131;text-transform: uppercase; text-align:center;\">Recordatorio  de pago - Oxygen-FX Gym!</h2> \n 
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\"><strong><br>Tu membresia esta a punto de expirar o ya expiro.</p></strong>\n 
                         <br><br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Si quieres saber, tus fechas de pago y dias restantes. Te invitamos a que ingreses a nuestro sitio web.</p>
                         <br><br>
                         <br><br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Recuerda que puedes verificar en cualquier momento todos tus pagos, solo debes ingresar en nuestra pagina web, en la seccion de historial de pagos.</p><br>
                         <br>
                         <p style=\"color:#5c5c5c;margin:5px auto; text-align:left;\">Favor de no responder este correo.</p>                         
                    </div>";
                    $mail = new Mail();                                    
                    $mail->From = "soporte@oxygen-fx.com";
                    $mail->FromName = "oxygen-fx team";
                    $mail->Host = "oxygen-fx.com";
                    $mail->Mailer = "sendmail";    
                    $mail->Subject = "Tu membresia esta a punto de expirar o ya expiro"; 
                    $mail->Body  = $cuerpo;                                                                                            
                    $mail->ContentType ="Content-type: text/html; charset=iso-8859-1";
                    $mail->IsHTML(true);
                    $mail->WordWrap =150;
                    $mail_error = false;    
                    $mail->AddAddress( $correo);
                    if (!$mail->Send()) {
                        $mail_error = true;
                        $mail->ClearAddresses();
                    }     
                    if(!$mail_error){
                        $mensaje = "Se enviar con exito";
                        $error = "0";
                    }else{
                        $mensaje = "Error e-mail.";
                        $error = "1";  
                        $transaccion_exitosa = false;
                    }                 
            }
        }
    $response = array("mensaje"=>$mensajesssssddds,"error"=>"$error");   
    echo array2json($response);    
}
function consultar_anuncio(){    
    include("cn_usuarios_2.php");
    $conexion->autocommit(FALSE);                                                       
    $transaccion_exitosa = true;
    $mensaje_dia = "<div style=\"width:80%;margin:10px auto;text-align:center\"><i class=\"fa fa-exclamation-circle\" style=\"font-size:5em;\"></i><h2 class=\"txt-center\">Oxygen-FX</h2><br><p class='txt-center' style=\"font-size:1.5em;\">";
    $sql = "SELECT sComentario AS mensaje FROM cb_comentario_del_dia  ";
    $result = $conexion->query($sql);
    $NUM_ROWs = $result->num_rows;   
    $error = "0";
    if ($NUM_ROWs > 0) {     
        while ($mensaje = $result->fetch_assoc()) {
            if(trim($mensaje['mensaje']) == ""){
                $mensaje_dia = "";
                $error = "1";
                                                                        
            }else{
                $mensaje_dia = $mensaje_dia.$mensaje['mensaje'];        
            }
            
        }
    }else{
        $error = "1";
    }
    if($error == "0"){
        $mensaje_dia = $mensaje_dia."</p></div>";
    }
    
    $response = array("mensaje"=>"$mensaje",
                      "error"=>"$error",
                      "mensaje_dia"=>"$mensaje_dia"
                      );   
    echo array2json($response);
}
function subir_imagen_socio(){    
    $error = "0";
    $edicion = $_POST['id_edicion'];
    //Actualizando el registro
    
    if (isset($_FILES["file"])){
        $file = $_FILES["file"];
        $nombre = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "imagenes_perfil/";     
        if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif'){
            $mensaje = "Error, el archivo no es una imagen";    
            $error = "1";
        }else if ($size > 1024*1024){
            $mensaje = "Error, el tamano maximo permitido es un 1MB";                                              
            $error = "1";                                                                                  
        }else{                                                                                              
            $src = $carpeta.$nombre.'/';
            $target_path = "imagenes_perfil/";
            $target_path = $target_path . basename( $edicion.'.jpg');
            $error = "0";
            include("cn_usuarios_2.php");                    
            $conexion->autocommit(FALSE);
            $transaccion_exitosa = true; 
            $sql = "UPDATE ct_socio set sFotoPerfilRuta='".$target_path."' WHERE iIDSocio ='".$edicion."' ";
            $conexion->query($sql);           
            if ($conexion->affected_rows < 0 ) {
                $error = "1";
                $transaccion_exitosa = false;
                $error = "1";
                $mensaje = "El usuario no ha sufrido ninguna modificacion";
            }
            if($transaccion_exitosa){
                $conexion->commit();
                $conexion->close();
                if(move_uploaded_file($file['tmp_name'], $target_path)) {
                    $mensaje = "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido";
                } else{
                    $mensaje = "Ha ocurrido un error, trate de nuevo!";
                    $error = "1";
                }
            }else{
                $conexion->rollback();
                $conexion->close(); 
                $mensaje = $mensaje;
            }   
            
        }
    }else{
         $mensaje = "No existe ningun archivo."; 
         $error = "1";
    }
    echo array2json($mensaje);

}
 
 
?>
