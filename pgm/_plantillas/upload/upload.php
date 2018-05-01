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
	$xps_titulo_barra = "TÍTULO PLANTILLA";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Colaboradores'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Título Plantilla";//<-- MODIFICABLE					
	            	$xps_volver   	="../phpFileTree/";//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=1;//<-- MODIFICABLE
					$xps_minimizar	=1;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

<form class="bottom-margin" enctype="multipart/form-data" id="validateForm" method="get" onSubmit="return false">

	<div class="modal-body">
		<div class="row">
		    <div class="col-md-4">  
			  <div class="form-group">
			    <label for="titulo" class="control-label">Titulo</label>
			      <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Titulo">
			  </div>
		    </div>
		    <div class="col-md-2">
		    	_
		    </div>
		    <div class="col-md-6">
				<div class="form-group">
				  <label for="archivo" class="control-label">Elejir Documento</label>
				    <input type="file" name="archivo" id="archivo"/>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">   
		<button type="submit" class="btn btn-iconed btn-primary" id="submit"><i class="fa fa-save"></i>Guardar</button>
	</div>
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

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

<script type="text/javascript">

my_modal = null;

$( function() {


//UPLOAD GUARDAR ___________________________________

//	$('#submit').click(function(){
	$("#validateForm").unbind('submit').bind('submit', function(){
//		$(".text-danger").remove();
//		var dataString = $('#validateForm').serialize();
		var form 	= $('form')[0];//$(this);
		var titulo 	= $("#titulo").val();
		var file2 	= $('#archivo');   //Ya que utilizas jquery aprovechalo...
		var archivo = file2[0].files;       //el array pertenece al elemento

//        var dataString = $('#validateForm').serialize();


		if(titulo && archivo){
              // Crea un formData y lo envías
			var formData = new FormData(document.getElementById('validateForm'));
//			var formData = new FormData(form);
				formData.append('titulo',titulo);
				//formData.append('archivo[]',archivo);//para array de archivos
//				formData.append('archivo',archivo);
				var inputLogo = $("#archivo")[0];
				formData.append(inputLogo.name, inputLogo.files[0]);

        console.log(formData);

        //return false;
		//	alert("HOLA");


			$.ajax({
                type: 'POST', //form.attr('method'),                  
                url: 'upload/upload_file.php',//form.attr('action'),
                data: formData,//new FormData(form[0]), // <-- usamos `FormData`
//          		dataType : 'json',                
                cache: false,                
                contentType: false,
                processData: false
			}).done(function(respuesta){
					alert(respuesta);
		    	$("#validateForm").fadeOut("slow").html("<div id='message'></div>")
		        .fadeIn("slow", function() {
		        	$('#message').html("<h2>"+respuesta+"</h2>");
					$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
	                 setTimeout(function () {
	                     $("#audiotag1")[0].play();
	                 }, 0);
	                 setTimeout(function () {
	                 	<?php
	                 		if($accion>1){
	                 			echo "$(location).attr('href','".$xps_volver."');";
	                     	}
	                     ?>
	                 }, 4000);
		        });
		    });//done
		}//if
		return false;
	});//function





});//fin del function();

</script>

<!-- @include _footer