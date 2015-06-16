<?php session_start();
if ( $_SESSION['acceso'] != "U" && $_SESSION['acceso'] != "A" ){ //No ha iniciado session
    header("Location: index.php");
    exit;
}else { 
    include('altas_1.php');    
?>
<?php
if( $_GET['type'] == sha1(md5("Enviar")).md5(sha1("Mail"))  ){
   
        if($_SESSION['usuario_actual'] == "BETO"){
            $usuario_actual = "ADMIN";
        }else{
            $usuario_actual = $_SESSION['usuario_actual'];
        }     
        if($_POST['btn_guardar'] =="1"){
            $duda = "";
            $duda = $_POST['txt_duda'];
            if(1){//insertarDuda($usuario_actual,$duda
                $duda = $_POST['txt_duda'];
                //Enviar Correo
                require_once("./lib/mail.php");
                $arreglo_correo[0] = "alopez@globalpc.net";
                $arreglo_correo[1] = "celina@globalpc.net";
                $cuerpo = '<html>';
                $cuerpo .= '<head>';
                $cuerpo .= '<title>oxygen-fx team</title>';
                $cuerpo .= '</head>';
                $cuerpo .= '<body>';
                $cuerpo .= '<table width="100%" border="0">';
                $cuerpo .= '<tr>';
                $cuerpo .= '<th width="30%">';
                $cuerpo .= '</tr>';
                $cuerpo .= '</table>';
                $mail = new Mail();                                    
                $mail->From = "soporte@oxygen-fx.com";
                $mail->FromName = "oxygen-fx team";
                $mail->Host = "oxygen-fx.com";
                $mail->Mailer = "sendmail";    
                $mail->Subject = "Solicitud soporte sistema"; 
                $mail->Body  = $cuerpo;                                                                                            
                $mail->ContentType ="Content-type: text/html; charset=iso-8859-1";
                $mail->IsHTML(true);
                $mail->WordWrap =150;
                $mail_error = false; 
                $mail->Body  = $cuerpo.'<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber2" height="99" bordercolor="#BEBEBE" bordercolorlight="#BEBEBE" bordercolordark="#808080">
                                        <tr>
                                            <td width="50%" height="19" colspan="2" bgcolor="#0D306C" ><font face="Verdana" size="2">&nbsp; GYM - DUDA </font></td>
                                        </tr>
                                        <tr>
                                            <td width="50%" height="19"><font face="Verdana" size="2">Usuario:</font>&nbsp;<font face ="Verdana" size="2"  color="#336699">&nbsp;  '.$usuario_actual.'</font> </td>
                                        </tr>
                                        <tr>
                                            <td width="50%" height="19"><font face="Verdana" size="2">Duda:</font>&nbsp;<font face ="Verdana" size="2"  color="#336699">&nbsp;  '.$duda.'</font> </td>
                                        </tr>
                                        </table></HTML>';
                $mail->ContentType ="Content-type: text/html; charset=iso-8859-1";
                $mail->IsHTML(true);
                $mail->WordWrap =100;                
                $mail_error = false;
                if (!(empty($arreglo_correo))) {
                    foreach($arreglo_correo as $Correo) {
                        $mail->AddAddress(trim($Correo));
                        if (!$mail->Send()) {
                            $mail_error = true;
                        }
                        $mail->ClearAddresses();
                    }
                } else {
                    $mail_error = true;
                }
               
            }
        }
        header("Location: index.php");
} 
include("header.php");?>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Soporte Tecnico</h1>
            <h2>Necesitas Ayuda con el Sistema? Env&iacute;anos un mensaje</h2>
        </div>
    <form action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Enviar")).md5(sha1("Mail")); ?>" method="POST">
        <div class="txt-content">
            <label>En el siguiente formulario puedes enviar cualquier duda, comentario o reportar alguna falla del sistema:</label>
            <div id="post-dia" class="center">
                <br>                                                                                           
                <textarea size="12" wrap="soft" rows="10" cols="60" name="txt_duda"><?php echo $mensaje_del_dia; ?></textarea>
                <br>
                <label><button class="btn-aceptar" name="btn_guardar" type="submit" value="1">Enviar Correo</button></label>
            </div>
        </div>
    </form>
<?php } ?>
        
        </div>     
        <?php include("footer.php"); ?>
    </div> 
</body>
</html>
