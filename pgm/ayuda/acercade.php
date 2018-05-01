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
      <i class="fa fa-file-text-o"></i>Acerca de...
</h1>


  <div class="row">
          <div class="col-sm-6">
            <div class="avatar-w">
              <img src="img/acerca_de_modulonet.cl.png" alt="modulonet.cl" class="img-max">
            </div>
          </div>
      <div class="left-inner-shadow">            
                  <div class="col-sm-9 col-md-5 col-lg-4">
                    <div class="profile-main-info">
                      <h1>Modulonet.cl</h1>
                      <p style="text-align: justify;">Completely synergize resource sucking relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.</p>

                      <a href="#">modulonet.cl <i class="fa fa-external-link-square icon-left-margin"></i></a>
                    </div>
                    <div class="profile-details visible-lg">
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa fa-map-marker"></i></div> Chile
                        </div>
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa fa-calendar"></i></div> Dec 06
                        </div>
                        <div class="col-lg-4">
                          <div class="icon"><i class="fa fa-male"></i></div> Male
                        </div>
                      </div>
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