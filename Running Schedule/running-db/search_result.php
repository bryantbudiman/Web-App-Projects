<?php
	session_start();
	
	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
		header('Location: ../login/login.php');
	}

	define('STRAVA_API_ENDPOINT', 'https://www.strava.com/api/v3/running_races/?year=2017');
	define('AUTH_TOKEN', 'a2b481cf6df03dd772986d913916431d412686b7');
	$header = ['Authorization: Bearer ' . AUTH_TOKEN];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, STRAVA_API_ENDPOINT);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	$response = curl_exec($ch);
	$response = json_decode($response, true);

	$result = array(
		0 => array(
			'race_type' => 0,
			'distance' => 8.8,
			'country' => 'Indonesia',
			'city' => 'Jakarta',
			'date' => '8/8/2018',
			'url' => 'www.nice.com'
			)
	);

	$dateChosen = new DateTime($_GET['start_date']);  

	for ($i = 0; $i < count($response); $i++) {
		$dateString = substr($response[$i]["start_date_local"], 0, 10);
		$dateRace = new DateTime($dateString);
		$temp = false; 

		if ( $_GET['country'] == "United States") {
			if($response[$i]["country"] == "United States" || $response[$i]["country"] == "USA") {
				$temp = true;
			}
		} else if ($_GET['country'] == "United Kingdom") {
			if($response[$i]["country"] == "United Kingdom" || $response[$i]["country"] == "UK") {
				$temp = true;
			}
		} else {
			if($response[$i]["country"] == $_GET['country']) {
				$temp = true;
			}
		}

		if( ($response[$i]["running_race_type"] == $_GET['race_type']) &&
			($temp) &&
			($response[$i]["city"] == $_GET['city']) && 
			($dateChosen < $dateRace)
		) {
 			$add = array(
 				'name' => $response[$i]["name"],
 				'race_type' => $response[$i]["running_race_type"],
				'distance' => $response[$i]["distance"],
				'country' => $response[$i]["country"],
				'city' => $response[$i]["city"],
				'date' => $response[$i]["start_date_local"],
				'url' => $response[$i]["url"]
 			);

 			array_push($result, $add);
		}
	} 	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BBB's Running Schedule</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">

	<style>
	.table th, .table td {
		text-align: center;
		vertical-align: middle;
	}

	tr img {
		max-width: 100px;
	}

	table.editTable td {
		font-size: 14px;
	}

		#header {
			background-image: url('http://www.telegraph.co.uk/content/dam/Travel/2017/April/marathon-tromso-xlarge.jpg');
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
	<?php include 'nav.php'; ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search Form</a></li>
		<li class="breadcrumb-item active">Search Results</li>
	</ol>

	<div class="container-fluid">

		<div class="row">
			<h1 class="col-12 mt-4">BBB's Running Schedule</h1>
		</div> <!-- .row -->

		<div id="header">
			Search Result
		</div> <!-- #header -->

		<div class="row">

			<div class="col-12 mt-4">
				Showing <span id="num-results" class="font-weight-bold">
					<?php echo (count($result)-1); ?>
				</span> result(s).
			</div>

			<table class="table table-responsive table-striped col-12 mt-3 editTable">
				<thead>
					<tr>
						<th>Name</th>
						<th>Race Type</th>
						<th>Distance</th>
						<th>Country</th>
						<th>City</th>
						<th>Date</th>
						<th>URL</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$race_type = $result[$i]['race_type'] + 1;
						for($i = 1; $i < count($result); $i++) :
					?>
					<tr>
						<td>
							<?php echo $result[$i]['name']; ?>	

							<div>
								<a href="add.php?name=<?php echo $result[$i]['name']; ?>&race_type=<?php echo $race_type ?>&country=<?php echo $result[$i]['country'] ?>&city=<?php echo $result[$i]['city'] ?>&date=<?php echo $result[$i]['date'] ?>&url=<?php echo $result[$i]['url'] ?>&distance=<?php echo $result[$i]['distance'] ?>" class="btn btn-outline-secondary mt-2" 
								onclick="return confirm('Are you sure you want to schedule <?php echo $row['name']; ?>?');">SCHEDULE</a>
							</div>
						</td>
						<td>
							<?php 
								if ($race_type == 1) {
									echo "Road"; 
								} else if ($race_type == 2) {
									echo "Trail";
								} else if ($race_type == 3) {
									echo "Track";
								} else if ($race_type == 4) {
									echo "Cross Country";
								}		
							?>
						</td>
						<td>
							<?php echo $result[$i]['distance']; ?>	
						</td>
						<td>
							<?php echo $result[$i]['country']; ?>	
						</td>
						<td>
							<?php echo $result[$i]['city']; ?>
						</td>		
						<td>
							<?php echo $result[$i]['date']; ?>
						</td>	
						<td>
							<?php echo $result[$i]['url']; ?>
						</td>			
					</tr>
					
					<?php endfor; ?>			
				</tbody>
			</table>
		</div> <!-- .row -->

	</div> <!-- .container-fluid -->


</body>
</html>