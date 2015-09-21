<?php
    session_start();
if ( $_SESSION['acceso'] != "C" ){ //No ha iniciado session: Esta ventana es solo para socios...no administradores
    header("Location: index.php");
    exit;
}else {  
    include("header.php");
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(inicio);
function inicio(){
    
    CargarDatosSocio();
}
function CargarDatosSocio(){
    
    var usuario_actual = <?php echo json_encode($_SESSION['usuario_actual']);?>

    $.ajax({             
        type:"POST", 
        url:"funciones_socio.php", 
        data:{accion:"CargarDatosSocio", usuario_actual: usuario_actual},
                async : true,
                dataType : "json",
                success : function(data){                               
                    
                    $("#informacion_personal").empty().append(data.informacion_personal);
                    $("#socio-workouts").empty().append(data.workouts);
                    $("#socio-maxespr").empty().append(data.maxespr); 
                    $("#socio-skills").empty().append(data.skills); 
                    d = new Date();
                    $("#foto_perfil_socio_consulta").attr("src",data.ruta + '?' + d.getTime() );
                }
     });
}
</script>
<div id="layer_content" class="main-section">  
    <div id="blog" class="container"> 
        <div class="page-title">
            <h1>Mi Cuenta</h1>
            <h2>Plataforma</h2>
        </div>
        <div id="perfil-cuenta" class="center">
            <div class="col-md-4">
                <div class="foto-perfil"><img id="foto_perfil_socio_consulta" src="" border="0" width="200" height="180" alt="foto_perfil.jpg"></div>
            </div>
            <div class="col-md-8">
               <fieldset id="informacion_personal">
                    <legend>Informacion Personal</legend>
                    
               </fieldset>
            </div>
            <!---- DATOS CONSOLA DEL SOCIO--->
            <div class="row">
               <div class="col-md-4">
                  <table id="socio-workouts">
                       <tr><td colspan="100%" class="table-head">WORKOUTS</td></tr>
                  </table>
               </div>
               <div class="col-md-4">
                <table id="socio-maxespr">
                       <tr><td colspan="100%" class="table-head">MAXES PR</td></tr>
                </table>
               </div>
               <div class="col-md-4">
                  <table id="socio-skills">
                       <tr><td colspan="100%" class="table-head">SKILLS</td></tr>
                  </table>
               </div>
            </div>
        </div>
    </div>
<?php include("footer.php"); ?>  
</div>
</body>
</html>
<?php } ?>  