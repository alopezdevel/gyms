<?php
    session_start();  
    include("header.php");
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="lib/jNotify/jNotify.jquery.css"> 
<script src="lib/jNotify/jNotify.jquery.min.js" type="text/javascript"></script>
<script>
$(document).ready(inicio);
function inicio(){
    var mostrar_aviso = '<?= $_SESSION["mostrar_aviso"] ?>';
    mostrarAnuncio();
}
function mostrarAnuncio(){
     $.post("funciones.php", { accion: "consultar_anuncio"},
        function(data){ 
             switch(data.error){
             case "1":   
                    break;
             case "0": jNotify(data.mensaje_dia,
                            {
                                VerticalPosition : 'top',                                                                
                                clickOverlay : true,
                                TimeShown : 5000,
                                onClosed:function(){ }
                            });   
                         
                    break;  
             }
         }
         ,"json");           
   }

        
</script>
<div id="layer_content" class="main-section">  

</div>
    <?php include("footer.php"); ?>  
</body>
</html>