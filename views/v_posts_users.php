<h4>Follow someone to see his/her posts. You need to follow yourself to see your own posts!</h4>

<?php foreach($users as $user): ?>

	<!-- Print this user's name -->
	<em><?=$user['first_name']?> <?=$user['last_name']?></em>
	<br>

	<!-- If there exists a connection with this user, show a unfollow link -->
	<?php if(isset($connections[$user['user_id']])): ?>
		<button><a href="/posts/unfollow/<?=$user['user_id'] ?>">unfollow</a></button>

	<!-- Otherwise, show the follow link -->
	<?php else: ?>
		<button><a href="/posts/follow/<?=$user['user_id'] ?>">follow</a></button>
	<?php endif; ?>

	<br><br>
<?php endforeach; ?>