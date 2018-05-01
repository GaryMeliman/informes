<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../../inc_base.php');	
?>

<link rel='stylesheet' type="text/css" href='<?=xps_ruteador()?>estilos/jquery-ui.css'>


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
		<div class="col-md-12"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Verificación de items";//<-- MODIFICABLE					
		            $xps_volver   	="grid_fichas.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&pi=".$_GET['pi']."&n=".$_GET['n'];
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=1;//<-- MODIFICABLE
					$xps_minimizar	=1;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->
<?php
	//************ acciones que puede realizar el controlador segun la accion que se envie **************

	//$accion = 1;//Debug 1 y 5, muestra que puedes hacer con la informacion que envias por post al modelo
	//$accion = 2;//insertar
	//$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar_ficha/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">

          <fieldset>
            <div class="row">
            	<div class="col-md-9">
            		<legend><?=xps_desencriptar($_GET['n'])?></legend>
            	</div>
				<div class="col-md-3">
              		<div id="gauge-01" style="height:90px"></div>
				</div>


        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Sel</th>
                <th>Item</th>
                <th>Detalle</th>
                <th>Fecha</th>
                <th class="text-center">Cumplimiento</th>
                <th class="text-center"></th>                
              </tr>
            </thead>
            <tbody>
<?
	$db	= new MySQL();

	$id_fi = xps_desencriptar($_GET['fi']);//id_ficha_inm
	$id_f  = xps_desencriptar($_GET['f']);// id_ficha


	$sql = "SELECT 
			  `fi`.`id_ficha_item`,
			  `fi`.`nombre_item`,
			  `fi`.`porcentaje_item`,
			  (SELECT `fip`.`fecha_ficha_inm` 
			  	FROM `fichas_items_inmobiliarios` `fip` 
			  	WHERE 	`fip`.`id_ficha_item` = `fi`.`id_ficha_item` AND 
			  			`fip`.`id_ficha_inm` = $id_fi) AS `fecha_realizacion`,
			  (SELECT `fip`.`detalle_item_inm` 
			  	FROM `fichas_items_inmobiliarios` `fip` 
			  	WHERE 	`fip`.`id_ficha_item` = `fi`.`id_ficha_item` AND 
			  			`fip`.`id_ficha_inm` = $id_fi) AS `detalle`,
			  (SELECT `fip`.`cierre_item_inm` 
			  	FROM `fichas_items_inmobiliarios` `fip` 
			  	WHERE 	`fip`.`id_ficha_item` = `fi`.`id_ficha_item` AND 
			  			`fip`.`id_ficha_inm` = $id_fi) AS `cierre`
			FROM
			  `fichas_items` `fi`
			WHERE
			  `fi`.`id_ficha` = $id_f
			ORDER BY
			  fi.orden_item";

// echo $sql;				  

	$consulta = $db->consulta($sql);

	$sumatoria = 0;
	if($db->num_rows($consulta)>0){
		$ii = 1;
		$asignado = "";
		while($rs = $db->fetch_array($consulta)){

//success+check
//danger+times
				$success = '';
				$crear_s = "danger";//0
				$crear_c = "times";//0
				$porcentaje = "";
				$fecha   = "";

			if($rs['fecha_realizacion']!=""){
				$success = 'class="success"';
				$crear_s = "success";//1
				$crear_c = "check";//1
				$porcentaje = $rs['porcentaje_item']."%";
				$sumatoria += $rs['porcentaje_item'];
				$fecha   = xps_fecha($rs['fecha_realizacion']);
			}

			$accion = $fecha ? 0 : 1;

?>


            <tr id="<?=$rs['id_ficha_item']?>" <?=$success?>>
                <td class="text-center"><?=$ii++?></td>
                <td class="text-center">
<?php
	if(!$rs['cierre']){
?>                	
                	<span style="cursor: pointer;" class="label label-<?=$crear_s?>" onclick="seleccionar('<?=xps_encriptar($accion)?>','<?=xps_encriptar($rs['id_ficha_item'])?>')">
                		<i class="fa fa-<?=$crear_c?>"></i>
                	</span>
<?php
	}
	else{
					echo '<i class="fa fa-'.$crear_c.'"></i>';
	}
?>                	
                </td>                
                 <td><?=$rs['nombre_item']?></td>
                 <td class="text-left"><?=($rs['detalle'] ? $rs['detalle'] : '-')?></td>
                 <td class="text-center"><?=$fecha?></td>
               <td class="text-center"><?=$porcentaje?>
               </td>
               <td class="text-center"  data-toggle="tooltip" data-placement="right" title="" data-original-title="A:<?=$accion?>,C:<?=$id_fp?>,V:<?=$rs['id_ficha_item']?>,C:<?=$rs['cierre']?>">
<?php
	if(!$accion){
?>
		<button data-toggle="tooltip" data-original-title="Detallar" type="button" class="btn btn-action btn-xs btn-danger" id="create-modal3" onclick="my_modal('Detallar','2',3,'<?=$rs['detalle']?>','<?=$rs['nombre_item']?>','<?=$rs['id_ficha_item']?>','<?=$_GET['fi']?>')">
			<i class="fa fa-list-alt"></i> Detallar
		</button>
<?php
//		if(!$rs['cierre']){
		if(1==0){
?>					
		<button data-toggle="tooltip" data-original-title="Cierre" type="button" class="btn btn-action btn-xs btn-warning" id="create-modal3" onclick="my_modal('Cerrar','0','<?=$rs['id_ficha_item']?>','<?=$_GET['fi']?>')">
			<i class="fa fa-unlock"></i>
		</button>
<?php
		}
		else{
		//			echo '<button type="button" class="btn btn-action btn-xs btn-danger"><i class="fa fa-lock"></i></button>';
		}
	}
?>
               </td>
            </tr>

<?php
		}
	}
