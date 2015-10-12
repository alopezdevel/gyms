<?php
    session_start();
    include("header.php");
?>
<script type="text/javascript">
$(document).ready(inicio);
    
    function inicio(){
    
        geturl();  
        fn_blog.getentrada($.get("entrada"));   
        fbroot();
        
        //$('#btn-borrar-entrada').click(fn_blog.borrarentrada);
    } 
function geturl(){
//empieza tomar valor de url//
  
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

//termina tomar valor de url//
}
function fbroot(){

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
}
    var fn_blog = {
        domroot:"#blog",
        blog_list: "#blog-list",
        getentrada: function(id){
               
            $.ajax({             
                type:"POST", 
                url:"funciones_blog.php", 
                data:{accion:"get_entradacont", identrada : id},
                async : true,
                cache: false,
                dataType : "json",
                success : function(data){                               
                    
                        $(fn_blog.blog_list).empty().append(data.tabla); 
                    }
            
            });    
          
        } 
        
    } //termina funciones blog 
function borrarentrada(id){
               
            $.ajax({             
                type:"POST", 
                url:"funciones_blog.php", 
                data:{accion:"delete_entradacont", identrada : id},
                async : true,
                dataType : "json",
                success : function(data){                               
                        switch(data.error){
                        case "1":  alert("Error al borrar los datos");
                            break;
                        case "0":   alert("Se ha eliminado la entrada exitosamente");
                            location.href= "blog.php";
                            break;  
                        } 
                }
            
            });    
          
}   
</script>
<?php ?>
<div id="fb-root"></div>
<script>
</script>
<div id="layer_content" class="main-section"> 
    <div id="blog" class="container"> 
        <div class="page-title">
            <h1>Blog</h1>
            <h2>Casos mas recientes</h2>
        </div>
    <div class="blog-cont col-md-8">
         <div id="blog-list"></div>
         <?php if($_SESSION["acceso"] == "A"){?>
            <div id="btn-borrar-entrada" class="btn-borrar-entrada" onclick="borrarentrada($.get('entrada'))"><i class="fa fa-trash"></i> Eliminar entrada</div>
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