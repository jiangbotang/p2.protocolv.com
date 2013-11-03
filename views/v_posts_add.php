<!-- This is the notification area -->
<?php if(isset($notification)): ?>
	<?php switch($notification):
		case "success": ?>
		<em>Your post has been added.</em>
		<br><br>
		<?php break; ?>
	<?php endswitch; ?>
<?php endif; ?>

<!-- Form for entering submit post content -->
<form name='newPost' method='POST' action='/posts/p_add' onsubmit="return validatePostContent()">

	<label for='content'>New Post</label><br>
	<textarea name='content' id='content'></textarea>

	<br><br>
	<input type='submit' value='New Post'>

</form>