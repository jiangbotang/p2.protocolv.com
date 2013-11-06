<h4>Follow someone to see his/her posts. You need to follow yourself to see your own posts!</h4>

<?php foreach($users as $user): ?>

	<!-- Print this user's name -->
	<h3><?=$user['first_name']?> <?=$user['last_name']?></h3>

	<!-- If there exists a connection with this user, show a unfollow link -->
	<?php if(isset($connections[$user['user_id']])): ?>
		<a class='btn' href="/posts/unfollow/<?=$user['user_id'] ?>">unfollow</a>

	<!-- Otherwise, show the follow link -->
	<?php else: ?>
		<a class='btn' href="/posts/follow/<?=$user['user_id'] ?>">follow</a>
	<?php endif; ?>

	<br><br>
<?php endforeach; ?>