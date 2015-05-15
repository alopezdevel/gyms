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
                    //$(fn_blog.blog_list+" tbody tr:even").addClass('gray');
                    //$(fn_blog.blog_list+" tbody tr:odd").addClass('white');
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
            <h2>Lo mas reciente</h2>
        </div>
	</div>
	<div id="blog-list" class="container">
	</div> 
<?php include("footer.php"); ?> 
</div> 
</body>
</html>