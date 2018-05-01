<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../../../inc_base.php');	
?>

<!--//############   AQUI NUEVOS JS O CSS   ######################//
		ojo que todo los js de jquery estan al final de la página
					BORRAR SI NO SE OCUPA

    //############ FIN AQUI NUEVOS JS O CSS ######################//-->

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "PROYECTOS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 0;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
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
					$xps_titulo		="Carga Rápida Unidades";//<-- MODIFICABLE					
		            $xps_volver   	="../grid_unidades.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n']."&pi=".$_GET['pi'];
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

	$accion = 1;//Debug 1 y 5, muestra que puedes hacer con la informacion que envias por post al modelo
	//$accion = 2;//insertar
	//$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "leer_excel.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="export_excel" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
          <fieldset>
            <legend>Carga rápida de unidades. Cod id_inmobiliario : [<?=xps_desencriptar($_GET['pi'])?>]</legend>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group has-iconed">
                  <label>Subir archivo xls o xlsx</label>
                  <div class="iconed-input">
                  	<div id="drop" style="display: none;"></div>
                  	<input type="file" name="xlfile" id="xlf" class="btn btn-success" />
                  	<input type="checkbox" name="userabs" checked style="display: none;">
                  	<input type="submit" value="Export to XLSX!" id="xport" onclick="export_xlsx();" disabled="true" style="display: none;">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label><br></label>
		            <div class="form-group text-center">
		              <!-- button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-save"></i> Subir Archivo</button -->
		            </div>
                </div>
              </div>
            </div>

          </fieldset>
        </form>
		<div class="row">
			<div class="col-md-12">
				<div id="htmlout"></div>
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
	<!-- *********** FIN ************ -->
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->
<script src="js/canvas-datagrid.js"></script>
<script src="js/shim.js"></script>
<script src="js/xlsx.full.min.js"></script>
<script>
/*jshint browser:true */
/* eslint-env browser */
/* eslint no-use-before-define:0 */
/*global Uint8Array, Uint16Array, ArrayBuffer */
/*global XLSX */


if(typeof require !== 'undefined') XLSX = require('xlsx');
var X = XLSX;
var cDg;

var process_wb = (function() {
	var XPORT = document.getElementById('xport');
	var HTMLOUT = document.getElementById('htmlout');

	/*	parse json	*/
	var to_json = function to_json(workbook) {
		var result = {};
		workbook.SheetNames.forEach(function(sheetName) {
			var roa = X.utils.sheet_to_json(workbook.Sheets[sheetName], {header:1});
			if(roa.length) result[sheetName] = roa;
		});
		return JSON.stringify(result, 2, 2);
	};	
	
	
	return function process_wb(wb) {

		/* get data */
		var ws = wb.Sheets[wb.SheetNames[0]];
		var data = XLSX.utils.sheet_to_json(ws, {header:1});



		/* update canvas-datagrid */
		if(!cDg) cDg = canvasDatagrid({ parentNode:HTMLOUT, data:data });
		cDg.style.height = '100%';
		cDg.style.width = '100%';
		cDg.data = data;
				/*	export to ajax to sql	*/
				output = to_json(wb);
				//console.log(output);
				guardar(output);
				
		XPORT.disabled = false;

		/* create schema (for A,B,C column headings) */
		var range = XLSX.utils.decode_range(ws['!ref']);
		for(var i = range.s.c; i <= range.e.c; ++i) cDg.schema[i - range.s.c].title = XLSX.utils.encode_col(i);

		HTMLOUT.style.height = (window.innerHeight - 400) + "px";
		HTMLOUT.style.width = (window.innerWidth - 50) + "px";

		if(typeof console !== 'undefined') console.log("output", new Date());
	};
})();

