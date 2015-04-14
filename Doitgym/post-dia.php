<?php session_start(); 
include('funciones_consulta.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
<style type="text/css">
@font-face {
    font-family: 'BuxtonSketchRegular';
    src: url('fonts/buxtonsketch.eot');
    src: url('fonts/buxtonsketch.eot') format('embedded-opentype'),
         url('fonts/buxtonsketch.woff') format('woff'),
         url('fonts/buxtonsketch.ttf') format('truetype'),
         url('fonts/buxtonsketch.svg#BuxtonSketchRegular') format('svg');
}

.txt {
	font-family:'BuxtonSketchRegular',Arial, Helvetica, sans-serif;
	font-size:16px;
	color:#333333;
	text-align:center;
}
</style>
</head>
<?php $mensaje_del_dia = Consulta_Comentario_Dia();?>
<body style="margin:0;">
<p class="txt" ><font size="6"> <?php echo $mensaje_del_dia; ?></font></p>
</body>

</html>
