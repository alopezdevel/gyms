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
                 
function post_nuevo(){
    //tomando variables:
    $nombre_titulo = trim($_POST["nombre_titulo"]);
    $contenido_blog = trim($_POST["contenido_blog"]);
    $visibilidad = trim($_POST["visibilidad"]);
    $categoria = trim($_POST["categoria"]);
    $usuario_actual = trim($_POST["usuario_actual"]);
    
    switch ($visibilidad) {
    case 1:
        $visibilidad = "publico";
        break;
    case 2:
        $visibilidad = "privado";
        break;
    }
    
    switch ($categoria) {
    case 1:
        $categoria = "blog";
        break;
    case 2:
        $categoria = "noticia";
        break;
    }
    
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT sUsuario FROM cu_control_acceso WHERE sUsuario = '".$usuario_actual."' LOCK IN SHARE MODE";
    $result = mysql_query($sql, $dbconn);
    if (mysql_num_rows($result) > 0) {
        
        @mysql_free_result($result);
        $sql= "INSERT INTO ct_blog_noticia SET sNombreTitulo = '".$nombre_titulo."', eCategoria = '".$categoria."', eVisibilidad = '".$visibilidad."', sAutor = '".$usuario_actual."', bContenido = '".$contenido_blog."', dFEchaCreacion = NOW()";

        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
            $error = "1";
            $mensaje = "Error al crear la entrada favor de revisar nuevamente los datos."; 
        }                
        if ($transaccion_exitosa) {
            $mensaje = "Se ah creado una nueva entrada";
            $error = "0";
            mysql_query("COMMIT");     
            mysql_close($dbconn);
        } else {
            $mensaje = "Error al guardar los datos. Favor de verificarlos 1.";
            $error = "1";  
            mysql_query("ROLLBACK");
            mysql_close($dbconn);
        }
                        
    } else {
        
        $mensaje = "Error al guardar los datos. Favor de verificarlos.";
        $error = "1";  
        mysql_query("ROLLBACK");
        mysql_close($dbconn);
    }
     $response = array("mensaje"=>"$mensaje","error"=>"$error");   
     echo array2json($response);
} 
function get_entradas(){
    
    $filtro_informacion = trim($_POST['filtroInformacion']);
     
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT iConsecutivo, sNombreTitulo, eCategoria, eVisibilidad, sAutor, dFechaCreacion, bContenido FROM ct_blog_noticia WHERE eCategoria = '".$filtro_informacion."' AND eVisibilidad = 'publico' ORDER BY iConsecutivo DESC";
    $result = mysql_query($sql, $dbconn);
    $htmlTabla = "";
    $countcont = 0;
    
    if (mysql_num_rows($result) > 0) { 
        while ($entradas = mysql_fetch_array($result)) {
           if($entradas["sNombreTitulo"] != ""){
                $categoria="";
                $countcont = $countcont + 1;
                $colorcategoria= "";
                 switch ($entradas["eCategoria"]) {
                    case "blog":
                        $categoria = "fa-book";
                        $colorcategoria = "blog-categoria";
                        break;
                    case "noticia":
                        $categoria = "fa-newspaper-o";
                        $colorcategoria = "noticia-categoria";
                        break;
                 }
        
                 $htmlTabla .= "<div class=\"blog-entrada\">
                                    <span class=\"".$colorcategoria."\"><i class=\"fa ".$categoria."\"></i> ".$entradas["eCategoria"]."</span>
                                    <h2 id=\"".$entradas["iConsecutivo"]."\" onclick=\"fn_blog.mostrarentrada(".$entradas["iConsecutivo"].")\">".$entradas["sNombreTitulo"]."</h2>".
                                    "<div class=\"cont".$countcont."\">".$entradas["bContenido"]."</div>".
                                    "<p class=\"autor\"><span>Publicado por </span>".$entradas["sAutor"]."<span>-<span> ".$entradas["dFechaCreacion"]."</p>
                                    <hr></div>";
             }else{                             
                 $htmlTabla .="<div></div>";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $htmlTabla .="<div></div>";
    }
        $html_tabla = utf8_encode($html_tabla); 
        $response = array("mensaje"=>"$sql","error"=>"$error","tabla"=>"$htmlTabla","count" =>"$countcont");   
        echo array2json($response);

} 
//consultar una sola entrada //
function get_entradacont(){
    
    $identrada = trim($_POST['identrada']);
     
    include("cn_usuarios.php");
    mysql_query("BEGIN");
    $transaccion_exitosa = true;
    $sql = "SELECT iConsecutivo, sNombreTitulo, eCategoria, eVisibilidad, sAutor, dFechaCreacion, bContenido, eComentarios FROM ct_blog_noticia WHERE iConsecutivo = '".$identrada."'";
    $result = mysql_query($sql, $dbconn);
    $htmlTabla = "";
    $countcont = 0;
    
    if (mysql_num_rows($result) > 0) { 
        while ($entradas = mysql_fetch_array($result)) {
           if($entradas["sNombreTitulo"] != ""){
                $categoria="";
                $countcont = $countcont + 1;
                $colorcategoria= "";
                 switch ($entradas["eCategoria"]) {
                    case "blog":
                        $categoria = "fa-book";
                        $colorcategoria = "blog-categoria";
                        break;
                    case "noticia":
                        $categoria = "fa-newspaper-o";
                        $colorcategoria = "noticia-categoria";
                        break;
                 }
        
                 $htmlTabla .= "<div class=\"blog-entrada\">
                                    <span class=\"".$colorcategoria."\"><i class=\"fa ".$categoria."\"></i> ".$entradas["eCategoria"]."</span>
                                    <h2>".$entradas["sNombreTitulo"]."</h2>".
                                    "<div>".$entradas["bContenido"]."</div>".
                                    "<p class=\"autor\"><span>Publicado por </span>".$entradas["sAutor"]."<span>-<span> ".$entradas["dFechaCreacion"]."</p>";
                 if($entradas["eComentarios"] == "si" || $entradas["eComentarios"] == ""){
                    
                    $htmlTabla .= "<div class=\"comentarios\">
                                    <div class=\"fb-comments\"". 
                                    "data-href=\"http://oxygen-fx.laredo2.net/system/blog.php#".$entradas["iConsecutivo"]."\" data-width=\"100%\" data-numposts=\"5\" data-colorscheme=\"light\"></div></div>".
                                    "</div>"; 
                     
                 } else{
                     
                     $htmlTabla .= "</div>";
                 }
                                    
             }else{                             
                 $htmlTabla .="<div></div>";
             }    
        }
        
        mysql_query("ROLLBACK");
        mysql_close($dbconn);                                                                                                                                                                      
    } else{
        
         $htmlTabla .="<div></div>";
    }
        $html_tabla = utf8_encode($html_tabla); 
        $response = array("mensaje"=>"$sql","error"=>"$error","tabla"=>"$htmlTabla");   
        echo array2json($response);

} 
?>