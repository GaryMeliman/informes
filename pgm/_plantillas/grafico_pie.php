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
	$xps_titulo_barra = "PROYECTOS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
  require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php'); 
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>



	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
	          <?php
	            $xps_titulo   	="GRAFICO";//<-- MODIFICABLE         
	            $xps_volver   	="../phpFileTree/";//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
	            $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
	            $xps_color    	=0;//<-- MODIFICABLE
	            $xps_actualizar =1;//<-- MODIFICABLE
	            $xps_minimizar  =1;//<-- MODIFICABLE
	            $xps_cerrar   	=0;//<-- MODIFICABLE

	            widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
	          ?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->




  <div class="widget widget-blue" id="area_chart_anchor">
    <div class="padded">
      <div id="piechart" style=""></div>
      <div id="legend"></div>
    </div>
  </div>

<!--  FIN CONTENIDO   -->
				</div>
			</div>
		</div>	
	<?php
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>	

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>

<script type="text/javascript">

$(function () {
  var browsersChart = Morris.Donut({
    element: 'piechart',
    data: [
      {
        label: 'valor 1',
        value: 25
      },
      {
        label: 'valor 2',
        value: 40
      },
      {
        label: 'valor 3',
        value: 25
      },
      {
        label: 'valor 4',
        value: 10
      }
    ],
    colors: [
      '#3498db',
      '#B76F6F',
      '#1abc9c',
      '#34495e',
      '#9b59b6',
      '#95a5a6'
    ],
    formatter: function (e) {
      return e + '%'
    }
  })

  $('.advanced-pie').each(function () {
    var e = $(this).data('barColor'),
    a = $(this).data('size');
    $(this).easyPieChart({
      barColor: e,
      scaleColor: '#BFBDB7',
      trackColor: !1,
      size: a
    })
  });

  browsersChart.options.data.forEach(function(label, i) {
    var legendItem = $('<span></span>').text( label['label'] + " ( " +label['value'] + "% )" ).prepend('<br><span>&nbsp;</span>');
    legendItem.find('span')
      .css('backgroundColor', browsersChart.options.colors[i])
      .css('width', '20px')
      .css('display', 'inline-block')
      .css('margin', '5px');
    $('#legend').append(legendItem)
  });


  });  

</script>

</body>

</html>