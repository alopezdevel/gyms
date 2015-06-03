<?php
    session_start();  
    include("header.php");
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<div id="layer_content" class="main-section">  
    <div id="blog" class="container"> 
        <div class="page-title">
            <h1>Mi Cuenta</h1>
            <h2>Ver mi Perfil</h2>
        </div>
        <div id="perfil-cuenta" class="row">
            <div class="col-md-4">
                <div class="foto-perfil"><img src="/system/images/usr/foto_perfil.jpg" border="0" width="250" height="230" alt="foto_perfil.jpg"></div>
            
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
    <?php include("footer.php"); ?>  
</body>
</html>