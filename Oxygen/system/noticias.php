<?php
    session_start();  
    include("header.php");
?>
<script type="text/javascript"> 
    $(document).ready(inicio);
    
    function inicio(){
        
        fn_blog.fillgrid(); 
        fbroot();  
        
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
        domroot:"#noticia",
        blog_list: "#noticia-list",
        count: 0,
        fillgrid: function(){
               $.ajax({             
                type:"POST", 
                url:"funciones_blog.php", 
                data:{accion:"get_entradas", filtroInformacion : 'noticia'},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $(fn_blog.blog_list).empty().append(data.tabla);
                    $count = data.count;
                        while($count > 0){
                                if($(fn_blog.blog_list + ' .cont'+$count).text().length > 200){
                                    limite = $(fn_blog.blog_list + ' .cont'+$count).text().substr(0,200)+" ...";
                                    $(fn_blog.blog_list + ' .cont'+$count).text(limite);
                                    $count = $count - 1;
                                } else{$count = $count - 1;}
                        }
                    
                    }
            }); 
            
        },  
        mostrarentrada: function(identrada){
              //cargando entrada
              var url = "noticia-contenido.php?noticia=" + identrada;
              $(location).attr('href',url);
        }  
    } //termina funciones noticia     
    
</script>
<div id="fb-root"></div>
<div id="layer_content" class="main-section"> 
    <div id="noticia" class="container"> 
        <div class="page-title">
            <h1>Noticias</h1>
            <h2>Casos mas recientes</h2>
        </div>
    <div class="noticia-cont col-md-8">
         <div id="noticia-list"></div> 
    </div>
    <div class="col-md-4">
          <div class="fb-page" data-href="https://www.facebook.com/OxigenFEX" data-width="100%" data-height="300px" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/OxigenFEX"><a href="https://www.facebook.com/OxigenFEX">Oxygen-FX Crossfit Nuevo Laredo</a></blockquote></div></div>
          <div class="widgets">
            <h4>Categorias</h4>
                <ul>
                    <li><a href="blog.php"><i class="fa fa-book"></i> Blog</a></li>
                    <li><a href="noticias.php"><i class="fa fa-newspaper-o"></i> Noticias</a></li> 
                </ul>
          </div>
    </div>
    </div> 
<?php include("footer.php"); ?> 
</div> 
</body>
</html>