function generatePassword(f,campo) {
	sarr = new Array("abcdefghijkmnopqrstuvwxyz", "ABCDEFGHJKLMNOPQRSTUVWXYZ", "0123456789", "~!@#%^*_+-=<>");
	s = new String();
	pw = new String();
	s = ((f.s0.checked) ? sarr[0] : '') + ((f.s1.checked) ? sarr[1] : '') + ((f.s2.checked) ? sarr[2] : '') + ((f.s3.checked) ? sarr[3] : '');
	if (s.length < 1) {
	  alert('¡Tienes que decirnos con qué caracteres generar la contraseña!');
	  return(false);
	}
	for (i = 0; i < f.len.value; i++) {
	   pw += s.charAt(Math.floor(Math.random()*s.length));
	}
//	f.pw.value = pw;
	document.getElementById(campo).value = pw;

	chkPass(pw);

	testPassword(pw);
}

function inc(bt) {
	return add(bt, 1);
}

function dec(bt) {
	return add(bt, -1);
}

function add(bt, num) {
	var num = new Number(num);
	var val = new Number(document.forms[0].len.value);
	val = val + num;

	if (val < 1) {
		val = 1;
	}

	document.forms[0].len.value = val.toString();
	return false;
}

function validate(bt) {
	f = bt.form;

	name  = f.sender_.value;
	email = f.semail_.value;
	msg   = f.stext_.value;

	if (name == '' || email == '' || msg == '') {
		return false;
	}

	return true;
}


function testPassword(passwd)
{
		var intScore   = 0
		var strVerdict = "weak"
		var strLog     = ""
		
		// PASSWORD LENGTH
		if (passwd.length<5)                         // length 4 or less
		{
			intScore = (intScore+3)
			strLog   = strLog + "3 points for length (" + passwd.length + ")\n"
		}
		else if (passwd.length>4 && passwd.length<8) // length between 5 and 7
		{
			intScore = (intScore+6)
			strLog   = strLog + "6 points for length (" + passwd.length + ")\n"
		}
		else if (passwd.length>7 && passwd.length<16)// length between 8 and 15
		{
			intScore = (intScore+12)
			strLog   = strLog + "12 points for length (" + passwd.length + ")\n"
		}
		else if (passwd.length>15)                    // length 16 or more
		{
			intScore = (intScore+18)
			strLog   = strLog + "18 point for length (" + passwd.length + ")\n"
		}
		
		
		// LETTERS (Not exactly implemented as dictacted above because of my limited understanding of Regex)
		if (passwd.match(/[a-z]/))                              // [verified] at least one lower case letter
		{
			intScore = (intScore+1)
			strLog   = strLog + "1 point for at least one lower case char\n"
		}
		
		if (passwd.match(/[A-Z]/))                              // [verified] at least one upper case letter
		{
			intScore = (intScore+5)
			strLog   = strLog + "5 points for at least one upper case char\n"
		}
		
		// NUMBERS
		if (passwd.match(/\d+/))                                 // [verified] at least one number
		{
			intScore = (intScore+5)
			strLog   = strLog + "5 points for at least one number\n"
		}
		
		if (passwd.match(/(.*[0-9].*[0-9].*[0-9])/))             // [verified] at least three numbers
		{
			intScore = (intScore+5)
			strLog   = strLog + "5 points for at least three numbers\n"
		}
		
		
		// SPECIAL CHAR
		if (passwd.match(/.[!,@,#,$,%,^,&,*,?,_,~]/))            // [verified] at least one special character
		{
			intScore = (intScore+5)
			strLog   = strLog + "5 points for at least one special char\n"
		}
		
									 // [verified] at least two special characters
		if (passwd.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/))
		{
			intScore = (intScore+5)
			strLog   = strLog + "5 points for at least two special chars\n"
		}
	
		
		// COMBOS
		if (passwd.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))        // [verified] both upper and lower case
		{
			intScore = (intScore+2)
			strLog   = strLog + "2 combo points for upper and lower letters\n"
		}

		if (passwd.match(/([a-zA-Z])/) && passwd.match(/([0-9])/)) // [verified] both letters and numbers
		{
			intScore = (intScore+2)
			strLog   = strLog + "2 combo points for letters and numbers\n"
		}
 
									// [verified] letters, numbers, and special characters
		if (passwd.match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/))
		{
			intScore = (intScore+2)
			strLog   = strLog + "2 combo points for letters, numbers and special chars\n"
		}
	

		var ctlBar = document.getElementById("mypassword_bar");
		var ctlText = document.getElementById("mypassword_text");


		if(intScore < 12)
		{
			strColor = "red";
			strText = "Bajo";
			ctlBar.style.width = "20%";
		}
		else if (intScore > 11 && intScore < 22)
		{
			strColor = "#e9730b";
			strText = "Regular";
			ctlBar.style.width = "40%";
		}
		else if (intScore > 21 && intScore < 32)
		{
			strColor = "#e9e20b";
			strText = "Media";
			ctlBar.style.width = "60%";
		}
		else if (intScore > 31 && intScore < 42)
		{
			strColor = "#5de90b";
			strText = "Alta";
			ctlBar.style.width = "80%";
		}
		else
		{
			strColor = "green";
			strText = "Muy Alta";
			ctlBar.style.width = "100%";
		}
	

	ctlBar.style.backgroundColor = strColor;
	ctlText.innerHTML = "<span>" + strText + "</span>";

}
