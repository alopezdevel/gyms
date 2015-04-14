<?php session_start(); ?>
<?php 
include("header.php");
?>

<div id="content">
<h1 class="camera">Galería de fotos</h1>
<div class="txt-content"> 
    <br><br>   
    <section class="slider">
        <div id="slider" class="flexslider">
          <ul class="slides">
            <li><img src="js/galeria/imgs/1.jpg"></li>
            <li><img src="js/galeria/imgs/2.jpg"></li>
            <li><img src="js/galeria/imgs/3.jpg"></li>  
            <li><img src="js/galeria/imgs/4.jpg"></li>  
            <li><img src="js/galeria/imgs/5.jpg"></li>  
            <li><img src="js/galeria/imgs/6.jpg"></li>
            <li><img src="js/galeria/imgs/7.jpg"></li>  
            <li><img src="js/galeria/imgs/8.jpg"></li>  
            <li><img src="js/galeria/imgs/9.jpg"></li>
            <li><img src="js/galeria/imgs/12.jpg"></li>  
            <li><img src="js/galeria/imgs/13.jpg"></li>  
            <li><img src="js/galeria/imgs/14.jpg"></li> 
            <li><img src="js/galeria/imgs/15.jpg"></li> 
            <li><img src="js/galeria/imgs/16.jpg"></li> 
            <li><img src="js/galeria/imgs/20.jpg"></li> 
            <li><img src="js/galeria/imgs/23.jpg"></li>  
            <li><img src="js/galeria/imgs/24.jpg"></li>  
            <li><img src="js/galeria/imgs/25.jpg"></li>  
            <li><img src="js/galeria/imgs/31.jpg"></li>         
          </ul>
        </div>
        <div id="carousel" class="flexslider">
          <ul class="slides">
            <li><img src="js/galeria/imgs/1.jpg"></li>
            <li><img src="js/galeria/imgs/2.jpg"></li>
            <li><img src="js/galeria/imgs/3.jpg"></li>  
            <li><img src="js/galeria/imgs/4.jpg"></li>  
            <li><img src="js/galeria/imgs/5.jpg"></li>  
            <li><img src="js/galeria/imgs/6.jpg"></li>
            <li><img src="js/galeria/imgs/7.jpg"></li>  
            <li><img src="js/galeria/imgs/8.jpg"></li>  
            <li><img src="js/galeria/imgs/9.jpg"></li>
            <li><img src="js/galeria/imgs/12.jpg"></li>  
            <li><img src="js/galeria/imgs/13.jpg"></li>  
            <li><img src="js/galeria/imgs/14.jpg"></li> 
            <li><img src="js/galeria/imgs/15.jpg"></li> 
            <li><img src="js/galeria/imgs/16.jpg"></li> 
            <li><img src="js/galeria/imgs/20.jpg"></li> 
            <li><img src="js/galeria/imgs/23.jpg"></li>  
            <li><img src="js/galeria/imgs/24.jpg"></li>  
            <li><img src="js/galeria/imgs/25.jpg"></li>  
            <li><img src="js/galeria/imgs/31.jpg"></li>         
          </ul>
        </div>
      </section>
  <p>Para ver m&aacute;s fotograf&iacute;as y enterarte de lo m&aacute;s actual, s&iacute;guenos en <a href="https://www.facebook.com/doitgym" target="_blank">Facebook</a>!</p>    
  <!-- jQuery -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>
  <!-- FlexSlider -->
  <script defer src="js/gallery/jquery.flexslider.js"></script>
  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 210,
        itemMargin: 5,
        asNavFor: '#slider'
      });
      
      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
  <!-- Syntax Highlighter -->
  <script type="text/javascript" src="js/gallery/demo/js/shCore.js"></script>
  <script type="text/javascript" src="js/gallery/demo/js/shBrushXml.js"></script>
  <script type="text/javascript" src="js/gallery/demo/js/shBrushJScript.js"></script>
  <!-- Optional FlexSlider Additions -->
  <script src="js/gallery/demo/js/jquery.easing.js"></script>
  <script src="js/gallery/demo/js/jquery.mousewheel.js"></script>
  <script defer src="js/gallery/demo/js/demo.js"></script>
<br><br>
</div>
</div>
</div>

<?php include("footer.php"); ?>
