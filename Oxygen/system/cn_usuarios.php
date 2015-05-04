<?php

$mysql_host = "sql.byethost25.org";

$mysql_database = "laredone_gym";

$mysql_username = "laredone_betojr";

$mysql_password = "Carpintero67";

//error_reporting(0);



$dbconn = @mysql_connect($mysql_host, $mysql_username, $mysql_password);

if (!$dbconn) {

    echo '<script language="javascript"> alert (\'No se estableció conexión con el servidor de MySQL. \')</script>';

    die();

}

$dbselect = @mysql_select_db($mysql_database, $dbconn);

if (!$dbselect) {

    echo '<script language="javascript"> alert (\'No se estableció conexión con la base de datos. \')</script>';

    //echo '<script language="javascript"> alert (\'Global PCNet está subiendo una nueva versión del sistema. Favor de intentar conectarse más tarde (Inicio de actualización: 22/Julio/2011 a las 13:00). \')</script>';

    die();

} 

?>