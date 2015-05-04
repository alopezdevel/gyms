<?php session_start(); ?>
<?php 
include("header.php");
?>

    <div id="content">
    
    	<div id="fb-root"></div>
			<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				  }(document, 'script', 'facebook-jssdk'));
		    </script>

        <h1 class="mail">Comentarios y/o Sugerencias</h1>
        
        <p>En este espacio puedes dejarnos tus comentarios y/o sugerencias de nuestros servicios, todos son bienvenidos!</p>
		<div class="fb-comments" style="margin:0px 150px;width:800px;" data-href="http://laredo2.net/gym/comentarios.php" data-width="700" data-numposts="10" data-colorscheme="light"></div>
    </div>

</div>

<?php include("footer.php"); ?>
