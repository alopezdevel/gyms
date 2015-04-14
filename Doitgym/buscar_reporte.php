<script>
function Validar_Reporte() {
    var forma = document.frmReportesFiltro;
    if ( !forma.chkFiltro1.checked && !forma.chkFiltro2.checked && !forma.chkFiltro3.checked ){
        alert("Favor de escoger al menos una opción.");
        return false;
    }else {
        return true;
    }
}
function Habilitar_Campo_Filtro_1(){
    var forma = document.frmReportesFiltro;
    if (forma.chkFiltro1.checked) {
        forma.txtFiltro1.disabled = false;
        forma.txtFiltro1.focus();
    } else {
        forma.txtFiltro1.disabled = true;
    }    
}
function Habilitar_Campo_Filtro_2(){
    var forma = document.frmReportesFiltro;
    if (forma.chkFiltro2.checked) {
        forma.txtFechaInicial.disabled = false;
        forma.txtFechaFinal.disabled = false;
        forma.txtFechaInicial.focus();
    } else {
        forma.txtFechaInicial.disabled = true;
        forma.txtFechaFinal.disabled = true;
    }    
}
function Habilitar_Campo_Filtro_3(){
    var forma = document.frmReportesFiltro;
    if (forma.chkFiltro3.checked) {
        forma.txtFiltro3.disabled = false;
        forma.txtFiltro3.focus();
    } else {
        forma.txtFiltro3.disabled = true;
    }    
}
function Habilitar_Campo_Filtro_4(){
    var forma = document.frmReportesFiltro;
    if (forma.chkFiltro4.checked) {
        forma.txtFiltro4.disabled = false;
        forma.txtFiltro4.focus();
    } else {
        forma.txtFiltro4.disabled = true;
    }    
}
function Habilitar_Campo_Filtro_5(){
    var forma = document.frmReportesFiltro;
    if (forma.chkFiltro5.checked) {
        forma.txtFiltro5.disabled = false;
        forma.txtFiltro5.focus();
    } else {
        forma.txtFiltro5.disabled = true;
    }    
}
</script>

  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="98%" colspan="2">
    <form action="<?php echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Buscar")).md5(sha1("Trafico"));?>" method="POST" name="frmReportesFiltro" onSubmit="return Validar_Reporte()">
      <table border="1"   cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber2" bordercolor="" bordercolorlight="" bordercolordark="">
        <tr>
          <td width="5%">&nbsp;</td>
          <td width="22%"><font face="Verdana"></font></td>
          <td width="73%">&nbsp;</td>
        </tr>
        <tr>
          <td width="5%">&nbsp;</td>
          <td width="22%"><font face="Verdana">
            <input name="chkFiltro1" type="checkbox" id="chkFiltro1" onClick="return Habilitar_Campo_Filtro_1()"
          <?php
            if ( !(empty($_POST['chkFiltro1'])) ) { 
                echo "checked";
            }
          ?>>
            <font color="#0D306C" size="2">Cliente:</font></font> </td>
          <td width="73%"><?php if ( count($arr_clientes) > 0 ) { ?>
              <select name="selCliente" id="selCliente"
            <?php
                if ( empty($_POST['chkCliente']) ) { 
                    echo "disabled";
                }
            ?>
              >
                <option value="*" <?php if ($_POST['selCliente'] == '*') { echo 'selected';} ?> >Todos los clientes</option>
                <?php foreach ($arr_clientes as $Cliente) {?>
                <option value="<?php echo $Cliente["cve_cliente"] ?>" 
                            <?php 
                                if ( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Trafico")) || $_GET['type'] == sha1(md5("cargar")).md5(sha1("proveedores")) ){
                                    if ($_POST['selCliente'] == $Cliente["cve_cliente"]) {
                                        echo "selected";
                                    }
                                }
                            ?> >
                            <?php 
                                if ($Cliente["alias"] == "") {
                                    echo getTruncarCampoCombo($Cliente["razon_social"]);
                                } else {
                                    echo getTruncarCampoCombo($Cliente["razon_social"])." (".$Cliente["alias"].")";
                                }
                            ?>
                </option>
                <?php } ?>
              </select>
              <?php } ?>
          </td>
        </tr>
      
        
        <tr>
          <td width="5%">&nbsp;</td>
          <td width="22%"><font face="Verdana">
            <input type="checkbox" name="chkFiltro2" onClick="return Habilitar_Campo_Filtro_2()"
          <?php
            if ( !(empty($_POST['chkFiltro2'])) ) { 
                echo "checked";
            }
          ?>>
            <font color="#0D306C" size="2">Filtro Fecha :</font></font> </td>
          <td width="73%"><input type="text" name="txtFechaInicial" size="15" maxlength="10"
          <?php
            if ( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Trafico")) || $_GET['type'] == sha1(md5("cargar")).md5(sha1("proveedores")) ){
                echo ' value="'.$_POST['txtFechaInicial'].'"';
            }
            
            if ( $_GET['type'] == sha1(md5("nueva")).md5(sha1("busqueda")) || empty($_POST['chkFiltro2']) ){     //Acaba de cargarse por primera vez la página
                echo "disabled";
            }
          ?>>
              <?php //<a href="javascript:showCal('Calendar2')"><img border="0" src="images/calendar.gif" width="18" height="18"></a>?>
              <font face="Verdana" size="2">a</font>
              <input type="text" name="txtFechaFinal" size="15" maxlength="10"
          <?php
            if ( $_GET['type'] == sha1(md5("Buscar")).md5(sha1("Trafico")) || $_GET['type'] == sha1(md5("cargar")).md5(sha1("proveedores")) ){
                echo ' value="'.$_POST['txtFechaFinal'].'"';
            }

            if ( $_GET['type'] == sha1(md5("nueva")).md5(sha1("busqueda")) || empty($_POST['chkFecha']) ){     //Acaba de cargarse por primera vez la página
                echo "disabled";
            }
          ?>>
              <?php //<a href="javascript:showCal('Calendar3')"><img border="0" src="images/calendar.gif" width="18" height="18"></a>?>
              <font face="Verdana" size="2" color="#336699"> (dd/mm/aaaa)</font> </td>
        </tr>
        
        
        <tr>
              <td width="5%">&nbsp;</td>
              <td width="22%"><font face="Verdana">
              <font color="#0D306C" size="2"><input type="checkbox" name="chkFiltro3" onClick="return Habilitar_Campo_Filtro_3()"
              <?php
                if ( !(empty($_POST['chkFiltro3'])) ) { 
                    echo "checked";
                }                  
              ?>>
                <font color="#0D306C" size="2">Filtro 3:</font></font> </td>
                <td width="73%"><input type="text" name="txtFiltro3" size="50" maxlength="50"
              <?php
                if ( $_GET['type'] == sha1(md5("Generar")).md5(sha1("Reporte")) || $_GET['type'] == sha1(md5("cargar")).md5(sha1("proveedores")) ){
                    echo ' value="'.$_POST['txtFiltro3'].'"'; 
                } 
                
                if ( $_GET['type'] == sha1(md5("nueva")).md5(sha1("busqueda")) || empty($_POST['chkFiltro3']) ){     //Acaba de cargarse por primera vez la página
                    echo "disabled";
                }            
              ?>>           
       </tr>
       <tr>
              <td width="5%">&nbsp;</td>
              <td width="22%"><font face="Verdana">
              <font color="#0D306C" size="2"><input type="checkbox" name="chkFiltro4" onClick="return Habilitar_Campo_Filtro_4()"
              <?php
                if ( !(empty($_POST['chkFiltro4'])) ) { 
                    echo "checked";
                }                  
              ?>>
                <font color="#0D306C" size="2">Filtro 4:</font></font> </td>
                <td width="73%"><input type="text" name="txtFiltro4" size="50" maxlength="50"
              <?php
                if ( $_GET['type'] == sha1(md5("Generar")).md5(sha1("Reporte")) || $_GET['type'] == sha1(md5("cargar")).md5(sha1("proveedores")) ){
                    echo ' value="'.$_POST['txtFiltro4'].'"'; 
                } 
                
                if ( $_GET['type'] == sha1(md5("nueva")).md5(sha1("busqueda")) || empty($_POST['chkFiltro4']) ){     //Acaba de cargarse por primera vez la página
                    echo "disabled";
                }            
              ?>>           
       </tr>
       <tr>
              <td width="5%">&nbsp;</td>
              <td width="22%"><font face="Verdana">
              <font color="#0D306C" size="2"><input type="checkbox" name="chkFiltro5" onClick="return Habilitar_Campo_Filtro_5()"
              <?php
                if ( !(empty($_POST['chkFiltro5'])) ) { 
                    echo "checked";
                }                  
              ?>>
                <font color="#0D306C" size="2">Filtro 5:</font></font> </td>
                <td width="73%"><input type="text" name="txtFiltro5" size="50" maxlength="50"
              <?php
                if ( $_GET['type'] == sha1(md5("Generar")).md5(sha1("Reporte")) || $_GET['type'] == sha1(md5("cargar")).md5(sha1("proveedores")) ){
                    echo ' value="'.$_POST['txtFiltro5'].'"'; 
                } 
                
                if ( $_GET['type'] == sha1(md5("nueva")).md5(sha1("busqueda")) || empty($_POST['chkFiltro5']) ){     //Acaba de cargarse por primera vez la página
                    echo "disabled";
                }            
              ?>>           
       </tr>          
      </table>
      <p align="center"><input type="submit" value="Buscar" name="btnBuscar"></p>
    </form>
    </td>
    <td width="1%">&nbsp;</td>
  </tr>