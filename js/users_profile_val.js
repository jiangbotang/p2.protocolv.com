 /*
 * IMPORTANT NOTE: the validation methods are all from val_methods.js
 * so for the validateForm() to work, the web page needs to have 
 * both this js and the val_methods.js included.
*/

// Just to check form fields are not empty
function validateProfile() {
	//validate first_name, return false if first_name is empty
	var first_name = document.forms["profileUpdate"]["first_name"].value;
	//isEmpty(first_name) returns true if first_name is empty
	//in that case, validateForm() return false
	//otherwise, keep moving	
	if (isEmpty(first_name)) {
		alert("You forgot to enter First Name.");
		return false;
	}


	//validate last_name, return false if last_name is empty
	var last_name=document.forms["profileUpdate"]["last_name"].value;
	if(isEmpty(last_name)) {
		alert("You forgot to enter Last Name.");
		return false;
	}

}

// Check form fields are not empty
// Two entries of new password are identical
function validatePassword() {
	//validate password, return false if password is empty
	var password=document.forms["passwordUpdate"]["password"].value;
	if(isEmpty(password)) {
		alert("You forgot to enter Password.");
		return false;
	}

	// New password can't be empty
	var newPassword=document.forms["passwordUpdate"]["newPassword"].value;
	if(isEmpty(newPassword)) {
		alert("You forgot to enter a new Password.");
		return false;
	}

	// Confirm password can't be empty
	var newPasswordCheck=document.forms["passwordUpdate"]["newPasswordCheck"].value;
	if(isEmpty(newPasswordCheck)) {
		alert("You forgot to confirm the new Password.");
		return false;
	}

	// Must confirm the new password
	if(newPassword != newPasswordCheck) {
		alert("Confirm new password failed! You entered your new Password differently.")
		return false;
	}

}
