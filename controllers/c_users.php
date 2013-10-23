<?php
class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	}

	public function signup() {

		#Setup view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title = "Sign Up";

		#include Javascript files in the template view
		$this->template->client_files_body = '<script type="text/javascript" src="/js/val_methods.js"></script>';
		$this->template->client_files_body .= '<script type="text/javascript" src="/js/users_signup_val.js"></script>';

		#Render template
		echo $this->template;
	}

	public function p_signup() {

		# More data we want to store with the user
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();

		# Encrypt the password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# Create an encrypted token via their email address and a random string
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

		#Insert this user into the database
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

		# Confirm the sign up and provide a link to go back to the log in page
		$this->template->content = View::instance('v_users_p_signup');
		$this->template->content->email = $_POST['email'];
		$this->template->title = "Sign Up";
		echo $this->template;
	}

	public function index() {
		echo "This is the index page";
	}

	public function login() {
		#Setup up the view
			$this->template->content = View::instance('v_users_login');
			$this->template->title = "Login";

			$this->template->client_files_head = '<link rel="stylesheet" href="/css/login.css" type="text/css">';

			$this->template->client_files_body = '<script type="text/javascript" src="/js/users_login_val.js"></script>';

		#Render template
			echo $this->template;
		
	}

	public function p_login() {
		#Sanitize the user entered data to prevent any funny-business
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		#Hash submitted password so we can compare it against one in the db
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		#Search the db for this email and password
		#Retrieve the token if it's available
			$q = "SELECT token
					FROM users
					WhERE email='".$_POST['email']."'
					AND password = '".$_POST['password']."'
				 ";

			$token = DB::instance(DB_NAME)->select_field($q);

		#If we didn't find a matching token in the database, it means login failed
			if(!$token) {

				#Send them back to the login page
				Router::redirect("/users/login");

		#But if we did, login succeed!
			} else {

				/*
				Store this token in a cookie using setcookie()
				Important Note: *Nothing* else can echo to the page before setcookie
				is called.
				Not even one single white space.
				param 1 = name of the cookie
				param 2 = the value of the cookie
				param 3 = when to expire
				param 4 = the path of the cookie (a single forward slash sets it for 
				the entire domain)				
				*/
				setcookie("token", $token, strtotime('+1 year'), '/');

				# Send them to the main page - or whatever you want them to go
				Router::redirect("/");
			}
	}

	public function logout() {
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

		# Delete their token cookie by settting it to a date in the past - effectively loggin them out
		# James comment: not secure? possible to modify the cookie?
		setcookie("token", "", strtotime('-1 year'), '/');

		# Send them back to the main index
		Router::redirect('/');
	}

	public function profile($user_name = NULL) {

		# If user is black, they're not logged in; redirect them to the login page
		if(!$this->user) {
			Router::redirect('/users/login');
		}

		# If they werent' rederected away, continue:

		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title = "Profile of ".$this->user->first_name;

		# Render template
		echo $this->template;
	}
}