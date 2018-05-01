<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>NUEVO USUARIO</title>

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php 
	require_once('../../inc_base.php');



$id_user 	= $_SESSION['valida']['id_usuario'];

$sql = "SELECT 
		  p.rut_pers,
		  CONCAT(p.nombre_pers, ' ', p.paterno_pers, ' ', p.materno_pers) AS usuario,
		  u.id_usuario,
		  pu.id_perfil,
		  u.login_usuario,
		  u.password_usuario,
		  p.id_persona,
		  pe.nombre_perfil
		FROM
		  `_usuarios` u
		  LEFT OUTER JOIN personas p ON (p.id_persona = u.id_persona)
		  LEFT OUTER JOIN `_perfil_usuarios` pu ON (u.id_usuario = pu.id_usuario)
		  LEFT OUTER JOIN `_perfil_empresas` pe ON (pu.id_perfil = pe.id_perfil)
		WHERE
		  u.id_usuario = ".$id_user." AND 
		  u.estado_usuario = 1 AND 
		  u.eliminado_usuario = 0
		";

//echo "$sql<hr>";

//exit();

	$db	= new MySQL();


$consulta = $db->consulta($sql);

$existe = 0;


if($db->num_rows($consulta)>0){
    $rs = $db->fetch_array($consulta);
		$rut 		= $rs['rut_pers'];
		$usuario	= $rs['usuario'];
		$perfil		= $rs['nombre_perfil'];
		$login		= $rs['login_usuario'];
		$pws		= $rs['password_usuario'];
		
}
else{
	echo "NO ENCONTRADO, no puede continuar";
	exit();
}

$var_dato = "-1";
$var_dato = "0|1|2|3|4|5|6|9|10";


?>


<link href="css/default.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript" src="js/pwd_meter.js"></script>
<SCRIPT src="js/generador_pws.js" type=text/javascript></SCRIPT>
<!--[if lt IE 7]>
	<link href="css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>

<form method="post"  enctype="multipart/form-data" name="formPassword" id="formPassword" onSubmit="return valida(this,'<?=$var_dato;?>',3,'nuevo_pws',1)"  >

        <table bgcolor="#FFFFFF" width="600px">
        <tr>
        	<td colspan="2">
        
<table id="titulo" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td align="center" valign="middle">&nbsp;</td>
        <td width="80%" align="center" valign="middle">
        	<legend>DETALLE USUARIO</legend>
            <?=$usuario?>
        </td>
        <td width="10%" align="center" valign="middle">&nbsp;</td>
	</tr>
