<?php
  $mysql_host = "31.22.4.142";
  $mysql_database = "websolu2_oxygen_dev";
  //$mysql_database = "websolu2_oxygen";
  $mysql_username = "websolu2_oxygen";
  $mysql_password = "0xyg3nus3r";
  $dbconn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);   
  $dbselect = true;
  if(mysqli_connect_error()){
      $mensaje_de_error =  "error de conexion";
  }                   
  
  
?>
