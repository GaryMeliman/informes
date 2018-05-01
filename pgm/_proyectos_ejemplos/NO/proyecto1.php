<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
    require_once('../inc_base.php');  
?>

<link rel='stylesheet' type="text/css" href='<?=xps_ruteador()?>estilos/jquery-ui.css'>


<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

</head>

<body class="glossed">

<?php
  $xps_titulo_barra = "Proyectos 1";//<--------MODIFICABLE TITULO
  $xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
  require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php'); 
  
//############## MENU ######################//  
  echo $_SESSION['valida']['menu'];
  echo $_SESSION['Proyectos'];
//############## MENU ######################//  
?>


  <div class="main-content">



  <!-- *********** INICIO ************ -->
    <div class="row">

<h1 class="page-title page-title-hard-bordered" style="margin-top: 0px;">
      <i class="fa fa-file-text-o"></i><?=xps_desencriptar($_GET['n'])?>
</h1>  
<?php
//_______________________________ ETAPAS _______________________________________

  $db = new MySQL();

  $id_proyecto = xps_desencriptar($_GET['pro']);

  $sql = "SELECT 
            `e`.`id_etapa`,
            `p`.`nombre_proyecto`,
            `e`.`nombre_etapa`,
            `e`.`porcentaje_etapa`
          FROM
            `etapas` `e`
            LEFT OUTER JOIN `proyectos` `p` ON (`e`.`id_plantilla_doc` = `p`.`id_plantilla_doc`)
          WHERE
            `p`.`id_proyecto` = $id_proyecto";  



  $consulta = $db->consulta($sql);
      $r=0;
  if($db->num_rows($consulta)>0){
      while($rs = $db->fetch_array($consulta)){

?>          

    <div class="col-md-6">
      <?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
      <div class="widget widget-blue">
        <?php
          $xps_titulo     = $rs['nombre_etapa']." - ".$rs['porcentaje_etapa']."%";//<-- MODIFICABLE         
          $xps_volver     ="grid_proyectos.php?cl=".$_GET['cl'];//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
          $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
          $xps_color      =0;//<-- MODIFICABLE
          $xps_actualizar =0;//<-- MODIFICABLE
          $xps_minimizar  =1;//<-- MODIFICABLE
          $xps_cerrar     =0;//<-- MODIFICABLE

          widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
        ?>
        <div class="widget-content">
<!-- INICIO CONTENIDO -->
          <div class="row" style="margin-left: -30px;margin-right: -40px;">

            <div class="col-md-9">
              <div class="row">

<?php
//_______________________________ DOCUMENTOS DE LAS ETAPAS _______________________________________
  $sql2 = "SELECT 
              `ped`.`id_etapa`,
              `ped`.`id_documento`,
              `d`.`nombre_doc`,
              `e`.`nombre_etapa`,
              `e`.`porcentaje_etapa`,
              `ped`.`porcentaje_doc_etapa`,
              `ped`.`estado_doc_etapa`,
              `dtd`.`img_tipo_doc`,
              (SELECT `ee`.`accion_entrega`
                 FROM `proyectos_documentos` `pd`
                      LEFT OUTER JOIN `estados_entregas` `ee` ON (`pd`.`id_entrega` = `ee`.`id_entrega`)
                 WHERE `pd`.`id_etapa` = `ped`.`id_etapa` AND
                       `pd`.`id_documento` = `ped`.`id_documento`
               ) AS `accion_entrega`
            FROM
              `plantillas_etapas_doc` `ped`
              LEFT OUTER JOIN `etapas` `e` ON (`ped`.`id_etapa` = `e`.`id_etapa`)
              LEFT OUTER JOIN `documentos` `d` ON (`ped`.`id_documento` = `d`.`id_documento`)
              LEFT OUTER JOIN `documentos_tipo_doc` `dtd` ON (`d`.`id_tipo_doc` = `dtd`.`id_tipo_doc`)
            WHERE
              `ped`.`id_etapa` =".$rs['id_etapa'];

  //   echo $sql2;              

  $consulta2 = $db->consulta($sql2);

  $cumplimiento = 0;
  $estado_cierre= "fa-unlock";
  $documentos   = 0;
  $comentarios  = "default";
  $revisar      = $comentarios;

  if($db->num_rows($consulta2)>0){
      while($rsd = $db->fetch_array($consulta2)){

        if($rsd['accion_entrega'] == 1){
          $cumplimiento += $rsd['porcentaje_doc_etapa'];
          $estado_cierre = "fa-lock";
        }
        if(!is_null($rsd['accion_entrega'])){
          $comentarios  = "primary";
          $revisar      = "info";
        }

        $img = $rsd['img_tipo_doc'];
        if($rsd['accion_entrega'] != 1) $img = substr_replace($rsd['img_tipo_doc'],"_off.png",3);
        $documentos   = 1;
?>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-8">
                                <div class="text-left">
                                  <img src="../img.php?r=doc.img/<?=$img?>" width="20" height="20">
                                  <i class="fa <?=$estado_cierre?>"></i> <font size="1.5px"><strong><?=$rsd['nombre_doc']?></strong></font>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-right">
                                  <font size="1px"><?=$rsd['porcentaje_doc_etapa']?>%</font>
                                  
                                  <button data-toggle="tooltip" data-original-title="Editar" type="button" class="btn btn-action btn-xs btn-<?=$comentarios?>" id="create-modal1" <?php if(!is_null($rsd['accion_entrega'])){?> onclick="my_modal('Editar','<?=$rsd['nombre_doc']?>')"<?php }?>><i class="fa fa-pencil"></i></button>
                                  
                                  <button data-toggle="tooltip" data-original-title="Revisar" type="button" class="btn btn-action btn-xs btn-<?=$revisar?>" id="create-modal2" <?php if(!is_null($rsd['accion_entrega'])){?> onclick="my_modal('Revisar','<?=$rsd['nombre_doc']?>')"<?php }?>><i class="fa fa-folder-open"></i></button>
                                  
                                  <button data-toggle="tooltip" data-original-title="Subir" type="button" class="btn btn-action btn-xs btn-danger" id="create-modal3" onclick="my_modal('Subir','<?=$rsd['nombre_doc']?>')"><i class="fa fa-external-link-square"></i></button>

<!-- Button trigger modal -->

                                </div>
                            </div>
                          <hr>
                          </div>

                      </div>
                    </div>
                  </div>
<?php
      }
  }
  else{
?>
                  <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissable">
                      <center><i class="fa fa-calendar"></i> <strong>Etapa sin documentos</strong></center>
                    </div>
                  </div>
<?php    
  }
?>
              </div>
            </div>

            <div class="col-md-3">
<?php
  if($documentos>0){
?>              
              <div id="gauge-<?=$rs['nombre_etapa']?>" style="height:90px"></div>
                <script type="text/javascript">
                  var p = new JustGage({
                    id: 'gauge-<?=$rs['nombre_etapa']?>',
                    value: <?=$cumplimiento?>,
                    gaugeWidthScale: 0.9,
                    min: 0,
                    max: 100,
                    showInnerShadow: !1,
                    showMinMax: !1,
                    gaugeColor: '#EAEAEA',
                    title: '<?=$rs['nombre_etapa']?>',
                    label:'Cumplimiento',
                    levelColors: [
                      '#DA0000',//rojo
                      '#daca00',//amarillo
                      '#00da07'//verde
                    ]    
                  });  
                </script>
<?php
  }
?>                
            </div>

          </div>
<!--  FIN CONTENIDO   -->
        </div>                
      </div>
    </div>

<?php

      }
  }
  else{//_______________________________________ NO HAY ETAPAS ______________________________
?>

    <div class="col-md-12">
      <?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
      <div class="widget widget-red">
        <?php
          $xps_titulo     = "Sin etapas";//<-- MODIFICABLE         
          $xps_volver     ="grid_proyectos.php?cl=".$_GET['cl'];//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
          $xps_fullscreen =0;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
          $xps_color      =0;//<-- MODIFICABLE
          $xps_actualizar =0;//<-- MODIFICABLE
          $xps_minimizar  =0;//<-- MODIFICABLE
          $xps_cerrar     =0;//<-- MODIFICABLE

          widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
        ?>
        <div class="widget-content">
<!-- INICIO CONTENIDO -->
          <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">NO HAY ETAPAS</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php    
  }
