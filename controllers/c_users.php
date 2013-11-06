<?php
class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	}

	/*
	 * Place to sign up
	 */
	public function signup($error = null) {

		#Setup view
		$this->template->content = View::instance('v_users_signup');
			$this->template->title = "Sign Up";

		# Pass an error message to the view if the method is called with an error parameter
		if ($error == "emailExistError") {
			$this->template->content->emailExistError="There is already a user associated with the email you entered.";
		}

		#include Javascript files in the template view
		$this->template->client_files_body = '<script type="text/javascript" src="/js/val_methods.js"></script>';
		$this->template->client_files_body .= '<script type="text/javascript" src="/js/users_signup_val.js"></script>';

		#Render template
		echo $this->template;
	}

	/*
	 * Process the sign up request
	 */
	public function p_signup() {

		#check if signup eamil already exits in database
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		$q = "SELECT user_id
				FROM users
				WHERE email='".$_POST['email']."'
				";
		$user_id = DB::instance(DB_NAME)->select_field($q);

		# email has not been used, allow signup
		if(!$user_id) {
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

		# email has been signed up, redirect to signup page with error message
		} else {
			Router::redirect("/users/signup/emailExistError");
		}
	}

	/*
	 * Shows up the v_index_index view as homepage
	 */
	public function index() {
		Router::redirect("/");
	}

	/*
	 * Place to log in
	 */
	public function login($error = null) {
		#Setup up the view
		$this->template->content = View::instance('v_users_login');
		$this->template->title = "Login";

		# Pass an error message to the view if the method is called with an error parameter
		if ($error == "error") {
			$this->template->content->errorMessage="The email and password combination does not exist! Please try again.";
		}

		$this->template->client_files_head = '<link rel="stylesheet" href="/css/login.css" type="text/css">';
		$this->template->client_files_body = '<script type="text/javascript" src="/js/users_login_val.js"></script>';

		#Render template
		echo $this->template;	
	}

	/*
	 * Process a log in request
	 */
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

				#Send them back to the login page with error parameter
				Router::redirect("/users/login/error");

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

	/*
	 * Place to view / edit profile, reset password
	 */
	public function profile($notification = null) {

		# Make sure user is logged in
		$this->loginCheck();

		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title = "Profile of ".$this->user->first_name;

		# Pass the notification to the view
		if (isset($notification)) {
			$this->template->content->notification = $notification;
		}
		
		# Setup client files
		$this->template->client_files_head = '<link rel="stylesheet" href="/css/profile.css" type="text/css">';
		$this->template->client_files_body = '<script type="text/javascript" src="/js/val_methods.js"></script>';
		$this->template->client_files_body .= '<script type="text/javascript" src="/js/users_profile_val.js"></script>';

		# Render template
		echo $this->template;
	}

	/*
	 * process uder profile update request
	 */
	public function p_profile() {

		# Make sure user is logged in
		$this->loginCheck();

		# Update database if there is a change, else redirect with error parameter
		if(($_POST['first_name'] == $this->user->first_name) && ($_POST['last_name'] == $this->user->last_name)) {
			# Redirect with a parameter "noChangeError"
			Router::redirect('/users/profile/noChangeError');		
		} else {
			# Sanitize user data
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

			# Modified field in the database also needs update
			$_POST['modified'] = Time::now();

			# Update database with $_POST
			$user_id = DB::instance(DB_NAME)->update("users", $_POST, "WHERE user_id = '".$this->user->user_id."'");

			# Redirect user to profile page after update
			Router::redirect('/users/profile');
		}
	}

	/*
	 * process password resetting request
	 */
	public function p_profile_resetPassword() {

		# Make sure user is logged in
		$this->loginCheck();

		# Check user entered old password
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		$q = "SELECT password
				FROM users
				WHERE user_id = '".$this->user->user_id."'";
		$passwordFromDB = DB::instance(DB_NAME)->select_field($q);

		# If password correct, let user update with new password, otherwise redirect with error message
		if ($_POST['password'] == $passwordFromDB) {
			# Transform new password
			$_POST['newPassword'] = sha1(PASSWORD_SALT.$_POST['newPassword']);
			# Info to be updated
			$data = Array("password" => $_POST['newPassword'],
						  "modified" => Time::now());
			# Update databse
			$user_id = DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");

			# Redirect with notification
			Router::redirect('/users/profile/passwordUpdateSuccess');
		} else {
			Router::redirect('/users/profile/wrongPasswordError');
		}
	}

	/*
	 * Check if an user is logged in.
	 */
	public function loginCheck() {
		if(!$this->user) {
			die("Members only. <a href='/users/login'>Login</a>");
		}

	}
}