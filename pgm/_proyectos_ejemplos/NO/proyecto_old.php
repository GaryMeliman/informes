<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
    require_once('../inc_base.php');  
?>

<link rel='stylesheet' type="text/css" href='<?=xps_ruteador()?>estilos/jquery-ui.css'>


<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

</head>

<body class="glossed">

<?php
  $xps_titulo_barra = "Proyectos";//<--------MODIFICABLE TITULO
  $xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
  require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php'); 
  
//############## MENU ######################//  
  echo $_SESSION['valida']['menu'];
  echo $_SESSION['Proyectos'];
//############## MENU ######################//  
?>


  <div class="main-content">



  <!-- *********** INICIO ************ -->
    <div class="row">

<h1 class="page-title page-title-hard-bordered" style="margin-top: 0px;">
      <i class="fa fa-file-text-o"></i><?=xps_desencriptar($_GET['n'])?>
</h1>  
<?php
//_______________________________ ETAPAS _______________________________________

  $db = new MySQL();

  $id_proyecto = xps_desencriptar($_GET['pro']);

  $sql = "SELECT 
            `e`.`id_etapa`,
            `p`.`nombre_proyecto`,
            `e`.`nombre_etapa`,
            `e`.`porcentaje_etapa`
          FROM
            `etapas` `e`
            LEFT OUTER JOIN `proyectos` `p` ON (`e`.`id_plantilla_doc` = `p`.`id_plantilla_doc`)
          WHERE
            `p`.`id_proyecto` = $id_proyecto";  



  $consulta = $db->consulta($sql);
      $r=0;
  if($db->num_rows($consulta)>0){
      while($rs = $db->fetch_array($consulta)){

?>          

    <div class="col-md-6">
      <?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
      <div class="widget widget-blue">
        <?php
          $xps_titulo     = $rs['nombre_etapa']." - ".$rs['porcentaje_etapa']."%";//<-- MODIFICABLE         
          $xps_volver     ="grid_proyectos.php?cl=".$_GET['cl'];//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
          $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
          $xps_color      =0;//<-- MODIFICABLE
          $xps_actualizar =0;//<-- MODIFICABLE
          $xps_minimizar  =1;//<-- MODIFICABLE
          $xps_cerrar     =0;//<-- MODIFICABLE

          widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
        ?>
        <div class="widget-content">
<!-- INICIO CONTENIDO -->
          <div class="row" style="margin-left: -30px;margin-right: -40px;">

            <div class="col-md-9">
              <div class="row">

<?php
//_______________________________ DOCUMENTOS DE LAS ETAPAS _______________________________________
  $sql2 = "SELECT 
              `ped`.`id_etapa`,
              `ped`.`id_documento`,
              `d`.`nombre_doc`,
              `e`.`nombre_etapa`,
              `e`.`porcentaje_etapa`,
              `ped`.`porcentaje_doc_etapa`,
              `ped`.`estado_doc_etapa`,
              `pd`.`id_proyecto`,
              `pd`.`id_entrega`,
              `pd`.`fecha_entrega`,
              `ee`.`nombre_entrega`,
              `ee`.`accion_entrega`,
              `dtd`.`img_tipo_doc`
            FROM
              `plantillas_etapas_doc` `ped`
              LEFT OUTER JOIN `etapas` `e` ON (`ped`.`id_etapa` = `e`.`id_etapa`)
              LEFT OUTER JOIN `documentos` `d` ON (`ped`.`id_documento` = `d`.`id_documento`)
              LEFT OUTER JOIN `proyectos_documentos` `pd` ON (`ped`.`id_etapa` = `pd`.`id_etapa`)
              AND (`ped`.`id_documento` = `pd`.`id_documento`)
              LEFT OUTER JOIN `estados_entregas` `ee` ON (`pd`.`id_entrega` = `ee`.`id_entrega`)
              LEFT OUTER JOIN `documentos_tipo_doc` `dtd` ON (`d`.`id_tipo_doc` = `dtd`.`id_tipo_doc`)
            WHERE
              `ped`.`id_etapa` = ".$rs['id_etapa'];

  //              echo $sql2;              

  $consulta2 = $db->consulta($sql2);

  $cumplimiento = 0;
  $estado_cierre= "fa-unlock";
  $documentos   = 0;

  if($db->num_rows($consulta2)>0){
      while($rsd = $db->fetch_array($consulta2)){

        if($rsd['accion_entrega'] == 1){
          $cumplimiento += $rsd['porcentaje_doc_etapa'];
          $estado_cierre = "fa-lock";
        }

        $img = $rsd['img_tipo_doc'];
        if($rsd['accion_entrega'] != 1) $img = substr_replace($rsd['img_tipo_doc'],"_off.png",3);
        $documentos   = 1;
?>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">

                          <div class="row">
                            <div class="col-md-8">
                                <div class="text-left">
                                  <img src="../img.php?r=doc.img/<?=$img?>" width="20" height="20">
                                  <i class="fa <?=$estado_cierre?>"></i> <font size="1.5px"><strong><?=$rsd['nombre_doc']?></strong></font>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-right">
                                  <font size="1px"><?=$rsd['porcentaje_doc_etapa']?>%</font>
                                  
                                  <button data-toggle="tooltip" data-original-title="Editar" type="button" class="btn btn-action btn-xs btn-primary" id="create-modal1"><i class="fa fa-pencil"></i></button>
                                  <button data-toggle="tooltip" data-original-title="Revisar" type="button" class="btn btn-action btn-xs btn-info" id="create-modal2"><i class="fa fa-folder-open"></i></button>
                                  <button data-toggle="tooltip" data-original-title="Subir" type="button" class="btn btn-action btn-xs btn-danger" id="create-modal3"><i class="fa fa-external-link-square"></i></button>

<!-- Button trigger modal -->

                                </div>
                            </div>
                          <hr>
                          </div>

                      </div>
                    </div>
                  </div>
<?php
      }
  }
  else{
?>
                  <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissable">
                      <center><i class="fa fa-calendar"></i> <strong>Etapa sin documentos</strong></center>
                    </div>
                  </div>
<?php    
  }
?>
              </div>
            </div>

            <div class="col-md-3">
<?php
  if($documentos>0){
?>              
              <div id="gauge-<?=$rs['nombre_etapa']?>" style="height:90px"></div>
                <script type="text/javascript">
                  var p = new JustGage({
                    id: 'gauge-<?=$rs['nombre_etapa']?>',
                    value: <?=$cumplimiento?>,
                    gaugeWidthScale: 0.9,
                    min: 0,
                    max: 100,
                    showInnerShadow: !1,
                    showMinMax: !1,
                    gaugeColor: '#EAEAEA',
                    title: '<?=$rs['nombre_etapa']?>',
                    label:'Cumplimiento',
                    levelColors: [
                      '#DA0000',//rojo
                      '#daca00',//amarillo
                      '#00da07'//verde
                    ]    
                  });  
                </script>
<?php
  }
?>                
            </div>

          </div>
<!--  FIN CONTENIDO   -->
        </div>                
      </div>
    </div>

<?php

      }
  }
  else{//_______________________________________ NO HAY ETAPAS ______________________________
?>

    <div class="col-md-12">
      <?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
      <div class="widget widget-red">
        <?php
          $xps_titulo     = "Sin etapas";//<-- MODIFICABLE         
          $xps_volver     ="grid_proyectos.php?cl=".$_GET['cl'];//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
          $xps_fullscreen =0;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
          $xps_color      =0;//<-- MODIFICABLE
          $xps_actualizar =0;//<-- MODIFICABLE
          $xps_minimizar  =0;//<-- MODIFICABLE
          $xps_cerrar     =0;//<-- MODIFICABLE

          widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
        ?>
        <div class="widget-content">
<!-- INICIO CONTENIDO -->
          <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">NO HAY ETAPAS</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php    
  }