?>



<?php //============ VENTANA MODAL ==================?>
<!--/// MODAL 1 ----------------------------------------------- -->
<div id="dialog-form1" title="Título">
	<form method="post" enctype="multipart/form-data" id="UploadMedia" onSubmit="return false">
		<?php
			echo guarda_doc();
		?>
		<fieldset>
			<div class="row">
				<div class="col-md-12">
					<div class="card-content">
						<div class="file-field input-field">
							<div class="btn" style="background-color:#757575">
								<span>File</span>
								<input type="file" name="file" id="file" multiple>
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text" placeholder="Upload one or more files">
							</div>
						</div>

              <br><br><br>
                    <div class="form-group text-left">
                <button type="submit" class="btn btn-action btn-xs btn-danger" id="submit">
                          <i class="fa fa-external-link-square"> Subir Archivo</i>
                        </button>
                    </div>

					</div>
				</div>
			</div>
		</fieldset>

	</form>
</div>
<?php //============ FIN VENTANA MODAL ==================?>




  </div>
  <!-- *********** FIN ************ -->
  </div>

  <!-- *********** PIÉ DE PÁGINA ************ -->
  <div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>



<script type="text/javascript">

my_modal = null;

$( function() {

    var dialog1;

    function modal(accion,data){
      $("#dialog-form1").dialog({modal: true}).dialog('open');

 //MODAL 1___________________________________________
    dialog1 = $( "#dialog-form1" ).dialog({
      autoOpen: false,
      title: accion,
      height: 500,
      width: 350,
      modal: true,
      buttons: {
        Cancel: function() {
          dialog1.dialog( "close" );
        }
      },
      close: function() {
        //form[ 0 ].reset();
        //allFields.removeClass( "ui-state-error" );
      }
    });

    };

    my_modal = modal;

//___________________________________________subir archivo
//	$('#file').change(function(){
  $('#submit').click(function(){        
    console.log("_____________");
		 //console.log(this,'this');
    //console.log("_____________");
      console.log($('#file'),'this')
    console.log("_____________");
//		var file=this.files[0];		
    var file = $('#file')[0].files[0];
		var imagetype=file.type;
		
		var extentions = ["image/jpeg","image/png","image/jpg","image/gif","text/plain","application/pdf","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.ms-powerpoint","application/vnd.openxmlformats-officedocument.presentationml.presentation","application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","image/vnd.dwg"];
				
		if(extentions.includes(imagetype)){
			//M.toast({html: 'File Is Valid!', classes: 'rounded'});		
			var filereader=new FileReader();
			filereader.onload=FileLoadCheck;
			filereader.readAsDataURL(file);
			FileUploadAjaxCall();
		}else{
			//M.toast({html: 'File Is Invalid!', classes: 'rounded'});
			//$('#previewImage').attr('src','images/images.png');
			return false;
		}
	});
	function FileLoadCheck(e){
		console.log(e,'Object');
		//$('#previewImage').attr('src',e.target.result);
	}


});//fin del function();

