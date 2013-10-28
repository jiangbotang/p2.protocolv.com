<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<!-- master css -->
	<link type="text/css" rel="stylesheet" href="/css/master.css">				
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>
	<!-- header -->
	<div id="header">
		<img src="/resource/img/logo.jpg">
	</div>

	<!-- display the menu if user is logged in-->
	<?php if($user): ?>
		<div id="menu">
			<!-- bring user back to posts page -->
			<a href='/posts/index'>Home</a>

			<a href='/users/logout'>Logout</a>
			<a href='/users/profile'>Profile</a>
			<a href='/posts/index'>Posts</a>
			<a href='/follow/follow'>Follow</a>
		</div>
	<?php endif; ?>


	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>

    <!-- footer -->
    <div id="footer">
    	<p>Cooyright 2013 Jiangbo Tang</p>
    </div>
</body>
</html>