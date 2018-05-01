<!DOCTYPE html>
<html>

<head>

<?php
    require_once('../../../inc_base.php');  
?>

  <title>Sistema MNK</title>

  <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
  <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">

<style>
  #gallery { float: left; width: 65%; min-height: 12em; }
  .gallery.custom-state-active { background: #eee; }
  .gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
  .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
  .gallery li a { float: right; }
  .gallery li a.ui-icon-zoomin { float: left; }
  .gallery li img { width: 100%; cursor: move; }
 
  #trash { float: right; width: 32%; min-height: 18em; padding: 1%; }
  #trash h4 { line-height: 16px; margin: 0 0 0.4em; }
  #trash h4 .ui-icon { float: left; }
  #trash .gallery h5 { display: none; }
</style>  

  <script>

  var registros = [];
  registros = registros.concat({'HdIdProyecto':'<?=$_GET['pro']?>'});
  registros = registros.concat({'HdIdRol':'<?=xps_encriptar(1)?>'});//Inactivo sin permisos

  $(function() {
    // Este es un álbum y una papelera de reciclaje
    var $gallery = $( "#gallery" ),
      $trash = $( "#trash" );
 
    // Hacer que las entradas del álbum se puedan arrastrar y soltar
    $( "li", $gallery ).draggable({
      cancel: "a.ui-icon", // Al hacer clic en un ícono, no se iniciará el arrastre
      revert: "invalid", // Cuando no se coloca, la entrada se restaura a su ubicación original
      containment: "document",
      helper: "clone",
      cursor: "move"
    });
 
    // Hacer que las 
    $( "li", $trash ).draggable({
      cancel: "a.ui-icon", // Al hacer clic en un ícono, no se iniciará el arrastre
      revert: "invalid", // Cuando no se coloca, la entrada se restaura a su ubicación original
      containment: "document",
      helper: "clone",
      cursor: "move"
    });

    // Deje que la papelera de reciclaje se coloque y acepte la entrada del álbum
    $trash.droppable({
      accept: "#gallery > li",
      activeClass: "ui-state-highlight",
    //hoverClass: "ui-state-hover",//
      drop: function( event, ui ) {
        deleteImage( ui.draggable );
      }
    });
 

 
    // Deje que el álbum se coloque y acepte las entradas de la Papelera de reciclaje
    $gallery.droppable({
      accept: "#trash li",
      activeClass: "custom-state-active",
      drop: function( event, ui ) {
        recycleImage( ui.draggable );
      }
    });
 
    // Función de eliminación de imagen
    var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Restaurar' class='ui-icon ui-icon-refresh'>Restaurar</a>";
    function deleteImage( $item ) {

      var paso = $item.attr( "id" );
      registros = registros.concat({'id':paso});
      console.log(registros);
  
      $item.fadeOut(function() {
        var $list = $( "ul", $trash ).length ?
          $( "ul", $trash ) :
          $( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );
    
        $item.find( "a.ui-icon-trash" ).remove();
        $item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
          $item
            .animate({ width: "48px" })
            .find( "img" )
              .animate({ height: "36px" });
        });
      });
    }
 
    // Función de restauración de imagen
    var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Eliminar' class='ui-icon ui-icon-trash'>Eliminar</a>";
    function recycleImage( $item ) {

      var paso = $item.attr( "id" );
      var elemento = registros.findIndex(function findFirstLargeNumber(item) { return item.id===paso;});
      registros.splice(elemento,1);
      console.log(registros);

      $item.fadeOut(function() {
        $item
          .find( "a.ui-icon-refresh" )
            .remove()
          .end()
          .css( "width", "96px")
          .append( trash_icon )
          .find( "img" )
            .css( "height", "72px" )
          .end()
          .appendTo( $gallery )
          .fadeIn();
      });
    }
 
    // Función de vista previa de la imagen, demo ui.dialog como ventana modal
    function viewLargerImage( $link ) {
      var src = $link.attr( "href" ),
        title = $link.siblings( "img" ).attr( "alt" ),
        $modal = $( "img[src$='" + src + "']" );
 
      if ( $modal.length ) {
        $modal.dialog( "open" );
      } else {
        var img = $( "<img alt='" + title + "' width='384' height='288' style='display: none; padding: 8px;' />" )
          .attr( "src", src ).appendTo( "body" );
        setTimeout(function() {
          img.dialog({
            title: title,
            width: 400,
            modal: true
          });
        }, 1 );
      }
    }
 
    // Resuelva el comportamiento del icono a través de proxies de eventos
    $( "ul.gallery > li" ).click(function( event ) {
      var $item = $( this ),
        $target = $( event.target );
 
      if ( $target.is( "a.ui-icon-trash" ) ) {
        deleteImage( $item );
      } else if ( $target.is( "a.ui-icon-zoomin" ) ) {
        viewLargerImage( $target );
      } else if ( $target.is( "a.ui-icon-refresh" ) ) {
        recycleImage( $item );
      }
 
      return false;
    });
  
//  var item = document.getElementById("1");

//  var item = function( event, ui ) {$item = ui.id[8];}
  <?php
    for($i=0;$i<0;$i++){
  ?>
  deleteImage( $("#<?=$i?>") ); 
  <?php
    }
  ?>
  });

  
  </script>
  
