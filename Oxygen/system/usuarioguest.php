<?php
   /*Si es diferente de recepcion y de administrador entonces desabilidar el objeto*/
   if($_SESSION['acceso'] != "U" && $_SESSION['acceso'] != "A")  {
      echo 'disabled';
     }else{
      echo 'enabled';
    }
?>