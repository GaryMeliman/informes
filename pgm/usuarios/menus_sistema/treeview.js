// TreeView ver 1.2

// Define Global Variables
var ruta = '../../../menu/menu.files/img/';
var treeData = new Array()					// The treeData array stores all of the information before the tree is displayed
var imagePath = './images/'		    		// Stores the path to image files used
var mn = imagePath + 'tvMinusNode.gif'		// The Minus Node image file
var ml = imagePath + 'tvMinusLastNode.gif'  // The Minus Last Node image file
var pn = imagePath + 'tvPlusNode.gif'	    // The Plus Node Image file
var pl = imagePath + 'tvPlusLastNode.gif' 	// The Plus Last Node image file
var no = imagePath + 'tvNode.gif'			// The Node image file (no plus or minus)
var ln = imagePath + 'tvLastNode.gif'		// The Last Node image file (no plus or minus)
var vl = imagePath + 'tvVertLine.gif'		// The Vertical Line image file
var bl = imagePath + 'tvBlank.gif'			// The blank image file
var tl = imagePath + 'tvTopLevel.gif'		// The Top Level Image file (Used for Level A nodes)
var of = imagePath + 'tvOpenFolder.gif'		// The Open Folder image file
var cf = imagePath + 'tvClosedFolder.gif'	// The Closed Folder image file
var dc = imagePath + 'tvPage.gif'			// The Document image file


// function tree(level,txt,linkk)
// This function actually creates the object of which treeData is an array.  
// The parameters of this object are:
//  Level   (integer) 1 being top level
//  txt     The text to be displayed in the tree view
//  linkk    The page that clicking on the text will linkk you to
//  show       determines if the node is visible 1 = yes; 0 = no
//  hasChild   
//  hasLowerSibling
//  nextSibling
//--------------------------------------------------------------------------------------------------------



function tree(level,txt,linkk,img,id,p,e,accion,param,d,pr) {

	this.level	= level;
	this.txt	= txt;
	this.linkk	= linkk;
	this.img	= img;
	this.show	= 1;
	this.hasChild 		 = false;
	this.hasLowerSibling = false;
	this.nextSibling	 = 0;
	this.id		= id;
	this.p		= p;
	this.e		= e;
	this.accion	= accion;
	this.param	= param;
	this.d		= d;
	this.pr		= pr;
}

// function treeAdd(level,txt,linkk)
// This function is used to actually create the array element containing the tree object defined above.  
// There is one array entry for each row in the tree.
//---------------------------------------------------------------------------------------------------------
function treeAdd(level,txt,linkk,img,id,p,e,accion,param,d,pr) {
	x = treeData.length;//tamaño elementos del menu
	treeData[x] = new tree(level,txt,linkk,img,id,p,e,accion,param,d,pr);
}

