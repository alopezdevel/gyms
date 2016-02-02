<?php
    session_start();  
    include("header.php");
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="lib/jNotify/jNotify.jquery.css"> 
<script src="lib/jNotify/jNotify.jquery.min.js" type="text/javascript"></script>
<link href="css/home.css" rel="stylesheet" type="text/css">
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
	<div id="home-section" class="container">
	<h1>Bienvenido a Oxygen-FX Crossfit</h1>
		<div class="row">
		<?php if($_SESSION["acceso"] == "A"){?>
			<div class="col-md-3">
				<div class="socios-enlaces">
					<h2>
						<span>Acceso directo</span>SOCIOS
					</h2>
					<ul>
						<li><a href="socio_verificacion_2"><i class="fa fa-check-square"></i> Registrar asistencia</a></li>
						<li><a href="registro_socio"><i class="fa fa-user-plus"></i> Agregar nuevo</a></li>
						<li><a href="alta_socio_2"><i class="fa fa-eye"></i> Ver catalogo</a></li>
						<li><a href="pagar_mensualidad_2"><i class="fa fa-usd"></i> Registrar pago</a></li>
						<li><a href="monitor_usuario"><i class="fa fa-user"></i> Monitor por socio</a></li>
						<li><a href="monitor_de_pago_por_usuario"><i class="fa fa-folder-open"></i> Reporte de pagos</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="utilerias-enlaces">
					<h2>Utilerias</h2>
					<ul>
						<li><a href="postdeldia"><i class="fa fa-envelope"></i> Mensaje del d&iacute;a</a></li>
						<li><a href="utileria_recordar_pago"><i class="fa fa-thumb-tack"></i> Recordatorio de pagos</a></li>
					</ul>
					<p>¿Necesitas<strong> Soporte Técnico</strong>?</p>
					<div class="btn-soporte"><a href="soporte_sistema">Envianos un mensaje</a></div>
				</div>
			</div>	
			<div class="col-md-6">
				<div class="blog-noticias">
					<h2>BLOG Y NOTICIAS</h2>
					<a href="post_nuevo" style="position: relative;top: 25px;">+ Agregar nueva entrada</a>
					<ul>
						<li class="btn-noticias"><a href="noticias"><img alt="btn_noticias.png" src="images/home/btn_noticias.png"></a></li>
						<li class="btn-blog"><a href="blog"><img alt="btn_blog.png" src="images/home/btn_blog.png"></a></li>
					</ul>
				</div>
			</div>	
		<?php } elseif($_SESSION["acceso"] == "C"){ ?>
		
		<?php } ?>
		</div>
	</div>
</div>
    <?php include("footer.php"); ?>  
</body>
</html>