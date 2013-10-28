<form name='myForm' method='POST' action='/users/p_signup' onsubmit="return validateForm()">

	First Name<br>
	<input type='text' name='first_name' value="<?php if(isset($_POST['first_name'])) 
															{echo htmlentities($_POST['first_name']);} ?>">
	<br><br>

	Last Name<br>
	<input type='text' name='last_name'>
	<br><br>

	Email<br>
	<input type='text' name='email'>
	<?php if(isset($emailExistError)) echo $emailExistError; ?>
	<br><br>

	Password<br>
	<input type='password' name='password'>
	<br><br>

	<input type='submit'>

</form>