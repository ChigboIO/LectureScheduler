<?php require_once("../../includes/header.php"); 
if(!isset($_SESSION['admin_login']))
	header("Location: ../../");
?>

<div id="center">
    <h1>Configuration Page</h1>
    <div class="text">
    <?php
	$config = isset($_GET['con'])? $_GET['con'] : 'departments';
	include_once($config.".php");
	?>
    </div>
</div>

<div id="right">
<?php 
include_once("side_link.php");

?>
</div>

<?php require_once("../../includes/footer.php"); ?>
