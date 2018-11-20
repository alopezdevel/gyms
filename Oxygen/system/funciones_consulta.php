<?php

function Consulta_pagos_socio($socio, $mes, $year_a, &$arr_){

    include("cn_usuarios.php");

    $sql = " SELECT 
             cb_pagos_socio.iFolio,
             cb_pagos_socio.iIDSocio,
	     cb_pagos_socio.iCantidadPago as pago,	

             ct_socio.sNombreSocio,

             ct_socio.sApellidoPaternoSocio,                                        

             ct_socio.sApellidoMaternoSocio,

             DATE_FORMAT(cb_pagos_socio.dFechaPago, '%d/%m/%Y') as dFechaPago, 

             DATE_FORMAT(cb_pagos_socio.dFechaVencimiento, '%d/%m/%Y') as dFechaVencimiento,

             DATEDIFF(cb_pagos_socio.dFechaVencimiento,DATE_ADD( NOW(), interval '-9' HOUR)) as dias_restantes,

             CASE WHEN DATEDIFF(cb_pagos_socio.dFechaVencimiento,".$_SESSION['fecha_actual_server'].") <= '0' THEN 'TERMINADO' WHEN DATEDIFF(cb_pagos_socio.dFechaVencimiento,".$_SESSION['fecha_actual_server'].") > 0 AND DATEDIFF(cb_pagos_socio.dFechaVencimiento,".$_SESSION['fecha_actual_server'].") <= 31 THEN 'EN PROGRESO' WHEN DATEDIFF(cb_pagos_socio.dFechaVencimiento,".$_SESSION['fecha_actual_server'].") > 31 THEN 'PENDIENTE' END AS Estatus

             FROM cb_pagos_socio

             INNER JOIN ct_socio ON ct_socio.iIDSocio = cb_pagos_socio.iIDSocio

             WHERE ct_socio.iIDSocio = '".$socio."' ORDER BY  cb_pagos_socio.dFechaVencimiento DESC ";

    if($mes != ""){

        $sql = $sql. " AND MONTH(cb_pagos_socio.dFechaVencimiento) = '".$mes."' ";

    }

    if($year_a != ""){

        $sql = $sql. " AND YEAR(cb_pagos_socio.dFechaVencimiento) = '".$year_a."' ";

    }

    $result = mysqli_query( $dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("id_socio" => stripslashes($Recordset['iIDSocio']),       
                            "folio_pago" => stripslashes($Recordset['iFolio']),
                           "nombre_socio" => stripslashes($Recordset['sNombreSocio']).' '.stripslashes($Recordset['sApellidoPaternoSocio']).' '.stripslashes($Recordset['sApellidoMaternoSocio']),
                           "fecha_pago" => stripslashes($Recordset['dFechaPago']),
			    "pago" => stripslashes($Recordset['pago']),

                           "fecha_vencimiento" => stripslashes($Recordset['dFechaVencimiento']),

                           "estatus_del_pago" => stripslashes($Recordset['Estatus']),

                           );

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn);

}

function getSocioPago($folio, &$arr_) {

    include("cn_usuarios.php");

    $sql = " SELECT cb_pagos_socio.iIDSocio,

             ct_socio.sNombreSocio,

             ct_socio.sApellidoPaternoSocio,

             ct_socio.sApellidoMaternoSocio,

             DATEDIFF(cb_pagos_socio.dFechaVencimiento,".$_SESSION['fecha_actual_server'].") as dias_restantes,

             DATE_FORMAT(cb_pagos_socio.dFechaVencimiento, '%d/%m/%Y') as dFechaVencimiento ,

             DATE_FORMAT(cb_pagos_socio.dFechaPago, '%d/%m/%Y') as dFechaPago 

             FROM cb_pagos_socio

             INNER JOIN ct_socio ON ct_socio.iIDSocio = cb_pagos_socio.iIDSocio

             WHERE cb_pagos_socio.iIDSocio = '".$folio."' 

             ORDER BY DATEDIFF(cb_pagos_socio.dFechaVencimiento,".$_SESSION['fecha_actual_server'].") DESC

             LIMIT 1";

    $result = mysqli_query( $dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("id_socio" => stripslashes($Recordset['iIDSocio']),

                           "nombre_socio" => stripslashes($Recordset['sNombreSocio']),

                           "apellido_paterno_socio" => stripslashes($Recordset['sApellidoPaternoSocio']),

                           "apellido_materno_socio" => stripslashes($Recordset['sApellidoMaternoSocio']),

                           "dias_restantes" => stripslashes($Recordset['dias_restantes']),

                           "fecha_vencimiento" => stripslashes($Recordset['dFechaVencimiento']),

                           "fecha_pago" => stripslashes($Recordset['dFechaPago']));

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn);

}

