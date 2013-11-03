<em>Reminder: you need to <a href='/posts/users'>follow a person</a> before you can review their posts!</em>

<!-- Start showing posts one by one -->
<?php foreach($posts as $post): ?>
<article>
	<h2><?=$post['first_name']?> <?=$post['last_name']?> posted:</h2>

	<p><?=$post['content']?></p>

	<time datetime="<?=Time::display($post['created'], 'Y-m-d G:i')?>">
		<?=Time::display($post['created'])?>
	</time>
</article>

<!-- If the owner of the post, provide the option to delete it -->
<?php if($post['post_user_id'] == $user->user_id): ?>
<!-- Send the post_id to the delete method -->
<button><a href='/posts/delete/"<?=$post['post_id']?>"'>DELETE</a></button>
<?php endif ?>

<?php endforeach; ?>