<?php

  session_start();

  ?>

  <script src="lib/jquery/jquery-1.4.2.min.js"></script> 

    <script type="text/javascript" src="lib/jquery/jquery-ui-1.8.4.custom.min.js"></script>

    <script type="text/javascript" src="lib/jquery/shoutbox.js"></script>

  <?php

  //include("header.php"); 

  ?>

  <link rel="stylesheet" href="css/chat/general2.css" type="text/css" media="screen" />

    <body>

        
    <div id="container">

        <span class="clear"></span>

        <div class="content">

            <div id="loading"></div>

            <ul>

            <ul>

        </div>

    </div>
	<form method="post" id="form">

            <table>

                <tr>

                    <td><input class="text" id="mensaje" type="text" MAXLENGTH="255"  placeholder="Mensaje:" style="margin-top:-20px;position:relative;margin-bottom:10px;"/></td>

                </tr>

                <tr>

                    <td><button id="send" type="submit" value="Enviar">Enviar</button></td>

                </tr>

                <tr>

                    <td><input class="text user" id="user" type="text" MAXLENGTH="25" placeholder="Usuario:" style="visibility:hidden;" value="<?php echo $_SESSION['usuario_actual']; ?>" /></td>

                </tr>

            </table>

    </form>

    

</body>


