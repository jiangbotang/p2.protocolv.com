<!-- the login & sign up view -->
<div id="content_sl">
	<!-- the sign up part of the view -->
	<div id="signup">
		<form method='POST' action='/users/signup'>
			<h2>Welcome!</h2>
			<p>BitClipper is a place where you can post your status upgrad and share that with
				you friends. You can also follow your friends and check their posts and status upgrade.
			</p>
			<p>
				Please sign up to get started!
			</p>
			<input type='submit' value='Sign up'>
		</form>
	</div>

	<!-- the login part of the view -->
	<div id="login">
		<form name='myForm' method='POST' action='/users/p_login' onsubmit="return validateForm();">

			Email<br>
			<input type='text' name='email'>
			<br><br>

			Password<br>
			<input type='password' name='password'>
			<br>

			<?php if(isset($errorMessage)) echo $errorMessage; ?>
			<br>

			<input type='submit' value='Log in'>
		</form>
	</div>
</div>