</table>
        
        	</td>
        </tr>
        <tr>
            <td width="503">
            	<table id="tablePwdCheck" cellpadding="5" cellspacing="1" border="0" width="100%" align="center">
               <tr>
                  <td valign="middle"><label>Rut</label></td>
                  <td valign="middle">:</td>
                  <td style="font-size:25px; font-weight:bold"><?=$rut?></td>
              </tr>
               <tr>
                  <td valign="middle"><label>Login</label></td>
                  <td valign="middle">:</td>
                  <td><?=$login?></td>
              </tr>
               <tr>
                    <td width="130" valign="middle"><label>Contrase&ntilde;a</label>
                    <br />
                    <label class="hide">Ocultar</label>
                    <input type="checkbox" id="mask" name="mask" value="1" checked="checked" onclick="togPwdMask();" class="hide" disabled="disabled" /></td>
                    <td width="3" valign="middle">:</td>
                    <td width="333">
                      
                      <input type="text" 		id="passwordTxt" name="TxtPws" autocomplete="off" onkeyup="chkPass(this.value);" size="20" maxlength="16" 
    style="font-size:35px; height:30" placeholder="aqu&iacute; su contrase&ntilde;a" disabled="disabled" />
                      
                    </td>
                </tr>
               <tr>
                 <td valign="middle"><label>Perfil</label></td>
                 <td valign="middle">:</td>
                 <td><?=$perfil?></td>
               </tr>

                <tr>
                  <td colspan="3"></th>
                </tr>
                <tr>
                    <td><label>Resultado</label></th>
                    <td>:</td>
                    <td>
                        <div id="scorebarBorder">
                        <div id="score">0%</div>
                        <div id="scorebar">&nbsp;</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Complejidad</label></td>
                    <td>:</td>
                    <td><div id="complexity" style="font-size:16px; font-weight:bold">Demasiado Corta</div></td>
                </tr>
            </table>
            </td>
            </tr>
            <tr>
              <td align="center"><table id="tablePwdStatus" cellpadding="5" cellspacing="1" border="1" width="450px">
                <tr>
                  <td style="vertical-align: top;"><table width="100%" height="255px" style="font-size:12px" border="1">
                    <tr>
                      <th colspan="2">Adiciones</th>
                    </tr>
                    <tr>
                      <td width="1%"><div id="div_nLength" class="fail">&nbsp;</div>
                        <div id="nLength" class="oculto box"></div>
                        <div id="nLengthBonus" class="oculto boxPlus"></div></td>
                      <td width="94%">N&uacute;mero de Caracteres</td>
                    </tr>
                    <tr>
                      <td><div id="div_nAlphaUC" class="fail">&nbsp;</div>
                        <div id="nAlphaUC" class="oculto box"></div>
                        <div id="nAlphaUCBonus" class="oculto boxPlus"></div></td>
                      <td>Letras May&uacute;sculas</td>
                    </tr>
                    <tr>
                      <td><div id="div_nAlphaLC" class="fail">&nbsp;</div>
                        <div id="nAlphaLC" class="oculto box"></div>
                        <div id="nAlphaLCBonus" class="oculto boxPlus"></div></td>
                      <td>Letras min&uacute;sculas</td>
                    </tr>
                    <tr>
                      <td><div id="div_nNumber" class="fail">&nbsp;</div>
                        <div id="nNumber" class="oculto box"></div>
                        <div id="nNumberBonus" class="oculto boxPlus"></div></td>
                      <td>N&uacute;meros</td>
                    </tr>
                    <tr>
                      <td><div id="div_nSymbol" class="fail">&nbsp;</div>
                        <div id="nSymbol" class="oculto box"></div>
                        <div id="nSymbolBonus" class="oculto boxPlus"></div></td>
                      <td>S&iacute;mbolos</td>
                    </tr>
                    <tr>
                      <td><div id="div_nMidChar" class="fail">&nbsp;</div>
                        <div id="nMidChar" class="oculto box"></div>
                        <div id="nMidCharBonus" class="oculto boxPlus"></div></td>
                      <td>Mitad N&uacute;meros o s&iacute;mbolos</td>
                    </tr>
                    <tr>
                      <td><div id="div_nRequirements" class="fail">&nbsp;</div>
                        <div id="nRequirements" class="oculto box"></div>
                        <div id="nRequirementsBonus" class="oculto boxPlus"></div></td>
                      <td>Requerimientos</td>
                    </tr>
                  </table></td>
                  <td style="vertical-align: top;"><table width="100%" style="font-size:12px" border="1">
                    <tr>
                      <th colspan="2" height="21px">Deducciones</th>
                    </tr>
                    <tr>
                      <td width="8%"><div id="div_nAlphasOnly" class="pass">&nbsp;</div>
                        <div id="nAlphasOnly" class="oculto box"></div>
                        <div id="nAlphasOnlyBonus" class="oculto boxMinus"></div></td>
                      <td width="72%">Solo Letras</td>
                    </tr>
                    <tr>
                      <td><div id="div_nNumbersOnly" class="pass">&nbsp;</div>
                        <div id="nNumbersOnly" class="oculto box"></div>
                        <div id="nNumbersOnlyBonus" class="oculto boxMinus"></div></td>
                      <td>Solo N&uacute;meros</td>
                    </tr>
                    <tr>
                      <td><div id="div_nRepChar" class="pass">&nbsp;</div>
                        <div id="nRepChar" class="oculto box"></div>
                        <div id="nRepCharBonus" class="oculto boxMinus"></div></td>
                      <td>Caracteres Repetidos (No sensible)</td>
                    </tr>
                    <tr>
                      <td><div id="div_nConsecAlphaUC" class="pass">&nbsp;</div>
                        <div id="nConsecAlphaUC" class="oculto box"></div>
                        <div id="nConsecAlphaUCBonus" class="oculto boxMinus"></div></td>
                      <td>Letras May&uacute;suculas consecutivas</td>
                    </tr>
                    <tr>
                      <td><div id="div_nConsecAlphaLC" class="pass">&nbsp;</div>
                        <div id="nConsecAlphaLC" class="oculto box"></div>
                        <div id="nConsecAlphaLCBonus" class="oculto boxMinus"></div></td>
                      <td>Letras Min&uacute;sculas consecutivas</td>
                    </tr>
                    <tr>
                      <td><div id="div_nConsecNumber" class="pass">&nbsp;</div>
                        <div id="nConsecNumber" class="oculto box"></div>
                        <div id="nConsecNumberBonus" class="oculto boxMinus"></div></td>
                      <td>N&uacute;meros consecutivos</td>
                    </tr>
                    <tr>
                      <td><div id="div_nSeqAlpha" class="pass">&nbsp;</div>
                        <div id="nSeqAlpha" class="oculto box"></div>
                        <div id="nSeqAlphaBonus" class="oculto boxMinus"></div></td>
                      <td>Sencuencia de Letras (+3)</td>
                    </tr>
                    <tr>
                      <td><div id="div_nSeqNumber" class="pass">&nbsp;</div>
                        <div id="nSeqNumber" class="oculto box"></div>
                        <div id="nSeqNumberBonus" class="oculto boxMinus"></div></td>
                      <td>Secuencia de N&uacute;meros (+3)</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <th colspan="6">Leyenda</th>
                </tr>
                <tr>
                  <td colspan="6"><ul id="listLegend">
                    <li>
                      <div class="exceed imgLegend">&nbsp;</div>
                      <span class="bold">Excepcional:</span><font style="font-size:10px"> Excede el m&iacute;nimo est&aacute;ndar. Se aplican bonos adicionales.</font></li>
                    <li>
                      <div class="pass imgLegend">&nbsp;</div>
                      <span class="bold">Suficiente:</span><font style="font-size:10px"> Cubre minimamente los est&aacute;ndares. Se aplican bonos adicionales.</font></li>
                    <li>
                      <div class="warn imgLegend">&nbsp;</div>
                      <span class="bold">Peligro:</span><font style="font-size:10px"> Aviso de uso de malas pr&aacute;cticas. Se reduce el resultado.</font></li>
                    <li>
                      <div class="fail imgLegend">&nbsp;</div>
                      <span class="bold">Fallo:</span><font style="font-size:10px"> No cumples para nada el m&iacute;nimo est&aacute;ndar. Se reduce el resultado.</font></li>
                  </ul></td>
                </tr>
              </table></td>
            </tr>
        </table>
            
               </td></tr>
            </table>
</form>
		
<script>
	chkPass('<?=$pws?>');
	document.getElementById('passwordTxt').value = '<?=$pws?>';
</script>

</body>
</html>
