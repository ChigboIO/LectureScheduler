<?php
include_once("dbopen.php");
$department = $_POST['dept'];

$query = mysqli_query($db, "SELECT * FROM lecturers WHERE department = '{$department}' ORDER BY lecturerName");
while($data = mysqli_fetch_assoc($query)){
	echo "<option value='{$data['lecturerId']}'>{$data['lecturerName']} ({$data['department']})</option>";
}
?>