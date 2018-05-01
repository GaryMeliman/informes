<?php

function crea_cbo_estado($estado){

			if($estado){
				$selectedA = "selected";
				$selectedB = "";
			}
			else{
				$selectedA = "";
				$selectedB = "selected";
			}

			    echo "<option value='".xps_encriptar(1)."' $selectedA>Activado</option>";
			    echo "<option value='".xps_encriptar(0)."' $selectedB>Desactivado</option>";
}

?>