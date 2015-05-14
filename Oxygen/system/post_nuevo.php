<?php
    session_start();  
    include("header.php");
    
    
?>
<link rel="Stylesheet" type="text/css" href="lib/jhtmlarea/css/jHtmlArea.css">
<script type="text/javascript" src="lib/jhtmlarea/jHtmlArea-0.8.js"></script>
<script type="text/javascript">
$(document).ready(inicio);
	 
function inicio(){
		
    $("#contenido_blog").htmlarea();
    mensaje = $( ".mensaje_valido" );
    $("#frm-post-new .btn-publicar").click(onInsertarPost);
    
    //focus
    $("#nombre_titulo").focus(onFocus);
    //blur
    $("#nombre_titulo").blur(onBlur);


        
};
     
function onInsertarPost(){
         
    //Variables
    var nombre = $("#nombre_titulo");
    var contenido_blog = $('#contenido_blog').htmlarea('html');
    var visibilidad = $("#visibilidad");
    var categoria = $("#categoria");
    todosloscampos = $( [] ).add( nombre_titulo ).add( visibilidad ).add( categoria ).add(contenido_blog);
    todosloscampos.removeClass( "error" );

    $("#nombre_titulo").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" ); 
    
    //validaciones
    var valid = true;
    
    //tamano
    valid = valid && checkLength( nombre, "nombre_titulo", 10, 200 );
    valid = valid && checkRegexp( nombre, /^[a-z]([0-9a-z_\s])+$/i, "El Titulo de la entrada debe contener: a-z, 0-9, espacios y debe comenzar con una letra." );
    
    valid = valid && checkLength( visibilidad, "visibilidad", "" );
    
    valid = valid && checkLength( categoria, "categoria", "" );
    
    valid = valid && checkLength( contenido_blog, "contenido_blog", "" );  
         
}

function onFocus(){
     $(this).css("background-color","#FFFFC0");
 }
function onBlur(){
    $(this).css("background-color","#FFFFFF");
 }
function actualizarMensajeAlerta( t ) {
      mensaje
        .text( t )
        .addClass( "alertmessage" );
      setTimeout(function() {
        mensaje.removeClass( "alertmessage", 2500 );
      }, 700 );
 }
function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        actualizarMensajeAlerta( n );
        o.addClass( "error" );
        o.focus();
        return false;
    } else {                     
        return true;        
    }
 }
function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        actualizarMensajeAlerta( "Length of " + n + " must be between " + min + " and " + max + "."  );
        o.addClass( "error" );
        o.focus();
        return false;    
    } else {             
        return true;                     
    }                    
}
</script>
<div id="layer_content" class="main-section">  
    <div class="container"> 
        <div class="page-title">
            <h1>Blog</h1>
            <h2>Añadir nueva entrada</h2>
        </div>
        <form id="frm-post-new" action="" method="post">
        <div class="row">
            <div class="col-md-8">
                <p class="mensaje_valido">&nbsp;All form fields are required.</p>
                <input id="nombre_titulo" type="text" maxlength="200" placeholder="Introduce el título aquí">
                <hr>
                <textarea id="contenido_blog"></textarea>
            </div>
            <div class="col-md-4">
                <div>
                    <h5><i class="fa fa-eye"></i> Visibilidad</h5>
                    <select id="visibilidad" name="visibilidad">
						<option value="1">Público</option>
						<option value="2">Privado</option>
					</select>
					<h5><i class="fa fa-check-square-o"></i> Categoría</h5>
					<select id="categoria" name="categoria">
						<option value="1">Blog</option>
						<option value="2">Noticias</option>
					</select>
					<h5 style="display: none;"><i class="fa fa-file-image-o"></i> Imagen Destacada</h5>
					<span style="display: none;"><a href="#">Asignar imagen destacada</a></span>
					<hr>
					<div id="autor" class="autor-name"><b>Autor:</b><span> <?php echo $_SESSION['usuario_actual']; ?></span></div>
					<hr>
					<button type="button" class="btn-1 btn-publicar"><i class="fa fa-upload"></i> Publicar Entrada</button>
            </div>
        </div>
        </form>
    </div>
</div>
    <?php include("footer.php"); ?>  
</body>
</html>