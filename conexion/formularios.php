<?php

function img_volver($parametros=""){
	$img = "";
	$img .= "<a href='javascript:;' onclick=\"window.location.href='$parametros';\">";
	$img .= "<img src='".xps_ruteador2() . "imagenes/imgD.php?r=signpost.png' /><br />";
	$img .= "<font class='text_blanco_bton'>Volver</font></a>";
	
	return $img;
}

function xps_encabezado($titulo,$subtitulo='',$parametros=''){

	if($subtitulo!=''){
		$sub = "<br><font size=2>$subtitulo</font>";
		$subtitulo = $sub;
	}

	$html = '';
	$html .= 	"<table id='titulo' width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
						<td align='center' valign='middle'>&nbsp;</td>
						<td align='center' valign='middle' width='80%'><legend>$titulo</legend>$subtitulo</td>
						<td align='center' valign='middle' width='10%'>
							".img_volver($parametros)."
						</td>
					</tr>
				</table>";
	return $html;

}

?>