// function makeTree()
// This function actually creates and fills in the table in the web browser using the data from the treeData array.
// This function should be called only after treeAdd() has been called for each node in the tree.
// --------------------------------------------------------------------------------------------------------
function makeTree() {
  var levelSet 	= 0;//cambio por rodrigo
  var linkk		= '';
  var txt		= '';
  var img		= '';
  // Set the Child and Sibling Flags for Each Row
  for (i=0;i<treeData.length;i++)	{
    hasSibling(i);
    if (i+1 < treeData.length) {
      if (treeData[i+1].level > treeData[i].level) treeData[i].hasChild = true;
      else treeData[i].hasChild = false;
    }
  }
  levelSibling = new Array();
  
  var tope_nivel = 4;
  for (i=0;i<treeData.length;i++)	{

	var img_new 	= "";
	var img_edit 	= "";
	var img_del 	= "";
	var img_new_ 	= "";
	var img_edit_ 	= "";
	var img_del_ 	= "";

		if(treeData[i].level!=tope_nivel){
			img_new 	= "<img src='" + imagePath + "nuevo.png' border=0 width=15 height=15 style='cursor:pointer' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',2)  alt='Nuevo Items' />";
		}
			img_del 	= "<img src='" + imagePath + "eliminar.png' border=0 width=15 height=15 style='cursor:pointer' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',4) alt='Eliminar Items' />";	

			img_edit 	= "<img src='" + imagePath + "editar.png' border=0 width=15 height=15 style='cursor:pointer' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',3)  alt='Modificar Items' />";


/*
		img_new_ 	= "<img src='" + imagePath + "nuevo.png' border=0 width=15 height=15 style='cursor:help' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',22)  alt='Nuevo Items' />";
		img_edit_ 	= "<img src='" + imagePath + "editar.png' border=0 width=15 height=15 style='cursor:help' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',33)  alt='Modificar Items' />";
		img_del_ 	= "<img src='" + imagePath + "eliminar.png' border=0 width=15 height=15 style='cursor:help' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',44) alt='Eliminar Items' />";
*/		
	if(treeData[i].accion == 2){
		var img_accion 	= "<img src='" + imagePath + "agregar.png' border=0 width=15 height=15 style='cursor:help' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',1)  alt='Nuevo Items' /><font style='font-size:9px;font-family:Cambria'>[Agregar]</font>";
	}
	if(treeData[i].accion == 4){
		var img_accion 	= "<img src='" + imagePath + "quitar.png' border=0 width=15 height=15 style='cursor:help' onclick=opciones('"+treeData[i].id+"','"+treeData[i].p+"','"+treeData[i].e+"','"+treeData[i].level+"','"+treeData[i].d+"','"+treeData[i].pr+"',0) alt='Eliminar Items' /><font style='font-size:9px;font-family:Cambria'>[Eliminar]</font>";
	}
			
	sLevel 					= treeData[i].level;
    levelSibling.length 	= sLevel+1;
    levelSibling[sLevel] 	= treeData[i].hasLowerSibling;
    txt 					= treeData[i].txt;
    var img 				= setImg(i);

    // Create a div to hold the node.  
    if (sLevel > 4) {  // Nivel en que se desplegaran los menus
      var sRow = "<div id='row" + i + "' style='height:30px;overflow:hidden;display:none;width:100%;'>";
      treeData[i].show = 0;  // mark the node as hidden
    }
    else {
      var sRow = "<div id='row" + i + "' style='height:30px;overflow:hidden;width:100%;'>";
    }
    for (zz=1;zz<sLevel;zz++) {// display vertical lines or spaces as required to line up the node properly.
      if (levelSibling[zz]) sRow += "<img src='" + vl + "' alt='' width=25 height=25 style='float:left;' />";  // if the node has a sibling then display a vertial line
      else if(zz > 1) sRow += "<img src='" + bl + "' alt='' width=25 height=25 style='float:left;' />"; // otherwise display a vertical line (if the node level is > 1)
    }
    sRow += "<div style='float:left;'>" + img + "</div>" ;  // display the images for the node
    sRow += "<div style='margin-top:2px;' ><span id='tvText" +i + "' onclick='clickRow(" + i + ");'>" + treeData[i].txt + "</span>";

	if(treeData[i].param == 1){
		if(i==0)
			sRow += "__"+img_new;
		else
			sRow += "____"+img_new +"  "+ img_edit +"  "+ img_del;
	}
	else if(treeData[i].param == 10){//administrar parametros
		sRow += "____"+img_accion;
	}
	sRow += "</div></div>"
    document.write(sRow);
   
  }
}

// Determine if the specified node has siblings (members at the same level under the same parent)
function hasSibling(rec) {
  var hasSibling = false;
  // loop through the array of tree objects.
  for (z=rec+1;z<treeData.length;z++) {  
    // if we reach a tree object with a lower level number then we are no longer under
    // the same parent, set the nextSibling to be the next node and break out of the loop.
    if (treeData[z].level < treeData[rec].level) {
        treeData[rec].nextSibling = z;
        break;
    }
    // if we find a node at the same level as the current node
    // set the nextSibling value to that node and set the hasLowerSibling
    // value to true, then break out of the loop.
    if (treeData[z].level == treeData[rec].level) {
      treeData[rec].hasLowerSibling = true;
      treeData[rec].nextSibling = z;
      break;
    }
  }
  // if the nextSibling value is 0 then set the nextSibling value to the last Node.
  if (treeData[rec].nextSibling == 0) treeData[rec].nextSibling = treeData.length;
}  

// setImg(nRow)
// This function determines what image files are required for each row in the tree and stores
// that information in the treeData array.
// ---------------------------------------------------------------------------------------------------------

function setImg(nRow) {
	
	var laimagen = ruta+treeData[nRow].img;
// if the node has a child then
  if (treeData[nRow].hasChild ) {
    // and the node has a sibling then imagea = plusnode
    if (treeData[nRow].hasLowerSibling) imagea = pn;
    // else imagea = plusLastNode
    else imagea = pl;
    // imageb = closed Folder
    imageb = laimagen;//cf;
  }
  // if the node does not have a child 
  else {
    // if the node has a sibling then imagea = node image
    if (treeData[nRow].hasLowerSibling) imagea = no;
    // else imagea = LastNode
    else imagea = ln;
    // imageb = document
    imageb = laimagen;//dc; 
  }
	var img = "<img id='imagea" + nRow + "' src='" + imagea + "' border=0 width=25 height=25 onclick='treeHide(" + nRow + ");' alt='' />";
  img += "<img id='imageb" + nRow + "' src='" + imageb + "' border=0 width=25 height=25 onclick='clickRow(" + nRow + ");' alt='' />";
  // if the node level is 1 then show the treeLevel image
  //if (parseInt(treeData[nRow].level) == 1) var img = "<img id='imagea" + nRow + "' src='" + tl + "' border=0 width=25 height=25 onclick='clickRow(" + nRow + ");' alt='' />";
	if (nRow == 0) var img = "<img id='imagea" + nRow + "' src='" + tl + "' border=0 width=25 height=25 onclick='clickRow(" + nRow + ");' alt='' />";  
  
  return img
}

