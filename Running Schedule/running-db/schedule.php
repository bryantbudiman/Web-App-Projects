<?php
	session_start();

	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
		header('Location: ../login/login.php');
	}

	require '../config/config.php';

	$page_url = $_SERVER['REQUEST_URI'];

	$page_url = preg_replace('/&page=\d+/', '', $page_url);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BBB's Running Schedule</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<style>
		.text {
			color: black;
		}

		#header {
			background-image: url('https://adventure-marathon.com/sites/default/files/styles/header_image/public/images/large.jpg?itok=6TqjeEO9');
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
	
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">BBB's Running Schedule</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->

	<div class="container-fluid">

		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="index.php" role="button" class="btn btn-danger">Back to Main Menu</a>
			</div> <!-- .col -->
		</div> <!-- .row -->

		<div id="header">
			Your Scheduled Races
		</div> <!-- #header -->

		<div class="row">
			<div class="col-12">
				<?php
					$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

					if ($mysqli->connect_errno) :
						// Connection Error.
						echo $mysqli->connect_error;
					else: 
						$mysqli->set_charset('utf8');

						$sql_num_rows = "SELECT COUNT(*) AS count
							FROM schedule
								LEFT JOIN race_type 
									ON schedule.race_type_id = race_type.race_type_id
								LEFT JOIN country
									ON schedule.country_id = country.country_id
								WHERE 1=1";

						$results_num_rows = $mysqli->query($sql_num_rows);

						/* Check for results error here. */

						$row_num_rows = $results_num_rows->fetch_assoc();

						$num_results = $row_num_rows['count'];

						$results_per_page = 10;

						if($num_results == 0) {
							$last_page = 1;
						} else {
							$last_page = ceil($num_results / $results_per_page);
						}

						if ( isset($_GET['page']) && !empty($_GET['page']) ) {
							$current_page = $_GET['page'];
						} else {
							$current_page = 1;
						}

						if ($current_page < 1) {
							$current_page = 1;
						} elseif (($current_page > $last_page) && ($last_page != 1)) {
							$current_page = $last_page;
						}

						$start_index = ($current_page - 1) * $results_per_page;

						$sql = "SELECT schedule.id, schedule.name, race_type.race_type, schedule.distance, schedule.start_date, schedule.city, country.nicename AS country , schedule.url
								FROM schedule
								LEFT JOIN race_type 
									ON schedule.race_type_id = race_type.race_type_id
								LEFT JOIN country
									ON schedule.country_id = country.country_id
								WHERE 1=1";

						$results = $mysqli->query($sql);

						if (!$results) :
							// SQL Error.
							echo $mysqli->error;
						else :
							// Results Received.
				?>

				<div>
					You have <?php echo $results->num_rows; ?> scheduled race(s).
				</div>
				
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>Name</th>
							<th>Race Type</th>
							<th>Distance</th>
							<th>Start Date</th>
							<th>City</th>
							<th>Country</th>
							<th>URL</th>
						</tr>
					</thead>
					<tbody>
						<?php
							while ( $row = $results->fetch_assoc() ) :
						?>
						<tr>
							<td>
								<?php echo $row['name']; ?>		

								<div>
									<a href="delete.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['name'] ?>" class="btn btn-dark mt-2" onclick="return confirm('Are you sure you want to delete <?php echo $row['name']; ?>?');">DELETE</a>
								</div>
							</td>
							<td><?php echo $row['race_type']; ?></td>
							<td><?php echo $row['distance']; ?></td>
							<td><?php echo $row['start_date']; ?></td>
							<td><?php echo $row['city']; ?></td>
							<td><?php echo $row['country']; ?></td>
							<td><?php echo $row['url']; ?></td>
						</tr>
						<?php
							endwhile;
						?>				
					</tbody>
				</table>

				<!-- Pagination feature -->
				<div class="col-12">
					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							<li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
								<a class="page-link" href="?<?php echo $page_url . '&page=1'; ?>">First</a>
							</li>
							<li class="page-item <?php echo ($current_page==1) ? 'disabled' : ''; ?>">
								<a class="page-link" href="?<?php echo $page_url . '&page=' . ($current_page-1); ?>">Previous</a>
							</li>
							<li class="page-item active">
								<a class="page-link" href=""><?php echo $current_page;?></a>
							</li>
							<li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
								<a class="page-link" href="?<?php echo $page_url . '&page=' . ($current_page+1); ?>">Next</a>
							</li>
							<li class="page-item <?php echo ($current_page==$last_page) ? 'disabled' : ''; ?>">
								<a class="page-link" href="?<?php echo $page_url . '&page=' . $last_page; ?>">Last</a>
							</li>
						</ul>
					</nav>
				</div> <!-- Pagination feature -->

				<?php
					$mysqli->close();
					endif; /* ELSE Results Received */
					endif; /* ELSE Connection Success */
				?>		
			</div> <!-- .col -->
		</div> <!-- .row -->

	</div> <!-- .container-fluid -->

</body>
</html>