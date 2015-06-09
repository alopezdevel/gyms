<?php
    session_start();
    include("globals.php");
    if ( $_SESSION['acceso'] != "A" ){
         header("Location: index.php");
        exit;
    } else {
        //---- inicio de filtros y orden de campos en la consulta ----//
            if (isset($_POST["hidOrdenarPor"])){
                $_SESSION['Orden']['socios']['hidOrdenarPor'] = $_POST["hidOrdenarPor"];
                $_SESSION['Orden']['socios']['hidOrdenarAscDesc'] = $_POST["hidOrdenarAscDesc"];            
            } else {
                $_POST["hidOrdenarPor"] = $_SESSION['Orden']['socios']['hidOrdenarPor'];
                $_POST["hidOrdenarAscDesc"] = $_SESSION['Orden']['socios']['hidOrdenarAscDesc'];            
            }
            if (isset($_POST["Filtrar"])) {
                $_SESSION['Filtros']['socios']['txtClaveDelSocio'] = $_POST["txtClaveDelSocio"];
                $_SESSION['Filtros']['socios']['txtNombreDelSocio'] = $_POST["txtNombreDelSocio"];
                $_SESSION['Filtros']['socios']['txtCorreo'] = $_POST["txtCorreo"];
            } else {
                $_POST["txtClaveDelSocio"] = $_SESSION['Filtros']['socios']['txtClaveDelSocio'];
                $_POST["txtNombreDelSocio"] = $_SESSION['Filtros']['socios']['txtNombreDelSocio'];
                $_POST["txtCorreo"] = $_SESSION['Filtros']['socios']['txtCorreo'];
            }
        //---- fin de filtros y orden de campos en la consulta ----//

        if ( $_GET['type'] == sha1(md5("cargar")).md5(sha1("pagina")).sha1(md5("primera")).md5(sha1("vez")) ){
            $_SESSION["limite_inferior_datos_grid"] = 0;
            $_SESSION["paginacion_actual"] = 1;
        }
        
        //ESTA FUNCION SE HACE PARA SABER EL NUMERO TOTAL DE PAGINAS QUE TIENE LA CONSULTA GENERAL
            $contador_consulta_transportistas_mexicanos = getCount_Consulta_Socios($_POST["txtClaveDelSocio"], $_POST["txtNombreDelSocio"], $_POST["txtNombreDelSocio"]);
            $x = 0;
            for ($i = 1; $i <= $contador_consulta_transportistas_mexicanos; $i = $i + $_SESSION["bloque_datos_grids"] ) {
                $x++;
            }
        //SE UTILIZA CUANDO SE OPRIME EL BOTON DE LA ULTIMA PAGINA (FINAL) PARA MOSTRAR EL NUMERO DE PAGINA EN EL COMBO BOX Y PARA DESHABILITAR LOS BOTONES DE SIGUIENTE Y DE ULTIMA PAGINA
        
        if ( isset($_GET['cve_pag']) ) {
            switch ($_GET['cve_pag']) {
                case sha1(md5("inicio")):        $_SESSION["limite_inferior_datos_grid"] = 0;
                                                $_SESSION["paginacion_actual"] = 1;
                    break;
                case sha1(md5("anterior")):        $_SESSION["limite_inferior_datos_grid"] = $_SESSION["limite_inferior_datos_grid"] - $_SESSION["bloque_datos_grids"];
                                                $_SESSION["paginacion_actual"] = $_SESSION["paginacion_actual"] - 1;
                    break;
                case sha1(md5("siguiente")):    $_SESSION["limite_inferior_datos_grid"] = $_SESSION["limite_inferior_datos_grid"] + $_SESSION["bloque_datos_grids"];
                                                $_SESSION["paginacion_actual"] = $_SESSION["paginacion_actual"] + 1;
                    break;
                case sha1(md5("final")):        $_SESSION["limite_inferior_datos_grid"] = $_SESSION["bloque_datos_grids"] * ($x - 1);
                                                $_SESSION["paginacion_actual"] = $x;
                    break;
                case sha1(md5("pagina")):        if ( intval($_GET['pag']) == 0 ) {        //PORQUE PUEDE SER QUE EL USUARIO MODIFIQUE EL URL PORQUE EL NUMERO DE LA PAGINA NO VIENE ENCRIPTADA, (si no es numero la variable get de PAG entonces se convierte con el intval en '0', si escogio la la p�gina 1 del combo, entonces tambien tenemos que resetear el limit en 0, para que traiga el primer bloque)
                                                    $_SESSION["limite_inferior_datos_grid"] = 0;
                                                    $_SESSION["paginacion_actual"] = 1;
                                                } else {
                                                    $_SESSION["limite_inferior_datos_grid"] = $_SESSION["bloque_datos_grids"] * (intval($_GET['pag']) - 1);
                                                    $_SESSION["paginacion_actual"] = intval($_GET['pag']);
                                                }
                    break;
                default:                        $_SESSION["limite_inferior_datos_grid"] = 0;
                                                $_SESSION["paginacion_actual"] = 1;
                    break;
            }
        }
        
        if ( $_SESSION["limite_inferior_datos_grid"] < 0 ) {
            $_SESSION["limite_inferior_datos_grid"] = 0;    //PORQUE PUEDE DARSE EL CASO EN QUE LE OPRIMAS AL BOTON DE ULTIMA PAGINA Y DESPUES LE DES ANTERIOR, ANTERIOR, ANTERIOR Y NO NECESARIAMENTE SE TIENE QUE PONER EN '0' EL VALOR DEL LIMITE INFERIOR, PORQUE AL OPRIMIR EL BOTON DE ULTIMA PAGINA PUEDE DARSE EL CASO DE QUE SEA UN NUMERO NO MULTIPLO DE LO QUE SE TIENE FIJO POR MOSTRAR ($_SESSION["bloque_datos_grids"]) Y ELLO PUEDE PROVOCAR QUE EL LIMITE INFERIOR SEA UN NUMERO NEGATIVO, LO CUAL HARIA TRONAR AL PROGRAMA
        }

        Consulta_Transportistas_Mexicanos($_POST["txtFiltroClave"], $_POST["txtFiltroRFC"], $_POST["txtFiltroNombre"], $_POST["hidOrdenarPor"], $_POST["hidOrdenarAscDesc"], $_SESSION["limite_inferior_datos_grid"], $_SESSION["bloque_datos_grids"], $arr_trans_mex_general);
        
        if ( $_GET['type'] == sha1(md5("nuevo")).md5(sha1("transportista")) || $_GET['type'] == sha1(md5("editar")).md5(sha1("transportista"))){
            $_SESSION["tipo_almacenamiento"] = $_GET['type'];
        }

        if ( $_GET['type'] == sha1(md5("editar")).md5(sha1("transportista")) || $_GET['type'] == sha1(md5("consultar")).md5(sha1("transportista")) ) {
            if ( count($arr_trans_mex_general) > 0 ) {
                foreach( $arr_trans_mex_general as $Element ) {
                    if (sha1(md5($Element["clave"]))==$_GET['cve']) {
                           break;
                    }
                }
            }
            getTransportistaMexicano($Element["clave"], $arr_trans_mexicano);
            
            $_SESSION["clave_transportista_mexicano"] = "";
            $_SESSION["nombre_transportista_mexicano"] = "";
            

            $_SESSION["clave_transportista_mexicano"] = $arr_trans_mexicano[0]["clave"]; 
            $_SESSION["nombre_transportista_mexicano"] = $arr_trans_mexicano[0]["nombre"];
            
            
            $valor_clave = $arr_trans_mexicano[0]["clave"];
            $valor_rfc = $arr_trans_mexicano[0]["rfc"];
            $valor_curp = $arr_trans_mexicano[0]["curp"];
            $valor_nombre = $arr_trans_mexicano[0]["nombre"];
            $valor_numero_CAAT = $arr_trans_mexicano[0]["CAAT"];
            $valor_numero_SCAAT = $arr_trans_mexicano[0]["SCAC"];

            $valor_nombre_contacto = $arr_trans_mexicano[0]["nombre_contacto"];
            $valor_cuenta_correo_contacto = $arr_trans_mexicano[0]["cuenta_correo_contacto"];
            $valor_telefono_contacto = $arr_trans_mexicano[0]["telefono_contacto"];
            $valor_nextel_contacto = $arr_trans_mexicano[0]["nextel_contacto"];
            
            $valor_calle_fiscal = $arr_trans_mexicano[0]["calle_fiscal"];
            $valor_numero_int_fiscal = $arr_trans_mexicano[0]["num_int_fiscal"];
            $valor_numero_ext_fiscal = $arr_trans_mexicano[0]["num_ext_fiscal"];
            $valor_colonia_fiscal = $arr_trans_mexicano[0]["colonia_fiscal"];
            $valor_cp_fiscal = $arr_trans_mexicano[0]["cp_fiscal"];
            $valor_ciudad_fiscal = $arr_trans_mexicano[0]["ciudad_fiscal"];
            $valor_calle_patio = $arr_trans_mexicano[0]["calle_patio"];
            $valor_numero_int_patio = $arr_trans_mexicano[0]["num_int_patio"];
            $valor_numero_ext_patio = $arr_trans_mexicano[0]["num_ext_patio"];
            $valor_colonia_patio = $arr_trans_mexicano[0]["colonia_patio"];
            $valor_cp_patio = $arr_trans_mexicano[0]["cp_patio"];
            $valor_ciudad_patio = $arr_trans_mexicano[0]["ciudad_patio"];
            $valor_comentarios_patio = $arr_trans_mexicano[0]["comentarios_patio"];
            $valor_nombre_archivo = $arr_trans_mexicano[0]["archivo_patio"];
        } else {
            $valor_clave = $_POST["txtID"];
            $valor_rfc = $_POST["txtRFC"];
            $valor_curp = $_POST["txtCURP"];
            $valor_nombre = $_POST["txtNombre"];
            $valor_numero_CAAT = $_POST["numero_caat"];
            $valor_numero_SCAAT = $_POST["numero_scaat"];
            
            $valor_nombre_contacto = $_POST["nombre_contacto"];
            $valor_cuenta_correo_contacto = $_POST["cuenta_correo_contacto"];
            $valor_telefono_contacto = $_POST["telefono_contacto"];
            $valor_nextel_contacto = $_POST["nextel_contacto"];

            $valor_calle_fiscal = $_POST["txtCalleFiscal"];
            $valor_numero_int_fiscal = $_POST["txtNumIntFiscal"];
            $valor_numero_ext_fiscal = $_POST["txtNumExtFiscal"];
            $valor_colonia_fiscal = $_POST["txtColoniaFiscal"];
            $valor_cp_fiscal = $_POST["txtCPFiscal"];
            $valor_ciudad_fiscal = $_POST["txtCiudadFiscal"];
            $valor_calle_patio = $_POST["txtCallePatio"];
            $valor_numero_int_patio = $_POST["txtNumIntPatio"];
            $valor_numero_ext_patio = $_POST["txtNumExtPatio"];
            $valor_colonia_patio = $_POST["txtColoniaPatio"];
            $valor_cp_patio = $_POST["txtCPPatio"];
            $valor_ciudad_patio = $_POST["txtCiudadPatio"];
            $valor_comentarios_patio = $_POST["txtComentariosPatio"];
            $valor_nombre_archivo = $_POST["archivo_patio"];
        }
                
        if ( $_GET['type'] == sha1(md5("borrar")).md5(sha1("transportista")) ){ //borrar
            if ( count($arr_trans_mex_general) > 0 ) {
                foreach( $arr_trans_mex_general as $Element ) {
                    if (sha1(md5($Element["clave"]))==$_GET['cve']) {
                        break;
                    }
                }
            }
            include("bajas.php");
            if ( borrarTransportistaMexicano($Element["clave"], $Element["nombre"]) ) {
                header("Location: ".$_SERVER['PHP_SELF']."?type=".sha1(4)."&cve=".sha1('-'));
                exit;
            }
         }
        if ( $_GET['type'] == sha1(md5("Guardar")).sha1(md5("nuevo")).md5(sha1("transportista")) ){ //Insertar o editar un proveedor
            include("altas.php");
            if (insertarTransportistaMexicano($valor_clave, $valor_rfc, $valor_curp, $valor_nombre, $valor_numero_CAAT,$valor_numero_SCAAT, $valor_nombre_contacto, $valor_cuenta_correo_contacto, $valor_telefono_contacto, $valor_nextel_contacto, $valor_calle_fiscal, $valor_numero_int_fiscal, $valor_numero_ext_fiscal, $valor_colonia_fiscal, $valor_cp_fiscal, $valor_ciudad_fiscal, $valor_calle_patio, $valor_numero_int_patio, $valor_numero_ext_patio, $valor_colonia_patio, $valor_cp_patio, $valor_ciudad_patio, $valor_comentarios_patio, $_FILES['filCroquis'])) {
                Consulta_Transportistas_Mexicanos("", "", "", "", "", "NULO", "NULO", $arr_trans_mex_general_comparar);    //para saber en donde es que se ubic� el nuevo registro seg�n el ORDER BY
                if ( count($arr_trans_mex_general_comparar) > 0 ) {
                    for( $i=0; $i < count($arr_trans_mex_general_comparar); $i++) {                    
                        if ( sha1(md5($arr_trans_mex_general_comparar[$i]["clave"])) == sha1(md5(strtoupper(trim($valor_clave)))) ) {
                            break;
                        }
                    }

                    $pagina_actual = intval(($i+1) / $_SESSION["bloque_datos_grids"]);    //registro_actual entre bloque de datos para ubicar al nuevo registro dentro del grid de consulta
                    if ( ($i+1) % $_SESSION["bloque_datos_grids"] != 0 ) {        //si el registro_actual se ubica en el �ltimo rengl�n del grid, entonces es necesario decirle que se quede en la p�gina que arroj� la divisi�n, en caso contrario es necesario incrementar a uno (+1) la p�ginaci�n del grid
                        $pagina_actual++;
                    }
                    $_SESSION["limite_inferior_datos_grid"] = $_SESSION["bloque_datos_grids"] * ($pagina_actual - 1);
                    $_SESSION["paginacion_actual"] = $pagina_actual;
                }

                header("Location: ".$_SERVER['PHP_SELF']."?type=".sha1(4)."&cve=".sha1('-'));
                exit;
            }
         }

        if ( $_GET['type'] == sha1(md5("Guardar")).sha1(md5("editar")).md5(sha1("transportista")) ){ //Insertar o editar un proveedor
            include("cambios.php");
            if (actualizarTransportistaMexicano($valor_clave, $valor_rfc, $valor_curp, $valor_nombre, $valor_numero_CAAT,$valor_numero_SCAAT, $valor_nombre_contacto, $valor_cuenta_correo_contacto, $valor_telefono_contacto, $valor_nextel_contacto, $valor_calle_fiscal, $valor_numero_int_fiscal, $valor_numero_ext_fiscal, $valor_colonia_fiscal, $valor_cp_fiscal, $valor_ciudad_fiscal, $valor_calle_patio, $valor_numero_int_patio, $valor_numero_ext_patio, $valor_colonia_patio, $valor_cp_patio, $valor_ciudad_patio, $valor_comentarios_patio, $_FILES['filCroquis'], $_POST['chkBorrar'])) {
                header("Location: ".$_SERVER['PHP_SELF']."?type=".sha1(4)."&cve=".sha1('-'));
                exit;
            }
         }
    }

