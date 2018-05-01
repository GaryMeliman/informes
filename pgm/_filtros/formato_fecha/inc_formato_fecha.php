<?php
function xps_fecha($formato=1, $fecha=NULL ){
	
	if($fecha==NULL)
		$fecha2 = date("Y-m-d H:i:s");
	else
		$fecha2 = $fecha;


	$fecha2 = date('Y-m-d', strtotime($fecha2));
    list($yy,$mm,$dd)=explode("-",$fecha2);

    if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)){
        if(checkdate($mm,$dd,$yy)){
			$fecha2 = $fecha2;//fecha es correcta
		}
		else{
			$fecha2 = date("Y-m-d");//fecha es incorrecta y corrijo a fecha actual
		}
	}
	else{
		$fecha2 = date("Y-m-d");//fecha es incorrecta y corrijo a fecha actual
	}
	
	//Variable nombre del mes
	$nommesL = array("-","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$nommesC = array("-","Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
	
	//variable nombre día
	$nomdiaL = array("Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado");
	$nomdiaC = array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab");
	
	/* date(j) toma valores de 1 al 31 segun el dia del mes
	date(n) devuelve numero del 1 al 12 segun el mes
	date(w) devuelve 0 a 6 del dia de la semana empezando el domingo
	date(Y) devuelve el año en 4 digitos */
	
	$numdia = date("w",strtotime($fecha2)); //Número de dia de la semana
	$dia 	= date("d",strtotime($fecha2)); //Dia del mes en numero
	$mes 	= date("n",strtotime($fecha2)); //Mes actual en numero
	$ano 	= date("Y",strtotime($fecha2)); //año actual en numero
	

		switch($formato){
			case 1 :  $retorno = date('d-m-Y', strtotime($fecha2));//	25/03/2018
					   break;
			case 2 :  $retorno = $nomdiaL[$numdia] . ", " . $dia . " de " . $nommesL[$mes] . " de " . $ano;// Domingo, 25 de Marzo de 2018
					   break;
			case 3 :  $retorno = $nommesC[$mes] . " de " . $ano;// Mar de 2018
					   break;
			case 4 :  
					  $select_mes = array();
					  for($i=1;$i<= 12;$i++){
						  if($i==$mes){$sel='selected';} else{$sel='';} 
						$select_mes[$i] = "\n<option value='".xps_encriptar($i)."' $sel>".$nommesL[$i]."</option>";
					  }
					  
					  $select_anyo = array();
					  for($anyo_inicio="2010";$anyo_inicio<= $ano;$anyo_inicio++){ 
					  		$selected = "";
					  		if(date("Y") == $anyo_inicio) $selected = "selected";
								$select_anyo[] = "<option value='".xps_encriptar($anyo_inicio)."' ".$selected.">$anyo_inicio</option>";
							
					  }
					  $array_mes_fecha = array("mes" => $select_mes, "anyo" => $select_anyo);
					  $retorno = $array_mes_fecha;
					  break;

			case 5 :  $retorno = strtoupper($nommesC[$mes]) . " - " . $ano; // MAR - 2018
					   break;
					   
			case 6 :  $retorno = date('Y-m-d', strtotime($fecha2));//Formato SQL 2018-03-25
					   break;					  

			case 7 :  $retorno = strtoupper($nommesL[$mes]) . " - " . $ano; // MARZO - 2018
					   break;

			case 8 :  $retorno = date('d-m-Y H:i:s', strtotime($fecha)); // 25-03-2018 14:22:44 <-DE LA FECHA ENVIADA
					   break;
					   
			case 9 :  $retorno = date("Y-m-d H:i:s"); // 25-03-2018 14:22:44 <-DE LA FECHA Y HORA ACTUAL
					   break;	
					   
			case 10:  $retorno = strtoupper($nommesL[$mes]) . " de " . $ano; // MARZO de 2018
					   break;
					   
			case 11:  $retorno = strtoupper($nommesC[$mes]) . "_" . $ano; // MAR_2018
					   break;
					
					//MES DEL AÑO
			case 12:  $retorno = strtolower($nommesL[$mes]);// marzo
					   break;

			case 13:  $retorno = strtoupper($nommesC[$mes]) . "_" . date('y', strtotime($fecha)); // usar 11
					   break;
					
			case 14:  $retorno = $nommesC[$mes] . "-" . $ano;// usar 5
					   break;

			case 15:  $retorno = $ano; // 2018
					   break;
					   
			default : $retorno = date('d-m-Y', strtotime($fecha2)); // 25-03-2018 <-igual al 1
					  break;
		}
	
	return $retorno;


}

function xps_esfecha($fecha) {
	$fecha = date('Y-m-d', strtotime($fecha));
    list($yy,$mm,$dd)=explode("-",$fecha);
    if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)){
        return checkdate($mm,$dd,$yy);
    }
    return false;
}

function xps_validatiempos($a,$b){
	if( date('Y-m-d', strtotime($a)) <= date('Y-m-d', strtotime($b)) )//fecha a es menor o igual a fecha b
		return true;
	else
		return false;
}

?>