// function treeHide(nRow)
function treeHide(nRow) {
	
	var laimagen = ruta+treeData[nRow].img;
	clickColor(nRow);
	if (treeData[nRow+1].show ==0) {      	// Show hidden rows We use nRow+1 because we don't actually want to hide the row that was clicked
    for (i=nRow+1;i<treeData[nRow].nextSibling;i++) {
      if (parseInt(treeData[i].level) == parseInt(treeData[nRow].level)+1) {
        document.getElementById('row' + i).style.display = 'block';
        treeData[i].show = 1;
      }
    }
    if(treeData[nRow].hasLowerSibling) document.getElementById('imagea' + nRow).src = mn;
    else document.getElementById('imagea' + nRow).src = ml;
    document.getElementById('imageb' + nRow).src = of;
  }
	else {	// Hide Rows
    for (i=nRow+1;i<treeData[nRow].nextSibling;i++) {
      document.getElementById('row' + i).style.display = 'none';
      treeData[i].show = 0;
      if (treeData[i].hasChild) {
        document.getElementById('imagea' + i).src = pl;
        document.getElementById('imageb' + i).src = ruta+treeData[i].img;//cf; 
      }
    }
    if(treeData[nRow].hasLowerSibling) document.getElementById('imagea' + nRow).src = pn;
    else document.getElementById('imagea' + nRow).src = pl;
    document.getElementById('imageb' + nRow).src = laimagen;//cf;
  }
}

// function clickRow(nRow) - Event to occur when a user clicks a row
function clickRow(nRow) {
  // perform the row's linkk command
  clickColor(nRow);
	if (treeData[nRow].linkk != ""){ 
  		var opcion = confirm("Esta seguro que quiere ir al link");	
		if(opcion)  window.open("../../"+treeData[nRow].linkk,"_blank");
  	}
}

function clickColor(nRow){
  currentRow = nRow;
  // unhighlight all rows
  for (i=0;i<treeData.length;i++) {
    document.getElementById('tvText'+i).style.color 			= "#000000";
    document.getElementById('tvText'+i).style.backgroundColor 	= "transparent";
    document.getElementById('tvText'+i).style.fontWeight 		= "normal";
  }
  // highlight clicked row
  document.getElementById('tvText'+nRow).style.color 			= "#ffffff";
  document.getElementById('tvText'+nRow).style.backgroundColor 	= "#0000cc";
  document.getElementById('tvText'+nRow).style.fontWeight 		= "bold";
  // perform the row's linkk command

}

function opciones(id,p,e,level,d,pr,opcion){

	var strURL="adm_menu/menus_model.php?id="+id+"&p="+p+"&e="+e+"&op="+opcion+"&l="+level+"&d="+d+"&pr="+pr;
	var req = getXMLHTTP();
	
	pantalla_carga();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {
						document.getElementById('msn_valida_xps').innerHTML = "<center><h2>DIRECCIONANDO...</h2></center>";
						//return false;
						var paso = req.responseText;
						var paso = paso.split("<pre>");
						
						if(paso.length==0){
							document.getElementById('msn_valida_xps').innerHTML = req.responseText;
							return false;
						}
						var confirmar = confirm(paso[1]);
							if(confirmar){
								setTimeout (location.href=paso[2], 200);
							}
							else{
								document.body.removeChild(document.getElementById("msn_valida_xps"));
								return false;	
							}
				} else {
					alert("Hubo un problema al utilizar XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
}

function pantalla_carga(){
		var mensaje_div = document.createElement("div");
			mensaje_div.id = "msn_valida_xps";
			mensaje_div.style.cssText = 'width:100%;height:100%;position:fixed;z-index:100;top:0px;left:0px;filter:alpha(opacity=55);opacity:.55;background-color:#fff;'
			mensaje_div.innerHTML='<center><br><br><br><br><br><img src="images/cargando_datos.gif" width="546" height="224"></center>';
			document.body.appendChild(mensaje_div);

}