?>


<?php //============ VENTANA MODAL ==================?>
<!--/// MODAL 1 ----------------------------------------------- -->
<div id="dialog-form1" title="Editar archivo">
  <p class="validateTips">All form fields are required.</p>
 
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
<!--/// MODAL 2 ----------------------------------------------- -->
<div id="dialog-form2" title="Revisar archivo">
  <p class="validateTips">All form fields are required.</p>
 
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
<!--/// MODAL 3 ----------------------------------------------- -->
<div id="dialog-form3" title="Subir archivo">
  <p class="validateTips">All form fields are required.</p>
 
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
<?php //============ FIN VENTANA MODAL ==================?>




  </div>
  <!-- *********** FIN ************ -->
  </div>

  <!-- *********** PIÉ DE PÁGINA ************ -->
  <div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<script type="text/javascript">




  $( function() {

      function showUrlInDialog(url){
        $.ajax({
          url: 'dialog.html',
          success: function(data) {
            $("#dialog-form").html(data).dialog({modal:true}).dialog('open');
          }
        });
      }
//$('#create-modal1').click(function(){dialog1.dialog( "open" );});
$("create-modal1").click(function(){
  $("#dialog-form1").dialog({modal: true}).dialog('open')).load("dialog.html");
//  $("#dialog-form1").html(data).dialog({modal: true}).dialog('open');
})



    var dialog1, dialog2, dialog3, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name      = $( "#name" ),
      email     = $( "#email" ),
      password  = $( "#password" ),
      allFields = $( [] ).add( name ).add( email ).add( password ),
      tips      = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "username", 3, 16 );
      valid = valid && checkLength( email, "email", 6, 80 );
      valid = valid && checkLength( password, "password", 5, 16 );
 
      valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
      valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
      valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
      if ( valid ) {
        $( "#users tbody" ).append( "<tr>" +
          "<td>" + name.val() + "</td>" +
          "<td>" + email.val() + "</td>" +
          "<td>" + password.val() + "</td>" +
        "</tr>" );
        dialog1.dialog( "close" );
      }
      return valid;
    }
 
 //MODAL 1___________________________________________
    dialog1 = $( "#dialog-form1" ).dialog({
      autoOpen: false,
      height: 400,
      width: 350,
      modal: true,
      buttons: {
        "Subir Archivo": addUser,
        Cancel: function() {
          dialog1.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });

//$('#create-modal1').click(function(){dialog1.dialog( "open" );});
$('#create-modal1').click(function(){dialog1.dialog( "open" );});

 //MODAL 2___________________________________________
    dialog2 = $( "#dialog-form2" ).dialog({
      autoOpen: false,
      height: 400,
      width: 350,
      modal: true,
      buttons: {
        "Revisar Archivo": addUser,
        Cancel: function() {
          dialog2.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });

$('#create-modal2').click(function(){dialog2.dialog( "open" );});

 //MODAL 3___________________________________________
    dialog3 = $( "#dialog-form3" ).dialog({
      autoOpen: false,
      height: 400,
      width: 350,
      modal: true,
      buttons: {
        "Subir Archivo": addUser,
        Cancel: function() {
          dialog3.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });

$('#create-modal3').click(function(){dialog3.dialog( "open" );});
 
    form = dialog1.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 


/*    $( "#create-modal" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });*/

  } );
  </script>





<!-- @include _footer