<?php
class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();

		/*
		 * Make sure user is logged in if they want to use anything in this controller
		 * Since very method in the posts controller are members only,
		 * put the log in check in the constructor
		 */
		if(!$this->user) {
			die("Members only. <a href='/users/login'>Login</a>");
		}
	}

	/*
	 * place to add a new post
	 */
	public function add($notification = null) {

		# Setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title = "New Post";

		# If method is called with parameter, pass it to the view
		if(isset($notification) && ($notification == 'success')) {
			$this->template->content->notification = $notification;
		}

		# Setup client files
		$this->template->client_files_head = '<link rel="stylesheet" href="/css/addPost.css" type="text/css">';
		$this->template->client_files_body = '<script type="text/javascript" src="/js/val_methods.js"></script>';
		$this->template->client_files_body .= '<script type="text/javascript" src="/js/posts_add_val.js"></script>';

		# Render template
		echo $this->template;
	}

	/*
	 * process the request to add a post
	 */
	public function p_add() {

		# Associate this post with this user
		$_POST['user_id'] = $this->user->user_id;

		# Unix timestamp of when post was created / modified
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		# Insert
		# Note we didn't have to sanitize any of the $_POST data because we're using 
		# the insert method which does it for us
		DB::instance(DB_NAME)->insert('posts', $_POST);

		# Quick and dirty feedback
		Router::redirect('/posts/add/success');
	}

	/*
	 * Process deleting a post
	 */	
	public function delete($post_id) {
		/*
		 * IMPORTANT: to prevent a user deleting other user's post by
		 * sending "domain/posts/delete/post_id"
		 * MUST check logged in user's user_id is the same as the 
		 * user_id associated with the post_id
		 */
		$q = 'SELECT
				posts.user_id
			FROM posts
			WHERE posts.post_id = '.$post_id;

		$post_user_id = DB::instance(DB_NAME)->select_field($q);
		if ($post_user_id != $this->user->user_id) {
			die("You don't have delete access to the post!");
		}

		# Delete this post
		$where_condition = "WHERE post_id = $post_id";
		DB::instance(DB_NAME)->delete('posts', $where_condition);


		Router::redirect('/posts/index');
	}

	/*
	 * Display all the posts from the users you are following.
	 * It can be improved to always display posts of the logged in user
	 */		
	public function index() {

		# Setup the View
		$this->template->content = View::instance('v_posts_index');
		$this->template->title = "Posts";

		# Build the query
		$q = 'SELECT
				posts.post_id,
				posts.content,
				posts.created,
				posts.user_id AS post_user_id,
				users_users.user_id AS follower_id,
				users.first_name,
				users.last_name
			FROM posts
			INNER JOIN users_users
				ON posts.user_id = users_users.user_id_followed
			INNER JOIN users
				ON posts.user_id = users.user_id
			WHERE users_users.user_id = '.$this->user->user_id;

		# Run the query
		$posts = DB::instance(DB_NAME)->select_rows($q);

		# Pass data to the View
		$this->template->content->posts = $posts;

		# Render the View
		echo $this->template;
	}

	/*
	 * Where you can follow / unfollow all the users
	 */	
	public function users() {

		# Setup the View
		$this->template->content = View::instance('v_posts_users');
		$this->template->title = "Users";

		# Build the query to get all the users
		$q = "SELECT *
				FROM users";

		# Execute the query go get all the users
		# Store the result array in the variable $users
		$users = DB::instance(DB_NAME)->select_rows($q);

		# Build the query to figure out what connections does this user alreadyd have?
		# I.e. who are they following
		$q = "SELECT *
				FROM users_users
				WHERE user_id = ".$this->user->user_id;

		# Execute this query with the select_array method
		# select_array will return our results in an array and use the "user_id_followed" field as the index
		# This will come in handy when we get to the view
		# Store our results (an array) in the variable $connections
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

		# Pass data (users and connections) to the view
		$this->template->content->users = $users;
		$this->template->content->connections = $connections;

		# Setup client files
		$this->template->client_files_head = '<link rel="stylesheet" href="/css/followUser.css" type="text/css">';

		# Render the view
		echo $this->template;
	}

	/*
	 * Process the request of followign a user
	 */	
	public function follow($user_id_followed) {

		# Prepare the data array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $user_id_followed
			);

		# Do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);

		# Send them back
		Router::redirect('/posts/users');
	}

	/*
	 * Process the request of unfollowign a user
	 */	
	public function unfollow($user_id_followed) {

		# Delete this connection
		$where_condition = "WHERE user_id = '".$this->user->user_id."' AND user_id_followed = '".$user_id_followed."'";
		DB::instance(DB_NAME)->delete('users_users', $where_condition);

		# Send them back
		Router::redirect('/posts/users');
	}
}