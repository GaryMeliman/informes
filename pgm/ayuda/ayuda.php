<!DOCTYPE html>
<html>

<head>
<?php
		require_once('../inc_conexion_base.php');	
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  

  <link rel='stylesheet' href='../../estilos/estilo.css'>

  <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Oswald:300,400,700|Open+Sans:400,700,300|Roboto:100,300,400,700|Roboto+Condensed:300,400,700' rel='stylesheet' type='text/css'>

  <link href="../../assets/favicon.ico" rel="shortcut icon">
  <link href="../../assets/apple-touch-icon.png" rel="apple-touch-icon">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    @javascript html5shiv respond.min
  <![endif]-->

  <title>Sistema MNK</title>

</head>

<body>

<div class="all-wrapper fixed-header left-menu">

  <div class="page-header">
    <div class="header-links hidden-xs">
      <div class="top-search-w pull-right">
        <input class="top-search" placeholder="Buscar" type="text">
      </div>

      <div class="dropdown hidden-sm hidden-xs">
        <a href="#" data-toggle="dropdown" class="header-link"><i class="icon-bolt"></i>
          Notificaciones <span class="badge alert-animated">5</span></a>
      </div>

      <div class="dropdown hidden-sm hidden-xs">
        <a href="#" data-toggle="dropdown" class="header-link"><i class="icon-cog"></i> Configuración</a>
      </div>

      <div class="dropdown">
        <a href="#" class="header-link clearfix" data-toggle="dropdown">
          <div class="avatar">
            <img src="../../assets/images/avatar-small.jpg" alt="">
          </div>
          <div class="user-name-w">
            USUARIO <i class="icon-caret-down"></i>
          </div>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li><a href="#">Separated link</a></li>
          <li><a href="#">One more separated link</a></li>
        </ul>
      </div>
    </div>

    <a class="logo hidden-xs" href="index.html"><i class="icon-rocket"></i></a>
    <a class="menu-toggler" href="#"><i class="icon-reorder"></i></a>
    <h1>FAQ</h1>
  </div>

  <?php
	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Ayuda'];
	
  ?>
  
<div class="main-content">

  <div class="widget widget-blue" style="height:500px">
    <div class="widget-title">
        <div class="widget-controls">
          <a href="#" class="widget-control widget-control-refresh" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="icon-refresh"></i></a>
          <a href="#" class="widget-control widget-control-minimize" data-toggle="tooltip" data-placement="top" title="" data-original-title="Minimizar"><i class="icon-minus-sign"></i></a>
        </div>
        <h3><i class="icon-th"></i>Formulario</h3>
    </div>

    <div class="widget-content">



    </div>                

  </div>


</div>



<script src="../../js/jquery.min.js"></script>
<script src="../../js/jquery-ui.min.js"></script>
<script src='../../js/configuracion.js'></script>
<script src='../../js/parametros.js'></script>

<!-- @include _footer