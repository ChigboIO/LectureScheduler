<?php
session_start();
require_once "../includes/dbopen.php";
require_once "../includes/root.php";

function authenticate() {
    header('WWW-Authenticate: Basic realm="Admin Authentication :::"');
    header('HTTP/1.0 401 Unauthorized');
    echo "<script> self.location= '../' </script>";
    exit;
} 

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] != 'ebere' || $_SERVER['PHP_AUTH_PW'] != 'ebere' ||
	isset($_GET['logout']))
	authenticate();
else 
{
	
	$_SESSION['admin_login'] = true;
	header("Location: generate/");
}
?>

