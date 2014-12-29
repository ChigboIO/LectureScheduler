<?php require_once("../includes/header.php"); 
$lecturerId = isset($_GET['lecturerId']) ? $_GET['lecturerId'] : 0;
$department = isset($_GET['department']) ? $_GET['department'] : '';

$lecturerId = $lecturerId ? mysqli_result("SELECT lecturerId AS field FROM lecturers WHERE lecturerId = $lecturerId AND department = '$department'") : 0;
$lecturerId = ($lecturerId) ? $lecturerId : 0;
$lecturerName =  mysqli_result("SELECT lecturerName AS field FROM lecturers WHERE lecturerId = $lecturerId");

$day_of_week = intval(date("N"));
echo "<script> var day_of_week = $day_of_week </script>";

$courses = array();
$q = mysqli_query($db, "SELECT courseCode FROM courses WHERE lecturerId = {$lecturerId}");
while($c = mysqli_fetch_assoc($q)){
	$courses[] = $c['courseCode'];
}
function checkCourse($day, $time){
	global $courses, $db;
	for($i = 0; $i < count($courses); $i++){
		if(mysqli_num_rows(mysqli_query($db, "SELECT $time FROM $day WHERE $time = '{$courses[$i]}'")))
			return "<b>".$courses[$i]."</b>";
	}
	return "<font color='#009933'><i>free</i></font>";
}

function table($day){
	global $db;
	
	echo "<table width='300px' align='center' border='0' cellspacing='0'>";
	echo "<thead><th width='50%'>Time</th><th>Course</th></thead>";
	echo "<tbody>";
	
	$query = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM $day"));
	echo "<tr class='odd'><td>08:00 - 09:00</td><td>".checkCourse($day, 'T_08_09')."</td></tr>";
	echo "<tr class='even'><td>09:00 - 10:00</td><td>".checkCourse($day, 'T_09_10')."</td></tr>";
	echo "<tr class='odd'><td>10:00 - 11:00</td><td>".checkCourse($day, 'T_10_11')."</td></tr>";
	echo "<tr class='even'><td>11:00 - 12:00</td><td>".checkCourse($day, 'T_11_12')."</td></tr>";
	echo "<tr class='odd'><td>12:00 - 01:00</td><td>".checkCourse($day, 'T_12_01')."</td></tr>";
	echo "<tr class='even'><td>01:00 - 02:00</td><td>".checkCourse($day, 'T_01_02')."</td></tr>";
	echo "<tr class='odd'><td>02:00 - 03:00</td><td>".checkCourse($day, 'T_02_03')."</td></tr>";
	echo "<tr class='even'><td>03:00 - 04:00</td><td>".checkCourse($day, 'T_03_04')."</td></tr>";
	
	echo "</tbody>";
	echo "</table>";
}
?>

<div id="center">
    <h1>Lecturer's Time Table Filter</h1>
    <div class="text">
    
    <fieldset>
    <legend><?php echo $lecturerName ?></legend>
    <div id="tabs">
      <ul>
        <li><a href="#TabContent1">Weekly View</a></li>
        <li><a href="#TabContent2">Daily View</a></li>
      </ul>
      <div class="TabbedPanelsContent" id="TabContent1">
     
    <table width="100%" align="center" border="0" cellspacing="0">
    <thead>
    <th>Days</th><th>08:00<br />09:00</th><th>09:00<br />10:00</th><th>10:00<br />11:00</th><th>11:00<br />12:00</th>
    <th>12:00<br />01:00</th><th>01:00<br />02:00</th><th>02:00<br />03:00</th><th>03:00<br />04:00</th>
    </thead>
    <tbody>
	<?php
	$days = array("monday", "tuesday", "wednessday", "thursday", "friday");
	$times = array("T_08_09", "T_09_10", "T_10_11", "T_11_12", "T_12_01", "T_01_02", "T_02_03", "T_03_04");
	$row_color = array("'odd'", "'even'");
	for($i = 0; $i < count($days); $i++){
		echo "<tr class=".$row_color[$i % 2]; if($day_of_week == $i+1) echo ' id="current_day"'; echo "><th>{$days[$i]}</th>";
		for($j = 0; $j < count($times); $j++){
			echo "<td>".checkCourse($days[$i], $times[$j])."</td>";
		}
		echo "</tr>";
	}
	
	?>
    </tbody>
    </table>
    </div>
    <div id="TabContent2">
        <div id="dailyTab" class="tabs-bottom">
        	<ul>
            	<li><a href="#monday">Monday</a></li>
                <li><a href="#tuesday">Tuesday</a></li>
                <li><a href="#wednessday">Wednessday</a></li>
                <li><a href="#thursday">Thursday</a></li>
                <li><a href="#friday">Friday</a></li>
            </ul>
            <div class="tabs-spacer"></div>
            <div id="monday">
            <span class="day_head">Monday</span>
            	<?php table('monday'); ?>
            </div>
            <div id="tuesday">
            <span class="day_head">Tuesday</span>
            	<?php table('tuesday'); ?>
            </div>
            <div id="wednessday">
            <span class="day_head">Wednessday</span>
            	<?php table('wednessday'); ?>
            </div>
            <div id="thursday">
            <span class="day_head">Thursday</span>
            	<?php table('thursday'); ?>
            </div>
            <div id="friday">
            <span class="day_head">Friday</span>
            	<?php table('friday'); ?>
            </div>
        </div>
    </div>
    </div>
    </fieldset>
    
    </div>
</div>

<div id="right">
<?php 
include_once("lecturer_login_div.php");
include_once("../includes/side_links_div.php"); ?>
</div>

<?php require_once("../includes/footer.php"); ?>
