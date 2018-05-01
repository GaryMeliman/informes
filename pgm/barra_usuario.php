<?php
	//mostrar u ocultar submenu
	$hide_sub_menu = (isset($_GET['a']) ? "" : ($xps_ver_submenu==0 ? "hide-sub-menu" : "" ));
?>
<div class="all-wrapper fixed-header left-menu <?=$hide_sub_menu?>" style="top: 0px;">

  <div class="page-header">
    <div class="header-links hidden-xs">
      <div class="top-search-w pull-right">
        <input class="top-search" placeholder="Buscar" type="text">
      </div>

      <div class="dropdown hidden-sm hidden-xs">
        <a href="#" data-toggle="dropdown" class="header-link"><i class="fa fa-bolt"></i> Notificaciones <span class="badge alert-animated">4</span></a>
        <ul class="dropdown-menu dropdown-inbar dropdown-wide">
          <li><a href="#"><span class="label label-warning">1 min</span> <i class="fa fa-bell"></i> New Mail Received</a></li>
          <li><a href="#"><span class="label label-warning">4 min</span> <i class="fa fa-fire"></i> Server Crash</a></li>
          <li><a href="#"><span class="label label-warning">12 min</span> <i class="fa fa-flag-o"></i> Pending Alert</a></li>
          <li><a href="#"><span class="label label-warning">15 min</span> <i class="fa fa-smile-o"></i> User Signed Up</a></li>
        </ul>        
      </div>

      <div class="dropdown hidden-sm hidden-xs">
        <a href="#" data-toggle="dropdown" class="header-link"><i class="fa fa-cog"></i> Configuración</a>
        <ul class="dropdown-menu dropdown-inbar">
          <li><a href="#"><i class="fa fa-cog"></i> Panel de Control</a></li>
          <li>
              <a href="javascript:;" onclick="window.location.href=ruteador(0,'phpFileTree/');" >
                <i class="fa fa-flag-o"></i> Plantilla <span class="badge alert-animated">1</span>
              </a>
          </li>
        </ul>
      </div>

      <div class="dropdown">
        <a href="#" class="header-link clearfix" data-toggle="dropdown">
          <div class="avatar">
            <img src="<?=xps_ruteador()?>assets/images/avatar-small.jpg" alt="">
          </div>
          <div class="user-name-w">
            <?=$_SESSION['valida']['usuario']?>[<?=$_SESSION['valida']['id_usuario']?>]<i class="fa fa-caret-down"></i>
          </div>
        </a>
        <ul class="dropdown-menu dropdown-inbar">
          <li><a href="#"><span class="label label-warning">2</span> <i class="fa fa-envelope"></i> Messages</a></li>
          <li><a href="#"><i class="fa fa-cog"></i> Cambiar contraseña</a></li>
          <li><a href="javascript:;" onclick="window.location.href=ruteador(2,'salir.php');" ><i class="fa fa-power-off"></i> Logout</a></li>
        </ul>
      </div>
    </div>
<!--i class="fa fa-home"></i-->    
<a class="logo hidden-xs" href="javascript:;" onclick="window.location.href=ruteador(2,'http://www.modulonet.cl');">
  <div class='Cube panelLoad'>
    <div class='cube-face cube-face-front'><b style="color:#58a6d9">Modulonet</b></div>
    <div class='cube-face cube-face-back'><i class="fa fa-sitemap" style="color:#ff1200"></i> Web</div>
    <div class='cube-face cube-face-left'><i class="fa fa-gears" style="color:#1fff00"></i> IoT</div>
    <div class='cube-face cube-face-right'><i class="fa fa-users" style="color:#00a9ff"></i> BSC</div>  
    <div class='cube-face cube-face-bottom'><i class="fa fa-gears" style="color:#b100ff"></i> TI</div>
    <div class='cube-face cube-face-top'><i class="fa fa-puzzle-piece" style="color:#2e93d7"></i>.cl</div>
  </div>
</a>
    <a class="menu-toggler" href="#"><i class="fa fa-bars"></i></a>
    <h1><?=$xps_titulo_barra?></h1>
  </div>