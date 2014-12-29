<?php require_once("../../includes/header.php"); 
if(!isset($_SESSION['admin_login']))
	header("Location: ../../");
?>

<div id="center">
    <h1>Time-Table Generation Page</h1>
    <div class="text">
    <form name="create" method="post" action="generate_script.php" id="create_form">
    <table width="50%" align="center" cellspacing="10">
    <tr><td colspan="2" bgcolor="#FF9900">
    NOTE: Scheduling another time table will clear the current time table in the system and create another
    time table of the specified semester.<br /></td></tr>
    <tr><td>Select Semester : 
    <select name="semester" class="fields">
    	<option value="1">First</option>
        <option value="2">Second</option>
    </select>
    </td><td>
    <input type="submit" name="submit" value="Schedule Time Table" class="fields" />
    </td></tr>
    </table>
    </form>
    <br><br><br>
    <center>
    <span id="waiting_span">
	<?php
	if(isset($_SESSION['generated'])){
	echo "{$_SESSION['generated']}";
	unset($_SESSION['generated']);
	}
	?>
    </span>
    </center>
    </div>
</div>

<div id="right">
<?php 
//include_once("../configure/side_link.php");
include_once("../../includes/side_links_div.php");
?>
</div>

<?php require_once("../../includes/footer.php"); ?>
