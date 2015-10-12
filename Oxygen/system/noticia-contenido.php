<?php
    session_start();  
    include("header.php");
?>
<script type="text/javascript">
//empieza tomar valor de url//
(function($) {  
    $.get = function(key)   {  
        key = key.replace(/[\[]/, '\\[');  
        key = key.replace(/[\]]/, '\\]');  
        var pattern = "[\\?&]" + key + "=([^&#]*)";  
        var regex = new RegExp(pattern);  
        var url = unescape(window.location.href);  
        var results = regex.exec(url);  
        if (results === null) {  
            return null;  
        } else {  
            return results[1];  
        }  
    }  
})(jQuery); 
//termina tomar valor de url//
 
    $(document).ready(inicio);
    
    function inicio(){
        
        fn_blog.getentrada($.get("noticia"));
        //$('#btn-borrar-entrada').click(borrarentrada);    
        
    } 
    var fn_blog = {
        domroot:"#noticia",
        blog_list: "#noticia-list",
        count: 0,
        getentrada: function(id){
               $.ajax({             
                type:"POST", 
                url:"funciones_blog.php", 
                data:{accion:"get_entradacont", identrada : id},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $(fn_blog.blog_list).empty().append(data.tabla);

                    }
            }); 
            
        }
    } //termina funciones noticia     
function borrarentrada(id){
               
            $.ajax({             
                type:"POST", 
                url:"funciones_blog.php", 
                data:{accion:"delete_entradacont", identrada : id},
                async : true,
                dataType : "json",
                success : function(data){                               
                        switch(data.error){
                        case "1":  
                            alert("Error al borrar los datos");
                            break;
                        case "0":   
                            alert("Se ha eliminado la entrada exitosamente");
                            location.href= "noticias.php";
                            break;  
                        } 
                }
            
            });    
          
        }
</script>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div id="layer_content" class="main-section"> 
    <div id="noticia" class="container"> 
        <div class="page-title">
            <h1>Noticias</h1>
            <h2>Casos mas recientes</h2>
        </div>
    <div class="noticia-cont col-md-8">
         <div id="noticia-list"></div>
         <?php if($_SESSION["acceso"] == "A"){?>
            <div id="btn-borrar-entrada" class="btn-borrar-entrada" onclick="borrarentrada($.get('noticia'))"><i class="fa fa-trash"></i> Eliminar entrada</div>
         <?php } ?> 
    </div>
    <div class="col-md-4">
          <div class="fb-page" data-href="https://www.facebook.com/OxigenFEX" data-width="100%" data-height="300px" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/OxigenFEX"><a href="https://www.facebook.com/OxigenFEX">Oxygen-FX Crossfit Nuevo Laredo</a></blockquote></div></div>
    </div>
    </div> 
<?php include("footer.php"); ?> 
</div> 
</body>
</html>