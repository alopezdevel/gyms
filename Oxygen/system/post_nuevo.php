<?php
    session_start();  
    include("header.php");
?>
<div id="layer_content" class="main-section">  
    <div class="container"> 
        <div class="page-title">
            <h1>Blog</h1>
            <h2>Añadir nueva entrada</h2>
        </div>
        <form id="frm-post-new" action="" method="post">
        <div class="row">
            <div class="col-md-8">
                <input type="text" maxlength="200" placeholder="Introduce el título aquí">
            </div>
            <div class="col-md-4">
                <div>
                    <h5><i class="fa fa-eye"></i> Visibilidad</h5>
                    <select name="visibilidad">
						<option value="">Público</option>
						<option value="">Privado</option>
					</select>
					<h5><i class="fa fa-check-square-o"></i> Categoría</h5>
					<select name="categoria">
						<option value="">Blog</option>
						<option value="">Noticias</option>
					</select>
					<h5><i class="fa fa-file-image-o"></i> Imagen Destacada</h5>
					<span><a href="#">Asignar imagen destacada</a></span>
					<hr>
					<div class="autor-name"><b>Autor:</b><span></span></div>
					<hr>
					<button type="button" class="btn-1"><i class="fa fa-upload"></i> Publicar Entrada</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
    <?php include("footer.php"); ?>  
</body>
</html>