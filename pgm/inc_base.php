<?php 
	require_once(dirname(__FILE__).'/../conexion/conexion.php');
	require_once(dirname(__FILE__).'/_filtros/filtros.php');

@session_start();
  if(!isset($_SESSION['valida']['menu'])) redireccionar();

	$xps_ruta_base = $_SESSION['valida']['ruta'];
	echo "\n<script type='text/javascript'>";
	echo "var menuRuta = '".$xps_ruta_base."';";
	echo "</script>\n";	
	echo '<script type="text/javascript" src="'.xps_ruteador() . 'js/ruteador.js"></script>'."\n";		
?>
<?php header('Content-Type: text/html; charset=UTF-8'); ?>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel='stylesheet' type="text/css" href='<?=xps_ruteador()?>estilos/estilo.css'>
  <link rel="stylesheet" type="text/css" href="<?=xps_ruteador()?>estilos/css.css">  
  <link rel='stylesheet' type="text/css" href='<?=xps_ruteador()?>estilos/pnotify.custom.min.css'>
  <!--link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Oswald:300,400,700|Open+Sans:400,700,300|Roboto:100,300,400,700|Roboto+Condensed:300,400,700' rel='stylesheet' type='text/css'-->

  <link href="<?=xps_ruteador()?>assets/favicon.ico" rel="shortcut icon">
  <link href="<?=xps_ruteador()?>assets/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    @javascript html5shiv respond.min
  <![endif]-->

<?php
//_________________________ FUNCION ENCABEZADO ___________________________________________________________
  function widget_controls($xps_titulo="",$volver="",$fullscreen=0,$color=0,$actualizar=0,$minimizar=0,$cerrar=0){
    $xps_id = str_replace("", " ", $xps_titulo);
?>    
    <div class="widget widget-blue" id="<?=$xps_id?>">
      <span class="offset_anchor" id="widget_send_a_message"></span>
      <div class="widget-title">
        <div class="widget-controls">
<?php
    if($volver!=""){
?>            
<!-- volver -->
          <a href="javascript:;" onclick="window.location.href=ruteador(1,'<?=$volver?>');" class="widget-control widget-control-back" data-toggle="tooltip" data-placement="top" title="" data-original-title="Volver">
            <i class="fa fa-reply"></i>
          </a>
<?php
    }

    if($fullscreen!=0){
?>  
<!-- fullscreen --> 
            <a href="#" class="widget-control widget-control-full-screen" data-toggle="tooltip" data-placement="top" title="" data-original-title="Full Screen">
              <i class="fa fa-expand"></i>
            </a>
            <a href="#" class="widget-control widget-control-full-screen widget-control-show-when-full" data-toggle="tooltip" data-placement="left" title="" data-original-title="Exit Full Screen">
              <i class="fa fa-expand"></i>
            </a>
<?php
    }

    if($color!=0){
?>  
<!-- color barra -->          
          <div class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
            <a href="#" data-toggle="dropdown" class="widget-control widget-control-settings">
              <i class="fa fa-cog"></i>
            </a>
              <ul class="dropdown-menu dropdown-menu-small" role="menu" aria-labelledby="dropdownMenu1">
                <li class="dropdown-header">Set Widget Color</li>
                <li><a data-widget-color="blue" class="set-widget-color" href="#">Blue</a></li>
                <li><a data-widget-color="red" class="set-widget-color" href="#">Red</a></li>
                <li><a data-widget-color="green" class="set-widget-color" href="#">Green</a></li>
                <li><a data-widget-color="orange" class="set-widget-color" href="#">Orange</a></li>
                <li><a data-widget-color="purple" class="set-widget-color" href="#">Purple</a></li>
              </ul>
          </div>
<?php
    }

    if($actualizar!=0){
?>  
<!-- actualizar -->  
            <a href="#" class="widget-control widget-control-refresh" data-toggle="tooltip" data-placement="top" title="" data-original-title="Refresh">
              <i class="fa fa-refresh"></i>
            </a>
<?php
    }

    if($minimizar!=0){
?>  
<!-- minimizar -->
            <a href="#" class="widget-control widget-control-minimize" data-toggle="tooltip" data-placement="top" title="" data-original-title="Minimize">
              <i class="fa fa-minus-circle"></i>
            </a>
<?php
    }

    if($cerrar!=0){
?>    
<!-- cerrar -->
            <a href="#" class="widget-control widget-control-remove" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove">
              <i class="fa fa-times-circle"></i>
            </a>
<?php
    }
?>  
        </div>
<!-- título -->        
        <h3><i class="fa fa-th"></i> <?=$xps_titulo?></h3>
      </div>
<?php
  }
?> 