<!DOCTYPE html>
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
            <li><a href="oxygen_fx.php">Acerca de Oxygen-FX</a></li>
            <li><a href="como_empezar">Como Empezar</a></li>
            <li><a href="galeria/index">Galería</a></li>
            <li class="active"><a href="ubicacion">Ubicación</a></li>
            <li><a href="contacto">Contacto</a></li>
        </ul>
        <a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>
    </div>
</nav><!--main-nav-end-->
<section class="main-section ubicacion" id="ubicacion" style="background:url('images/cont/bg_ubicacion.jpg') center top no-repeat;-moz-background-size: 100% auto;-o-background-size: 100% auto;-webkit-background-size: 100% auto;background-size: 100% auto;"> 
    <div class="container">
        <h2 style="color:#ffffff!important;text-shadow:1px 1px 0px rgba(0,0,0,0.8);">Ubicación</h2>
        <iframe src="https://www.google.com/maps/d/embed?mid=zvKGdIaLBJ8Q.kc-TSAS7m_i0&z=18" width="1000" height="450" frameborder="0" style="border:0">[Su navegador no soporta los marcos flotantes por lo tanto ni podra visualizar el mapa.]</iframe>
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