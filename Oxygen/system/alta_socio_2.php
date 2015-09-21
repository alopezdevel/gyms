<?php             
 session_start();
 if ($_SESSION['acceso'] != "A" ){ //No ha iniciado session
    header("Location: login.php");
 }else{
include("header.php");?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css">          
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/js/jquery.form.js" type="text/javascript"></script>
<script>
function llenadoGrid(){
    var filtro = "";  //DATE_FORMAT(dFechaIngreso,  '%m/%d/%Y')         
    if($('#filtro_fecha_creacion').val() !=""){     
        filtro += "DATE_FORMAT(dFecharegistro,  '%d/%m/%Y')|" + $("#filtro_fecha_creacion").val() + ",*"
    }
    if($('#filtro_id_socio').val() !=""){     
        filtro += "iIDSocio|" + $("#filtro_id_socio").val() + ",*"
    }                                                 
    if($('#filtro_correo_socio').val() !=""){     
        filtro += "sCorreoSocio|" + $("#filtro_correo_socio").val() + ",*"
    }            
    if($('#filtro_nombre_socio').val() !=""){     
        filtro += "Concat(sNombreSocio, ' ', sApellidoPaternoSocio, ' ', sApellidoMaternoSocio)|" + $("#filtro_nombre_socio").val() + ",*"
    }
    
    if($('#filtro_Estatus_Cuenta').val() !="" && $('#filtro_Estatus_Cuenta').val() != null && $('#filtro_Estatus_Cuenta').val() != "null"){     
        filtro += "bactivo|" + $("#filtro_Estatus_Cuenta").val() + ",*"
    }
    
        var fn_request_certificate = {
        domroot:"#fn_request_certificate",
        data_grid: "#data_grid_certificate",
        fillgrid: function(){
               $.ajax({             
                type:"POST",                                 
                url:"funciones.php", 
                data:{accion:"get_socios_asinc", filtroInformacion : filtro},
                async : true,
                dataType : "json",
                success : function(data){                               
                    $(fn_request_certificate.data_grid+" tbody").empty().append(data.tabla);
                    $(fn_request_certificate.data_grid+" tbody tr:even").addClass('gray');
                    $(fn_request_certificate.data_grid+" tbody tr:odd").addClass('white');
                                }
            }); 
        }    
    }
    fn_request_certificate.fillgrid();
}
$(document).ready(inicio);
function inicio(){   
    $('#emailForm').ajaxForm({      
            beforeSubmit: validate,
            success: function(data, statusText, xhr, form ) {
            $("#file_imagen").val("");
            $("button_submit").prop('disabled', false);   
            $('#loading').hide();
            alert(data);     
            onEditarCliente($("#id_edicion").val()); 
            $("#button_submit").prop('disabled', false);                        
            } 
    });
    function validate(formData, jqForm, options) {     
            var form =  jqForm[0]; 
            $('#loading').html('Cargando foto...').show();
            $("#button_submit").prop('disabled', true);        
}  
    var dialogo;
    var dialogo2;
    $( "#tabs" ).tabs();
   
    
    //dialogo 1
    dialogo = $( "#dialog-user" ).dialog({
      autoOpen: false,
      height: 800,
      width: 1296,                                 
      modal: true,  
       buttons: {
        "Crear nuevo usuario": onInsertarUsuario,
        Cancel: function() {
          $('input.texto').val("");  
          dialogo.dialog( "close" );
        }
      },    
      close: function() {
        //form[ 0 ].reset();
        //allFields.removeClass( "ui-state-error" );
      }
    }); 
     //focus
     $( "#filtro_Estatus_Cuenta" ).selectmenu();
     $(".date").datepicker({
        onSelect: function() {
            $(this).change();
        }
    });    
    //dialogo 2
    dialogo2 = $( "#dialog-user-editar" ).dialog({
      autoOpen: false,
      height: 800,
      width: 1296,                                 
      modal: true,  
       buttons: {
        "Actualizar": onActualizarUsuario,
        Cancel: function() {
          $('input.texto').val("");
          dialogo2.dialog( "close" );
        }
      },    
      close: function() {
        //form[ 0 ].reset();
        //allFields.removeClass( "ui-state-error" );                 
      }
    });  
     //focus
     $( "#filtro_Estatus_Cuenta" ).selectmenu();
     $(".date").datepicker({
        onSelect: function() {
            $(this).change();
        }
    }); 
    $( "#filtro_fecha_creacion" ).datepicker({onSelect: function(){ onkeyup()},dateFormat: 'dd/mm/yy'}); 
    $('input.texto').focus(onFocus);
    //blur
    $('input.texto').blur(onBlur);
    $("#Nuevosocio").click(onAltaCliente);
    //filtros
    $( "#filtro_fecha_creacion" ).keyup(onkeyup);
    $( "#filtro_id_socio" ).keyup(onkeyup);
    $("#filtro_correo_socio").keyup(onkeyup);
    $("#filtro_nombre_socio").keyup(onkeyup);  
    $("#filtro_Estatus_Cuenta" ).selectmenu({ change: function( event, ui ) { onkeyup(); }});
    llenadoGrid();
    $("#borrado_boton").click(Onborrar);
    /*$("input[name='file']").on("change", function(){
            var ruta = "funciones.php";
           $.post("funciones.php", { accion: "subir_imagen_socio", id:ruta},
           function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("El socio se ha borrar de manera satisfactoria.");
                         llenadoGrid();
                    break;  
             }
         }
         ,"json");   
        });   */
}  
          

                                                           
function onSubirImagen(){  
    var formData = new FormData($("#formulario")[0]);
    var ruta = "imagen-ajax.php";   
    $.ajax({
            url: "funciones.php",
            type: "POST",
            data:{accion:"subir_imagen_socio", formData : formData}, 
            contentType: false,
            processData: false,
            success: function(datos){
                //$("#respuesta").html(datos);
            }
            });    
} 
function onkeyup(){
    llenadoGrid();
}              
function Onborrar(id){
   if(confirm("estas seguro que desea borrar al socio con el ID: " + id + "?")){ 
    $.post("funciones.php", { accion: "registrar_asistencia", id:id},
        function(data){ 
             switch(data.error){
             case "1":   alert( data.mensaje);
                    break;
             case "0":   
                         alert("El socio se ha borrar de manera satisfactoria.");
                         llenadoGrid();
                    break;  
             }
         }
         ,"json");           
   }
}   
function onActualizarUsuario(){
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    var floatRegex = /[-+]?([0-9]*.[0-9]+|[0-9]+)/; 
    var ID = $("#id_edicion");    
    var name = $("#nombree");    
    var apellido_paterno = $("#apellido_paternoe");
    var apellido_materno = $("#apellido_maternoe");
    var calle = $("#callee");
    var colonia = $("#coloniae");
    var telefono = $("#telefonoe");
    var sexo = $("#sexoe");
    var mensualidad = $("#mensualidade");
    
     //Workouts
    var fran = $("#iFran"); 
    var helen = $("#iHelen"); 
    var grace = $("#iGrace"); 
    var Filthy = $("#iFilthy"); 
    var Row = $("#iRow"); 
    var Sprint = $("#iSprint"); 
    var Run = $("#iRun");
    
    //Skills
    var eRope = $("#eRope"); 
    var eDu = $("#eDu"); 
    var eHspu = $("#eHspu");         
    var ePulls = $("#ePulls");         
    var eMtsWalk = $("#eMtsWalk"); 
    var iBoxJump = $("#iBoxJump");    
    var eRingMuscle = $("#eRingMuscle");    
    
    //Maxer pr     
    var iCleanJerk = $("#iCleanJerk"); 
    var iSnatch = $("#iSnatch"); 
    var iDeadlift = $("#iDeadlift"); 
    var iBackSquat = $("#iBackSquat"); 
    var iMaxPullUps = $("#iMaxPullUps"); 
    var iMaxMuscleUp = $("#iMaxMuscleUp"); 
    var iMaxBurpeesMin = $("#iMaxBurpeesMin"); 
    
    //datos personales
    var edad = $("#edade"); 
    var altura = $("#alturae"); 
    var peso = $("#pesoe"); 
    
    
    
    todosloscampos = $( [] ).add( name ).add( apellido_paterno ).add( apellido_materno ).add( apellido_materno ).add( email ).add( calle ).add( colonia ).add( telefono ).add( sexo ).add( mensualidad )
    .add( fran ).add( helen ).add( grace ).add( Filthy ).add( Row ).add( Sprint ).add( Run )
    .add( eRingMuscle ).add( eDu ).add( eHspu ).add( ePulls ).add( eMtsWalk ).add( iBoxJump ).add( eRope )
    .add( iCleanJerk ).add( iSnatch ).add( iDeadlift ).add( iBackSquat ).add( iMaxPullUps ).add( iMaxMuscleUp ).add( iMaxBurpeesMin )
    .add( edad ).add( altura ).add( peso )
    ;
    todosloscampos.removeClass( "error" );
    $("#namee").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
     //validaciones
    var valid = true;
    
    //Nombre socio
    valid = valid && checkLength( name, "Nombre del socio", 2, 25 );
    valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Nombre del socio debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido paterno
    valid = valid && checkLength( apellido_paterno, "Apellido paterno", 2, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido paterno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido materno
    valid = valid && checkLength( apellido_materno, "Apellido materno", 2, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido materno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //calle
    valid = valid && checkLength( calle, "Calle", 5, 25 );
    valid = valid && checkRegexp( calle, /^[a-z]([0-9a-z_\s])+$/i, "Calle debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //colonia
    valid = valid && checkLength( colonia, "Colonia", 5, 25 );
    valid = valid && checkRegexp( colonia, /^[a-z]([0-9a-z_\s])+$/i, "Colonia debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    
    valid = valid && checkLength( telefono, "Telefono", 6, 25 );
    valid = valid && checkRegexp( telefono, /[0-9-()+]{3,20}/, "Telefono solo permite numeros: 0-9" );
    
    if($("#sexoe").val() == ""){
        valid = false;
        actualizarMensajeAlerta( 'Favor de seleccionar un genero para el socio' );  
    }
    
    if($("#mensualidade").val()!= ""){
        valid = valid && checkLength( mensualidad, "Mensualidad", 1, 25 );
        valid = valid && checkRegexp( mensualidad, floatRegex , "Mensualidad solo permite numeros: 0-9" );
    }
     if($("#edade").val()!= ""){
        valid = valid && checkLength( edad, "Edad", 1, 25 );
        valid = valid && checkRegexp( edad, floatRegex , "Edad solo permite numeros: 0-9" );
    }
     if($("#alturae").val()!= ""){
        valid = valid && checkLength( altura, "Altura", 1, 25 );
        valid = valid && checkRegexp( altura, floatRegex , "Altura solo permite numeros: 0-9" );
    }
     if($("#pesoe").val()!= ""){
        valid = valid && checkLength( peso, "Peso", 1, 25 );
        valid = valid && checkRegexp( peso, floatRegex , "Peso solo permite numeros: 0-9" );
    }
    if ( valid ) {           
        $.post("funciones.php", { accion: "actualizar_usuario", nombre: name.val() , apellido_paterno: apellido_paterno.val(),
                                                          apellido_materno: apellido_materno.val() , id: ID.val(),
                                                          calle: calle.val() , colonia: colonia.val(),
                                                          fran: fran.val(), helen: helen.val(), filthy: Filthy.val(), grace: grace.val(),
                                                          row:Row.val(), sprint: Sprint.val(), run: Run.val(), eRope:eRope.val(),  
                                                          eRingMuscle:eRingMuscle.val(), eDu: eDu.val(), eHspu: eHspu.val(),    
                                                          ePulls:ePulls.val(), eMtsWalk: eMtsWalk.val(), iBoxJump: iBoxJump.val(),
                                                          iCleanJerk:iCleanJerk.val(), iSnatch: iSnatch.val(), iDeadlift: iDeadlift.val(),
                                                          iBackSquat:iBackSquat.val(), iMaxPullUps: iMaxPullUps.val(), iMaxMuscleUp: iMaxMuscleUp.val(),
                                                          iMaxBurpeesMin:iMaxBurpeesMin.val(),
                                                          telefono: telefono.val() , mensualidad: mensualidad.val(), 
                                                          edad: edad.val(), altura: altura.val(), peso: peso.val(), 
                                                          sexo: sexo.val() ,nivel: "C"},
        function(data){ 
             switch(data.error){
             case "1":   actualizarMensajeAlerta( data.mensaje);
                         $("#nombre").focus();                         
                    break;
             case "2":   actualizarMensajeAlerta( data.mensaje);
                         $("#nombre").focus();                         
                    break;
             case "0":   actualizarMensajeAlerta("Favor de llenar los campos.");
                         $('input.texto').val("");
                         $("#sexo").val("");
                         $("#name").focus();                                                                          
                         alert("Gracias. El usuario " + name.val() + " se ha actualizado de manera satisfactoria.");   
                         actualizarMensajeAlerta("Gracias. El usuario " + name.val() + " se ha actualizado de manera satisfactoria.");
                         llenadoGrid(); 
                         $( "#dialog-user-editar" ).dialog( "close" );
                         //location.href= "inicio.php";
                    break;  
             }
         }
         ,"json");
       
    }
}
function onInsertarUsuario(){    
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    var floatRegex = /[-+]?([0-9]*.[0-9]+|[0-9]+)/; 
    var name = $("#nombre");    
    var apellido_paterno = $("#apellido_paterno");
    var apellido_materno = $("#apellido_materno");
    var email = $("#email");
    var calle = $("#calle");
    var colonia = $("#colonia");
    var telefono = $("#telefono");
    var sexo = $("#sexo");
    
    
    
    var mensualidad = $("#mensualidad");
    todosloscampos = $( [] ).add( name ).add( apellido_paterno ).add( apellido_materno ).add( apellido_materno ).add( email ).add( calle ).add( colonia ).add( telefono ).add( sexo ).add( mensualidad );
    todosloscampos.removeClass( "error" );
    $("#name").focus().css("background-color","#FFFFC0");
    actualizarMensajeAlerta( "" );
     //validaciones
    var valid = true;
    
    //Nombre socio
    valid = valid && checkLength( name, "Nombre del socio", 2, 25 );
    valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Nombre del socio debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido paterno
    valid = valid && checkLength( apellido_paterno, "Apellido paterno", 2, 25 );
    valid = valid && checkRegexp( apellido_paterno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido paterno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //apellido materno
    valid = valid && checkLength( apellido_materno, "Apellido materno", 2, 25 );
    valid = valid && checkRegexp( apellido_materno, /^[a-z]([0-9a-z_\s])+$/i, "Apellido materno debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //email
    valid = valid && checkLength( email, "E-mail", 6, 80 );                                                                                                           
    valid = valid && checkRegexp( email, emailRegex, "ej. ui@hotmail.com" );
    //calle
    valid = valid && checkLength( calle, "Calle", 5, 25 );
    valid = valid && checkRegexp( calle, /^[a-z]([0-9a-z_\s])+$/i, "Calle debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    //colonia
    valid = valid && checkLength( colonia, "Colonia", 5, 25 );
    valid = valid && checkRegexp( colonia, /^[a-z]([0-9a-z_\s])+$/i, "Colonia debe contener a-z, 0-9, guiones bajos, espacios y debe iniciar con una letra." );
    
    valid = valid && checkLength( telefono, "Telefono", 6, 25 );
    valid = valid && checkRegexp( telefono, /[0-9-()+]{3,20}/, "Telefono solo permite numeros: 0-9" );
    
    //Workouts
    
    
    if($("#sexo").val() == ""){
        valid = false;
        actualizarMensajeAlerta( 'Favor de seleccionar un genero para el socio' );  
    }
    
    if($("#mensualidad").val()!= ""){
        valid = valid && checkLength( mensualidad, "Mensualidad", 1, 25 );
        valid = valid && checkRegexp( mensualidad, floatRegex , "Mensualidad solo permite numeros: 0-9" );
    }
    if ( valid ) {     
        $.post("funciones.php", { accion: "alta_usuario", nombre: name.val() , apellido_paterno: apellido_paterno.val(),
                                                          apellido_materno: apellido_materno.val() , email: email.val(),
                                                          calle: calle.val() , colonia: colonia.val(), 
                                                          telefono: telefono.val() , mensualidad: mensualidad.val(),                                                           
                                                          sexo: sexo.val() ,nivel: "C"},
        function(data){ 
             switch(data.error){
             case "1":   actualizarMensajeAlerta( data.mensaje);   
                         $("#nombre").focus();
                         $('#tabs').tabs("option", "active", 0);
                    break;
             case "0":   actualizarMensajeAlerta("Favor de llenar los campos.");
                         $('input.texto').val("");
                         $("#sexo").val("");
                         $("#name").focus();                                                                          
                         alert("Gracias. El usuario " + name.val() + " se ha registrado de manera satisfactoria.");   
                         actualizarMensajeAlerta("Gracias. El usuario " + name.val() + " se ha registrado de manera satisfactoria.");
                         llenadoGrid(); 
                         $( "#dialog-user" ).dialog( "close" );
                         //location.href= "inicio.php";
                    break;  
             }
         }
         ,"json");
       
    }
}
function onFocus(){
     $(this).css("background-color","#FFFFC0");
 }
 function onBlur(){
    $(this).css("background-color","#FFFFFF");
 }
 function actualizarMensajeAlerta( t ) {
      var mensaje = $( ".mensaje_valido" );
      mensaje
        .text( t )
        .addClass( "alertmessage" );
        
      setTimeout(function() {
        mensaje.removeClass( "alertmessage", 2500 );
      }, 700 );
 }
 function checkRegexp( o, regexp, n ) {
    if ( !( regexp.test( o.val() ) ) ) {
        actualizarMensajeAlerta( n );
        o.addClass( "error" );
        o.focus();
        //$( "#nombree" ).focus();
        alert(n);
        return false;
    } else {                     
        return true;        
    }
 }
 function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        actualizarMensajeAlerta( "La longitud del campo " + n + " debe contener por lo menos entre " + min + " y " + max + ". caracteres"  );
         alert("La longitud del campo " + n + " debe contener por lo menos entre " + min + " y " + max + ". caracteres" ); 
        o.addClass( "error" );
        o.focus();
        //$( "#nombree" ).focus();
        return false;    
    } else {             
        return true;                     
    }                    
 }
function onAltaCliente(){
  
    $( "#dialog-user" ).dialog("open");
} 
function onEditarCliente(id){    
    //llenado el div
    
    
    $('#tabs').tabs("option", "active", 0);    
    $.post("funciones.php", { accion: "consulta_socio_edicion", id: id },
        function(data){ 
             switch(data.error){
             case "1":   
                    break;
             case "0":  //llenando inputs
                        $("#id_edicion").val(id);    
                        $("#emaile").val(data.correo);    
                        $("#nombree").val(data.nombre);
                        $("#apellido_paternoe").val(data.apellido_paterno);    
                        $("#apellido_maternoe").val(data.apellido_materno);    
                        $("#callee").val(data.calle);    
                        $("#coloniae").val(data.colonia);    
                        $("#telefonoe").val(data.telefono);    
                        $("#sexoe").val(data.genero);                                     
                        $("#mensualidade").val(data.cantidad);     
                        //Workouts
                        $("#iFran").val(data.sWFran);
                        $("#iHelen").val(data.sWHelen);
                        $("#iGrace").val(data.sWGrace);
                        $("#iFilthy").val(data.sWFilthy50);
                        $("#iRow").val(data.sWRow500m);
                        $("#iSprint").val(data.sWSprint400m);
                        $("#iRun").val(data.sWRun5k);
                        //skills
                        $("#eRope").val(data.eS_ropeclaims);
                        $("#eDu").val(data.eS_du);
                        $("#eHspu").val(data.eS_hspu);
                        $("#ePulls").val(data.eS_pullups);
                        $("#eMtsWalk").val(data.eS_walkhs);
                        $("#iBoxJump").val(data.iS_boxjumpmax);
                        $("#eRingMuscle").val(data.eS_ringmuscleup);                        
                        //maxer pr
                        $("#iCleanJerk").val(data.iMP_cleanandjerk);
                        $("#iSnatch").val(data.iMP_snatch);
                        $("#iDeadlift").val(data.iMP_deadlift);
                        $("#iBackSquat").val(data.iMP_backsquat);
                        $("#iMaxPullUps").val(data.iMP_maxpullups);
                        $("#iMaxMuscleUp").val(data.iMP_maxmuscleup);
                        $("#iMaxBurpeesMin").val(data.iMP_maxburpeesmin);                        
                        $("#nombree").focus();
                        //foto de perfil
                        d = new Date();
                        $("#foto_perfil_socio_consulta").attr("src",data.ruta + '?' + d.getTime() );
                        //Datos personales
                        $("#edade").val(data.edad);                        
                        $("#alturae").val(data.altura);                        
                        $("#pesoe").val(data.peso);                        
                        
                    break;  
             }
         }
         ,"json");
    
    
    $( "#dialog-user-editar" ).dialog("open");
} 
</script>
<div id="layer_content" class="main-section">
    <div class="container"> 
        <div class="page-title">
            <h1>Socios</h1>
            <h2>Catalogo de Socios</h2>
        </div>
        <div class="txt-content"> 
            <div class="frm-buscar3">
                <div class="frm-btns clearfix">
                        <button id="Nuevosocio" name="Nuevosocio" type="button" value="1" >Nuevo socio</button> 
                </div>                    
            </div>
        </div> 
        
        <table id="data_grid_certificate" class="data_grid">
        <thead>                                                                                       
            <tr id="grid-head1">                                                                                             
                <td align="center" class="etiqueta_grid" nowrap="nowrap" ><input class="inp"  id="filtro_fecha_creacion" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_id_socio" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_correo_socio" type="text"></td>
                <td align="center" class="etiqueta_grid"><input class="inp"  id="filtro_nombre_socio" type="text"></td>
                <td align="center" class="etiqueta_grid" nowrap="nowrap"><select   id="filtro_Estatus_Cuenta" size="3" multiple ><option value="">&nbsp;<option value="0">Pendiente</option><option value="1">Activado</option></td>
                <td class="etiqueta_grid" colspan = "2">&nbsp;</td> 
            </tr>
            <tr id="grid-head2">                            
                <td align="center" class="etiqueta_grid" nowrap="nowrap" >Fecha de registro</td>
                <td align="center" class="etiqueta_grid">ID socio</td>
                <td align="center" class="etiqueta_grid">Correo socio</td>
                <td align="center" class="etiqueta_grid">Nombre socio</td>
                <td align="center" class="etiqueta_grid">Estatus cuenta</td>
                <td class="etiqueta_grid" colspan = "2">&nbsp;</td> 
                
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
        </table>
        
        
    </div> 
</div>    
<div id="dialog-user" title="Alta Socio" class="ui-widget" >
   
    
        
            <div class="container">
                <div class="page-title">
                    <h1>Socios</h1>
                    <h2>Nuevo Socio</h2>
                </div>
                <form method="post" id="formulario" enctype="multipart/form-data" >
                    <p class="mensaje_valido">Favor de llenar los campos.</p>
                    <input  id = "nombre"   class="texto" name="nombre" type="text" placeholder="Nombre del socio:">
                    <input  id = "apellido_paterno" class="texto"  name="apellido_paterno" type="text" placeholder="Apellido paterno:">
                    <input  id = "apellido_materno" class="texto"  name="apellido_materno" type="text" placeholder="Apellido materno:">
                    <input  id = "email" name="email" class="texto" type="text" placeholder="E-mail:">         
                    <input  id = "calle" name="calle" class="texto" type="text" placeholder="Calle:">
                    <input  id = "colonia" name="colonia" class="texto" type="text" placeholder="Colonia:">
                    <input  id = "telefono" name="Telefono" class="texto" type="text" placeholder="telefono:">
                    <select name="sexo" id="sexo" class="texto">
                        <option value=""><-Seleccione Genero-></option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>            
                    <input  id = "mensualidad"  class="texto" name="mensualidad" type="text" placeholder="Mensualidad sugerida (opcional):">           
                </form>
            </div> 
        </div>
        
        
    </div>
    
    
</div>
<div id="dialog-user-editar" title="Actualizar Socio" class="ui-widget" >
    
    
    <div id="tabs">
        <ul>
                <li><a href="#tabs-1">Perfil del Socio</a></li>
                <li><a href="#tabs-2">Workouts</a></li>    
                <li><a href="#tabs-3">Skills</a></li>
                <li><a href="#tabs-4">Maxer Pr</a></li>
                <li><a href="#tabs-5">Foto de Perfil del socio</a></li>
        </ul>  
        <div id="tabs-1">      
            <div class="container">
                <div class="page-title">
                    <h1>Socios</h1>
                    <h2>Editar Socio</h2>
                </div>
                <form name="emailForm" id="emailForm" method="POST" action="funciones.php"  enctype="multipart/form-data">
                <div class="container">
                    <p class="mensaje_valido">Favor de llenar los campos.</p>
                    <input  id = "id_edicion" name="id_edicion" class="texto" type="hidden" >
                    <fieldset>
                    <legend>Datos Personales</legend> 
                    <div class="frm-field">
                       <div class="field-label"><label>Correo electr&oacute;nico:</label></div>
                       <div class="field-input">
                           <input  id = "emaile" name="email" class="texto" type="text" placeholder="Correo Electr&oacute;nico:" readonly  disabled>
                        </div>
                    </div> 
                    <div class="frm-field">
                       <div class="field-label"><label>Nombre del Socio:</label></div>
                       <div class="field-input">
                          <input  id = "nombree"   class="texto" name="nombre" type="text" placeholder="Nombre del socio:">
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Apellido Paterno:</label></div>
                       <div class="field-input">
                          <input  id = "apellido_paternoe" class="texto"  name="apellido_paterno" type="text" placeholder="Apellido paterno:">
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Apellido Materno:</label></div>
                       <div class="field-input">
                           <input  id = "apellido_maternoe" class="texto"  name="apellido_materno" type="text" placeholder="Apellido materno:">
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Genero:</label></div>
                       <div class="field-input"> 
                        <select name="sexoe" id="sexoe" class="texto">
                            <option value=""><-Seleccione Genero-></option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                       </div>
                    </div>
                    </fieldset>
                    <br>      
                    <fieldset>
                    <legend>Direcci&oacute;n y Tel&eacute;fono:</legend>
                    <div class="frm-field">
                       <div class="field-label"><label>Calle:</label></div>
                       <div class="field-input">
                          <input  id = "callee" name="calle" class="texto" type="text" placeholder="Calle:">
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Colonia:</label></div>
                       <div class="field-input">
                           <input  id = "coloniae" name="colonia" class="texto" type="text" placeholder="Colonia:"> 
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Tel&eacute;fono:</label></div>
                       <div class="field-input">
                           <input  id = "telefonoe" name="Telefono" class="texto" type="text" placeholder="telefono:"> 
                        </div>
                    </div>
                    </fieldset>
                    <br>      
                    <fieldset>
                    <legend>Datos Personales:</legend>
                    <div class="frm-field">
                       <div class="field-label"><label>Edad:</label></div>
                       <div class="field-input">
                          <input  id = "edade" name="edad" class="texto" type="text" placeholder="Edad:">
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Altura(cm.):</label></div>
                       <div class="field-input">
                           <input  id = "alturae" name="alturae" class="texto" type="text" placeholder="Altura:"> 
                        </div>
                    </div>
                    <div class="frm-field">
                       <div class="field-label"><label>Peso (kg.):</label></div>
                       <div class="field-input">
                           <input  id = "pesoe" name="pesoe" class="texto" type="text" placeholder="Peso:"> 
                        </div>
                    </div>
                    </fieldset>
                    <br>
                    <fieldset>
                    <legend>Informaci&oacute;n sobre Mensualidad</legend>
                    <div class="frm-field">
                       <div class="field-label"><label>Mensualidad (Opcional):</label></div>
                       <div class="field-input">
                           <input  id = "mensualidade"  class="texto" name="mensualidad" type="text" placeholder="Mensualidad sugerida (opcional):"> 
                        </div>
                    </div>
                    </fieldset>
               </div> 
            </div>
        </div>
        <div id="tabs-2">
            <div class="page-title">
                <h1>Socios</h1>
                <h2>Editar Socio</h2>                
            </div>
            <div class="container">
                <p class="mensaje_valido">Favor de llenar los campos.</p>
                    <div class="col_4 left">
                        <label>Fran:</label><input  id = "iFran" name="fran" class="texto" type="text" placeholder="Fran:">
                    </div>
                    <div class="col_4 left">
                        <label>Helen:</label><input  id = "iHelen" name="helen" class="texto" type="text" placeholder="Helen:">
                    </div>
                    <div class="col_4 left">
                        <label>Grace:</label><input  id = "iGrace" name="grace" class="texto" type="text" placeholder="Grace:">
                    </div>
                    <div class="col_4 left">
                        <label>Filthy:</label><input  id = "iFilthy" name="fran" class="texto" type="text" placeholder="Filthy:">
                    </div>
                    <div class="col_4 left">
                        <label>Row:</label><input  id = "iRow" name="fran" class="texto" type="text" placeholder="Row:">
                    </div>
                    <div class="col_4 left">
                        <label>Sprint:</label><input  id = "iSprint" name="fran" class="texto" type="text" placeholder="Sprint:">
                    </div>
                    <div class="col_4 left"> 
                        <label>Run:</label><input  id = "iRun" name="fran" class="texto" type="text" placeholder="Run:">
                    </div>
            </div>  
        </div>
        <div id="tabs-3">
            <div class="page-title">
                <h1>Socios</h1>
                <h2>Editar Socio</h2>                
            </div>            
            <div class="container">
            <p class="mensaje_valido">Favor de llenar los campos.</p>
                   <div class="frm-field">
                       <div class="field-label"><label>Rope Climb:</label></div>
                       <div class="field-input">
                           <select name="eRope" id="eRope"  class="texto"placeholder="rope claims:">   
                                <option value=""><-Seleccione una opcion-></option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                   </div>
                   <div class="frm-field">
                       <div class="field-label"><label>DU:</label></div>
                       <div class="field-input">
                           <select name="eDu" class="texto" id="eDu" placeholder="DU:">   
                                <option value=""><-Seleccione una opcion-></option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                           </select>
                       </div>
                   </div>
                   <div class="frm-field">
                       <div class="field-label"><label>5M - 3W HSPU:</label></div>
                       <div class="field-input">
                           <select name="eHspu" id="eHspu" placeholder="5M - 3W HSPU:">   
                                <option value=""><-Seleccione una opcion-></option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                           </select>
                       </div>
                   </div>
                   <div class="frm-field">
                       <div class="field-label"><label>5M - 3W PULL UPS:</label></div>
                       <div class="field-input">
                        <select name="ePulls" id="ePulls" placeholder="5M - 3W PULL UPS:">   
                            <option value=""><-Seleccione una opcion-></option>
                            <option value="si">Si</option>
                            <option value="no">No</option>
                          </select>
                       </div>
                   </div>
                   <div class="frm-field">
                       <div class="field-label"><label>M5 - 3W MTS  WALK HS:</label></div>
                       <div class="field-input">
                           <select name="eMtsWalk" id="eMtsWalk" placeholder="M5 - 3W MTS  WALK HS:">   
                                <option value=""><-Seleccione una opcion-></option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                           </select>
                       </div>
                   </div>
                   <div class="frm-field">
                       <div class="field-label"><label>BOX JUMP MAX INCH:</label></div>
                       <div class="field-input">
                           <input  id = "iBoxJump" name="iBoxJump" class="texto" type="text" placeholder="BOX JUMP MAX INCH:">
                       </div>
                   </div>
                   <div class="frm-field">
                       <div class="field-label"><label>Ring Muscle Up:</label></div>
                       <div class="field-input">
                            <select name="eRingMuscle" id="eRingMuscle" placeholder="Ring Muscle Up:">   
                                <option value=""><-Seleccione una opcion-></option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                       </div>
                   </div>
            </div> 
        </div>   
         <div id="tabs-5">
                <div class="page-title">
                    <h1>Socios</h1>
                    <h2>Editar Socio</h2>
                </div>
         
            <div class="container">
                <p class="mensaje_valido">Favor de llenar los campos.</p>
                <div class="foto-perfil"><img id = "foto_perfil_socio_consulta" src="" border="0" width="200" height="180" alt="foto_perfil.jpg"></div>
                <p>Subir foto de perfil: <input type="file" name="file" id="file_imagen" ></p>
                    <div align="left"><input type="submit" value="Subir Foto" id="button_submit"  class="btn_2" ></div>
                 <input type="hidden" name="accion" id="accion" value="subir_imagen_socio"  />
                 <div id="loading"></div> 
                </div>
            </div>               
        <div id="tabs-4">
            <div class="page-title">
                <h1>Socios</h1>
                <h2>Editar Socio</h2>
            </div>
            <div class="container">
                <p class="mensaje_valido">Favor de llenar los campos.</p>
                <div class="col_4 left">
                   <label>Clean & Jerk:</label><input  id = "iCleanJerk" name="iCleanJerk" class="texto" type="text" placeholder="Clean & Jerk:">
                </div>
                <div class="col_4 left">
                   <label>Snatch:</label><input  id = "iSnatch" name="iSnatch" class="texto" type="text" placeholder="Snatch:">
                </div>
                <div class="col_4 left">
                   <label>Deadlift:</label><input  id = "iDeadlift" name="iDeadlift" class="texto" type="text" placeholder="Deadlift:">
                </div>
                <div class="col_4 left">
                   <label>Back Squat:</label><input  id = "iBackSquat" name="iBackSquat" class="texto" type="text" placeholder="Back Squat:">
                </div>
                <div class="col_3 left">
                   <label>Max Pull-ups:</label><input  id = "iMaxPullUps" name="iMaxPullUps" class="texto" type="text" placeholder="Max Pull-ups:">
                </div>
                <div class="col_3 left">
                   <label>Max MUSCLE -UP:</label><input  id = "iMaxMuscleUp" name="iMaxMuscleUp" class="texto" type="text" placeholder="Max MUSCLE -UP:">
                </div>
                <div class="col_3 left">
                   <label>MAX BURPEES MIN:</label><input  id = "iMaxBurpeesMin" name="fran" class="texto" type="text" placeholder="MAX BURPEES MIN:">
                </div>
            </div>  
            
           
            
                       
            </form>
        </div>       
    
    
    
</div>

</body>
</html>
<?php }?>
                