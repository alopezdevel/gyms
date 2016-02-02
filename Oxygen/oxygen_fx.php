﻿<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">

<title>Oxygen-FX Crossfit</title>
<link rel="icon" href="images/favicon.png" type="image/png">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<link href="css/animate.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="js/jquery.1.8.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jquery-scrolltofixed.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.isotope.js"></script>
<script type="text/javascript" src="js/wow.js"></script>
<script type="text/javascript" src="js/classie.js"></script>


    <!-----SLIDER HOMEPAGE----->
    <link rel='stylesheet' id='camera-css'  href='slide/css/camera.css' type='text/css' media='all'>     
    <script type='text/javascript' src='slide/scripts/jquery.min.js'></script>
    <script type='text/javascript' src='slide/scripts/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='slide/scripts/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='slide/scripts/camera.js'></script> 
    <script type='text/javascript' src='slide/scripts/script.js'></script>


</head>
<body>
<div style="overflow:hidden;" id="home">
<nav class="main-nav-outer" id="test"><!--main-nav-start-->
    <div class="container">
        <a href="./" class="img-logo"><img  src="images/img-logo.png" alt="logo"></a>
        <ul class="top-nav">
			<li class="i-login"><a href="system/login.php" title="Iniciar Sesion" target="_blank"><span><i class="fa fa-user"></i></span></a></li>
			<li class="i-facebook"><a href="https://www.facebook.com/OxigenFEX" title="Siguenos en Facebook!" target="_blank"><span><i class="fa fa-facebook"></i></span></a></li>
			<li class="i-youtube"><a href="https://www.youtube.com/CrossfitOxygenFX8" title="Siguenos en YouTube!" target="_blank"><span><i class="fa fa-youtube"></i></span></a></li>
			<li class="i-instagram"><a href="https://www.instagram.com/pavorendon/" title="Siguenos en Instagram!"><span><i class="fa fa-instagram"></i></span></a></li>
		</ul>
        <ul class="main-nav">
            <li><a href="./">Inicio</a></li>
            <li class="active"><a href="oxygen_fx.php">Acerca de Oxygen-FX</a></li>
            <li><a href="como_empezar">Como Empezar</a></li>
            <li><a href="galeria/index">Galería</a></li>
            <li><a href="ubicacion">Ubicación</a></li>
            <li><a href="contacto">Contacto</a></li>
        </ul>
        <a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>
    </div>
</nav><!--main-nav-end-->
<!--- HEADER----->
<div class="header section-oxygenfx">
    <h1 class="wow animated fadeInLeft delay-02s">OXYGEN-FX CROSSFIT</h1>
    <h3 class="wow animated fadeInRight delay-03s">Cada dia vamos a probarte, cada día vamos a impulzarte mas.</h3>
</div>
<!--- TERMINA HEADER ---->
<div class="section-oxygenfx">
<div class="line"></div>
<section class="main-section"><!--main-section-start-->
    <div class="container"> 
        <div class="center wow fadeInUp delay-03s txt-justify">
            <p>Esta Bodega como muchos le llaman, no tiene la apariencia de un gimnasio comun y corriente al que estamos acostrumbrados. No existen ni espejos ni maquinas, asi como tampoco dispone de bicicletas fijas, caminadoras, ni estantes cargados de mancuernas.
            <br><br>El "Box" o lugar donde se llevan acado nuestros entrenamientos, es un espacio abierto con suelo de goma que parecen rompecabezas, sin aire acondicionado, el techo es tan alto que parecera que estas dentro de una fabrica o bodega en l cual no sabes lo que te espera, hay barras, cajas de madera, cuerdas, sogas, aros, estructuras sin sentido, entre otros materiales especiales perfectamente acomodados para su uso.</p>
        </div>
        <div class="col_3 left wow fadeInUp delay-03s">
            <img src="images/cont/img_oxygen.jpg" border="0" width="400" height="500" alt="img_comenzar.jpg (140,825 bytes)">
        </div> 
        <p class="left txt-justify" style="width:67%;padding-left: 10px;;">
            Muchos han probado todo tipo de ejercicios, rutinas y entrenamientos, pero te toma únicamente unas cuantas clases comprender por qué este lugar se convierte en la pasión de muchos y lo llamamos "Oxygenos". Por raro que suene...cuanto te encuentras a la mitad de un WOD (Trabajo del día), el mejor consuelo es que casi termina. Sin embargo, sabes que lo vas a conseguir porque nadie lo puede dejar a medias y hay personas a tu alrededor que te alientan para terminarlo como una sola familia o grupo.
            <br><br><strong>Una de las razones del por qué vale la pena vivir esta experiencia</strong> es que, en realidad, tu no compites contra tus compañeros sino contigo mismo, con el atleta que todos llevamos dentro.
            <br><br><strong>Oxygen FX</strong>, se convierte en un lugar en donde cada una de las personas que lo conforman tiene una razón diferente para hacerlo y día a día ser mejores.
            <br><br>En OXYGEN FX lograras transformar tu cuerpo y tu vida de una manera que creerás que puede ser posible llevando tu esfuerzo al límite, al extremo, hasta convertirse en un Oxygeno.
            <br><br><span><strong class="txt-center">Te invitamos a que vivas la experiencia y cambies tu vida!! </strong></span>
        </p>         
    </div>
</section>
</div>
<footer class="footer">
    <div class="container"> 
        Oxygen-FX Crossfit. © Copyright 2015.        
       </div>
</footer>

<script type="text/javascript">
    $(document).ready(function(e) {
        $('#test').scrollToFixed();
        $('.res-nav_click').click(function(){
            $('.main-nav').slideToggle();
            return false    
            
        });
        
    });
</script>

  <script>
    wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100
      }
    );
    wow.init();
  </script>


<script type="text/javascript">
    $(window).load(function(){
        
        $('a').bind('click',function(event){
            var $anchor = $(this);
            
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - 80
            }, 1500,'easeInOutExpo');
            /*
            if you don't want to use the easing effects:
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1000);
            */
            event.preventDefault();
        });
    })
</script>

<script type="text/javascript">

$(window).load(function(){
  
  
  var $container = $('.portfolioContainer'),
      $body = $('body'),
      colW = 375,
      columns = null;

  
  $container.isotope({
    // disable window resizing
    resizable: true,
    masonry: {
      columnWidth: colW
    }
  });
  
  $(window).smartresize(function(){
    // check if columns has changed
    var currentColumns = Math.floor( ( $body.width() -30 ) / colW );
    if ( currentColumns !== columns ) {
      // set new column count
      columns = currentColumns;
      // apply width to container manually, then trigger relayout
      $container.width( columns * colW )
        .isotope('reLayout');
    }
    
  }).smartresize(); // trigger resize to set container width
  $('.portfolioFilter a').click(function(){
        $('.portfolioFilter .current').removeClass('current');
        $(this).addClass('current');
 
        var selector = $(this).attr('data-filter');
        $container.isotope({
            
            filter: selector,
         });
         return false;
    });
  
});

</script>
</body>
</html>