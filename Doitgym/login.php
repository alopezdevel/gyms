<?php

session_start();

session_unset();

session_destroy();

include("cn_usuarios.php");

if ($dbconn && $dbselect) {  

?>

<script>

function Validar_Login() {                //CONTROL_ACCESO.PHP

    var forma = document.form-login;

    if (forma.txtUsuario.value == "" || forma.txtClaveSecreta.value == ""){

        alert("Favor de llenar ambos campos.");

        return false;

    }

    else {

        return true;

    }

}

</script>

<?php

include("header.php");

?>

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/login.css">
    <div id="content">
        <h1 class="user">PANEL DE CONTROL</h1>
        <div class="txt-content"> 
        <form id="form-login" name="form-login" method="POST" action="acceso.php" onSubmit="return Validar_Login()"> 
                    <div id="caja-gris">                                       
                    <div class="user"><input name="txtUsuario" type="text" placeholder="Usuario:" ></div>
                    <div class="password"><input name="txtClaveSecreta" type="password" placeholder="Contrase&ntilde;a:" ></div>
                    <div><button name="btn_accept" class="btn_accept">Aceptar</button></div>
					</div>
                </form>
        </div> 
    </div>
</div>


<?php include("footer.php"); ?>

<?php }else{

    echo '<script language="javascript"> alert (\'El sistema esta fuera de servicio. \')</script>';

}

?>

