// TreeView ver 1.2
// by Neal Schafer

// Define Global Variables
var ruta = '../menu/js/menu/img/';
var treeData = new Array()					        // The treeData array stores all of the information before the tree is displayed
var imagePath = './images/'		    // Stores the path to image files used
var mn = imagePath + 'tvMinusNode.gif'		  // The Minus Node image file
var ml = imagePath + 'tvMinusLastNode.gif'  // The Minus Last Node image file
var pn = imagePath + 'tvPlusNode.gif'	    	// The Plus Node Image file
var pl = imagePath + 'tvPlusLastNode.gif' 	// The Plus Last Node image file
var no = imagePath + 'tvNode.gif'			      // The Node image file (no plus or minus)
var ln = imagePath + 'tvLastNode.gif'		    // The Last Node image file (no plus or minus)
var vl = imagePath + 'tvVertLine.gif'		    // The Vertical Line image file
var bl = imagePath + 'tvBlank.gif'			    // The blank image file
var tl = imagePath + 'tvTopLevel.gif'		    // The Top Level Image file (Used for Level A nodes)
var of = imagePath + 'tvOpenFolder.gif'		  // The Open Folder image file
var cf = imagePath + 'tvClosedFolder.gif'	  // The Closed Folder image file
var dc = imagePath + 'tvPage.gif'			      // The Document image file


// function tree(level,txt,link)
// This function actually creates the object of which treeData is an array.  
// The parameters of this object are:
//  Level   (integer) 1 being top level
//  txt     The text to be displayed in the tree view
//  link    The page that clicking on the text will link you to
//  show       determines if the node is visible 1 = yes; 0 = no
//  hasChild   
//  hasLowerSibling
//  nextSibling
//--------------------------------------------------------------------------------------------------------

function opciones(id, opcion){

	var agregar = "agrega_menu.asp?";
	var quitar 	= "quita_menu.asp?";
	var nuevo	= "nuevo_menu.asp?";
	
//	alert(pagina+"id="+ id +"&op="+opcion);
	
	switch (opcion){
	
		case 1 : location.href=agregar+"id="+ id;
				break;
				
		case 2 : location.href=nuevo+"id="+ id;
				break;
				
		case 3 : location.href=quitar+"id="+ id;
				break;
	}
}

function tree(level,txt,link,img,id,accion) {

	this.level = level;
	this.txt = txt;
	this.link = link;
	this.img = img;
	this.show = 1;
	this.hasChild = false;
	this.hasLowerSibling = false;
	this.nextSibling = 0;
	this.id = id;
	this.accion = accion;
}

// function treeAdd(level,txt,link)
// This function is used to actually create the array element containing the tree object defined above.  
// There is one array entry for each row in the tree.
//---------------------------------------------------------------------------------------------------------
function treeAdd(level,txt,link,img,id,accion) {
	x = treeData.length;//tamaño elementos del menu
	treeData[x] = new tree(level,txt,link,img,id,accion);
}

// function makeTree()
// This function actually creates and fills in the table in the web browser using the data from the treeData array.
// This function should be called only after treeAdd() has been called for each node in the tree.
// --------------------------------------------------------------------------------------------------------
function makeTree() {
  var levelSet = 0;//cambio por rodrigo
  var link	= '';
  var txt	= '';
  var img	= '';
  // Set the Child and Sibling Flags for Each Row
  for (i=0;i<treeData.length;i++)	{
    hasSibling(i);
    if (i+1 < treeData.length) {
      if (treeData[i+1].level > treeData[i].level) treeData[i].hasChild = true;
      else treeData[i].hasChild = false;
    }
  }
  levelSibling = new Array();
  for (i=0;i<treeData.length;i++)	{
	  

	if(treeData[i].accion == 1){
		var img_new 	= "";
		var img_del 	= "____<img src='" + imagePath + "/eliminar.png' border=0 width=15 height=15 style='cursor:hand' onclick=opciones('" + treeData[i].id + "',3) alt='Quita Items' />";	
	}else{
		var img_new 	= "____<img src='" + imagePath + "/nuevo.png' border=0 width=15 height=15 style='cursor:hand' onclick=opciones('" + treeData[i].id + "',1)  alt='Agrega Items' />";
		var img_del 	= "";
	}


	if(treeData[i].accion == 500){
		var img_new 	= "";
		var img_del 	= "";
	}
/**/

    sLevel = treeData[i].level;
    levelSibling.length = sLevel+1;
    levelSibling[sLevel] = treeData[i].hasLowerSibling;
    txt = treeData[i].txt;
    var img = setImg(i);
    // Create a div to hold the node.  
    if (sLevel > 2) {  // If the node level is higher than 2 then start with it hidden.
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

		if(i>0)
			sRow += img_new + img_del;
	
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
  if (parseInt(treeData[nRow].level) == 1) var img = "<img id='imagea" + nRow + "' src='" + tl + "' border=0 width=25 height=25 onclick='clickRow(" + nRow + ");' alt='' />";
  return img
}

// function treeHide(nRow)
function treeHide(nRow) {
	
	var laimagen = ruta+treeData[nRow].img;
	
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
  currentRow = nRow;
  // unhighlight all rows
  for (i=0;i<treeData.length;i++) {
    document.getElementById('tvText'+i).style.color = "#000000";
    document.getElementById('tvText'+i).style.backgroundColor = "transparent";
    document.getElementById('tvText'+i).style.fontWeight = "normal";
  }
  // highlight clicked row
  document.getElementById('tvText'+nRow).style.color = "#ffffff";
  document.getElementById('tvText'+nRow).style.backgroundColor = "#0000cc";
  document.getElementById('tvText'+nRow).style.fontWeight = "bold";
  // perform the row's link command
  if (treeData[nRow].link != "") window.location = (treeData[nRow].link); 
}


