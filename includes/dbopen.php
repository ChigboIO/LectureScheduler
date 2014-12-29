<?php
include 'dbconfig.php';
$db = mysqli_connect($dbhost,$dbuser,$dbpassw,$dbname) or die('Error connecting to database');

function mysqli_result($query)
{
	global $db;
	$result_q = mysqli_query($db, $query);
	$result_a = mysqli_fetch_assoc($result_q);
	$result_v = $result_a['field'];
	return $result_v;
}

//set my time zone to UTC = GMT
date_default_timezone_set("UTC");
?>

