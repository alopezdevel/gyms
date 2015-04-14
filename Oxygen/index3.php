<?php

session_start();  



include("header.php");

?>



    <div id="index-content">  
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>  
        <div id="slider-container">
        <div id="container" >
            <div id="billy_clip">
                <ul id="billy_scroller">
                     <li><a href="como_empezar.php"><img src="js/slider-index/imgs/1.png" width="1175" height="450" alt="Do it GYM"></a></li>
                     <li><a href="galeria.php"><img src="js/slider-index/imgs/2.jpg" width="1175" height="450" alt="Do it GYM"></a></li>
                     <li><a href="horarios.php"><img src="js/slider-index/imgs/3.png" width="1175" height="450" alt="Do it GYM - Horarios"></a></li> 
                     <li><a href="membresia_doit.php"><img src="js/slider-index/imgs/2.png" width="1175" height="450" alt="Do it GYM"></a></li>
                     <li><a href="horarios.php"><img src="js/slider-index/imgs/4.png" width="1175" height="450" alt="Do it GYM - Horarios"></a></li>  
                 </ul>    
             </div>
            <ul id="billy_indicators"></ul>
        </div>
        </div>
        <div class="horarios" style="display: none;">
            <div id="horarios-container">
                <span>Lunes / Viernes</span><br> de 6:30am-11:00pm <br>
                <br><span>Sabado / Domingo</span><br>de 9:00 am a 3:00 pm
                <br>
                <a href="horarios.php" class="btn-red btn-animacion" style="position: relative;top:8px;">Horario de Clases</a>      
            </div>
            <div style="float: right;margin-top: -30px;" class="fb-follow" data-href="https://www.facebook.com/doitgymnuevolaredo" data-width="200px" data-height="30px" data-colorscheme="dark" data-layout="standard" data-show-faces="true"></div>
        </div>
    </div>
    <div class="temp"> BIENVENIDO A DO IT GYM <br> Fitness & Muscle Factory</div>

</div>

<?php include("footer.php"); ?>
