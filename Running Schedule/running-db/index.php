<?php
	session_start();
	
	if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
		header('Location: ../login/login.php');
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
		#map {
			height: 100%;
			flex: 1 1 auto;
			background-color: #CCC;
		}

		body { background-color: #f7f9f9; }

		.text { color: black; }

		.top-buffer { margin-top:23px; }

	</style>
</head>
<body>
	<?php include 'nav.php'; ?>

	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4 text text-sm-center">BBB's Running Schedule</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<a href="schedule.php" class="btn btn-danger btn-lg btn-block mt-4 mt-md-2" role="button" aria-describedby="info">
					See Schedule
				</a>
				<p id="info" class="text">
					Click here to see the races you have scheduled!
				</p>
			</div>

			<div class="col-md-6">
				<a href="search_form.php" class="btn btn-danger btn-lg btn-block mt-4 mt-md-2" role="button" aria-describedby="info">
					Advanced Search
				</a>
				<p id="info" class="text">
					Returns a list running races based on a set of search criterias.
				</p>
			</div>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container-fluid">
		<img src="https://cbsnewyork.files.wordpress.com/2015/11/gettyimages-495245112_master-e1477336781538.jpg" class="img-fluid" alt="Index Picture">
	</div>

	<div class="container-fluid">
		<div class="row top-buffer" id="location">
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container-fluid">
		<div class="row top-buffer" id="nearbyRaces">
		</div> <!-- .row -->
	</div> <!-- .container -->

	<script>
	    function initMap()	{
			var nearbyRaces = document.getElementById("nearbyRaces");

			while (nearbyRaces.firstChild) {
				nearbyRaces.removeChild(nearbyRaces.firstChild);
			}

	    	var url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=";
			var latitude;
		    var longitude;	

	    	if(navigator.geolocation) {	    	
	    		navigator.geolocation.getCurrentPosition(function(position) {
		    		var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		    		
		    		latitude = position.coords.latitude;
		    		longitude = position.coords.longitude;
		    		url = url + latitude + "," + longitude + "&sensor=true";

		    		ajax(url, function(results) {
		    			var resultIWant = results.results[0].address_components[3].long_name;

		    			var location = document.getElementById("location");

		    			var whereIAm = document.createElement('div');
						whereIAm.className = "col-md-12 text-danger";

						var text1 = document.createElement('h3');
						text1.className = "text-center";	
						text1.innerHTML = "You are at " + resultIWant + "!";

						var text2 = document.createElement('h3');
						text2.className = "text-center";	
						text2.innerHTML = "Nearby races are shown as follows."

						whereIAm.appendChild(text1);
						whereIAm.appendChild(text2);
						location.appendChild(whereIAm);

		    			ajax('strava.php', function(results){
		    				if(results.length == 0) {
		    					var nearbyRaces = document.getElementById("nearbyRaces");
		    					var tempDiv = document.createElement('div');
		    					var text = document.createElement('h3');
								text.className = "text-center";	
								text.innerHTML = "No running races near you."
								tempDiv.appendChild(text);
								nearbyRaces.appendChild(tempDiv);
		    				}

		    				else {
								for (var i = 0; i < results.length; i++) {
									if(results[i].city == resultIWant) {
										var nearbyRaces = document.getElementById("nearbyRaces");

										var raceContainer = document.createElement('div');
										raceContainer.className = "col-md-3 rounded text-white bg-dark";

										var raceName = results[i].name;
										var raceType = results[i].running_race_type;
										var city = results[i].city;
										var state = results[i].state; 
										var country = results[i].country;
										var distance = results[i].distance;
										var url = results[i].url; 
										var startDate = results[i].start_date_local;

										var dl = document.createElement('dl');

										var dt_raceName = document.createElement('dt');
										dt_raceName.innerHTML = "Name";
										var dd_raceName = document.createElement('dd');
										dd_raceName.innerHTML = raceName;

										var dt_raceType = document.createElement('dt');
										dt_raceType.innerHTML = "Type";
										var dd_raceType = document.createElement('dd');
										dd_raceType.innerHTML = raceTypeName(raceType);

										var dt_raceAddress = document.createElement('dt');
										dt_raceAddress.innerHTML = "Address";
										var dd_raceAddress = document.createElement('dd');
										if (state != null) {
											dd_raceAddress.innerHTML = city + ", " + state + ", " + country;
										} else {
											dd_raceAddress.innerHTML = city + ", " + country;
										}
						
										var dt_raceDistance = document.createElement('dt');
										dt_raceDistance.innerHTML = "Distance";
										var dd_raceDistance = document.createElement('dd');
										dd_raceDistance.innerHTML = distance + " meters";

										var dt_raceDate = document.createElement('dt');
										dt_raceDate.innerHTML = "Date";
										var dd_raceDate = document.createElement('dd');
										dd_raceDate.innerHTML = startDate;

										var dt_raceURL = document.createElement('dt');
										dt_raceURL.innerHTML = "URL";
										var dd_raceURL = document.createElement('dd');
										dd_raceURL.innerHTML = url;

										dl.appendChild(dt_raceName);
										dl.appendChild(dd_raceName);

										dl.appendChild(dt_raceType);
										dl.appendChild(dd_raceType);

										dl.appendChild(dt_raceAddress);
										dl.appendChild(dd_raceAddress);

										dl.appendChild(dt_raceDistance);
										dl.appendChild(dd_raceDistance);

										dl.appendChild(dt_raceDate);
										dl.appendChild(dd_raceDate);

										dl.appendChild(dt_raceURL);
										dl.appendChild(dd_raceURL);

										raceContainer.appendChild(dl);

										var left = document.createElement('div');
										left.className = "col-md-1";

										nearbyRaces.appendChild(left);
										nearbyRaces.appendChild(raceContainer);
									}
								}
							}
						});
		    		});
	    		});
	    	} else {
	    		console.log("error with geolocation");
	    	}
	    }

	    function raceTypeName(raceTypeNumber) {
	    	if(raceTypeNumber == 0) {
	    		return "Road";
	    	} else if (raceTypeNumber == 1) {
	    		return "Trail";
	    	} else if (raceTypeNumber == 2) {
	    		return "Track";
	    	} else if (raceTypeNumber == 3) {
	    		return "Cross Country";
	    	}
	    }

	    function ajax(url, callback) {
			var xhr = new XMLHttpRequest();

			xhr.open('GET', url, true ); 
			xhr.onreadystatechange = function(){
				if(xhr.readyState == XMLHttpRequest.DONE){
					if(xhr.status == 200){
						callback(JSON.parse(xhr.responseText));
					}
					else{
						alert('AJAX error.');
						console.log(xhr.status);
					}
				}
			}

			xhr.send(); 
		};
	</script> 

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ-4QhNBU_itIHZ7-Ts6lKrNssy4NgLno&callback=initMap">	
	</script>
</body>
</html>