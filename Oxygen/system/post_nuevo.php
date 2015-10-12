<?php
    session_start();
    if ($_SESSION['acceso'] != "A" ){ //No ha iniciado session
            header("Location: login.php");
    }else{
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
    $("#categoria").change(SelectCategoria);
        
}; 
function SelectCategoria(){
    
    if($('#categoria').val() == "1"){
        
       $('#comentarios').removeAttr('disabled'); 
    }else{
        
        $('#comentarios').attr('disabled','disabled');
        $('#comentarios').val('no');
    }
} 
function onInsertarPost(){
         
    //Variables
    var nombre = $("#nombre_titulo");
    var contenido_blog = $('#contenido_blog').htmlarea('html').toString();;
    var visibilidad = $("#visibilidad");
    var categoria = $("#categoria");
    var comentarios = $("#comentarios");
    todosloscampos = $( [] ).add( nombre_titulo ).add( visibilidad ).add( categoria ).add(contenido_blog).add(comentarios);
    todosloscampos.removeClass( "error" );
    
    var usuario_actual = <?php echo json_encode($_SESSION['usuario_actual']);?>

    $("#nombre_titulo").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" ); 
    
    //validaciones
    var valid = true;
    
    //tamano
    valid = valid && checkLength( nombre, "Titulo", 10, 200 );
    //valid = valid && checkRegexp( nombre, /^[a-z0-9_-]{3,16}$/, "El Titulo de la entrada debe contener: a-z, 0-9, espacios y debe comenzar con una letra." );
        
	//if(contenido_blog != "" && valid){
    	
    	//valid = true;
    	//return false;
		
	//}else{
	
	//	actualizarMensajeAlerta( "Por favor, escribe algun contenido para la entrada." );
		//valid = false;
		//return false;
	//} 
	
	if ( valid ) {
        $.post("funciones_blog.php", { accion: "post_nuevo", nombre_titulo: nombre.val() , contenido_blog: contenido_blog, visibilidad: visibilidad.val(), categoria: categoria.val(), usuario_actual: usuario_actual, comentarios: comentarios.val()},
        function(data){ 
             switch(data.error){
             case "1":   actualizarMensajeAlerta( data.mensaje);
                         $("#nombre_titulo").focus();
                         //email.addClass( "error" ); 
                    break;
             case "0":   actualizarMensajeAlerta("Todos los campos son requeridos.");
                         //$("#nombre_titulo").val("");
                         //$("#contenido_blog").htmlarea('html', '');
                         //$("#visibilidad option[value='']").attr('selected',true);
                         //$("#categoria option[value='']").attr('selected',true);
                         //$("#nombre_titulo").focus();
                         alert("Gracias, has creado una nueva entrada en Oxygen-FX");
                         if($("#categoria").val() == "1"){
                             
                             location.href= "blog.php";  
                         }else{
                             
                             location.href= "noticias.php";  
                         }
                         
                    break;  
             }
         }
         ,"json"); 
    }   
         
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
        actualizarMensajeAlerta( "La longitud del " + n + " debe ser por lo menos entre " + min + " y " + max + "."  );
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
            <h2>A&ntilde;adir nueva entrada</h2>
        </div>
        <form id="frm-post-new" action="" method="post">
        <div class="row">
            <div class="col-md-8">
                <p class="mensaje_valido">&nbsp;Todos los campos son requeridos.</p>
                <input id="nombre_titulo" type="text" maxlength="200" placeholder="Introduce el t&iacute;tulo aqu&iacute;">
                <hr>
                <textarea id="contenido_blog"></textarea>
            </div>
            <div class="col-md-4">
                <div>
                    <h5><i class="fa fa-eye"></i> Visibilidad</h5>
                    <select id="visibilidad" name="visibilidad">
                    	<option value="1">Selecciona una opci&oacute;n...</option>
						<option value="1">P&uacute;blico</option>
					</select>
					<h5><i class="fa fa-check-square-o"></i> Categor&iacute;a</h5>
					<select id="categoria" name="categoria">
						<option value="1">Blog</option>
						<option value="2">Noticias</option>
					</select>
                    <h5><i class="fa fa-comments"></i> Permitir Comentarios</h5>
                    <select id="comentarios" name="comentarios">
                        <option value="2">Selecciona una opci&oacute;n...</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
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
<?php }?>