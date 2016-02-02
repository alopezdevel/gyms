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
            <li><a href="oxygen_fx">Acerca de Oxygen-FX</a></li>
            <li class="active"><a href="como_empezar">Como Empezar</a></li>
            <li><a href="galeria/index">Galería</a></li>
            <li><a href="ubicacion">Ubicación</a></li>
            <li><a href="contacto">Contacto</a></li>
        </ul>
        <a class="res-nav_click right" href="#"><i class="fa-bars"></i></a>
    </div>
</nav><!--main-nav-end-->
<!--- HEADER----->
<div class="header section-comenzar">
    <h1 class="wow animated fadeInLeft delay-02s">Como Empezar</h1>
    <h3 class="wow animated fadeInRight delay-03s">No siempre amaras el ejercicio, pero lo que siempre amaras es el resultado.</h3>
</div>
<!--- TERMINA HEADER ---->
<div class="section-comenzar">
<div class="line"></div>
<section class="main-section"><!--main-section-start-->
    <div class="container"> 
        <div class="col_1 left wow fadeInUp delay-03s" style="width:67%;">
            <h2>¿Cómo puedo empezar?</h2>
            <p>Puedes <a href="#ubicacion">visitarnos</a>, <a href="contacto">llamarnos</a> o <a href="contacto">enviarnos un correo electrónico</a>.</p>
            <h2>¿Puedo asistir para ver una clase o hacer algunas preguntas?</h2>
            <p>Claro!, Nos encantaria recibirte en cualquier momento para ver una clase y ver cómo se hace.</p>
            <h2>¿Tengo que estar en forma?</h2>
            <p>NO, para cualquier sesión de ejercicios nuestro cuerpo se debe ir adaptando para alcanzar la habilidad necesaria.</p>
            <h2>¿Importa la edad?</h2>
            <p>NO, tenemos CrossFitters de todas las edades desde 18 a 60 años!.</p>
            <h2>¿Qué ropa es la adecuada y que debo llevar?</h2>
            <p>Ropa y tenis cómodos y no olvides traer algo de agua..</p>
            <h2>¿Es normal sentirse nervioso?</h2>
            <p>SÍ, a todo el mundo que entra por la puerta la primera vez es muy nervioso..</p>
        </div>
        <div class="col_3 left wow fadeInUp delay-03s">
            <img src="images/cont/img_comenzar.jpg" border="0" width="400" height="500" alt="img_comenzar.jpg (140,825 bytes)">
            <div class="bann">
                <img src="images/home/img-home-3.png" alt="">
                <h3>Consulta tu membresía</h3>
                <ul>
                    <li><a href="system/login.php"><strong>» </strong>Consultar estado actual</a></li>
                    <li><a href="system/login.php"><strong>» </strong>Consultar pagos realizados</a></li>
                </ul>
            </div>
        </div>          
    </div>
</section>
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
