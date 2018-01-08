<?php
	session_start();

	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
		header('Location: ../login/login.php');
	}

	require '../config/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BBB's Running Schedule<</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
</head>
<body>
	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Schedule</a></li>
		<li class="breadcrumb-item active">Delete</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Delete a Song</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php 
					if ( !isset($_GET['id']) || empty($_GET['id']) ) : 
				?>

				<div class="text-danger">Invalid Track ID.</div>

				<?php
					else :
						$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

						if ($mysqli->connect_errno) :
							// DB Error
							echo $mysqli->connect_error;
						else :
							$sql = "DELETE FROM schedule WHERE id = " . $_GET['id'] . ";";

							$results = $mysqli->query($sql);

							if (!$results) :
								// SQL Error
								echo $mysqli->error;
							else :
								// SQL Success
				?>
							<div class="text-success"><span class="font-italic"><?php echo $_GET['name']; ?></span> was successfully updated.</div>

				<?php
							endif; /* SQL Error */
							$mysqli->close();
						endif; /* DB Connection Connection Error */
					endif; /* Required input validtion */
				?>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-danger">Back to Schedule</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container -->

</body>
</html>