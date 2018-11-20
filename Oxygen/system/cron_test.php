<?php
  function insertarDuda($duda, $comentario){

    include("cn_usuarios.php");//Conexion

    $transaccion_exitosa = true;

    mysql_query("BEGIN");//Transaccion inica        

        $sql = "INSERT INTO cb_comentario_del_dia SET sComentario = '".$comentario."' ";

        mysql_query($sql, $dbconn);

        if ( mysql_affected_rows() < 1 ) {

            $transaccion_exitosa = false;

            $mensaje_error="No se pudo insertar el comentario. Favor de verificar los datos.";
            echo $mensaje_error.' '.$sql; 

        }

    if ($transaccion_exitosa) {

        mysql_query("COMMIT");

        mysql_close($dbconn);
        

        return TRUE;

    } else {
        mysql_query("ROLLBACK");
        mysql_close($dbconn);
        return false;
    }

}
insertarDuda("1","Se pudo insertar correctamente el insert de cron cron :D?");
?>
