<?php

$mysql_host = "31.22.4.142";

$mysql_database = "websolu2_oxygen_dev";
//$mysql_database = "websolu2_oxygen";

$mysql_username = "websolu2_oxygen";

$mysql_password = "0xyg3nus3r";

//error_reporting(0);



$dbconn = @mysql_connect($mysql_host, $mysql_username, $mysql_password);

if (!$dbconn) {

    echo '<script language="javascript"> alert (\'No se estableci� conexi�n con el servidor de MySQL. \')</script>';

    die();

}

$dbselect = @mysql_select_db($mysql_database, $dbconn);

if (!$dbselect) {

    echo '<script language="javascript"> alert (\'No se estableci� conexi�n con la base de datos. \')</script>';

    //echo '<script language="javascript"> alert (\'Global PCNet est� subiendo una nueva versi�n del sistema. Favor de intentar conectarse m�s tarde (Inicio de actualizaci�n: 22/Julio/2011 a las 13:00). \')</script>';

    die();

} 

?>