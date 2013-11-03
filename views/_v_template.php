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

	<!-- display the navigation bar if user is logged in
		 The styling are basically from Saddam Azad
		 http://azadcreative.com/2009/03/bulletproof-css-sliding-doors/
	-->
	<?php if($user): ?>
		<div class="navigation">
			<ul>
				<li><a href='/'><span>Home</span></a></li>
				<li><a href='/users/profile'><span>My Profile</span></a></li>
				<li><a href='/posts/index'><span>See Posts</span></a></li>
				<li><a href='/posts/add'><span>New Post</span></a></li>
				<li><a href='/posts/users'><span>Follow Someone</span></a></li>
				<li><a href='/users/logout'><span>Logout</span></a></li>
			</ul>
		</div>
	<?php endif; ?>


	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>

	<!-- footer -->
	<div id="footer">
    	<p>Harvard Extension School CSCI E-15. Cooyright 2013 Jiangbo Tang.</p>
	</div>

</body>
</html>