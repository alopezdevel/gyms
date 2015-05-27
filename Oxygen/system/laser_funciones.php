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

 function CargarEmpleados(){ 
     
     $filtro_id = trim($_POST['filtro_id']);
     $filtro_nombre =   trim($_POST['filtro_nombre']);
     $filtro_correo =   trim($_POST['filtro_correo']);
     
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT idEmpleado, CONCAT(sNombre , ' ', sApellidoPaterno, ' ',  sApellidoMaterno) AS sNombre, sTelefono, sDireccion, sColonia, sCorreoElectronico, iEdad,dFechaCreacion  FROM ct_empleado WHERE idEmpleado != '' ";
    
    if($filtro_id != ""){
          $sql = $sql ." AND idEmpleado LIKE '%".$filtro_id."%' ";
    }
    if($filtro_nombre != ""){
          $sql = $sql ." AND CONCAT(sNombre , ' ', sApellidoPaterno, ' ',  sApellidoMaterno) LIKE '%".$filtro_nombre."%' ";
    }
    if($filtro_correo != ""){
          $sql = $sql ." AND sCorreoElectronico LIKE '%".$filtro_correo."%' ";
    }
    
    $result = mysql_query($sql, $dbconn);
    $htmlTabla = "";
    
    if (mysql_num_rows($result) > 0) { 
        while ($empleados = mysql_fetch_array($result)) {
           if($empleados["sNombre"] != ""){
        
                 $htmlTabla .= "<tr>                            
                                    <td>".$empleados['dFechaCreacion']."</td>".
                                    "<td>".$empleados['idEmpleado']."</td>".              
                                   "<td>".$empleados['sNombre']."</td>".
                                   "<td>".$empleados['sCorreoElectronico']."</td>".
                                   "<td nowrap='nowrap'><span onclick='onBorrarEmpleado(\"".$empleados['idEmpleado']."\")' class=\"btn-grid\" title=\"Eliminar Empleado\"><i class=\"fa fa-trash\"></i></span> <span onclick='onEditarEmpleado(\"".$empleados['idEmpleado']."\")' class=\"btn-grid\" title=\"Editar Empleado\"><i class=\"fa fa-pencil-square-o\"></i></span></td>".                                             
                                "</tr>"   ;
             }else{                             
                 $error = "1";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $htmlTabla .="<div style=\"text-align:center; font-weight: bold;\">No hay empleados disponibles.</div>";
    }
        $html_tabla = utf8_encode($html_tabla); 
        $response = array("mensaje"=>"$sql","error"=>"$error","tabla"=>"$htmlTabla");   
        echo array2json($response);
     
     
}
function BorrarEmpleado(){
    
    $id = trim($_POST['id']);
    $error = "0"; 
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "DELETE FROM ct_empleado WHERE idEmpleado = '".$id."'";
    $result = mysql_query($sql, $dbconn);
    if (mysql_affected_rows() < 1) { 
        
        $transaccion_exitosa = false;
        $error = "1";
        mysql_query("ROLLBACK");
        mysql_close($dbconn);
                                                                                                                                                                               
    } else{
        
        //mysql_query("COMMIT");
        mysql_query("COMMIT");     
        mysql_close($dbconn);
         
    }
        
        
       // echo $error;
       // exit;
        $response = array("mensaje"=>"$sql","error"=>"$error");   
        echo array2json($response);
}
function nuevo_empleado() {
    
    $nombre = trim($_POST['nombre']);
    $apellidopaterno = trim($_POST['apellidopaterno']);
    $apellidomaterno = trim($_POST['apellidomaterno']);
    $telefono = trim($_POST['telefono']);
    $direccion = trim($_POST['direccion']);
    $colonia = trim($_POST['colonia']);
    $correo = trim($_POST['email']);
    $edad = trim($_POST['edad']);
    
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT sCorreoElectronico FROM ct_empleado WHERE sCorreoElectronico = '".$correo."' LOCK IN SHARE MODE";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
       
       //@mysql_free_result($result); 
       $mensaje = "Error al guardar los datos.";
       $error = "1"; 
       $transaccion_exitosa = false; 
       mysql_query("ROLLBACK");
       mysql_close($dbconn); 
        
    }else{
    
        $sql = "INSERT INTO ct_empleado SET sNombre = '".$nombre."', sApellidoPaterno = '".$apellidopaterno."', sApellidoMaterno = '".$apellidomaterno."', sTelefono = '".$telefono."', sDireccion = '".$direccion."', sColonia = '".$colonia."', sCorreoElectronico = '".$correo."', iEdad = ".$edad.",  dFechaCreacion = NOW()";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
            $error = "1";
            $mensaje = "Error al crear el registro favor de revisar nuevamente los datos."; 
            $transaccion_exitosa = false;
        }                
        if ($transaccion_exitosa) {
            $mensaje = "Se agreg&oacute; un empleado exitosamente!";
            $error = "0";
            mysql_query("COMMIT");     
            mysql_close($dbconn);
        } else {
            $mensaje = "Error al guardar los datos. Favor de verificarlos.";
            $error = "1"; 
            $transaccion_exitosa = false; 
            mysql_query("ROLLBACK");
            mysql_close($dbconn);
        }
    }
     echo $error;
     exit;
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
}


?>
