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

function CargarDatosSocio(){
    
    $username = trim($_POST['usuario_actual']);
    
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT iIDSocio, CONCAT(sNombreSocio , ' ', sApellidoPaternoSocio, ' ',  sApellidoMaternoSocio) AS sNombreSocio,  CONCAT(sCalleSocio , ' Col. ', sColoniaSocio,) AS sDireccion, eGenero FROM ct_socio WHERE sCorreoSocio = '".$username."'";
    $result = mysql_query($sql, $dbconn);
    $informacion_personal = "";
    
    if (mysql_num_rows($result) > 0) { 
        while ($socios = mysql_fetch_array($result)) {
           if($socios["iIDSocio"] != ""){
                
               $genero="";
               switch ($socios["eGenero"]) {
                    case "M":
                        $genero = "Masculino";
                        break;
                    case "F":
                        $genero = "Femenino";
                        break;
                 }
        
                 $informacion_personal .= "<legend>Informacion Personal</legend>
                                    <div><span class=\"tag_field\">ID: </span><span>".$socios["iIDSocio"]."</span></div>
                                    <div><span class=\"tag_field\">Nombre: </span><span>".$socios["sNombreSocio"]."</span></div>
                                    <div><span class=\"tag_field\">Region: </span><span>".$socios["sDireccion"]."</span></div>
                                    <div><span class=\"tag_field\">Genero: </span><span>".$genero."</span></div>
                                    <div><span class=\"tag_field\">Edad: </span><span></span></div>
                                    <div><span class=\"tag_field\">Altura: </span><span></span></div>
                                    <div><span class=\"tag_field\">Peso: </span><span></span></div>";
             }else{                             
                 $informacion_personal .="<div style=\"text-align:center; font-weight: bold;\">No hay datos disponibles.</div>";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $informacion_personal .="<div style=\"text-align:center; font-weight: bold;\">No hay datos disponibles.</div>";
    }
        $informacion_personal = utf8_encode($informacion_personal); 
        $response = array("mensaje"=>"$sql","error"=>"$error","informacion_personal"=>"$informacion_personal");   
        echo array2json($response);
    
    
}
?>
