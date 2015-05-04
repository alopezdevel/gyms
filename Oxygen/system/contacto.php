<?php session_start(); ?>
<?php 
include("header.php");
?>

    <div id="content" style="height:900px!important;">

        <h1 class="mail">Contacto</h1>
        <img class="img" src="images/content/img-contacto.jpg" border="0" alt="img-contacto.jpg (267,516 bytes)">
        <div class="txt-content">
            <h5 style="float: left;">Ponte en Contacto con nosotros:</h5>
        <form id="frm" method="POST" action="http://nlaredo.globalpc.net/cgi-bin/mailform">            
            <input name="Nombre" type="text" placeholder="Nombre">
            <input name="mailto" type="email" placeholder="E-mail">
            <input name="mailto" type="text" placeholder="Telefono">
            <textarea name="Mensaje" cols="20" rows="2" placeholder="Mensaje"></textarea>
            <div class="frm-btns">
                <button class="cancel" type="reset">Cancelar</button>
                <button class="send" type="submit">Enviar</button>
            </div>
        <input name="email" type="hidden" value="doitgym@hotmail.com">
        <input name="subject" type="hidden" value="Contacto - Do it Gym">
        <input name="thanks" type="hidden" value="http://gym.laredo2.net">
        </form>
        <iframe class="right" style="margin-top: -25px;" src="https://mapsengine.google.com/map/embed?mid=zvKGdIaLBJ8Q.krcnb8Vmypgc" width="600" height="360" border="0" frameborder="0" marginheight="0" marginwidth="0" name="iframeubicacion" scrolling="no"></iframe> 
        </div>
         
    </div>

</div>

<?php include("footer.php"); ?>
