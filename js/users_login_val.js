function validateForm() {

	/* validate input email address
 	* must contain an @ sign and at least one dot (.)
 	* the @ must not be the first character of the email address
 	* the last dot must be present after the @ sign
 	* minimum 2 characters before the end
	*/
	var x=document.forms["myForm"]["email"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
  		alert("You entered an invalid email address");
  		return false;
  	}

  	/*
 	* make sure password field is not empty
	*/
	var x=document.forms["myForm"]["password"].value;
	if (x==null || x=="") {
  		alert("You forgot to enter password");
  		return false;
 	 }
}