?>
			</tbody>
			<tfoot>
<?php
	if($sumatoria>0){
?>				
			  <tr>
			  	<th class="text-right" colspan="5">Sumatoria : </th>
			  	<th class="text-center"><?=$sumatoria."%"?></th>
			  	<th></th>
			  </tr>
<?php
	}
?>			  
              <tr>
                <th id="respuesta" class="text-left" colspan="7">...</th>
              </tr>
			</tfoot>			
		  </table>

          </fieldset>
        </form>


<!--  FIN CONTENIDO   -->
				</div>                
			</div>
		</div>	
	<?php
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>
	<!-- *********** FIN ************ -->
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>


<?php //============ VENTANA MODAL 1 ==================?>
<!--/// MODAL 1 ----------------------------------------------- -->
<div id="dialog-form1" title="Título" style="display: none;overflow-x: hidden;">

	<div class="row">
		<div class="col-md-12">
			<div class="widget-content">
		        <ul class="chat-messages-list" id="lista_comentarios">

          <li>
            <div class="row">
              <div class="col-xs-2">
                <div class="avatar">
                  <img src="assets/images/avatar-small.jpg" alt="">
                </div>
              </div>
              <div class="col-xs-10">
                <div class="chat-bubble chat-bubble-right">
                  <div class="bubble-arrow"></div>
                  <div class="meta-info"><a href="#">Andres Iniesta</a> on Jun 25</div>
                  <p>Collaboratively administrate empowered markets via plug-and-play networks.</p>
                </div>
              </div>
            </div>
          </li>


		        </ul>
			</div>
		</div>
	</div>

</div>
<?php //============ FIN VENTANA MODAL 1 ==================?>
<!--/// FIN MODAL 1 ----------------------------------------------- -->

<?php //============ VENTANA MODAL 2 ==================?>
<!--/// MODAL 2 ----------------------------------------------- -->
<div id="dialog-form2" title="Título" style="display: none; overflow-x: hidden;">
<br>
	<form method="post" enctype="multipart/form-data" id="UploadMedia2" onSubmit="return false">
		<fieldset>
			<div class="row">
				<div class="col-md-12">
					<div class="card-content">
						<div class="file-field input-field">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
		                    			<label class="text-left"><b id="nomArchivo2"></b></label>
										<textarea name="TXTDetalleIM" id="TXTDetalleIM" class="form-control" rows="1"></textarea>
									</div>									
								</div>
							</div>
						</div>

						<!-- Variables -->						
						<span id="insert2"></span>

              			<br>
                    	<div class="form-group text-right">
                			<button type="button" class="btn btn-action btn-xs btn-primary" id="submit2" onclick="my_guardar(2)">
                          		<i class="fa fa-external-link-square"> Guardar</i>
                        	</button>
                    	</div>
					</div>
				</div>
			</div>
		</fieldset>

	</form>

<img src="../../../../img.php?r=logos.img/cargando_datos.gif" alt="<?=$rs['nombre_tipo_doc']?>" width="100%" height="100%" id="cargando2" style="display: none;">

</div>
<?php //============ FIN VENTANA MODAL 2 ==================?>
<!--/// FIN MODAL 2 ----------------------------------------------- -->



<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->

