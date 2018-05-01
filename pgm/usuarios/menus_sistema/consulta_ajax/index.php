<html>
<head>
<script>
function ajax_post(url){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    
    var fn = document.getElementById("first_name").value;
    var ln = document.getElementById("last_name").value;


    var vars = "firstname="+fn+"&lastname="+ln;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = "processing...";
}

function enviar(){

	var url = "rnl_consulta.php";
	
	ajax_post(url);
}

</script>
</head>
<body>
<h2>Ajax Post to PHP and Get Return Data</h2>
First Name: <input id="first_name" name="first_name" type="text">  <br><br>
Last Name: <input id="last_name" name="last_name" type="text"> <br><br>
<input name="myBtn" type="submit" value="Submit Data" onclick="enviar();"> <br><br>
<div id="status"></div>
</body>
</html>