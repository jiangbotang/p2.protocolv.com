<h2>Welcome, <?php echo $user->first_name; ?> <?php echo $user->last_name; ?></h2>

<!-- show different notification messages -->
<?php if(isset($notification)): ?>
	<?php switch($notification):
		case "noChangeError": ?>
		<em>You haven't made any change to your profile!</em>
		<br><br>
		<?php break; ?>

		<?php case "wrongPasswordError": ?>
		<em>Please enter correct current password!</em>
		<br><br>
		<?php break; ?>

		<?php case "passwordUpdateSuccess": ?>
		<em>You password has been updated!</em>
		<br><br>
		<?php break; ?>
	<?php endswitch; ?>
<?php endif; ?>

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
			<input type="submit" value="Update My Profile">
		</form>
	</div>

	<div id="passwordUpdate">
		<form name='passwordUpdate' method='POST' action='/users/p_profile_resetPassword' onsubmit="return validatePassword()">
			<label for="password"><small>Your Current Password</small></label>
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
			<input type="submit" value="Update My Password">
		<form>
	</div>
</div>
