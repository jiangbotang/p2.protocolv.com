/*
 * Use to check if a input is empty or not
 * Return true if x is null or empty
*/
function isEmpty(x) {
	if (x==null || x=="") {
  		return true;
 	 } else {
 	 	return false;
 	 }
}

/*
 * Use to check if email address is valid
 * Return true if it is NOT a valid email address
 * To be a valid
 * The input data must contain an @ sign and at least one dot (.)
 * The @ must not be the first character of the email address
 * The last dot must be present after the @ sign, and minimum 2 characters before the end
*/
function notEmail(x) {
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
  		return true;
  	} else {
  		return false;
  	}
}