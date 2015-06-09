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
    $sql = "SELECT *, CONCAT(sNombreSocio , ' ', sApellidoPaternoSocio, ' ',  sApellidoMaternoSocio) AS sNombreSocio,  CONCAT(sCalleSocio , ' Col. ', sColoniaSocio) AS sDireccion FROM ct_socio WHERE sCorreoSocio = '".$username."'";
    $result = mysql_query($sql, $dbconn);
    $informacion_personal = "";
    $workouts = "";
    $maxespr = "";
    $skills = "";
    
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
               if($socios["dFechaNacimientoSocio"] != ""){$socios["dFechaNacimientoSocio"] = calculaedad($socios["dFechaNacimientoSocio"])." A&ntilde;os";}
               if($socios["iAlturaSocio"] != ""){$socios["iAlturaSocio"] = $socios["iAlturaSocio"]." Mts.";}
               if($socios["iPesoSocio"] != ""){$socios["iPesoSocio"] = $socios["iPesoSocio"]." Kg.";} 
               if($socios["sWFran"] !=""){ $socios["sWFran"] = $socios["sWfran"]." Min.";}
               if($socios["sWHelen"] != ""){$socios["sWHelen"] = $socios["sWHelen"]." Min.";}
               if($socios["sWGrace"] != ""){$socios["sWGrace"] = $socios["sWGrace"]." Min.";} 
               if($socios["sWFilthy50"] != ""){$socios["sWFilthy50"] = $socios["sWFilthy50"]." Min.";}
               if($socios["sWRow500m"] != ""){$socios["sWRow500m"] = $socios["sWRow500m"]." Min.";}
               if($socios["sWSprint400m"] != ""){$socios["sWSprint400m"] =$socios["sWSprint400m"]." Min.";}
               if($socios["sWRun5k"] != ""){$socios["sWRun5k"] = $socios["sWRun5k"]." Min.";}
               if($socios["iMP_cleanandjerk"] != ""){$socios["iMP_cleanandjerk"] = $socios["iMP_cleanandjerk"]." Lbs.";}
               if($socios["iMP_snatch"] != ""){$socios["iMP_snatch"] = $socios["iMP_snatch"]." Lbs.";}
               if($socios["iMP_deadlift"] != ""){$socios["iMP_deadlift"] = $socios["iMP_deadlift"]." Lbs.";}
               if($socios["iMP_backsquat"] != ""){$socios["iMP_backsquat"] = $socios["iMP_backsquat"]." Lbs.";}
               if($socios["iS_boxjumpmax"] != ""){$socios["iS_boxjumpmax"] = $socios["iS_boxjumpmax"]." In.";}  
               
        
                 $informacion_personal .= "<legend>Informacion Personal</legend>".
                                    "<div><span class=\"tag_field\">ID: </span><span>".$socios["iIDSocio"]."</span></div>".
                                    "<div><span class=\"tag_field\">Nombre: </span><span>".$socios["sNombreSocio"]."</span></div>".
                                    "<div><span class=\"tag_field\">Region: </span><span>".$socios["sDireccion"]."</span></div>".
                                    "<div><span class=\"tag_field\">Genero: </span><span>".$genero."</span></div>".
                                    "<div><span class=\"tag_field\">Edad: </span><span>".$socios["dFechaNacimientoSocio"]."</span></div>".
                                    "<div><span class=\"tag_field\">Altura: </span><span>".$socios["iAlturaSocio"]."</span></div>".
                                    "<div><span class=\"tag_field\">Peso: </span><span>".$socios["iPesoSocio"]." </span></div>";
                                    
                 $workouts .= "<tr><td colspan=\"100%\" class=\"table-head\">WORKOUTS</td></tr>".
                                "<tr><td class=\"tag_field\">Fran: </td><td>".$socios["sWFran"]."<td/></tr>".
                                "<tr><td class=\"tag_field\">Helen: </td><td>".$socios["sWHelen"]."<td/></tr>".
                                "<tr><td class=\"tag_field\">Grace: </td><td>".$socios["sWGrace"]."<td/></tr>".
                                "<tr><td class=\"tag_field\">Filthy 50: </td><td>".$socios["sWFilthy50"]."<td/></tr>".
                                "<tr><td class=\"tag_field\">Row 500m: </td><td>".$socios["sWRow500m"]."<td/></tr>".
                                "<tr><td class=\"tag_field\">Sprint 400m: </td><td>".$socios["sWSprint400m"]."<td/></tr>".
                                "<tr><td class=\"tag_field\">Run 5k: </td><td>".$socios["sWRun5k"]."<td/></tr>";
                                
                 $maxespr .= "<tr><td colspan=\"100%\" class=\"table-head\">MAXES PR</td></tr>".
                                "<tr><td class=\"tag_field\">Clean & Jerk: </td><td>".$socios["iMP_cleanandjerk"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Snatch: </td><td>".$socios["iMP_snatch"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Deadlift: </td><td>".$socios["iMP_deadlift"]."</td></tr>".
                                "<tr><td class=\"tag_field\">BackSquat: </td><td>".$socios["iMP_backsquat"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Max Pull-Ups: </td><td>".$socios["iMP_maxpullups"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Max Muscle-Up: </td><td>".$socios["iMP_maxmuscleup"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Max Burpees Min: </td><td>".$socios["iMP_maxburpeesmin"]."</td></tr>";
                                
                 $skills .= "<tr><td colspan=\"100%\" class=\"table-head\">SKILLS</td></tr>".
                                "<tr><td class=\"tag_field\">Clean & Jerk: </td><td>".$socios["eS_ropeclaims"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Snatch: </td><td>".$socios["eS_du"]." </td></tr>".
                                "<tr><td class=\"tag_field\">Deadlift: </td><td>".$socios["eS_hspu"]." </td></tr>".
                                "<tr><td class=\"tag_field\">BackSquat: </td><td>".$socios["eS_pullups"]." </td></tr>".
                                "<tr><td class=\"tag_field\">Max Pull-Ups: </td><td>".$socios["eS_walkhs"]." </td></tr>".
                                "<tr><td class=\"tag_field\">Max Muscle-Up: </td><td>".$socios["iS_boxjumpmax"]."</td></tr>".
                                "<tr><td class=\"tag_field\">Max Burpees Min: </td><td>".$socios["eS_ringmuscleup"]." </td></tr>";
             }else{  
                //si falla la consulta se muestra lo siguiente:                           
                 $informacion_personal .="<legend>Informacion Personal</legend><div style=\"text-align:center; font-weight: bold;\">No hay datos disponibles.</div>";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $informacion_personal .="<legend>Informacion Personal</legend><div style=\"text-align:center; font-weight: bold;\">No hay datos disponibles.</div>";
    }
        $informacion_personal = utf8_encode($informacion_personal); 
        $workouts = utf8_encode($workouts);
        $maxespr = utf8_encode($maxespr); 
        $skills = utf8_encode($skills); 
        $response = array("mensaje"=>"$sql","error"=>"$error","informacion_personal"=>"$informacion_personal", "workouts" => "$workouts", "maxespr" => "$maxespr", "skills" => "$skills");   
        echo array2json($response);
    
    
}
// CARGAR PAGOS SOCIO //
function CargarPagosSocio(){
    
    $username = trim($_POST['usuario_actual']);
    
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $error = "0";
    $transaccion_exitosa = true;
    $sql = "SELECT iIDSocio FROM ct_socio WHERE sCorreoSocio = '".$username."'";
    $result = mysql_query($sql, $dbconn);
    $html_tabla = "";
    if (mysql_num_rows($result) > 0) {
       
       $socio = mysql_fetch_array($result);
       $socio =  $socio['iIDSocio'];
       $sql2 = "SELECT iFolio, iIDSocio, DATE_FORMAT(dFechaPago,'%d %b %y') AS dFechaPago, DATE_FORMAT(dFechaVencimiento,'%d %b %y') AS dFechaVencimiento, DATE_FORMAT(dFechaVencimiento,'%Y-%m-%d') AS dEstadoPago FROM cb_pagos_socio WHERE iIDSocio = '".$socio."'";
       $result2 = mysql_query($sql2, $dbconn);
       if (mysql_num_rows($result2) > 0) { 
           while ($pagos = mysql_fetch_array($result2)) {
               
               $Statuspago = calcular_estado_pago($pagos["dEstadoPago"]);
                if($pagos["iFolio"] != ""){ 
                     $html_tabla .="<tr>".
                          "<td><b>".$pagos["iFolio"]."</td>".
                          "<td><b>".$pagos["iIDSocio"]."</td>".
                          "<td>".$Statuspago."</td>".
                          "<td>".$pagos["dFechaPago"]."</td>".
                          "<td>".$pagos["dFechaVencimiento"]."</td>". 
                     "</tr>";
                    
                }else{
                    
                   $error = "1";
                   $mensaje = "Al cargar los datos.";
                   $transaccion_exitosa = false;  
       
                }
               
           }
              
       }else{
           
           $error = "1";
           $mensaje = "No se encontraron pagos realizados, favor de revisarlo con el Administrador.";
           $transaccion_exitosa = false; 
           
       }
        
    }
    else{
        
        $error = "1";
        $mensaje = "No se puede encontrar la clave del socio, favor de intentarlo nuevamente.";
        $transaccion_exitosa = false; 
    } 
    //Revisamos si fue exitosa la consulta.
    if($transaccion_exitosa){
        
        mysql_query("COMMIT");
        mysql_close($dbconn); 
        
    }else{
       mysql_query("ROLLBACK");
       mysql_close($dbconn);  
    }  
       
     $html_tabla = utf8_encode($html_tabla); 
     $response = array("mensaje"=>"$mensaje","error"=>"$error","html_tabla" => "$html_tabla");   
     echo array2json($response);
    
}
// CALCULAR EDAD...//
function calculaedad($fechanacimiento){
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}
// CALCULAR ESTADO PAGO SOCIO ----//
function calcular_estado_pago($fechavencimiento){
    list($ano,$mes,$dia) = explode("-",$fechavencimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0) {$estado_pago = "EN PROGRESO"; }
    else{ $estado_pago = "VENCIDO"; }
          
    return $estado_pago;
}
?>
