<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
    require_once('../inc_base.php');  
?>

<!--//############   AQUI NUEVOS JS O CSS   ######################//
    ojo que todo los js de jquery estan al final de la página
          BORRAR SI NO SE OCUPA

    //############ FIN AQUI NUEVOS JS O CSS ######################//-->

</head>

<body class="glossed">

<?php
  $xps_titulo_barra = "AYUDA";
  $xps_ver_submenu  = 1;
  require_once('../barra_usuario.php'); 
  
//############## MENU ######################//  
  echo $_SESSION['valida']['menu'];
  echo $_SESSION['Ayuda'];
//############## MENU ######################//  
?>


  <div class="main-content">
  <!-- *********** INICIO ************ -->
    <div class="col-md-12">

        <div class="widget-content">
<!-- INICIO CONTENIDO -->


<h1 class="page-title page-title-hard-bordered">
      <i class="fa fa-gear"></i>Soporte
</h1>

<div class="error-page-wrapper">
      <div class="picture-w">
        <i class="fa fa-gears"></i>
      </div>
      <h1>Soporte</h1>
      <h3>How can we help you?</h3>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="big-search-box">
            <form class="" role="form">
              <div class="input-group">
                <input class="form-control nrb input-lg" placeholder="ingrese su busqueda..." type="text">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-primary dropdown-toggle btn-iconed btn-lg" data-toggle="dropdown"><i class="fa fa-search"></i> <span>Buscar</span></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>






<!--  FIN CONTENIDO   -->
        </div>                

    </div>  

  <!-- *********** FIN ************ -->
  </div>
  <!-- *********** PIÉ DE PÁGINA ************ -->
  <div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<script src="<?=xps_ruteador()?>js/jquery.min.js"></script>
<script src="<?=xps_ruteador()?>js/jquery-ui.min.js"></script>
<script src='<?=xps_ruteador()?>js/notificacion_ac6.js'></script>

<!-- @include _footer