function Consulta_Log_Del_Dia($fecha="", &$arr_) {

    include("cn_usuarios.php");

    $sql = " SELECT ct_socio.iIDSocio,

             concat(ct_socio.sNombreSocio,' ',ct_socio.sApellidoPaternoSocio,' ',ct_socio.sApellidoMaternoSocio) as nombre_socio,

             cb_transacciones_socio.eTipoTransaccion as estatus,

             DATE_FORMAT(cb_transacciones_socio.dFechaVisitaSocio, '%d/%m/%Y - %r') as fecha_visita_socio

             FROM ct_socio

             RIGHT JOIN cb_transacciones_socio ON ct_socio.iIDSocio = cb_transacciones_socio.iIDSocio

             WHERE DATE_FORMAT(cb_transacciones_socio.dFechaVisitaSocio, '%d/%m/%Y') = DATE_FORMAT(".$_SESSION['fecha_actual_server'].", '%d/%m/%Y') ORDER BY cb_transacciones_socio.dFechaVisitaSocio DESC";

    $result = mysqli_query($dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("id_socio" => stripslashes($Recordset['iIDSocio']),

                           "nombre_socio" => stripslashes($Recordset['nombre_socio']),

                           "estatus" => stripslashes($Recordset['estatus']),

                           "fecha_visita_socio" => stripslashes($Recordset['fecha_visita_socio']));

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn);

}

function Consulta_Log_Usuario($socio, $mes, $year_a, &$arr_) {

    include("cn_usuarios.php");

    $sql = " SELECT ct_socio.iIDSocio,

             concat(ct_socio.sNombreSocio,' ',ct_socio.sApellidoPaternoSocio,' ',ct_socio.sApellidoMaternoSocio) as nombre_socio,

             cb_transacciones_socio.eTipoTransaccion as estatus,

             DATE_FORMAT(cb_transacciones_socio.dFechaVisitaSocio, '%d/%m/%Y - %r') as fecha_visita_socio

             FROM ct_socio

             RIGHT JOIN cb_transacciones_socio ON ct_socio.iIDSocio = cb_transacciones_socio.iIDSocio

             WHERE ct_socio.iIDSocio = '".$socio."' ";

    if($mes != ""){

        $sql = $sql. " AND MONTH(cb_transacciones_socio.dFechaVisitaSocio) = '".$mes."' ";

    }

    if($year_a != ""){

        $sql = $sql. " AND YEAR(cb_transacciones_socio.dFechaVisitaSocio) = '".$year_a."' ";

    }

    $result = mysqli_query($dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("id_socio" => stripslashes($Recordset['iIDSocio']),

                           "nombre_socio" => stripslashes($Recordset['nombre_socio']),

                           "estatus" => stripslashes($Recordset['estatus']),

                           "fecha_visita_socio" => stripslashes($Recordset['fecha_visita_socio']));

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn);

}