$titulo_pagina = "TRANSPORTISTAS MEXICANOS";
include("header.php");
?>
<?php if ( $_GET['type'] != sha1(md5("nuevo")).md5(sha1("transportista")) && $_GET['type'] != sha1(md5("Guardar")).sha1(md5("nuevo")).md5(sha1("transportista")) && $_GET['type'] != sha1(md5("editar")).md5(sha1("transportista")) && $_GET['type'] != sha1(md5("Guardar")).sha1(md5("editar")).md5(sha1("transportista")) && $_GET['type'] != sha1(md5("consultar")).md5(sha1("transportista")) ){ ?>
  <tr>
    <td width="1%" height="19"></td>
    <td width="98%" colspan="2" height="19">
    <form method="POST" name="frmPaginacionTransportistasMexicanos" id="frmPaginacionTransportistasMexicanos" action="<?= $_SERVER['PHP_SELF']."?type=".sha1(md5("cargar")).md5(sha1("pagina")).sha1(md5("primera")).md5(sha1("vez"))?>">
        <input type="hidden" name="hidOrdenarPor" <?php echo 'value="'.$_POST["hidOrdenarPor"].'"'; ?>>
        <input type="hidden" name="hidOrdenarAscDesc" <?php echo 'value="'.$_POST["hidOrdenarAscDesc"].'"'; ?>>
    <table width="100%">
      <tr>
        <td width="100%">
            <table border="1" bgcolor="<?php echo $_SESSION["diseno"]["fondo"]["fondo_grid"] ?>" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber2" bordercolor="<?php echo $_SESSION["diseno"]["borde_grids"] ?>" bordercolorlight="<?php echo $_SESSION["diseno"]["borde_grids"] ?>" bordercolordark="<?php echo $_SESSION["diseno"]["borde_grids"] ?>">
              <tr>
                <td width="22%" background="images/div_grad_blue.gif"></td>
                <td width="27%" background="images/div_grad_blue.gif"></td>
                <td width="33%" background="images/div_grad_blue.gif"></td>
                <td width="6%" background="images/div_grad_blue.gif"></td>
                <td width="6%" background="images/div_grad_blue.gif"></td>
                <td width="6%" background="images/div_grad_blue.gif"></td>
              </tr>
              <tr>
                <td width="22%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["fuerte"] ?>" align="center"><input type="text" name="txtFiltroClave" size="18" maxlength="15" <?php echo 'value="'.$_POST["txtFiltroClave"].'"'; ?>></td>
                <td width="27%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["fuerte"] ?>" align="center"><input type="text" name="txtFiltroRFC" size="20" maxlength="13" <?php echo 'value="'.$_POST["txtFiltroRFC"].'"'; ?>></td>
                <td width="33%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["fuerte"] ?>" align="center"><input type="text" name="txtFiltroNombre" size="40" maxlength="120" <?php echo 'value="'.$_POST["txtFiltroNombre"].'"'; ?>></td>
                <td colspan="3" width="12%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["fuerte"] ?>" align="center"><input type="submit" value="Filtrar" name="Filtrar"></td>
              </tr>
              <tr>
                <td width="22%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["claro"] ?>" align="center"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="1" color="#DEDEDE"><a style="color:#DEDEDE" href="javascript: OrdenamientoGrid(document.frmPaginacionTransportistasMexicanos,'1');"><b>Clave</b></a>
                <?= getImagenOrdenGrid($_POST["hidOrdenarPor"], "1", $_POST["hidOrdenarAscDesc"]);?></font></td>
                <td width="27%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["claro"] ?>" align="center"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="1" color="#DEDEDE"><a style="color:#DEDEDE" href="javascript: OrdenamientoGrid(document.frmPaginacionTransportistasMexicanos,'2');"><b>RFC</b></a>
                <?= getImagenOrdenGrid($_POST["hidOrdenarPor"], "2", $_POST["hidOrdenarAscDesc"]);?></font></td>
                <td width="33%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["claro"] ?>" align="center"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="1" color="#DEDEDE"><a style="color:#DEDEDE" href="javascript: OrdenamientoGrid(document.frmPaginacionTransportistasMexicanos,'3');"><b>Nombre</b></a>
                <?= getImagenOrdenGrid($_POST["hidOrdenarPor"], "3", $_POST["hidOrdenarAscDesc"]);?></font></td>
                <td width="6%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["claro"] ?>" align="center">&nbsp;</td>
                <td width="6%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["claro"] ?>" align="center">&nbsp;</td>
                <td width="6%" bgcolor="<?php echo $_SESSION["diseno"]["fondo_encabezado_grids"]["claro"] ?>" align="center">&nbsp;</td>
              </tr>
              <?php
                if ( count($arr_trans_mex_general) > 0 ) {
                    foreach( $arr_trans_mex_general as $Element ) {
               ?>
                    <tr onMouseOver="this.style.background='#DADDD9'" onMouseOut="this.style.background='<?php echo $_SESSION["diseno"]["fondo"]["fondo_grid"] ?>'">
                      <td width="22%" valign="top" nowrap="nowrap">
                      <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699"><?= $Element["clave"] ?></font></td>
                      <td width="27%" valign="top" nowrap="nowrap">
                      <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699"><?= $Element["rfc"] ?></font></td>
                      <td width="33%" valign="top" nowrap="nowrap">
                      <font size="2" face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" color="#336699"><?= $Element["nombre"] ?></font></td>
                      <td width="6%" valign="top" align="center" nowrap="nowrap"><font size="2" face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>">
                        <?php $url=$_SERVER['PHP_SELF']."?type=".sha1(md5("consultar")).md5(sha1("transportista"))."&cve=".sha1(md5($Element["clave"])) ?>
                        <a title="Consultar Registro" href="javascript: SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>');"> <img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_c.gif" width="15" height="15"></a></font></td>
                      <td width="6%" valign="top" align="center" nowrap="nowrap"><font size="2" face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>">
                          <?php $url=$_SERVER['PHP_SELF']."?type=".sha1(md5("editar")).md5(sha1("transportista"))."&cve=".sha1(md5($Element["clave"])) ?>
                          <a title="Editar Registro" href="javascript: SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>');"><img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_e.gif" width="15" height="15"></a></font></td>
                      <td width="6%" valign="top" align="center" nowrap="nowrap"><font size="2" face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>">
                          <?php $url=$_SERVER['PHP_SELF']."?type=".sha1(md5("borrar")).md5(sha1("transportista"))."&cve=".sha1(md5($Element["clave"])) ?>
                          <a title="Borrar Registro" href="javascript: if (confirmarBorrar('el transportista mexicano')) { SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>'); }"><img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_tacha.gif" width="15" height="15"></a></font></td>
                    </tr>
                <?php 
                    } 
                }
                ?>
               <tr>
                <td width="22%" align="center">
                <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#808080">&nbsp;</font></td>
                <td width="27%" align="center">
                <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#808080">&nbsp;</font></td>
                <td width="33%" align="center">
                <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#808080">&nbsp;</font></td>
                <td width="6%" align="center">
                <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#808080">&nbsp;</font></td>
                <td width="6%" align="center">
                <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#808080">&nbsp;</font></td>
                <td width="6%" align="center">
                <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#808080">&nbsp;</font></td>
              </tr>
        
            </table>
        </td>
      </tr>
    
      <tr>
        <td>
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber2">    
                <tr>
                    <td width="45%">
                    <img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_palomita.gif" width="15" height="15"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?type=<?php echo sha1(md5("nuevo")).md5(sha1("transportista")); ?>&cve=<?php echo sha1('-'); ?>">Insertar Nuevo Transportista </a></font>
                    </td>
                    <?php if ( $contador_consulta_transportistas_mexicanos > $_SESSION["bloque_datos_grids"] ) {?>
                            <td width="39%"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#0D306C">P�gina:</font>
                                <select name="paginacion" onChange="return Cargar_Paginacion_TransportistasMexicanos()">
                                <?php
                                    $x = 0;
                                    for ($i = 1; $i <= $contador_consulta_transportistas_mexicanos; $i = $i + $_SESSION["bloque_datos_grids"] ) { 
                                        $x++;
                                    ?>
                                        <option value="<?= $x;?>" 
                                        <?php 
                                            if ( $_SESSION["paginacion_actual"] == $x ) {
                                                echo "selected";
                                            }
                                        ?> >
                                        <?= $x; ?>
                                        </option>
                                <?php 
                                    }  ?>
                                </select>
                            </td>
                    <?php } ?>
                    <td width="4%" align="center">
                    <?php if ( $_SESSION["paginacion_actual"] > 1 ) { ?>
                            <?php $url=$_SERVER['PHP_SELF']."?type=".sha1('-')."&cve_pag=".sha1(md5("inicio")) ?>
                            <a title="Primera P�gina" href="javascript: SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>');"> <img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_nav_first_big.gif" width="15" height="15"></a></td>
                    <?php } ?>
                    <td width="4%" align="center">
                    <?php if ( $_SESSION["paginacion_actual"] > 1 ) { ?>
                            <?php $url=$_SERVER['PHP_SELF']."?type=".sha1('-')."&cve_pag=".sha1(md5("anterior")) ?>
                            <a title="P�gina Anterior" href="javascript: SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>');"> <img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_nav_back_big.gif" width="15" height="15"></a></td>
                    <?php } ?>
                        <td width="4%" align="center">
                    <?php if ( $_SESSION["paginacion_actual"] < $x && $contador_consulta_transportistas_mexicanos > $_SESSION["bloque_datos_grids"] ) { ?>
                            <?php $url=$_SERVER['PHP_SELF']."?type=".sha1('-')."&cve_pag=".sha1(md5("siguiente")) ?>
                            <a title="P�gina Siguiente" href="javascript: SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>');"> <img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_nav_next_big.gif" width="15" height="15"></a></td>
                    <?php } ?>
                        <td width="4%" align="center">
                    <?php if ( $_SESSION["paginacion_actual"] < $x && $contador_consulta_transportistas_mexicanos > $_SESSION["bloque_datos_grids"] ) { ?>
                            <?php $url=$_SERVER['PHP_SELF']."?type=".sha1('-')."&cve_pag=".sha1(md5("final")) ?>
                            <a title="�ltima P�gina" href="javascript: SubmitFormaPaginacion(document.frmPaginacionTransportistasMexicanos, '<?= $url ?>');"> <img border="0" src="<?php echo $_SESSION["diseno"]["botones"] ?>/ico_nav_last_big.gif" width="15" height="15"></a></td>
                    <?php } ?>
                </tr>
            </table>
            <hr color="<?php echo $_SESSION["diseno"]["separador"] ?>">
        </td>
      </tr>
    
    </table>  
    </form>
    </td>
    <td width="1%" height="19"></td>
  </tr>

<?php } ?>
  <tr>
    <td width="1%" height="19"></td>
    <td width="98%" colspan="2" height="19">
    <?php
    if ( $_GET['type'] == sha1(md5("editar")).md5(sha1("transportista")) || $_GET['type'] == sha1(md5("nuevo")).md5(sha1("transportista")) || $_GET['type'] == sha1(md5("Guardar")).sha1(md5("editar")).md5(sha1("transportista")) || $_GET['type'] == sha1(md5("Guardar")).sha1(md5("nuevo")).md5(sha1("transportista")) ){ ?>
        <form action="<?php 
            if ( $_GET['type'] == sha1(md5("Guardar")).sha1(md5("editar")).md5(sha1("transportista")) || $_GET['type'] == sha1(md5("Guardar")).sha1(md5("nuevo")).md5(sha1("transportista")) ){
                echo $_SERVER['PHP_SELF']."?type=".$_GET['type']."&cve=".$_GET['cve'];
            } else {
                echo $_SERVER['PHP_SELF']."?type=".sha1(md5("Guardar")).$_GET['type']."&cve=".$_GET['cve']; 
            }
        ?>" method="POST" enctype="multipart/form-data" name="frmTransportistaMexicano" id="frmTransportistaMexicano" onSubmit="return Validar_Transportista_Mexicano()">
        <table border="1" bgcolor="<?php echo $_SESSION["diseno"]["fondo"]["fondo_grid"] ?>" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber3" bordercolor="<?php echo $_SESSION["diseno"]["borde_grids"] ?>" bordercolorlight="<?php echo $_SESSION["diseno"]["borde_grids"] ?>" bordercolordark="<?php echo $_SESSION["diseno"]["borde_grids"] ?>">

<?php if ( getConfiguracionClaves_Auto_Manual_Catalogo("bTransMexAutomaticos") != '1' ||  $_SESSION["tipo_almacenamiento"] == sha1(md5("editar")).md5(sha1("transportista")) ) { ?>
                <tr>
                    <td width="30%" align="right">
                        <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Clave:</font>
                    </td>
                    <td width="70%">
                <?php if ( $_SESSION["tipo_almacenamiento"] == sha1(md5("editar")).md5(sha1("transportista")) ) { ?>
                        <input type="hidden" name="txtID" size="18" maxlength="15" value="<?= $valor_clave ?>">
                         <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_clave ?></font>
                <?php } else { ?>
                        <input type="text" name="txtID" size="18" maxlength="15" value="<?= $valor_clave ?>">
                <?php } ?>
                    </td>
                </tr>    
<?php } else { ?>
            <input type="hidden" name="txtID" value="N/A">
<?php } ?>

            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">RFC:</font>
                </td>
                <td width="70%">
                    <input type="text" name="txtRFC" size="20" maxlength="13" value="<?= $valor_rfc ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
                </td>
            </tr>    
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">CURP:</font>
                </td>
                <td width="70%">
                    <input type="text" name="txtCURP" size="25" maxlength="18" value="<?= $valor_curp ?>"> 
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
                </td>
            </tr>    
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Nombre:</font>
                </td>
                <td width="70%">
                    <input type="text" name="txtNombre" size="55" maxlength="120" value="<?= $valor_nombre ?>">
                </td>
            </tr>

            <tr>
            <td width="30%" align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">CAAT:</font></td>
            <td width="70%">
                    <input type="text" name="numero_caat" size="7" maxlength="4" value="<?= $valor_numero_CAAT ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
            </td>
            </tr> 
            
            <tr>
                <td width="30%" align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">SCAC:</font></td>
                <td width="70%">
                    <input type="text" name="numero_scaat" size="7" maxlength="4" value="<?= $valor_numero_SCAAT ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
                </td>
            </tr>           

            <tr>
            <td width="30%" align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Nombre del contacto:</font></td>
            <td width="70%">
                    <input type="text" name="nombre_contacto" size="55" maxlength="120" value="<?= $valor_nombre_contacto ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
            </td>
            </tr>            

            <tr>
            <td width="30%" align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Cuenta de correo del contacto:</font></td>
            <td width="70%">
                    <input type="text" name="cuenta_correo_contacto" size="55" maxlength="120" value="<?= $valor_cuenta_correo_contacto ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
            </td>
            </tr>            

            <tr>
            <td width="30%" align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Tel�fono(s) del contacto:</font></td>
            <td width="70%">
                    <input type="text" name="telefono_contacto" size="55" maxlength="120" value="<?= $valor_telefono_contacto ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
            </td>
            </tr>            

            <tr>
            <td width="30%" align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Nextel del contacto:</font></td>
            <td width="70%">
                    <input type="text" name="nextel_contacto" size="55" maxlength="120" value="<?= $valor_nextel_contacto ?>">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font>
            </td>
            </tr>            

            <tr>
              <td colspan="2" align="right"><hr color="<?php echo $_SESSION["diseno"]["separador"] ?>"></td>
            </tr>
             <tr>
               <td align="right"><div align="left"><strong><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#0D306C">DIRECCI�N FISCAL </font></strong></div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Calle:</font> </td>
               <td><input name="txtCalleFiscal" type="text" id="txtCalleFiscal" size="55" maxlength="80" value="<?= $valor_calle_fiscal ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero interior:</font> </td>
               <td><input name="txtNumIntFiscal" type="text" id="txtNumIntFiscal" size="13" maxlength="10" value="<?= $valor_numero_int_fiscal ?>">
                 <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font> </td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero exterior:</font> </td>
               <td><input name="txtNumExtFiscal" type="text" id="txtNumExtFiscal" size="13" maxlength="10" value="<?= $valor_numero_ext_fiscal ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Colonia:</font> </td>
               <td><input name="txtColoniaFiscal" type="text" id="txtColoniaFiscal" size="55" maxlength="120" value="<?= $valor_colonia_fiscal ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">C&oacute;digo postal:</font> </td>
               <td><input name="txtCPFiscal" type="text" id="txtCPFiscal" size="13" maxlength="10" value="<?= $valor_cp_fiscal ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Ciudad:</font> </td>
               <td><input name="txtCiudadFiscal" type="text" id="txtCiudadFiscal" size="55" maxlength="80" value="<?= $valor_ciudad_fiscal ?>" >
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
            <tr>
              <td colspan="2" align="right"><hr color="<?php echo $_SESSION["diseno"]["separador"] ?>"></td>
            </tr>
             <tr>
               <td align="right"><div align="left"><strong><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#0D306C">DIRECCI�N PATIO </font></strong></div></td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Calle:</font> </td>
               <td><input name="txtCallePatio" type="text" id="txtCallePatio" size="55" maxlength="80" value="<?= $valor_calle_patio ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero interior:</font> </td>
               <td><input name="txtNumIntPatio" type="text" id="txtNumIntPatio" size="13" maxlength="10" value="<?= $valor_numero_int_patio ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero exterior:</font> </td>
               <td><input name="txtNumExtPatio" type="text" id="txtNumExtPatio" size="13" maxlength="10" value="<?= $valor_numero_ext_patio ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Colonia:</font> </td>
               <td><input name="txtColoniaPatio" type="text" id="txtColoniaPatio" size="55" maxlength="80" value="<?= $valor_colonia_patio ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">C&oacute;digo postal:</font> </td>
               <td><input name="txtCPPatio" type="text" id="txtCPPatio" size="13" maxlength="10" value="<?= $valor_cp_patio ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Ciudad:</font> </td>
               <td><input name="txtCiudadPatio" type="text" id="txtCiudadPatio" size="55" maxlength="80" value="<?= $valor_ciudad_patio ?>">
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>
             <tr>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Comentarios:</font></td>
               <td><textarea name="txtComentariosPatio" cols="70" rows="5" wrap="soft" id="txtComentariosPatio"><?= $valor_comentarios_patio ?></textarea>
               <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">*</font></td>
             </tr>

            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Croquis:</font> </td>
              <td><input name="filCroquis" type="file" id="filCroquis">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">(menor a 50 KB) *</font>
                  <?php if ( $_SESSION["tipo_almacenamiento"] == sha1(md5("editar")).md5(sha1("transportista")) ) { ?>
                              <input type="hidden" name="archivo_patio" size="20" maxlength="255" value="<?= $valor_nombre_archivo; ?>">
                              <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699"><a href="javascript:NuevaVentanaDownload('<?= sha1(md5($valor_clave)) ?>', '<?= sha1(md5('NO_APLICA')) ?>', '<?= sha1(md5('NO_APLICA')) ?>', '<?= sha1(md5('croquis_transportista_mexicano')) ?>')"><?= $valor_nombre_archivo; ?></a></font>
                  <?php } ?>
              </td>
            </tr>
            <?php if ( !(empty($valor_nombre_archivo)) ) {?>
                    <tr>
                        <td  colspan="2" align="center"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#0D306C"><b>�Borrar croquis?:</b></font>
                            <input type="checkbox" name="chkBorrar[]" value="Borrar_Croquis"
                            <?php    if ( count($_POST['chkBorrar']) > 0 ) {
                                        if ( in_array("Borrar_Croquis", $_POST['chkBorrar']) ) {
                                            echo 'checked';
                                        }
                                    }
                            ?>
                            >
                        </td>
                    </tr>
            <?php } ?>

             <tr>
               <td align="right">&nbsp;</td>
               <td>&nbsp;</td>
             </tr>        
             <?php
             if ( $_GET['type'] == sha1(md5("editar")).md5(sha1("transportista")) && $valor_clave != ""  ) {
             ?>
             <tr>
               <td align="right">&nbsp;</td>
               <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2"><a href="<?php echo "transportistas_mexicanos_contacto.php"; ?>"><b>Contacto</b></a></font></td>
             </tr> 
             <?php }   
             ?>     
          </table>
             <p align="center">
                 <input type="submit" value="Aceptar" name="B1"> 
                 &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="Cancelar" name="Cancelar" onClick="parent.location='<?php echo $_SERVER['PHP_SELF']; ?>?type=<?php echo sha1(4);?>&cve=<?php echo sha1('-');?>'">
             </p>
            <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;&nbsp;* Campo opcional.</font>
      </form>
    <?php } else {
    if ( $_GET['type'] == sha1(md5("consultar")).md5(sha1("transportista"))){ ?>

        <table border="1" bgcolor="<?php echo $_SESSION["diseno"]["fondo"]["fondo_grid"] ?>" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" id="AutoNumber3" bordercolor="<?php echo $_SESSION["diseno"]["borde_grids"] ?>" bordercolorlight="<?php echo $_SESSION["diseno"]["borde_grids"] ?>" bordercolordark="<?php echo $_SESSION["diseno"]["borde_grids"] ?>">
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Clave:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699"></font><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_clave ?> </font>
                </td>
            </tr>    
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">RFC:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_rfc ?> </font> 
                </td>
            </tr>    
            <?php if (!(empty( $valor_curp ))) { ?>
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">CURP:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_curp ?> </font>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Nombre:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["nombre"] ?> </font>
                </td>
            </tr>

            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">CAAT:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["CAAT"] ?> </font>
                </td>
            </tr>
            
            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">SCAAT:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["SCAAT"] ?> </font>
                </td>
            </tr>

            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Nombre del contacto:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["nombre_contacto"] ?> </font>
                </td>
            </tr>

            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Cuenta de correo del contacto:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["cuenta_correo_contacto"] ?> </font>
                </td>
            </tr>

            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Tel�fono(s) del contacto:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["telefono_contacto"] ?> </font>
                </td>
            </tr>

            <tr>
                <td width="30%" align="right">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Nextel del contacto:</font>
                </td>
                <td width="70%">
                    <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $arr_trans_mexicano[0]["nextel_contacto"] ?> </font>
                </td>
            </tr>

            <tr>
              <td colspan="2" align="right"><hr color="<?php echo $_SESSION["diseno"]["separador"] ?>"></td>
            </tr>
            <tr>
              <td align="right"><div align="left"><strong><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#0D306C">DIRECCI&Oacute;N FISCAL </font></strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Calle:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_calle_fiscal ?> </font>
              </td>
            </tr>
            <?php if (!(empty( $valor_numero_int_fiscal ))) { ?>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero interior:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_numero_int_fiscal ?> </font>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero exterior:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_numero_ext_fiscal ?> </font>
              </td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Colonia:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_colonia_fiscal ?> </font>
              </td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">C&oacute;digo postal:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_cp_fiscal ?> </font>
              </td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Ciudad:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_ciudad_fiscal ?> </font>
              </td>
            </tr>
            <tr>
              <td colspan="2" align="right"><hr color="<?php echo $_SESSION["diseno"]["separador"] ?>"></td>
            </tr>
            <tr>
              <td align="right"><div align="left"><strong><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#0D306C">DIRECCI&Oacute;N PATIO </font></strong></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Calle:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_calle_patio ?> </font>
              </td>
            </tr>
            <?php if (!(empty( $valor_numero_int_patio ))) { ?>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero interior:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_numero_int_patio ?> </font>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">N&uacute;mero exterior:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_numero_ext_patio ?> </font>
              </td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Colonia:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_colonia_patio ?> </font>
              </td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">C&oacute;digo postal:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_cp_patio ?> </font>
              </td>
            </tr>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Ciudad:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_ciudad_patio ?> </font>
              </td>
            </tr>
            <?php if (!(empty( $valor_comentarios_patio ))) { ?>
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Comentarios:</font></td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<?= $valor_comentarios_patio ?> </font>
              </td>
            </tr>
            <?php } ?>
            <?php if (!(empty( $valor_nombre_archivo ))) { ?>        
            <tr>
              <td align="right"><font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2">Croquis:</font> </td>
              <td width="70%">
                  <font face="<?php echo $_SESSION["diseno"]["tipo_letra"] ?>" size="2" color="#336699">&nbsp;<a href="javascript:NuevaVentanaDownload('<?= sha1(md5($Element["clave"])) ?>', '<?= sha1(md5('NO_APLICA')) ?>', '<?= sha1(md5('NO_APLICA')) ?>', '<?= sha1(md5('croquis_transportista_mexicano')) ?>')"><?= $valor_nombre_archivo ?></a></font>
              </td>
            </tr>
            <?php } ?>
      </table>
             <p align="center">
                <input type="button" value="Regresar" name="Cancelar" onClick="parent.location='<?php echo $_SERVER['PHP_SELF']; ?>?type=<?php echo sha1(4);?>&cve=<?php echo sha1('-');?>'">
             </p>
    <?php 
        } 
    } 
    ?>
    
    </td>
    <td width="1%" height="19"></td>
  </tr>
<?php include("footer.php"); ?>
