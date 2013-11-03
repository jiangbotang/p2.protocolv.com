/*
 * IMPORTANT NOTE: the validation methods are all from val_methods.js
 * so for the validateForm() to work, the web page needs to have 
 * both this js and the val_methods.js included.
*/

// Just to check form fields are not empty
function validatePostContent() {
	//validate post content, return false if it is empty
	var postContent = document.forms["newPost"]["content"].value;
	//isEmpty(postContent) returns true if postContent is empty
	//in that case, validatePostContent() return false
	if (isEmpty(postContent)) {
		alert("Can't add empty post!");
		return false;
	}
}