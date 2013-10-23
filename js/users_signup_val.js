/*
 * Validate the signup form, make sure every field is not empty
 * and email address is valid.

 * IMPORTANT NOTE: the validation methods are all from val_methods.js
 * so for the validateForm() to work, the web page needs to have 
 * both this js and the val_methods.js included.
*/
function validateForm() {
	//validate first_name, return false if first_name is empty
	var first_name = document.forms["myForm"]["first_name"].value;
	//isEmpty(first_name) returns true if first_name is empty
	//in that case, validateForm() return false
	//otherwise, keep moving	
	if (isEmpty(first_name)) {
		alert("You forgot to enter First Name.");
		return false;
	}


	//validate last_name, return false if last_name is empty
	var last_name=document.forms["myForm"]["last_name"].value;
	if(isEmpty(last_name)) {
		alert("You forgot to enter Last Name.");
		return false;
	}

	//validate email, return false if not a valid email address
	var email=document.forms["myForm"]["email"].value;
	if(notEmail(email)) {
		alert("Your email address is not valid.");
		return false;
	}

	//validate password, return false if password is empty
	var password=document.forms["myForm"]["password"].value;
	if(isEmpty(password)) {
		alert("You forgot to enter Password.");
		return false;
	}

}
