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
    $queryUsuario = "SELECT eTipoUsuario FROM cu_control_acceso WHERE sUsuario = '".$usuario."' AND hClave = sha1('".$clave."') AND hActivado = sha1('1')";
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
?>