function getMembresia($folio,$nombre,$apellidoPaterno,&$arr_) {

    include("cn_usuarios.php");             

        $sql = " select c.iIDSocio as idsocio,

                c.sNombreSocio as nombre,

                c.sApellidoPaternoSocio as apellidoPaterno,

                c.sApellidoMaternoSocio as apellidoMaterno,

                (select DATE_FORMAT(p.dFechaVencimiento,'%d/%m/%Y') from cb_pagos_socio p where p.iIDSocio=c.iIDSocio order by p.dFechaVencimiento Desc limit 1) as fechaVencimiento,

                (select DATE_FORMAT(p.dFechaPago,'%d/%m/%Y') from cb_pagos_socio p where p.iIDSocio=c.iIDSocio order by p.dFechaVencimiento Desc limit 1) as fechaPago

                from ct_socio c 

                inner join cb_pagos_socio p on (p.iIDSocio=c.iIDSocio)

                where c.sNombreSocio like '%".$nombre."%' and c.sApellidoPaternoSocio like '%".$apellidoPaterno."%' ";               

                if($folio != "") {

                    $sql = $sql." AND  c.iIDSocio = '".$folio."' group by c.iidsocio,c.snombresocio,c.sapellidopaternosocio,c.sapellidomaternosocio ";

                 } 

    $result = mysqli_query( $dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("id_socio" => stripslashes($Recordset['idsocio']),

                           "nombre" => stripslashes($Recordset['nombre']),

                           "apellido_paterno" => stripslashes($Recordset['apellidoPaterno']),

                           "apellido_materno" => stripslashes($Recordset['apellidoMaterno']),

                           "fecha_vencimiento" => stripslashes($Recordset['fechaVencimiento']),

                           "fecha_pago" => stripslashes($Recordset['fechaPago']));

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn);

}  

function getSocio($folio,&$arr_) {
    include("cn_usuarios.php");             
       $sql = " select iIDSocio as idsocio,
                sNombreSocio as nombre,
                sApellidoPaternoSocio as apellidoPaterno,
                sApellidoMaternoSocio as apellidoMaterno,
                sCalleSocio,
                sColoniaSocio,
                sCorreoSocio,
                sComentariosGeneralesSocio,
                sTelefonoSocio,
                eGenero,
                sCantidadPago,
                DATE_FORMAT(dFechaNacimientoSocio, '%d/%m/%Y') as dFechaNacimientoSocio
                from ct_socio c  
                where c.iIDSocio='".$folio."' ";               
    $result = mysqli_query( $dbconn,$sql);
    if (mysqli_num_rows($result) > 0) {
        while ($Recordset = mysql_fetch_array($result)) {
           $arr_[] = array("id_socio" => stripslashes($Recordset['idsocio']),
                           "nombre" => stripslashes($Recordset['nombre']),
                           "apellido_paterno" => stripslashes($Recordset['apellidoPaterno']),
                           "apellido_materno" => stripslashes($Recordset['apellidoMaterno']),
                           "calle_socio" => stripslashes($Recordset['sCalleSocio']),
                           "colonia_socio" => stripslashes($Recordset['sColoniaSocio']),
                           "correo_socio" => stripslashes($Recordset['sCorreoSocio']),
                           "comentarios_generales_socio" => stripslashes($Recordset['sComentariosGeneralesSocio']),
                           "telefono_socio" => stripslashes($Recordset['sTelefonoSocio']),
                           "genero_socio" => stripslashes($Recordset['eGenero']),
                           "cantidadPago_socio" => stripslashes($Recordset['sCantidadPago']),
                           "fecha_nacimiento_socio" => stripslashes($Recordset['dFechaNacimientoSocio'])  
                           );
        }
    }
    mysqli_free_result($result);
    mysqli_close($dbconn);
}  

