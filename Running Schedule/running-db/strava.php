<?php
	define('STRAVA_API_ENDPOINT', 'https://www.strava.com/api/v3/running_races/?year=2017');
	define('AUTH_TOKEN', 'a2b481cf6df03dd772986d913916431d412686b7');
	$header = ['Authorization: Bearer ' . AUTH_TOKEN];

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, STRAVA_API_ENDPOINT);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	$response = curl_exec($ch);
?>	