</head>

<body>

<?php
  $xps_titulo_barra = "PROYECTOS";
  $xps_ver_submenu  = 1;
  require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php'); 
  
//############## MENU ######################//  
  echo $_SESSION['valida']['menu'];
  echo $_SESSION['Proyectos'];
//############## MENU ######################//  
?>


  <div class="main-content">
  <!-- *********** INICIO ************ -->
    <div class="col-md-12"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
      <div class="widget widget-blue" style="height:500px">
        <?php
          $xps_titulo     ="USUARIOS DEL PROYECTOS";//<-- MODIFICABLE          
          $xps_volver     ="grid_usuarios.php?cl=".$_GET['cl']."&pro=".$_GET['pro'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
          $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
          $xps_color      =0;//<-- MODIFICABLE
          $xps_actualizar =1;//<-- MODIFICABLE
          $xps_minimizar  =0;//<-- MODIFICABLE
          $xps_cerrar     =0;//<-- MODIFICABLE

          widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
        ?>
        <div class="widget-content">
<!-- INICIO CONTENIDO -->
<div class="ui-widget ui-helper-clearfix">
 
<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">

<?php

  $id_proyecto = xps_desencriptar($_GET['pro']);


  $db = new MySQL();

  $sql = "SELECT 
            `u`.`id_usuario`,
            `e`.`nom_fantasia_emp`,
            `p`.`nombre_pers`,
            `p`.`paterno_pers`,
            `p`.`materno_pers`,
            `u`.`foto_usuario`,
            `p`.`rut_pers`,  
            (SELECT `c`.`nombre_cargo` FROM `trabajadores` `t` LEFT OUTER JOIN `trabajadores_cargo` `tc` ON (`t`.`id_trab` = `tc`.`id_trab`) LEFT OUTER JOIN `cargos` `c` ON (`tc`.`id_cargo` = `c`.`id_cargo`) WHERE `t`.`id_persona` = `p`.`id_persona` AND `t`.`estado_trab` = 1) AS `cargo`
          FROM
            `_usuarios` `u`
            LEFT OUTER JOIN `personas` `p` ON (`u`.`id_persona` = `p`.`id_persona`)
            LEFT OUTER JOIN `empresas` `e` ON (`u`.`id_emp` = `e`.`id_emp`)
          WHERE
            `u`.`estado_usuario` = 1 AND 
            `u`.`eliminado_usuario` = 0 AND
            `u`.`id_usuario` NOT IN (SELECT `pu`.`id_usuario` FROM `proyectos_usuarios` `pu` WHERE `pu`.`id_proyecto` = $id_proyecto)
          ORDER BY
            `e`.`nom_fantasia_emp`,
            `u`.`estado_usuario` DESC,
            `u`.`eliminado_usuario`,
            `p`.`nombre_pers`,
            `p`.`paterno_pers`,
            `p`.`materno_pers`";  

  $consulta = $db->consulta($sql);
  $incorporados = "";
  
  if($db->num_rows($consulta)>0){
    $i = 1;
    while($rs = $db->fetch_array($consulta)){

        $fotosusuarios = $rs['rut_pers'].".png";
        if($rs['foto_usuario'] == 0) $fotosusuarios = "sin_foto.png";

?>
  <li class="ui-widget-content ui-corner-tr" id="<?=$rs['id_usuario']?>">
    <h5 class="ui-widget-header"><?=$rs['nombre_pers']?> <?=$rs['paterno_pers']?> <?=$rs['materno_pers']?></h5>
    <img src="../../../img.php?r=fotosusuarios.img/<?=$fotosusuarios?>" alt="<?=$rs['nombre_pers']?>" width="40" height="70">
    <a href="../../../img.php?r=fotosusuarios.img/<?=$fotosusuarios?>" title="Ver imagen más grande" class="ui-icon ui-icon-zoomin">Ver imagen más grande</a>
    <a href="link/to/trash/script/when/we/have/js/off" title="Eliminar" class="ui-icon ui-icon-trash">Eliminar</a>

    <font size="1px"><?=$rs['cargo']?></font>
  </li>  
<?php
    }
  }
?> 
</ul>
 
<div id="trash" class="ui-widget-content ui-state-default">
        <div class="row">
          <div class="col-md-10" style="padding-right: 0px;">  
            <h4 class="ui-widget-header" style="padding-top: 8px;padding-bottom: 8px;">
              <span class="ui-icon ui-icon-trash"></span>Usuarios Activos
            </h4>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-action btn-lg btn-primary" id="guardar" style="color:#0ea5ab;padding-left: 0px;padding-right: 0px;padding-top: 0px;" >
              <i class="fa fa-save"></i>
            </button>
          </div>
        </div>

<?php


  $db = new MySQL();

  $sql = "SELECT 
            `pu`.`id_usuario`,
            `p`.`rut_pers`,
            `p`.`nombre_pers`,
            `p`.`paterno_pers`,
            `p`.`materno_pers`,
            `u`.`foto_usuario`
          FROM
            `proyectos_usuarios` `pu`
            LEFT OUTER JOIN `_usuarios` `u` ON (`pu`.`id_usuario` = `u`.`id_usuario`)
            LEFT OUTER JOIN `personas` `p` ON (`u`.`id_persona` = `p`.`id_persona`)
          WHERE
            `pu`.`id_proyecto` = $id_proyecto
          ORDER BY
            `u`.`estado_usuario` DESC,
            `u`.`eliminado_usuario`,
            `p`.`nombre_pers`,
            `p`.`paterno_pers`,
            `p`.`materno_pers`";  

  $consulta = $db->consulta($sql);

  if($db->num_rows($consulta)>0){
    $i = 1;
    echo '<ul class="gallery ui-helper-reset">';
    while($rs = $db->fetch_array($consulta)){

        $fotosusuarios = $rs['rut_pers'].".png";
        if($rs['foto_usuario'] == 0) $fotosusuarios = "sin_foto.png";

        if ($i==1) $incorporados .= "{'id': ".$rs['id_usuario']."}";
        else $incorporados .= ",{'id': ".$rs['id_usuario']."}";

          $i++;

?>

<li class="ui-widget-content ui-corner-tr ui-draggable ui-draggable-handle" id="<?=$rs['id_usuario']+3?>" style="display: list-item; width: 48px;">
    <h5 class="ui-widget-header"><?=$rs['nombre_pers']?></h5>
    <img src="../../../img.php?r=fotosusuarios.img/<?=$fotosusuarios?>" alt="<?=$rs['nombre_pers']?>" style="display: inline-block; height: 36px;" width="40" height="70">
    <a href="../../../img.php?r=fotosusuarios.img/<?=$fotosusuarios?>" title="Ver imagen más grande" class="ui-icon ui-icon-zoomin">Ver imagen más grande</a>
    

    <font size="1px"></font>
  <a href="link/to/recycle/script/when/we/have/js/off" title="Restaurar" class="ui-icon ui-icon-refresh">Restaurar</a></li>

<?php
    }
    echo "</ul>";
  }
?>

</div>
 
</div>
<!--  FIN CONTENIDO   -->
        </div>                
      </div>
    </div>  
  <?php
    for($i=1;$i<29;$i++){
      echo "<br>";
    }
  ?>
  <!-- *********** FIN ************ -->
  </div>
  <!-- *********** PIÉ DE PÁGINA ************ -->
  <div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');
    
    $accion = 3;
    $ruta_guarda_form = "guardar_usuarios/guardar_model.php";//<--- MODIFICABLE

?>
<script>

   $(function() {//guardar registros

      <?php
          if($incorporados) echo "registros = registros.concat($incorporados);";
      ?>

        $('#guardar').click(function(){
            console.log(JSON.stringify(registros));

//          return false;
       //Guardar

            var dataString = JSON.stringify(registros);

        $.ajax({
                data:  dataString,
                url:   '<?=$ruta_guarda_form?>',
                type:  'POST',
                beforeSend: function () {
                  $("#trash").html("Procesando, espere por favor...");
                  $("#audiotag1")[0].play();
                },
                success:  function (response) {
                  $("#trash").html(response);
                       setTimeout(function () {
                        <?php
                          if($accion>1){
                            echo "$(location).attr('href','$xps_volver');";
                          }
                         ?>
                       }, 4000);          
                }
        });            


          return false;
        });        
    });
</script>

<!-- @include _footer