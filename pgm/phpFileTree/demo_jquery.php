<?php
// PHP File Tree Demo
// For documentation and updates, visit http://abeautifulsite.net/notebook.php?article=21

// Main function file
include("php_file_tree.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>PHP File Tree Demo</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link href="styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
		
		<!-- Makes the file tree(s) expand/collapsae dynamically -->
		<script src="jquery-1.3.2" type="text/javascript"></script>
		<script src="php_file_tree_jquery.js" type="text/javascript"></script>
	</head>

	<body>
	

		
		<h2>Browing...</h2>
		
		<?php
		
		// This links the user to http://example.com/?file=filename.ext
		//echo php_file_tree($_SERVER['DOCUMENT_ROOT'], "http://example.com/?file=[link]/");

		// This links the user to http://example.com/?file=filename.ext and only shows image files
		//$allowed_extensions = array("gif", "jpg", "jpeg", "png");
		//echo php_file_tree($_SERVER['DOCUMENT_ROOT'], "http://example.com/?file=[link]/", $allowed_extensions);
		
		// This displays a JavaScript alert stating which file the user clicked on
		echo php_file_tree("../_plantillas/", '../_plantillas/[link]');
		
		?>
		
	</body>
	
</html>