function Consulta_Chat($total_mensajes,&$arr_){

    include("cn_usuarios.php");

    $sql = " SELECT DATE_FORMAT(dFecha , '%d/%m/%Y') as fecha, sUsuario, sMensaje

             FROM cs_chat

             ORDER BY iConsecutivo DESC LIMIT ".$total_mensajes;

    $result = mysqli_query( $dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("fecha" => stripslashes($Recordset['fecha']),

                           "usuario" => stripslashes($Recordset['sUsuario']),

                           "mensaje" => stripslashes($Recordset['sMensaje']));

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn); 

}

function getPagoMes($folio,$year,$mes,&$arr_)   {

    include("cn_usuarios.php");           

    $sql = " select cb_pagos_socio.dFechaPago 

             from  cb_pagos_socio 

             where iIDSocio='".$folio."' and year(dFechaPago)='".$year."' and month(dFechaPago)='".$mes."' limit 1";                

   $result = mysqli_query( $dbconn,$sql);

    if (mysqli_num_rows($result) > 0) {

        while ($Recordset = mysqli_fetch_array($result)) {

           $arr_[] = array("FechaPago" => stripslashes($Recordset['dFechaPago']));

        }

    }

    mysqli_free_result($result);

    mysqli_close($dbconn);

}

function Consulta_Comentario_Dia() {        //USUARIOS.PHP

    include("cn_usuarios.php");

    $sql = "SELECT sComentario AS mensaje 

            FROM cb_comentario_del_dia

            WHERE DATE_FORMAT(dFecha,'%d/%m/%Y') = DATE_FORMAT(".$_SESSION['fecha_actual_server'].",'%d/%m/%Y') ";

    $mensaje = mysqli_fetch_array(mysqli_query( $dbconn,$sql));

    mysqli_close($dbconn);

    return $mensaje['mensaje'];

}

