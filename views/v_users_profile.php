<h2>Welcome, <?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h2>
<div id="profile">
	<div id="profileUpdate">
		<form name='profileUpdate' method='POST' action='/users/p_profile' onsubmit="return validateProfile()">
			<label><small>Your First Name</small></label>
			<br>
			<input type="text" name="first_name" placeholder="Your First Name" value="<?php echo $user->first_name;?>">

			<br><br>
			<lable><small>Your Last Name</small></label>
			<br>
			<input type="text" name="last_name" placeholder="Your Last Name" value="<?php echo $user->last_name; ?>">

			<br><br>
			<label><small>Your Email Address</small></label>
			<br>
			<input type="text" name="email" placeholder="Your Email Address" value="<?php echo $user->email; ?>" disabled>

			<br><br>
			<button type="submit">Update My Profile</button>
		</form>
	</div>

	<div id="passwordUpdate">
		<form name='passwordUpdate' method='POST' action='/users/p_profile_resetPassword' onsubmit="return validatePassword()">
			<label for="password"><small>Your Old Password</small></label>
			<br>
			<input type="password" name="password" placeholder="Your old password">

			<br><br>
			<label for="newPassword"><small>Your New Password</small></label>
			<br>
			<input type="password" name="newPassword" placeholder="Your new password">

			<br><br>
			<label for="newPasswordCheck"><small>Confirm Your New Password</small></label>
			<br>
			<input type="password" name="newPasswordCheck" placeholder="Your new password">

			<br><br>
			<button type="submit">Update My Password</button>
		<form>
	</div>
</div>
