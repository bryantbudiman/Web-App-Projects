<?php

session_start();
// Check whether user is logged in.
if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
	// User is not logged in.

	$login_error = false;

	// Check whether form was submitted
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		// Form was submitted

		if ( empty($_POST['username']) || empty($_POST['password']) ) {
			// Missing username or pass.
			$login_error = 'empty';
		} elseif ( $_POST['username'] == 'bryant' && $_POST['password'] == 'budiman' ) {
			// Correct Credentials
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $_POST['username'];
			header('Location: ../running-db');
		} else {
			// Invalid credentials
			$login_error = 'invalid';
		}

	}

} else {
	// User is already logged in.
	header('Location: ../running-db');
}

?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Benjamin Bryant Budiman">
	<link rel="icon" href="../../favicon.ico">

	<title>BBB's Running Schedule</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}

		body {
			background-color: #f7f9f9;
		}

		.text {
			color: black;
		}

		#header {
			background-image: url('https://s3-eu-west-1.amazonaws.com/rb-cms/wmm-stage/uploads/imageuploader_cms/5dd6086f65205c42fb3a9b8ef8f257fb9d0a/i1200.jpg');
			background-size: cover;
			background-position: center;
			line-height: 400px;
			height: 400px;
			text-align: center;
			color: #FFF;
			font-size: 2.3em;
			text-shadow: 0 0 15px #000;
			position: relative;
		}
	</style>
</head>
<body>
	<div id="header">
		BBB's Running Schedule
	</div> <!-- #header -->

	<div class="container">
		<div class="row">
			<h3 class="col-12 mt-4 text-left text">User Login</h3>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">

					<?php if ( $login_error == 'empty' ) : ?>
						Please enter username and password.
					<?php endif; ?>

					<?php if ( $login_error == 'invalid' ) : ?>
						Invalid username or password.
					<?php endif; ?>

				</div>
			</div> <!-- .row -->
			
			<div class="form-group row">
				<label for="username" class="col-sm-3 col-form-label text-sm-right text">Username</label>
				<div class="col-sm-8">
				<input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
				</div>
			</div>

			<div class="form-group row">
				<label for="password" class="col-sm-3 col-form-label text-sm-right text">Password</label>
				<div class="col-sm-8">
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-danger">Login</button>
					<a href="../running-db" role="button" class="btn btn-danger">Cancel</a>
				</div>
			</div> <!-- .form-group -->
		</form>

	</div> <!-- .container -->
</body>
</html>