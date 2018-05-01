<?php
ob_start();
ob_end_flush();


require_once(dirname(__FILE__).'/conexion/conexion.php');

if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else   $ip = $_SERVER['REMOTE_ADDR'];


$rut	= xps_valida_rut($_POST['rut']);
$login	= $_POST['login'];
$pwd	= $_POST['pwd'];

//var_dump($_POST);




if( (xps_valida_rut($_POST['rut'])? 1 : 0) == 0 ){ 
	//echo "Rut no valido";
	$tipo		= 'RESTRINGIDO';
	$titulo		= 'RUT NO VALIDO';
	$texto_body	= '<br>El rut ingresado no es valido';
	$ruta		= 0;
	$volver		= 0;
	cuadro_mensaje($tipo,$titulo,$texto_body,$ruta,$volver);
	exit();
};


if($rut =="" || $login == "" || $pwd == "" || $ip == "" || count($_POST) == 0)
		header("LOCATION:index.php"); 


session_start();
$_SESSION['valida'] = array();


$db = new MySQL();

$procedimiento = "call validacion_sistema('$rut','$login','$pwd',0,'$ip')";

//echo $procedimiento."<hr>";
//exit();

$consulta = $db->consulta($procedimiento);


if($db->num_rows($consulta)>0){

	$m1 = "";
	$subm1 = 0;
	$subul = '
			<ul>';
	$subme = 0;
	$var_m3 = "";
	$var_m2 = '
<!-- ************* SUBMENU ************* -->	
		<div class="sub-sidebar-wrapper" style="padding-top: 50px;">';
	$paso = 1;
	$var_m1 = '
<!-- ############### MENU ############## -->
	<div class="side">
		<div class="sidebar-wrapper" style="padding-top: 50px;">
			<ul>';

	  while($menu = $db->fetch_array($consulta)){ 
			$_SESSION['valida']['usuario']			= $menu['nombre_usuario'];
			$_SESSION['valida']['contratista']		= $menu['contratista'];
			$_SESSION['valida']['id_usuario']		= $menu['id_usuario'];
			$_SESSION['valida']['auditor']			= $menu['auditor'];
			$_SESSION['valida']['id_trabajador']	= $menu['id_trabajador'];

			$_SESSION['valida']['id_cert']			= $menu['id_certificadora'];
			$_SESSION['valida']['id_cont']			= $menu['id_contratista'];
			$_SESSION['valida']['id_emp_p']			= $menu['id_principal'];
			$_SESSION['valida']['id_emp_c']			= $menu['id_vinculo'];
			
			$_SESSION['valida']['categoria']		= $menu['grupo_categoria_cont'];
			$_SESSION['valida']['tipo_perfil']		= $menu['tipo_perfil'];
			$_SESSION['valida']['nivel_acceso']		= $menu['nivel_acceso'];

			$_SESSION['valida']['parametros']		= $menu['parametros'];
			
			if($_SESSION['valida']['parametros'] == ""){
				session_destroy();
				cuadro_mensaje('RESTRINGIDO','FALTAN PARAMETROS','Los parametros no se cargaron correctamente',0);
				$var_m = "";//"var menuItems = [\n[' ','','','','','','','','', ],\n";
				exit();
			}


			
		switch($menu['nivel_menu']){
//_____________________________________________________________________________		
			case "1" :  

				if($subme == 1){//cierre del submenu
					$_SESSION[$m1] = $var_m2.'
			</ul>
		</div>
	</div>
<!-- ############### FIN MENU ############## -->';
					$subme = 0;
					$var_m2 = '
<!-- ************* SUBMENU A ************* -->	
		<div class="sub-sidebar-wrapper" style="padding-top: 50px;">';//apertura nuevo submenu
					$subul = '
			<ul>';
				}
							
				$m1 = $menu['nombre_menu'];
				$var_m1 .= '
					<li>
						<a href="javascript:;" onclick="window.location.href=ruteador(0,\''.$menu['link_menu'].'?a='.$m1.'\');" data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$m1.'">
							<i class="'.$menu['img_menu'].'"></i>
						</a>
					</li>';

				$subm1 = 0;
				$var_m3 = "";
			
						break;
//_____________________________________________________________________________			
			case "2" :
				$subme = 1;
			if($menu['link_menu']==""){//subtitulo		
				$var_m2 .= $var_m3.'
			<br>
			<div class="breadcrumb">
				<h5 style="margin:0em;color:#fff;vertical-align:baseline;text-transform: none;">&nbsp;&nbsp;
					<i class="icon-chevron-sign-right"></i>&nbsp;'.$menu['nombre_menu'].'
				</h5>
			</div>
			<ul>';
			$subm1 = 0;
			}
			else{//submenu
				$var_m2 .= $subul.'
					<li>
						<a href="javascript:;" onclick="window.location.href=ruteador(0,\''.$menu['link_menu'].'\');"> '.$menu['nombre_menu'].'</a>
					</li>';
			}
			
			$subm1++;			
			if($subm1==1){ 
				$subul = "";
				$var_m3 = '
			</ul>';
			}			

						break;
//_____________________________________________________________________________
			case "3" :
				$subme = 1;
				$var_m2 .= '
					<li>
						<a href="javascript:;" onclick="window.location.href=ruteador(0,\''.$menu['link_menu'].'\');"> '.$menu['nombre_menu'].'</a>
					</li>';

			$subm1++;			
			if($subm1==1){ 
				$subul = "";
				$var_m3 = '
			</ul>';
			}

						break;
//_____________________________________________________________________________			
			case "4" :  

			break;			
			default : break;
		}
 
 }//while
 
 $var_m1 .= '
			</ul>
		</div>';

	$datos_rnl  = explode("|", $_SESSION['valida']['parametros']);
		$n_ruta		= $datos_rnl[1];
		
	$_SESSION['valida']['menu'] = $var_m1;
	$_SESSION['valida']['ruta']	= $n_ruta;
	$_SESSION['valida']['aux']	= 0;

	header("LOCATION:".$n_ruta."/index.php"); 

}
else{
		session_destroy();
		cuadro_mensaje('RESTRINGIDO','DATOS INCORRECTOS','Los datos ingresados no coiciden,<br>Por favor ingrese su login y password nuevamente',0);
		$var_m = "var menuItems = [\n[' ','','','','','','','','', ],\n";
		exit();
}


	exit();
?>