<h2>Welcome to <?=APP_NAME?></h2>

<?php if($user): ?>
	<h2>You are logged in as <em><?=$user->first_name?> <?=$user->last_name?> !</em></h2>
<?php endif; ?>

<p><?=APP_NAME?> is a simple micro-blogging platform.
	<br>
	Please log in to see the posts
	of the people you are following!
	<br>
	If you haven't signed up yet.
	Please sign up to get started.
</p>
<br><br>
<button><a href='/users/login'><em>log in</em></a></button>
<button><a href='/users/signup'><em>sign up</em></a></button>

<br><br>
<h4>+1 features:</h4>
<ul>
	<li>Editting profile</li>
	<li>Resetting password</li>
	<li>Delete post</li>
</ul>
