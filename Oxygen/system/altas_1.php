<?php

function insertarMensaje($usuario, $mensaje){ 

            $usuario = strtoupper(trim($usuario));

            $mensaje = strtoupper(trim($mensaje));

            if($usuario !="" && $mensaje != "" ){

                    include("cn_usuarios.php");

                    mysql_query("BEGIN");

                    $transaccion_exitosa = true;                                                                                                                                                          

                    $sql = "INSERT INTO cs_chat SET sUsuario = '". mysql_real_escape_string(strip_tags($usuario))."',sMensaje = '". mysql_real_escape_string(strip_tags($mensaje))."', dFecha = DATE_ADD( NOW(), interval '-9' HOUR) ";

                    mysql_query($sql, $dbconn);

                    if ( mysql_affected_rows() < 1 ) {

                        $transaccion_exitosa = false;                                                                                                                                                                     

                    }

                    if ($transaccion_exitosa) {

                        mysql_query("COMMIT");

                        mysql_close($dbconn);

                        return true;        

                    } else {

                        //error

                        mysql_query("ROLLBACK");

                        mysql_close($dbconn);

                        return false;

                    }

            }else{

               //Mensaje no enviado

                return false;

            }

              

}
function insertarComentarioDelDia($usuario, $mensaje){

    include("cn_usuarios.php");//Conexion

    $transaccion_exitosa = true;

    mysql_query("BEGIN");//Transaccion inica        

    $sql ="SELECT  sComentario from cb_comentario_del_dia WHERE  DATE_FORMAT(dFecha,'%d/%m/%Y') = DATE_FORMAT(".$_SESSION['fecha_actual_server'].",'%d/%m/%Y') lock in share mode";

    $result =  mysql_query($sql, $dbconn);

    if (mysql_num_rows($result) > 0) {

        $sql = "DELETE FROM  cb_comentario_del_dia WHERE DATE_FORMAT(dFecha,'%d/%m/%Y') =  DATE_FORMAT(".$_SESSION['fecha_actual_server'].",'%d/%m/%Y') ";

        mysql_query($sql, $dbconn);

        if ( mysql_affected_rows() < 1 ) {

            $transaccion_exitosa = false;

            $mensaje_error="No se pudo borrar el comentario. Favor de verificar los datos.";

        }

    }

    if($transaccion_exitosa){

        $sql = "INSERT INTO cb_comentario_del_dia SET sComentario = '".$mensaje."',  sUsuario = '".$usuario."' ,dFecha = ".$_SESSION['fecha_actual_server']." ";

        mysql_query($sql, $dbconn);

        if ( mysql_affected_rows() < 1 ) {

            $transaccion_exitosa = false;

            $mensaje_error="No se pudo insertar el comentario. Favor de verificar los datos.";

        }

    }

    if ($transaccion_exitosa) {

        mysql_query("COMMIT");

        mysql_close($dbconn);

        echo '<script language="javascript">alert(\'Comentarios Agregado.\')</script>';

        return TRUE;

    } else {

        echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';

        mysql_query("ROLLBACK");

        mysql_close($dbconn);

        return false;

    }

}
function insertarDuda($duda, $comentario){

    include("cn_usuarios.php");//Conexion

    $transaccion_exitosa = true;

    mysql_query("BEGIN");//Transaccion inica        

        $sql = "INSERT INTO cb_dudas_soporte SET sComentario = '".$mensaje."',  sUsuario = '".$usuario."' ,dFecha = ".$_SESSION['fecha_actual_server']." ";

        mysql_query($sql, $dbconn);

        if ( mysql_affected_rows() < 1 ) {

            $transaccion_exitosa = false;

            $mensaje_error="No se pudo insertar el comentario. Favor de verificar los datos.";

        }

    if ($transaccion_exitosa) {

        mysql_query("COMMIT");

        mysql_close($dbconn);

        echo '<script language="javascript">alert(\'Comentarios Agregado.\')</script>';

        return TRUE;

    } else {

        echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';

        mysql_query("ROLLBACK");

        mysql_close($dbconn);

        return false;

    }

}
function insertarPagoMensualidad($id_socio,$monto,$fecha_inicial, $fecha_final){
    //include("funciones_consulta.php");
    //Validaciones
    
    //Validar fecha 1
    $validar_fecha_inicial = true;
    $exp = "^[0-9]{2}/[0-9]{2}/[0-9]{4}$";
    if (ereg($exp,$fecha_inicial)) {
        if (checkdate((integer)substr($fecha_inicial,3,2),(integer)substr($fecha_inicial,0,2),(integer)substr($fecha_inicial,6,4))) {
            $validar_fecha_inicial =  true;
        } else {
            $validar_fecha_inicial = false;
        }
    } else {
        $validar_fecha_inicial = false;
    }
    
    //Validar fecha 2
    $validar_fecha_final = true; 
    $exp = "^[0-9]{2}/[0-9]{2}/[0-9]{4}$";
    if (ereg($exp,$fecha_final)) {
        if (checkdate((integer)substr($fecha_final,3,2),(integer)substr($fecha_final,0,2),(integer)substr($fecha_final,6,4))) {
            $validar_fecha_final =  true;
        } else {
            $validar_fecha_final = false;
        }
    } else {
        $validar_fecha_final = false;
    }
    
    
    
    
    $exp = "^[0-9]+$"; 
    $validar_monto = ereg($exp,$monto);
    //$validar_monto = Expresion_Regular("numero_decimal", $monto, 1,8 );       
    //echo '2';
    if ($validar_fecha_inicial && $validar_monto && $validar_fecha_final) {
        //formateando fecha         
        $fecha_inicial = substr($fecha_inicial,6,4).'/'.substr($fecha_inicial,3,2).'/'.substr($fecha_inicial,0,2);
        $fecha_final = substr($fecha_final,6,4).'/'.substr($fecha_final,3,2).'/'.substr($fecha_final,0,2);
        include("cn_usuarios.php");//Conexion 
        $transaccion_exitosa = true;
        mysql_query("BEGIN");//Transaccion inica
        $sql ="INSERT INTO cb_pagos_socio set iidsocio='".$id_socio."',dfechapago='".$fecha_inicial."',icantidadpago='".$monto."',dfechacreacionregistro=".$_SESSION['fecha_actual_server'].",susuariocreacionregistro='".$_SESSION['acceso']."',sipcreacionregistro='".$_SERVER['REMOTE_ADDR']."',dfechavencimiento= '".$fecha_final."' ";
        mysql_query($sql, $dbconn);
        if ( mysql_affected_rows() < 1 ) {
echo $sql;
            $transaccion_exitosa = false;
            $mensaje_error="No se pudo insertar el pago. Favor de verificar los datos.";
        }
        if ($transaccion_exitosa) {
            mysql_query("COMMIT");
            mysql_close($dbconn);
            return TRUE;
        } else {
            echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';
            mysql_query("ROLLBACK");
            mysql_close($dbconn);
            return false;
        }
                                                    
    }else{
        $num_param = 0;
        $msg_error = "";
        
        if ($validar_monto == false) {
            $msg_error = "MONTO";
            $num_param = $num_param + 1;
        }

        if ($validar_fecha_inicial == false) {
            if ($num_param > 0) {
                $msg_error = $msg_error.", FECHA INICIAL";
            } else {
                $msg_error = "FECHA INICIAL";
            }
            $num_param = $num_param + 1;
        }
        
        if ($validar_fecha_final == false) {
            if ($num_param > 0) {
                $msg_error = $msg_error.", FECHA FINAL";
            } else {
                $msg_error = "FECHA FINAL";
            }
            $num_param = $num_param + 1;
        }
        if ($num_param == 1) {
            echo '<script language="javascript">alert(\'El campo '.$msg_error.' es inválido. Favor de verificarlo.\')</script>';
        } else {
            echo '<script language="javascript">alert(\'Los campos '.$msg_error.' son inválidos. Favor de verificarlos.\')</script>';        
        }
                
        return false;
    }
}
function insertarNuevoSocio($nombre,$Apaterno,$Amaterno,$Calle,$Colonia,$Correo,$ComentariosGenerales,$Telefono,$Genero,$CantidadPago,$fechaNacimiento){

    include("cn_usuarios.php");//Conexion

    $transaccion_exitosa = true;

	 //formateando fecha         

    $fechaNacimientoSocio = substr($fechaNacimiento,6,4).'/'.substr($fechaNacimiento,3,2).'/'.substr($fechaNacimiento,0,2);

    mysql_query("BEGIN");//Transaccion inica

	$sql ="insert into ct_socio set sNombreSocio='".$nombre."',sApellidoPaternoSocio='".$Apaterno."',sApellidoMaternoSocio='".$Amaterno."',sCalleSocio='".$Calle."',sColoniaSocio='".$Colonia."',sCorreoSocio='".$Correo."',sComentariosGeneralesSocio='".$ComentariosGenerales."',sTelefonoSocio='".$Telefono."',eGenero='".$Genero."',sCantidadPago='".$CantidadPago."',dFechaPago=".$_SESSION['fecha_actual_server'].",dFechaRegistro=".$_SESSION['fecha_actual_server'].",dFechaNacimientoSocio='".$fechaNacimientoSocio."',sUsuarioCreacionRegistro='".$_SESSION['acceso']."'";  

        mysql_query($sql, $dbconn);

        if ( mysql_affected_rows() < 1 ) {

            $transaccion_exitosa = false;

            $mensaje_error="No se pudo insertar el socio. Favor de verificar los datos.";

        }

    if ($transaccion_exitosa) {

        mysql_query("COMMIT");

        mysql_close($dbconn);

        return TRUE;

    } else {

        echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';

        mysql_query("ROLLBACK");

        mysql_close($dbconn);

        return false;

    }

}

?>