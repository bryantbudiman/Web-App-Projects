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
		<li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Search Results</a></li>
		<li class="breadcrumb-item active">Add Schedule</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Schedule a Running Race</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php
					$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
					$country_id = 8;

					if ($mysqli->connect_errno) :
						// DB Error
						echo $mysqli->connect_error;
					else :
						$dvdSQL = "SELECT country_id
								FROM country
								WHERE nicename LIKE '" . $_GET['country'] . 
								"' OR iso3 LIKE '" . $_GET['country'] . 
								"' OR iso LIKE '" . $_GET['country'] . "';";

						$results = $mysqli->query($dvdSQL);

						if(!$results) {
							echo $mysqli->error;
						} else {
							while ( $row = $results->fetch_assoc() ) {
								$country_id = $row['country_id'];
							}
						}

						$sql = "INSERT INTO schedule (name, race_type_id, distance, start_date, city, country_id, url)
								VALUES ('"
							. $_GET['name']
							. "', " 
							. $_GET['race_type']
							. ", "
							. $_GET['distance']
							. ", '"
							. $_GET['date']
							. "', '"
							. $_GET['city']
							. "', "
							. $country_id
							. ", '"
							. $_GET['url']
							. "');";

						$results = $mysqli->query($sql);

						if (!$results) :
							// SQL Error
							echo $mysqli->error;
						else :
							// SQL Success
				?>
						<div class="text-success"><span class="font-italic"><?php echo $_GET['name']; ?></span> was successfully scheduled.</div>

				<?php
						endif; /* SQL Error */
					$mysqli->close();
					endif; /* DB Connection Connection Error */
				?>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-danger">Back</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>