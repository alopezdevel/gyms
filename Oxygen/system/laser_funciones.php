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

//EMPLEADOS -- EMPLEADOS
function CargarEmpleados(){ 
     
     $filtro_id = trim($_POST['filtro_id']);
     $filtro_nombre =   trim($_POST['filtro_nombre']);
     $filtro_correo =   trim($_POST['filtro_correo']);
     $filtro_fecha_creacion =  trim($_POST['filtro_fecha_creacion']);
     
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
    if($filtro_fecha_creacion != ""){
          $sql = $sql ." AND DATE_FORMAT(dFechaCreacion,  '%d/%m/%Y') LIKE '%".$filtro_fecha_creacion."%' ";
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
                                   "<td nowrap='nowrap'><span onclick='onBorrarEmpleado(\"".$empleados['idEmpleado']."\")' class=\"btn-grid\" title=\"Eliminar Empleado\"><i class=\"fa fa-trash\"></i></span> <span onclick='onCargarEmpleado(\"".$empleados['idEmpleado']."\")' class=\"btn-grid\" title=\"Editar Empleado\"><i class=\"fa fa-pencil-square-o\"></i></span></td>".                                             
                                "</tr>"   ;
             }else{                             
                 $error = "1";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $htmlTabla .="<tr><td style=\"text-align:center; font-weight: bold;\" colspan=\"100%\">No hay datos disponibles.</td><tr>";
    }
        $html_tabla = utf8_encode($html_tabla); 
        $response = array("mensaje"=>"$sql","error"=>"$error","tabla"=>"$htmlTabla");   
        echo array2json($response);
     
     
}
function CargarEmpleado(){ 
     
     $id = trim($_POST['id']);
     $error = "0";
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT idEmpleado, sNombre , sApellidoPaterno, sApellidoMaterno, sTelefono, sDireccion, sColonia, sCorreoElectronico, iEdad,dFechaCreacion  FROM ct_empleado WHERE idEmpleado = '".$id."' ";
    $result = mysql_query($sql, $dbconn);
    
    if (mysql_num_rows($result) > 0) { 
        while ($empleados = mysql_fetch_array($result)) {
            
            $nombre = $empleados['sNombre'];
            $apellidopaterno = $empleados['sApellidoPaterno'];
            $apellidomaterno = $empleados['sApellidoMaterno'];
            $telefono = $empleados['sTelefono'];   
            $direccion = $empleados['sDireccion'];
            $colonia = $empleados['sColonia'];
            $correo = $empleados['sCorreoElectronico']; 
            $edad = $empleados['iEdad'];

        }
                                                                                                                                                                     
    } else{
        
         $error = "1"; 
    }
        $response = array("mensaje"=>"$mensaje",
                      "error"=>"$error",
                      "correo"=>"$correo",
                      "nombre"=>"$nombre",
                      "apellidopaterno"=>"$apellidopaterno",
                      "apellidomaterno"=>"$apellidomaterno",
                      "direccion"=>"$direccion",    
                      "colonia"=>"$colonia",
                      "telefono"=>"$telefono",
                      "edad"=>"$edad"
                      );   
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
       $mensaje = "Error al guardar los datos: Ya existe un empleado con el mismo correo electronico.";
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
            $mensaje = "Se ha agregado un empleado exitosamente.";
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
     //echo $error;
     //exit;
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
}
function actualizar_empleado(){
    
    $id =  trim($_POST['id']);  
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
    $sql = "SELECT idEmpleado FROM ct_empleado WHERE idEmpleado = '".$id."' LOCK IN SHARE MODE";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
       
        $sql = "UPDATE ct_empleado SET sNombre = '".$nombre."', sApellidoPaterno = '".$apellidopaterno."', sApellidoMaterno = '".$apellidomaterno."', sTelefono = '".$telefono."', sDireccion = '".$direccion."', sColonia = '".$colonia."', sCorreoElectronico = '".$correo."', iEdad = ".$edad." WHERE idEmpleado = '".$id."'";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
            $error = "1";
            $mensaje = "Error al actualizar el registro."; 
            $transaccion_exitosa = false;
        }                
        if ($transaccion_exitosa) {
            $mensaje = "Se han actualizado los datos exitosamente.";
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
        
    }else{
    
       $mensaje = "Error al guardar los datos: No se encontro ningun registro.";
       $error = "1"; 
       $transaccion_exitosa = false; 
       mysql_query("ROLLBACK");
       mysql_close($dbconn);  
    }
     //echo $error;
     //exit;
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
}
//HORARIOS -- HORARIOS
function CargarHorarios(){
    
    $filtro_id = trim($_POST['filtro_id']);
    $filtro_entrada1 =   trim($_POST['filtro_entrada1']);
    $filtro_entrada2 =   trim($_POST['filtro_entrada2']);
    $filtro_salida1 =  trim($_POST['filtro_salida1']);
    $filtro_salida2 =  trim($_POST['filtro_salida2']);
    $filtro_tiposemana = trim($_POST['filtro_tiposemana']);   
     
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT idHorario, DATE_FORMAT(dEntrada1,'%h:%i %p') AS dEntrada1, DATE_FORMAT(dEntrada2,'%h:%i %p') AS dEntrada2, DATE_FORMAT(dSalida1,'%h:%i %p') AS dSalida1, DATE_FORMAT(dSalida2,'%h:%i %p') AS dSalida2, eTipoSemana,dFechaCreacion  FROM ct_horario WHERE idHorario != '' ";
    
    if($filtro_id != ""){
          $sql = $sql ." AND idHorario LIKE '%".$filtro_id."%' ";
    }
    if($filtro_entrada1 != ""){
          $sql = $sql ." AND DATE_FORMAT(dEntrada1,'%h:%i %p') LIKE '%".$filtro_entrada1."%' ";
    }
    if($filtro_entrada2 != ""){
          $sql = $sql ." AND DATE_FORMAT(dEntrada2,'%h:%i %p') LIKE '%".$filtro_entrada2."%' ";
    }
    if($filtro_salida1 != ""){
          $sql = $sql ." AND DATE_FORMAT(dSalida1,'%h:%i %p') LIKE '%".$filtro_salida1."%' ";
    }
    if($filtro_salida2 != ""){
          $sql = $sql ." AND DATE_FORMAT(dSalida2,'%h:%i %p') LIKE '%".$filtro_salida2."%' ";
    }
    if($filtro_tiposemana != ""){
          $sql = $sql ." AND eTipoSemana LIKE '%".$filtro_tiposemana."%' ";
    }
    
    $result = mysql_query($sql, $dbconn);
    $htmlTabla = "";
    
    if (mysql_num_rows($result) > 0) { 
        while ($horarios = mysql_fetch_array($result)) {
           if($horarios["idHorario"] != ""){
        
                 $htmlTabla .= "<tr>                            
                                    <td>".$horarios['idHorario']."</td>".
                                    "<td>".$horarios['dEntrada1']."</td>".              
                                   "<td>".$horarios['dEntrada2']."</td>".
                                   "<td>".$horarios['dSalida1']."</td>".
                                   "<td>".$horarios['dSalida2']."</td>".
                                   "<td>".$horarios['eTipoSemana']."</td>".
                                   "<td nowrap='nowrap'><span onclick='onBorrarHorario(\"".$horarios['idHorario']."\")' class=\"btn-grid\" title=\"Eliminar Horario\"><i class=\"fa fa-trash\"></i></span> <span onclick='onCargarHorario(\"".$horarios['idHorario']."\")' class=\"btn-grid\" title=\"Editar Horario\"><i class=\"fa fa-pencil-square-o\"></i></span></td>".                                             
                                "</tr>"   ;
             }else{                             
                 $error = "1";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $htmlTabla .="<tr><td style=\"text-align:center; font-weight: bold;\" colspan=\"100%\">No hay datos disponibles.</td><tr>";
    }
        $html_tabla = utf8_encode($html_tabla); 
        $response = array("mensaje"=>"$sql","error"=>"$error","tabla"=>"$htmlTabla");   
        echo array2json($response);
    
}
function BorrarHorario(){
    
    $id = trim($_POST['id']);
    $error = "0"; 
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "DELETE FROM ct_horario WHERE idHorario = '".$id."'";
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
function nuevo_horario() {
    
    $entrada1 = trim($_POST['entrada1']);
    $entrada2 = trim($_POST['entrada2']);
    $salida1 = trim($_POST['salida1']);
    $salida2 = trim($_POST['salida2']);
    $tiposemana = trim($_POST['tiposemana']);
    
    switch ($tiposemana) {
    case 1:
        $tiposemana = "inglesa";
        break;
    case 2:
        $tiposemana = "completa";
        break;
    }
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT dEntrada1, dEntrada2, dSalida1, dSalida2, eTipoSemana FROM ct_horario WHERE dEntrada1 = '".$entrada1."' AND dEntrada2 = '".$entrada2."' AND dSalida1 = '".$salida1."' AND dSalida2 = '".$salida2."' AND eTipoSemana = '".$tiposemana."'LOCK IN SHARE MODE";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
       
       //@mysql_free_result($result); 
       $mensaje = "Error al guardar los datos: Ya existe un horario con los mismos valores.";
       $error = "1"; 
       $transaccion_exitosa = false; 
       mysql_query("ROLLBACK");
       mysql_close($dbconn); 
        
    }else{
    
        $sql = "INSERT INTO ct_horario SET dEntrada1 = '".$entrada1."', dEntrada2 = '".$entrada2."', dSalida1 = '".$salida1."', dSalida2 = '".$salida2."', eTipoSemana = '".$tiposemana."', dFechaCreacion = NOW()";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
            $error = "1";
            $mensaje = "Error al crear el registro favor de revisar nuevamente los datos."; 
            $transaccion_exitosa = false;
        }                
        if ($transaccion_exitosa) {
            $mensaje = "Se ha agregado un horario exitosamente.";
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
     //echo $error;
     //exit;
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
}
function CargarHorario(){ 
     
     $id = trim($_POST['id']);
     $error = "0";
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT idHorario, DATE_FORMAT(dEntrada1, '%H:%i') AS dEntrada1, DATE_FORMAT(dEntrada2, '%H:%i') AS dEntrada2 , DATE_FORMAT(dSalida1, '%H:%i') AS dSalida1, DATE_FORMAT(dSalida2, '%H:%i') AS dSalida2, eTipoSemana  FROM ct_horario WHERE idHorario = '".$id."' ";
    $result = mysql_query($sql, $dbconn);
    
    if (mysql_num_rows($result) > 0) { 
        while ($horarios = mysql_fetch_array($result)) {
            
            $entrada1 = $horarios['dEntrada1'];
            $entrada2 = $horarios['dEntrada2'];
            $salida1 = $horarios['dSalida1'];
            $salida2 = $horarios['dSalida2'];   
            $tiposemana = $horarios['eTipoSemana'];
            switch ($tiposemana) {
                case 'inglesa':
                    $tiposemana = "1";
                    break;
                case 'completa':
                    $tiposemana = "2";
                    break;
            }
            

        }
                                                                                                                                                                     
    } else{
        
         $error = "1"; 
    }
        $response = array("mensaje"=>"$mensaje",
                      "error"=>"$error",
                      "entrada1"=>"$entrada1",
                      "entrada2"=>"$entrada2",
                      "salida1"=>"$salida1",
                      "salida2"=>"$salida2",    
                      "tiposemana"=>"$tiposemana"
                      
                      );   
        echo array2json($response);
     
     
}
function ActualizarHorario(){
    
    $id =  trim($_POST['id']);  
    $entrada1 = trim($_POST['entrada1']);
    $entrada2 = trim($_POST['entrada2']);
    $salida1 = trim($_POST['salida1']);
    $salida2 = trim($_POST['salida2']);
    $tiposemana = trim($_POST['tiposemana']);
    
    switch ($tiposemana) {
    case 1:
        $tiposemana = "inglesa";
        break;
    case 2:
        $tiposemana = "completa";
        break;
    }
    
    include("cn_laser.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT idHorario FROM ct_horario WHERE idHorario = '".$id."' LOCK IN SHARE MODE";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
       
        $sql = "UPDATE ct_horario SET dEntrada1 = '".$entrada1."', dEntrada2 = '".$entrada2."', dSalida1 = '".$salida1."', dSalida2 = '".$salida2."', eTipoSemana = '".$tiposemana."', dFechaCreacion = NOW() WHERE idHorario = '".$id."'";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
            $error = "1";
            $mensaje = "Error al actualizar el registro."; 
            $transaccion_exitosa = false;
        }                
        if ($transaccion_exitosa) {
            $mensaje = "Se han actualizado los datos exitosamente.";
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
        
    }else{
    
       $mensaje = "Error al guardar los datos: No se encontro ningun registro.";
       $error = "1"; 
       $transaccion_exitosa = false; 
       mysql_query("ROLLBACK");
       mysql_close($dbconn);  
    }
     //echo $error;
     //exit;
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
}
?>
