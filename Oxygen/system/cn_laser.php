<?php

$mysql_host = "sql.byethost25.org";
$mysql_database = "laredone_laser";
$mysql_username = "laredone_wcenter";
$mysql_password = "05100248abc";


$dbconn = @mysql_connect($mysql_host, $mysql_username, $mysql_password);

if (!$dbconn) {

    echo '<script language="javascript"> alert (\'No se estableció conexión con el servidor de MySQL. \')</script>';
    die();

}

$dbselect = @mysql_select_db($mysql_database, $dbconn);

if (!$dbselect) {

    echo '<script language="javascript"> alert (\'No se estableció conexión con la base de datos. \')</script>';
    die();

} 

?>