function FileUploadAjaxCall(){	
	$.ajax({
		url:'guardar_upload/guardar_model.php?_'+new Date().getTime(),
			type:'POST',
			data:new FormData($('#UploadMedia').get(0)),
			contentType:false,
			cache:false,
			processData:false,
			success:function(data){
				console.log(data,'data');
				//M.toast({html: 'File Upload Successfully!', classes: 'rounded'});
			}
		});
}


</script>

<?php

function guarda_doc(){
	try{
		@session_start();
			$datos_rnl	= explode("|", $_SESSION['valida']['parametros']);
			$n_ruta		= $datos_rnl[1];

			$name = "archivos.doc";//explode("/", $r);

			$existe		 = 0;//hasta este momento no existe el archivo
			$xps_dominio = "archivos";

			$encontrado = strpos(dirname(__FILE__), "\\");
			if($encontrado === false)
				$img_rute = explode("/", dirname(__FILE__)) ;//linux
			else
				$img_rute = explode("\\", dirname(__FILE__)) ;//windors
			
			$rute = "";
			foreach ($img_rute as $key => $value) {
				if($value != $n_ruta) $rute .= $value."/";
				else break;
			}

		$ruta = $rute."".$n_ruta."_".$xps_dominio."/".$name."/"; //ruta correcta

	      if ( !file_exists($ruta) ) {
	        throw new Exception("Ruta : ".$ruta.", no encontrada");
	      }	

	      return $ruta;
		
	} catch (Exception $e) {
			echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			return "0";
	}	
}

?>



<!-- @include _footer