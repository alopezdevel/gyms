<?php

session_start();  



include("header.php");

?>



    <div id="index-content">

    

        <div id="slider-container">

            <iframe id="I1" name="I1" border="0" frameborder="0" height="284" marginheight="0" marginwidth="0" scrolling="no" src="js/slider-index/index.html" width="710">

            Your browser does not support inline frames or is currently configured not to display inline frames.

            </iframe>

        </div>

        <div class="horarios">

            <div id="horarios-container">

                8:30am Zumba - ROii Garzaa

                <br>9:30am Insanity - Karina Perez

                <br>6:15pm Zumba - Zin Fer Esparza

                <br>7:15pm Combat - Juan Torres

                <br>7:30pm Insanity T25 - Karina Perez 

                <br>7:30pm Spinning - VeronIca Lopez

                <br>8:15pm Zumba - Roii Garza 

                <br>9:15pm Insanity - Karina Perez         

            </div>

        </div>
	
 </div>
    <div id="banners-container">
    
    	<div id="fb-root"></div>
		<script>(function(d, s, id) {
 		 var js, fjs = d.getElementsByTagName(s)[0];
 		 if (d.getElementById(id)) return;
 		 js = d.createElement(s); js.id = id;
 		 js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1";
 		 fjs.parentNode.insertBefore(js, fjs);
		 }(document, 'script', 'facebook-jssdk'));</script>
		<table style="width: 100%">
			<tr>
				<td>
				<div class="fb-like-box" style="background:#2b2b2b;border: 1px solid #0d0d0d;" data-href="http://www.facebook.com/doitgymnuevolaredo" data-width="330" data-height="220" data-colorscheme="dark" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>
				</td>
				<td></td>
				<td class="post-dia">
				<iframe border="0" frameborder="0" marginheight="0" marginwidth="0" name="iframe5" scrolling="no" src="post-dia.php"></iframe></td>
				<td>&nbsp;</td>
				<td class="anuncio-dia">&nbsp;</td>
			</tr>
		</table>
	
	</div>

</div>

<?php include("footer.php"); ?>