var do_file = (function() {
	var rABS = typeof FileReader !== "undefined" && (FileReader.prototype||{}).readAsBinaryString;
	var domrabs = document.getElementsByName("userabs")[0];
	if(!rABS) domrabs.disabled = !(domrabs.checked = false);

	return function do_file(files) {
		rABS = domrabs.checked;
		var f = files[0];
		var reader = new FileReader();

//______________________________________________________________________________________________
		if(valida(f)==false){
			var txt = "Archivo incorrecto";
			console.log(txt);
			document.getElementById('htmlout').innerHTML = txt;
			return false;
		}
//______________________________________________________________________________________________

		reader.onload = function(e) {
			if(typeof console !== 'undefined') console.log("onload", new Date(), rABS);
			var data = e.target.result;
			if(!rABS) data = new Uint8Array(data);
			process_wb(X.read(data, {type: rABS ? 'binary' : 'array'}));
		};
		if(rABS) reader.readAsBinaryString(f);
		else reader.readAsArrayBuffer(f);
	};
})();

(function() {
	var drop = document.getElementById('drop');
	if(!drop.addEventListener) return;

	function handleDrop(e) {
		e.stopPropagation();
		e.preventDefault();
		do_file(e.dataTransfer.files);
	}

	function handleDragover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.dataTransfer.dropEffect = 'copy';
	}

	drop.addEventListener('dragenter', handleDragover, false);
	drop.addEventListener('dragover', handleDragover, false);
	drop.addEventListener('drop', handleDrop, false);
})();

(function() {
	var xlf = document.getElementById('xlf');
	if(!xlf.addEventListener) return;
	function handleFile(e) { do_file(e.target.files); }
	xlf.addEventListener('change', handleFile, false);
})();

var export_xlsx = (function() {
	function prep(arr) {
		var out = [];
		for(var i = 0; i < arr.length; ++i) {
			if(!arr[i]) continue;
			if(Array.isArray(arr[i])) { out[i] = arr[i]; continue };
			var o = new Array();
			Object.keys(arr[i]).forEach(function(k) { o[+k] = arr[i][k] });
			out[i] = o;
		}
		return out;
	}

	return function export_xlsx() {
		if(!cDg) return;
		/* convert canvas-datagrid data to worksheet */
		var new_ws = XLSX.utils.aoa_to_sheet(prep(cDg.data));

				console.log(cDg.data);//guardar datos
		/* build workbook */
		var new_wb = XLSX.utils.book_new();
		XLSX.utils.book_append_sheet(new_wb, new_ws, 'SheetJS');

		/* write file and trigger a download */
		XLSX.writeFile(new_wb, 'sheetjs.xlsx', {bookSST:true});
	};
})();

	function valida(f){

		var imagetype=f.type;
		var extentions = ["application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
		//console.log(extentions.includes(imagetype));				
		return extentions.includes(imagetype);
	}
//guardar
//	 $(function() {//guardar registros
	function guardar(output){
		alert("Hola");
		    $.ajax({
		      	url: "guardar/guardar_model.php",		    	
                method:"POST",  
                data: output,//new FormData(this),  
                contentType:false,  
                processData:false,  
                success:function(data){  
                	console.log(data);
                     $('#resultado').html(data);  
                     $('#excel_file').val('');  
                },
			      error:  function(data, status, error) {
			              console.log('Error => ',error);
			              console.log('Estatus => ',status);
			              console.log('Data => ',data);
			              alert("ERROR");
//			              location.reload();
			      }                
		    });
			return false;
	}
//	    });


</script>


<script>
	 $(function() {//guardar registros
   	    $('#submit1').click(function(){
           $('#export_excel1').submit();  
      	});

   	    $('#export_excel1').on('submit1', function(event){

   	    	console.log("_____________-");

   	    	event.preventDefault();

//	        var dataString = $('#validateForm').serialize();
		    $.ajax({
		      	url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",		    	
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                processData:false,  
                success:function(data){  
                     $('#resultado').html(data);  
                     $('#excel_file').val('');  
                }
		    });
			return false;
	    });
	});
</script>

<!-- @include _footer