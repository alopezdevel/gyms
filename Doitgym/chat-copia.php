<?php session_start(); ?>
	<script src="lib/jquery/jquery-1.4.2.min.js"></script> 
    <script type="text/javascript" src="lib/jquery/jquery-ui-1.8.4.custom.min.js"></script>
    <script type="text/javascript" src="lib/jquery/shoutbox.js"></script>
    <link rel="stylesheet" href="css/chat/general.css" type="text/css" media="screen" />

<?php 
include("header.php");
?>

    <div id="content">

        <h1>Mensajes Do it</h1>
        
         <form method="post" id="form">

            <table>

                <tr>

                    <td><label>Usuario:</label></td>

                    <td><input class="text user" id="user" type="text" MAXLENGTH="25" disabled="disabled" value="<?php echo $_SESSION['usuario_actual']; ?>" /></td>

                </tr>

                <tr>

                    <td><label>Mensaje:</label></td>

                    <td><input class="text" id="mensaje" type="text" MAXLENGTH="255" /></td>

                </tr>

                <tr>

                    <td></td>

                    <td><input id="send" type="submit" value="Enviar" /></td>

                </tr>

            </table>

    </form>

    <div id="container">

        <ul class="menu">

            <li>Chat</li>

        </ul>

        <span class="clear"></span>

        <div class="content">

            <h1>Ultimos Mensajes</h1>

            <div id="loading"></div>

            <ul>

            <ul>

        </div>

    </div>


    </div>

</div>

<?php include("footer.php"); ?>