<script type="text/javascript">
  var p = new JustGage({
    id: 'gauge-01',
    value: <?=$sumatoria?>,
    gaugeWidthScale: 0.9,
    min: 0,
    max: 100,
    showInnerShadow: !1,
    showMinMax: !1,
    gaugeColor: '#EAEAEA',
    title: 'Cumplimiento',
    label:'',
    levelColors: [
      '#DA0000',//rojo
      '#daca00',//amarillo
      '#00da07'//verde
    ]    
  });  

	seleccionar = null;
	my_modal	= null;
	my_guardar  = null;

	var dialog1;

	 $(function() {

	 	//guardar registros____________________________________________________________
   	    function checklist_select(accion,HiIdVerificacion){

       //Guardar
		var dataString = [];
			dataString = dataString.concat({'accion':accion});
			dataString = dataString.concat({'HdIdFichaIn':'<?=$_GET['fi']?>'});
	       	dataString = dataString.concat({'HdIdItemFicha':HiIdVerificacion});

	       	console.log(dataString);

//	    var dataString = $('#validateForm').serialize();
      	var dataString = JSON.stringify(dataString);
//          return false;

		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",
		      data: dataString,
		    }).done(function(respuesta){

		    	$("#formulario").fadeOut("slow");
		    	$('#respuesta').html("<div id='message'></div>");
		    	acciones  = respuesta.split("<pre>");
		    	if(acciones.length>0){
		    		respuesta = acciones[2];
		    		if(acciones[0].length>0)
		    			respuesta = acciones[0];
		    	}
		        $('#message').html("<h2>"+respuesta+"</h2>")
		        .fadeIn(1500, function() {
					//$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
	                 setTimeout(function () {
	                     $("#audiotag1")[0].play();
	                 }, 0);
	                 setTimeout(function () {
	                 	location.reload();
	                 }, 500);
		        });

				//
		    });
			return false;
	    };

    	seleccionar = checklist_select;

//MODAL 1___________________________________________
    function modal(accion,x,envio,detalle,item,HdIdItemFicha,HdIdFichaIn){
      $("#dialog-form"+x).dialog({modal: true}).dialog('open');

	    dialog1 = $("#dialog-form"+x).dialog({
			autoOpen: false,
			title: accion,
			height: 300,
			width: 400,
			modal: true,
			buttons: {
				Cancel: function() {
					dialog1.dialog("close");
				} 
			},
			close: function() {
				$("#insert"+x).empty();
				$("#nomArchivo"+x).empty();
				$("#TXTDetalleIM").val("");
	      	}
	    });

		$("#UploadMedia"+x +" #insert"+x).append("<input type='hidden' name='accion' id='accion' value='"+envio+"'>");
		$("#UploadMedia"+x +" #insert"+x).append("<input type='hidden' name='estado' id='estado' value='"+x+"'>");
		$("#UploadMedia"+x +" #insert"+x).append("<input type='hidden' name='HdIdItemFicha' id='HdIdItemFicha' value='"+HdIdItemFicha+"'>");
		$("#UploadMedia"+x +" #insert"+x).append("<input type='hidden' name='HdIdFichaIn' id='HdIdFichaIn' value='"+HdIdFichaIn+"'>");
		$("#UploadMedia"+x +" #nomArchivo"+x).append(item);
		$("#TXTDetalleIM").val(detalle);


		if(x==1){
		    $.ajax({
		    	url: "guardar_detalle/guardar_model.php",
				type: "POST",
				data: {HdIdProyecto : id},
		    	success: function(result){
		        	$("#lista_comentarios").html(result);
		    	},
	            error: function(data, status, error) {
	                console.log('Error => ',error);
	                console.log('Estatus => ',status);
	            }
			});
		};

    };

    my_modal = modal;

    function guardar(f){

    		var formUpload  = $('#UploadMedia'+f);
			var CargaUpload = $('#cargando'+f);

		  	formUpload.hide("slow");
		  	CargaUpload.show("slow");

	        var dataString = formUpload.serialize();
	        console.log(dataString);

		$.ajax({
				url:'guardar_detalle/guardar_model.php?_'+new Date().getTime(),
				type:'POST',
				data:dataString,
				success:function(data){
					console.log('Data =>',data);
				  	formUpload.show("slow");
				  	CargaUpload.hide("slow");
					resetFormElement();
					dialog1.dialog("close");
					alert("Listo");
					location.reload();
				},
	            error: function(data, status, error) {
	                console.log('Error => ',error);
	                console.log('Estatus => ',status);
	                console.log('Data => ',data);
				  	formUpload.show("slow");
				  	CargaUpload.hide("slow");
					resetFormElement();
					dialog1.dialog("close");
					alert("ERROR");
					location.reload();
          }			
	  			});
    };//guardar fin
	my_guardar = guardar;

	function resetFormElement() {
		$("#TXTDetalleIM").val("");
	}

	});



</script>

<!-- @include _footer