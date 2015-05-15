<?php
    session_start();  
    include("header.php");
?>
<script> 
	$(document).ready(inicio);
	
	function inicio(){
	
	    var fn_blog = {
        domroot:"#blog",
        blog_list: "#blog-list",
        fillgrid: function(){
               $.ajax({             
                type:"POST", 
                url:"funciones_blog.php", 
                data:{accion:"get_entradas", filtroInformacion : 'blog'},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $(fn_blog.blog_list).empty().append(data.tabla);
                                if($(fn_blog.blog_list + ' .cont').text().length > 150){
                                    limite = $(fn_blog.blog_list + ' .cont').text().substr(0,150)+" ...";
                                    $(fn_blog.blog_list + ' .cont').text(limite);
                                }
                    
                    }
            }); 
        }    
    }
        fn_blog.fillgrid();

	}
	
	
</script>
<div id="layer_content" class="main-section"> 
	<div id="blog" class="container"> 
        <div class="page-title">
            <h1>Blog</h1>
            <h2>Casos más recientes</h2>
        </div>
	<div id="blog-list" class="col-md-8">
	</div>
    <div class="col-md-4"></div>
	</div> 
<?php include("footer.php"); ?> 
</div> 
</body>
</html>