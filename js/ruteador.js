function ruteador(accion,ruta){
   // alert(window.location.host+"\n"+    window.location.hostname+"\n"+    window.location.protocol+"\n"+    window.location.port+"\n"+    window.location.pathname+"\n"+    window.location.origin);


    var dir_menu  = ""
    var dir_actual  = location.pathname;
    var dir_ruta  = dir_actual.split("/");
    var dir_path  = "";
    var saltos    = 1;
    var cadena    = document.URL;
    var xps_host    = window.location.host;
    var xps_host    = xps_host.replace('.','');

    if(/localhost/.test(cadena))  saltos = 2;
    if(parseInt(xps_host)>0) saltos = 2;   
    
    switch(accion){
      case 0  : dir_menu  = "administracion/"+menuRuta+"/";//==> QUITAR PALABRA ADMINISTRACION
            break;
            
      case 1  : dir_menu  = "";	//ruta botones
				new_ruta = "";
				for(var i=saltos ; i < dir_ruta.length-1 ; i++){
					new_ruta += dir_ruta[i]+"/";
				}
				ruta = new_ruta+ruta;
            break;
            
      case 2  : return  ruta;//URL externas
            break;
            
      default : dir_menu = "";
            break;             
    }
    
    
    for(var i=saltos ; i < dir_ruta.length-2 ; i++){
        dir_path = dir_path + "../";
        //document.write(i + "_" + dir_ruta[i] + "|");
    }

    if(dir_ruta.length==4){
      //document.write("4_ ");
      dir_path = "../" + dir_path
    }
    else{
      dir_path = "../" + dir_path
    }
    
    return  dir_path + dir_menu + ruta;
}	

//var rutaimg   = ruteador(3) +'img.php?r=';//.ruteador(2);

function enfocarpagina(){self.focus();}
  setTimeout("enfocarpagina();",1);