function Expresion_Regular($tipo, $campo, $entero = 0, $decimal = 0) {
    $exp="";
    if ($tipo == "fecha") {
        $exp = "^[0-9]{2}/[0-9]{2}/[0-9]{4}$";
        if (ereg($exp,$campo)) {
            if (checkdate((integer)substr($campo,3,2),(integer)substr($campo,0,2),(integer)substr($campo,6,4))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        switch ($tipo) {
            case "alfanumerico_con_espacios_y_punto_y_comilla_simple":  $campo = preg_replace('/\s+/', '', $campo);        //elimina espacio(' ')
                                                                        $campo = preg_replace('/\.+/', '', $campo);        //elimina punto(.)
                                                                        $campo = preg_replace('/\'+/', '', $campo);        //elimina comilla simple(')
                                                                        $campo = preg_replace('/\"+/', '', $campo);        //elimina comilla doble(")
                                                                        $campo = preg_replace('/\#+/', '', $campo);        //elimina gato(#)
                                                                        $campo = preg_replace('/\&+/', '', $campo);        //elimina amperson(&)
                                                                        $campo = preg_replace('/\=+/', '', $campo);        //elimina igual(=)
                                                                        $campo = preg_replace('/\++/', '', $campo);        //elimina guión(+)
                                                                        $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                                        $campo = preg_replace('/\/+/', '', $campo);        //elimina diagonal normal(/)
                                                                        $campo = preg_replace('/\,+/', '', $campo);        //elimina coma(,)
                                                                        $campo = preg_replace('/\!+/', '', $campo);        //elimina signo de admiración(!)
                                                                        $campo = preg_replace('/\@+/', '', $campo);        //elimina arroba(@)
                                                                        $campo = preg_replace('/\$+/', '', $campo);        //elimina signo de pesos($)
                                                                        $campo = preg_replace('/\%+/', '', $campo);        //elimina signo de porcentaje(%)
                                                                        $campo = preg_replace('/\^+/', '', $campo);        //elimina signo de exponente(^)
                                                                        $campo = preg_replace('/\;+/', '', $campo);        //elimina asterisco(;)
                                                                        $campo = preg_replace('/\:+/', '', $campo);        //elimina asterisco(:)
                                                                        $campo = preg_replace('/\(+/', '', $campo);        //elimina paréntesis inicial(()
                                                                        $campo = preg_replace('/\)+/', '', $campo);        //elimina paréntesis final())
                                                                        $campo = preg_replace('/\|+/', '', $campo);        //elimina pipe(|)
                                                                        $exp = "^[()\_a-zA-Z0-9áéíóúñÑ]+$";
                break;
                
            case "alfanumerico_con_espacios_y_punto":   $campo = preg_replace('/\s+/', '', $campo);        //elimina espacio(' ')
                                                        $campo = preg_replace('/\.+/', '', $campo);        //elimina punto(.)
                                                        $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                        $campo = preg_replace('/\/+/', '', $campo);        //elimina diagonal normal(/)
                                                        $campo = preg_replace('/\&+/', '', $campo);        //elimina amperson(&)
                                                        $campo = preg_replace('/\,+/', '', $campo);        //elimina coma(,)
                                                        $campo = preg_replace('/\(+/', '', $campo);        //elimina paréntesis inicial(()
                                                        $campo = preg_replace('/\)+/', '', $campo);        //elimina paréntesis final())
                                                        $campo = preg_replace('/\|+/', '', $campo);        //elimina pipe(|)
                                                        $exp = "^[_a-zA-Z0-9áéíóúñÑ]+$";                
                break;
                
            case "alfanumerico_sin_espacios":   $campo = preg_replace('/\.+/', '', $campo);        //elimina punto(.)
                                                $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                $campo = preg_replace('/\/+/', '', $campo);        //elimina diagonal normal(/)
                                                $campo = preg_replace('/\&+/', '', $campo);        //elimina amperson(&)
                                                $exp = "^[_a-zA-Z0-9ñÑ]+$";
                break;

           case "contenedor_maritimo":          $exp = "^[a-zA-ñÑ]{4}[0-9]{7}$";
                break;

                                    
            case "password":                    $campo = preg_replace('/\@+/', '', $campo);        //elimina arroba(-)
                                                $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                $campo = preg_replace('/\/+/', '', $campo);        //elimina diagonal normal(/)
                                                $exp = "^[_a-zA-Z0-9ñÑ]+$";
                break;

            case "bultos_auditoria":            $campo = preg_replace('/\s+/', '', $campo);        //elimina espacio(' ')
                                                $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                $campo = preg_replace('/\,+/', '', $campo);        //elimina coma(,)
                                                $exp = "^[0-9]+$";                
                break;

            case "patente":                        $exp = "^[0-9]{4}$";
                break;                

            case "consecutivo_pedimento":        $exp = "^[0-9]{6}$";
                break;                

            case "cve_aduana_original":            $exp = "^[0-9]{3}$";
                break;                

            case "pedimento":                    $exp = "[0-9]{7}$";
                break;                

            case "firma_electronica":            $exp = "[a-zA-Z0-9ñÑ]{7}$";
                break;                

            case "numero_scac":                    $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                $campo = preg_replace('/\/+/', '', $campo);        //elimina diagonal normal(/)
                                                $exp = "^[_a-zA-Z0-9ñÑ]{4}$";
                break;

            case "numero_caat":                 $campo = preg_replace('/\-+/', '', $campo);        //elimina guión(-)
                                                $campo = preg_replace('/\/+/', '', $campo);        //elimina diagonal normal(/)
                                                $exp = "^[_a-zA-Z0-9ñÑ]{4}$";
                break;

            case "numerico":                    $exp = "^[0-9]+$";
                break;
            
            case "numero_entero_positivo":            return validarDecimales($campo, $entero, 0, 1, "");
                break;
                        
            case "numero_decimal":                  $campo = preg_replace('/\-+/', '', $campo);     //elimina guión(-)
                                                    return validarDecimales($campo, $entero, $decimal, 0, "cualquier_entero");
                break;

            case "numero_decimal_contando_cero":     return validarDecimales($campo, $entero, $decimal, 0, "");  //0 o positivo (no negativos)
                break;

            case "numero_decimal_positivo":            return validarDecimales($campo, $entero, $decimal, 0, "mayor_a_0");
                break;

            case "CURP":                        $exp = "^[a-zA-Z0-9ñÑ]{18}$";
                break;
            

            case "RFC":        $campo = preg_replace('/\#+/', '0', $campo);        //elimina gato(#)
                            $campo = preg_replace('/\&+/', '0', $campo);        //elimina amperson(&)
                            $exp = "^[a-zA-Z0-9ñÑ]{12,13}$";
                break;
        }
        return(ereg($exp,$campo));
    }
} 

function getSocios($nombre,$apellidopaterno,&$arr_) {
    include("cn_usuarios.php");             
       $sql = " select iIDsocio,sNombreSocio,sApellidoPaternoSocio,sApellidoMaternoSocio,sCalleSocio,sColoniaSocio,sCorreoSocio,sComentariosGeneralesSocio,sTelefonoSocio,eGenero from ct_socio where bactivo='1' and  sNombreSocio like '".$nombre."%' and sApellidoPaternoSocio like '".$apellidopaterno."%' group by sNombreSocio,sApellidoPaternoSocio ";               
    $result = mysqli_query( $dbconn,$sql);
    if (mysqli_num_rows($result) > 0) {
        while ($Recordset = mysqli_fetch_array($result)) {
           $arr_[] = array("id_socio" => stripslashes($Recordset['iIDsocio']),
                           "nombre_socio" => stripslashes($Recordset['sNombreSocio']),
                           "apellido_paterno" => stripslashes($Recordset['sApellidoPaternoSocio']),
                           "apellido_materno" => stripslashes($Recordset['sApellidoMaternoSocio']),
                           "calle_socio" => stripslashes($Recordset['sCalleSocio']),
                           "colonia_socio" => stripslashes($Recordset['sColoniaSocio']),
                           "correo_socio" => stripslashes($Recordset['sCorreoSocio']),
                           "comentarios_generales_socio" => stripslashes($Recordset['sComentariosGeneralesSocio']),
                           "telefono_socio" => stripslashes($Recordset['sTelefonoSocio']),
                           "genero_socio" => stripslashes($Recordset['eGenero'])
                           );
        }
    }
    mysqli_free_result($result);
    mysqli_close($dbconn);
}

function SocioInactivo($folio) {
  include("cn_usuarios.php");//Conexion                
   $transaccion_exitosa = true;                                                                                                                                                                                    
   mysqli_query("BEGIN");//Transaccion inica
   $sql="update ct_socio set bactivo=0 where iidsocio='".$folio."' ";
   mysqli_query( $dbconn,$sql);
   if(mysqli_affected_rows() < 0 ) {
     $transaccion_exitosa = false;
     $mensaje_error="No se pudieron guardar los datos del socio. Favor de verificar los datos.";
    }
    if ($transaccion_exitosa) {
    mysqli_query("COMMIT");
    mysqli_close($dbconn);
     return TRUE;
    }else{
     echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';
     mysqli_query("ROLLBACK");
     mysqli_close($dbconn);
     return false;  
    } 
}
function ValidarSocio($nombre,$Apaterno,$Amaterno,$Calle,$Colonia,$Correo,$ComentariosGenerales,$Telefono,$Genero,$CantidadPago,$fechaNacimiento,$esInsert){  
 $TodoOk=True;
 
  if(trim($nombre) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo nombre\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(trim($Apaterno) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Apellido Paterno.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(trim($Amaterno) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Apellido Materno.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(trim($Calle) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Calle.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(trim($Colonia) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Colonia.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  /*
  if(trim($Correo) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Correo.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
   */

  if(!filter_var($Correo, FILTER_VALIDATE_EMAIL)){ 
      echo '<script language="javascript">alert(\'Favor de capturar un correo valido xxxx.@xxxx.xx.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(trim($Telefono) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Telefono.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
     
  if(trim($Genero) =="")
  {
     echo '<script language="javascript">alert(\'Favor de Seleccionar el genero.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
 
  if(trim($fechaNacimiento) =="")
  {
     echo '<script language="javascript">alert(\'Favor de llenar el campo Fecha de nacimiento.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(trim($CantidadPago) =="")
  {
     echo '<script language="javascript">alert(\'Favor de Asignar una cuota mensual del socio.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
  
  if(Expresion_Regular(fecha,$fechaNacimiento)==false){
     echo '<script language="javascript">alert(\'Favor de llenar la fecha de nacimiento con un formato dd/mm/yyyy.\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }
    //Validar que el socio no sea de menos de 8 aqos.
  /*if(date_diff($fechaNacimiento,-$_SESSION['fecha_actual_server']) <=8){
     echo '<script language="javascript">alert(\'La fecha minima de un socio es de 8 aqos\')</script>';
     $TodoOk=false;
     return $TodoOk;
  }*/
  
  //solo aplicar esta validacion en un insert.
  if($esInsert){
  //Validar que no se repita el socio.
      if(ExisteSocio($nombre,$Apaterno,$Amaterno)){
         echo '<script language="javascript">alert(\'Este Socio ya existe en la base de datos,no puedes capturar mas de una vez un socio.\')</script>';
         $TodoOk=false;
         return $TodoOk;   
      }
  }
  
  return $TodoOk;  
} 
function ExisteSocio($nombre,$Amaterno,$Apaterno){
   include("cn_usuarios.php");
   $existe=FALSE;
   $sql = "select sNombreSocio from ct_socio where sNombreSocio='".$nombre."' and sApellidoPaternoSocio='".$Apaterno."' and sApellidoMaternoSocio='".$Amaterno."'";                
   $result = mysqli_query( $dbconn,$sql);
    if (mysqli_num_rows($result) > 0) {
        $existe=TRUE;
    }
    mysql_free_result($result);
    mysql_close($dbconn);
    return $existe;  
} 
function ActualizarSocio($folio,$nombre,$Apaterno,$Amaterno,$Calle,$Colonia,$Correo,$ComentariosGenerales,$Telefono,$Genero,$CantidadPago,$fechaNacimiento){ 
   include("cn_usuarios.php");//Conexion                
   $transaccion_exitosa = true;
   //formateando fecha         
   $fechaNacimientoSocio = substr($fechaNacimiento,6,4).'/'.substr($fechaNacimiento,3,2).'/'.substr($fechaNacimiento,0,2);                                                                                                                                                                                    
   mysqli_query("BEGIN");//Transaccion inica
   $sql="update ct_socio set  sNombreSocio='".$nombre."',sApellidoPaternoSocio='".$Apaterno."',sApellidoMaternoSocio='".$Amaterno."',sCalleSocio='".$Calle."',sColoniaSocio='".$Colonia."',sCorreoSocio='".$Correo."',sComentariosGeneralesSocio='".$ComentariosGenerales."',sTelefonoSocio='".$Telefono."',eGenero='".$Genero."',sCantidadPago='".$CantidadPago."',dFechaNacimientoSocio='".$fechaNacimientoSocio."' where iidsocio='".$folio."' ";
   mysqli_query( $dbconn,$sql);
   if(mysqli_affected_rows() < 0 ) {
     $transaccion_exitosa = false;
     $mensaje_error="No se pudieron guardar los datos del socio. Favor de verificar los datos.";
    }
    if ($transaccion_exitosa) {
    mysqli_query("COMMIT");
    mysqli_close($dbconn);
     return TRUE;
    }else{
     echo '<script language="javascript">alert(\''.$mensaje_error.'\')</script>';
     mysqli_query("ROLLBACK");
     mysqli_close($dbconn);
     return false;  
    }                                                 
}

?>



