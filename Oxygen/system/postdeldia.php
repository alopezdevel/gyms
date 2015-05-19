<?php session_start();
if ( $_SESSION['acceso'] != "U" && $_SESSION['acceso'] != "A" ){ //No ha iniciado session
    header("Location: index.php");
    exit;
}else { 
    include('altas_1.php');
    include('funciones_consulta.php');
?>
<?php
if( $_GET['type'] == sha1(md5("Insertar")).md5(sha1("Comentario"))  ){
   
        if($_SESSION['usuario_actual'] == "BETO"){
            $usuario_actual = "ADMIN";
        }else{
            $usuario_actual = $_SESSION['usuario_actual'];
        }     
        if($_POST['btn_guardar'] =="1"){
            if(insertarComentarioDelDia($usuario_actual,$_POST['txt_mensaje_dia'])){
            }
        }
        header("Location: postdeldia.php"."?type=".sha1(md5("primera")).md5(sha1("vez")));
} 
include("header.php");
$mensaje_del_dia = Consulta_Comentario_Dia();?>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Utilerias</h1>
            <h2>Mensaje del dia</h2>
        </div>
    <form action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Insertar")).md5(sha1("Comentario")); ?>" method="POST">
        <div class="txt-center">
            <p class="txt-center">En siguiente formulario puedes escribir un mensaje o anuncio para que aparezca en la p&aacute;gina principal del sistema:</p>
            <div id="post-dia" class="center">
                <textarea size="12" wrap="soft" rows="10" cols="60" name="txt_mensaje_dia" style="font-family:buxtonsketch; background: url(index/img_postit.png);border: none;"><?php echo $mensaje_del_dia; ?></textarea>
                <br /><br /><br />
                <label><button class="btn-aceptar" name="btn_guardar" type="submit" value="1">Guardar</button> &nbsp; <button class="btn-cancelar" name="btn_cancelar"  type="submit" value="0">Cancelar</button></label>
            </div>
        </div>
    </form>
    </div>
<?php include("footer.php"); ?>
</div> 
</body>
</html>
<?php }?>
