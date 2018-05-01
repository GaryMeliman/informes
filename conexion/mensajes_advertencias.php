<?php

function cuadro_mensaje($tipo='DEFAULT',$titulo='',$texto_body='',$ruta=1,$volver=0,$counter=NULL,$borrar_cache=1){

//session_start();
$ruta_base = $_SESSION['valida']['ruta'];
if($borrar_cache==1){
    ob_clean();
    ob_start();
}			
?>
<!--
"></script>
-->
		</div>
	</div>



    <?php
		$img = "";
		
		switch($tipo){
		
			case 'ERROR' 		: 	$clas = "error-page-wrapper";
									$img   = "fa fa-exclamation-circle"; 
										break;

			case 'ADVERTENCIA' 	:	$clas = "advertencia-page-wrapper";
									$img  = "fa fa-exclamation-triangle"; 
										break;

			case 'AVISO' 		: 	$clas = "aviso-page-wrapper";
									$img  = "fa fa-info-circle"; 
										break;

			case 'RESTRINGIDO'	: 	$clas = "restringido-page-wrapper";
									$img  = "fa fa-lock"; 
										break;

			case 'MANTENCION'	: 	$clas = "mantencion-page-wrapper";
									$img  = "fa fa-chain-broken"; 
										break;

			default				:	$clas = "advertencia-page-wrapper";
									$img  = "fa fa-minus-circle";
									$tipo = "DEFAULT";
										break;

		}
		
		if(is_null($counter) === FALSE){

			$img   = "fa fa-clock-o";
			$ruta  = "../";
			$fecha = explode(":",$counter);
		
			$dia_c		= ( is_null($fecha[0]) ? date("d")+1 : $fecha[0] );
			$mes_c		= ( is_null($fecha[1]) ? date("m") : $fecha[1] );
			$anyo_c		= ( is_null($fecha[2]) ? date("Y") : $fecha[2] );
			if(count($fecha)>3){
				$hora_c		= ( is_null($fecha[3]) ? '00' : $fecha[3] );
				$minutos_c	= ( is_null($fecha[4]) ? '00' : $fecha[4] );
			}
			else{
				$hora_c		= date('h');
				$minutos_c	= date('i');
			}
		
?>	
			<script language="JavaScript">
                TargetDate		= <?=$mes_c?>+"/"+<?=$dia_c?>+"/"+<?=$anyo_c?>+" "+<?=$hora_c?>+":"+<?=$minutos_c?>;//+" AM";
                BackColor		= "palegreen";
                ForeColor		= "navy";
                CountActive		= true;
                CountStepper	= -1;
                LeadingZero 	= true;
                DisplayFormat	= "<br>Tiempo Estimado<br>%%D%% D&iacute;as, %%H%% Horas, %%M%% Minutos, %%S%% Segundos.<br><br>";
        		FinishMessage	= "<br>Soporte en proceso...<br><br>";
            </script>
            
<?php
		}
?>

	<div class="col-md-12">
		<div class="widget-content">
<!-- INICIO CONTENIDO -->

			<h1 class="page-title page-title-hard-bordered">
			      <i class="fa fa-file-text-o"></i><?=$titulo?>
			</h1>

			<div class="row">
				<div class="col-sm-3">
					<div class="<?=$clas?>">
			      		<div class="picture-w">
			        		<i class="<?=$img?>"></i>
			      		</div>
					</div>  
				</div>
				<div class="left-inner-shadow">            
					<div class="col-lg-9 col-md-5 col-lg-4">
						<div class="profile-main-info">
							<h1><?=$tipo?></h1>
							<p style="text-align: justify;"><?=$texto_body?>&nbsp;</p>
							<p><?php 
									echo "<hr><h5><b>Detalle técnico del error:</b></h5>";
									echo "<pre>";
								if(!is_null(error_get_last())){									
									var_dump(error_get_last());
								}
								else echo "array[0]{'No hay error definido'}";
									echo "</pre>";
								?>
							</p>
			        <?php
				        if(is_null($counter) === FALSE){
					?>
							<div id="cntdwn" class="text-center" style='background-color:#EC7630; color:#000000'>x</div>
			         <?php
						}
					 ?>
						</div>
	                    <div class="profile-details visible-lg">
							<div class="row">
								<div class="col-lg-4">
									<div class="icon"><i class="fa fa-bullhorn"></i></div>
										<a href="#"> Informar</a>
								</div>
								<div class="col-lg-4">
									<a href="javascript:;" onClick="window.history.back(<?=$volver?>)">
										<div class="icon">
											<i class="fa fa-mail-reply"></i></div>Retroceder
	                        			</div>
	                        		</a>
	                        	<div class="col-lg-4">
	                        		<a href="javascript:;" onclick="window.location.href='<?=xps_ruteador()?><?=$ruta_base?>/logout.php';" >
	                          			<div class="icon"><i class="fa fa-power-off"></i></div>Reiniciar
	                          		</a>
	                        	</div>
	                      	</div>
	                    </div>
					</div>
	      		</div>            
			</div>
<!--  FIN CONTENIDO   -->
		</div>                
	</div>
</div>
<?php
		if(is_null($counter) === FALSE){
?>
            <script language="JavaScript" src="<?= xps_ruteador().$ruta; ?>js/countdown.js"></script>
<?php
		}
		exit();
}
?>