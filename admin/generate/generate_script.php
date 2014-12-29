<?php
session_start();
require_once("../../includes/dbopen.php");

$trials = 0;
do{
	$dead_lock = false;
	$trials++;
	
	mysqli_query($db, "TRUNCATE TABLE monday");
	mysqli_query($db, "TRUNCATE TABLE tuesday");
	mysqli_query($db, "TRUNCATE TABLE wednessday");
	mysqli_query($db, "TRUNCATE TABLE thursday");
	mysqli_query($db, "TRUNCATE TABLE friday");
	
	$mon_value = ""; $teu_value = ""; $wed_value = ""; $thu_value = ""; $fri_value = "";
	$dept_query = mysqli_query($db, "SELECT * FROM departments");
	while($data = mysqli_fetch_array($dept_query)){
		for($i = 100; $i <= $data['duration']; $i += 100){
			$mon_value .= " ('{$data['departmentName']}', {$i}), ";
			$teu_value .= " ('{$data['departmentName']}', {$i}), ";
			$wed_value .= " ('{$data['departmentName']}', {$i}), ";
			$thu_value .= " ('{$data['departmentName']}', {$i}), ";
			$fri_value .= " ('{$data['departmentName']}', {$i}), ";
		}
		
	}
	$mon_value = substr_replace($mon_value, "", -2);
	$teu_value = substr_replace($teu_value, "", -2);
	$wed_value = substr_replace($wed_value, "", -2);
	$thu_value = substr_replace($thu_value, "", -2);
	$fri_value = substr_replace($fri_value, "", -2);
	
	//echo("INSERT INTO monday(department, level) VALUES{$mon_value}");
	mysqli_query($db, "INSERT INTO monday(department, level) VALUES{$mon_value}");
	mysqli_query($db, "INSERT INTO tuesday(department, level) VALUES{$teu_value}");
	mysqli_query($db, "INSERT INTO wednessday(department, level) VALUES{$wed_value}");
	mysqli_query($db, "INSERT INTO thursday(department, level) VALUES{$thu_value}");
	mysqli_query($db, "INSERT INTO friday(department, level) VALUES{$fri_value}");
	
	$days = array("monday", "tuesday", "wednessday", "thursday", "friday");
	$times = array("T_08_09", "T_09_10", "T_10_11", "T_11_12", "T_12_01", "T_01_02", "T_02_03", "T_03_04");
	$one_hours = array();
	
	$semester = $_POST['semester'];
	$courses_query = mysqli_query($db, "SELECT * FROM courses WHERE semester = $semester ORDER BY priority DESC, RAND()");
	///////////////
	$j = 0;
	while($course = mysqli_fetch_assoc($courses_query)){
		//echo "subject ". $j++ ."<br>";
		$unit = $course['unitLoad'];
		if($unit == 1){
			$one_hours[] = $course['courseCode'];
			continue;
		}else if($unit > 2)
			$one_hours[] = $course['courseCode'];
		
		$lecturer = $course['lecturerId'];
		
		$d = rand(0, 4); $t = (rand(0, 3) * 2) - 2;
		$turn_count = 0;
		do{
			$allfree = true;
			$turn_count++;
			$t += 2;
			if($t > 7){
				$t = 0;
				$d++; 
			}
			if($d > 4)
				$d = 0;
			$day = $days[$d]; //$day = $days[rand(0, 4)];
			$x = $t; //$x = rand(0, 3) * 2;
			$time = $times[$x];
			$time2 = $times[$x + 1];
			
			$classes_query = mysqli_query($db, "SELECT * FROM classcourses WHERE courseCode = '{$course['courseCode']}'");
			while($class = mysqli_fetch_assoc($classes_query)){
				if(mysqli_result("SELECT $time AS field FROM $day WHERE department = '{$class['department']}' AND level = {$class['level']}") != "free" ||
				 mysqli_result("SELECT $time2 AS field FROM $day WHERE department = '{$class['department']}' AND level = {$class['level']}") != "free"){
					$allfree = false;
					break;
				 }
			}
			if($allfree){
				$q = mysqli_query($db, "SELECT courseCode FROM courses WHERE lecturerId = $lecturer");
				while($c = mysqli_fetch_assoc($q)){
					if(mysqli_num_rows(mysqli_query($db, "SELECT * FROM $day WHERE $time = '{$c['courseCode']}'")) > 0 ||
					mysqli_num_rows(mysqli_query($db, "SELECT * FROM $day WHERE $time2 = '{$c['courseCode']}'")) > 0){
						$allfree = false;
						break;
					}
				}
			}
			if($turn_count > 20){
				$dead_lock = true;
				break;
				//echo "deadlocked 1";
				//exit;
			}
		}while(!$allfree);
		
		if($dead_lock)
			break;
		
		$classes_query = mysqli_query($db, "SELECT * FROM classcourses WHERE courseCode = '{$course['courseCode']}'");
		while($class = mysqli_fetch_assoc($classes_query)){
			mysqli_query($db, "UPDATE $day SET $time = '{$course['courseCode']}', $time2 = '{$course['courseCode']}' WHERE department = 
			'{$class['department']}' AND level = {$class['level']}");
		}
		
	}
	
	//then fix the one hour lectures
	for($i = 0; $i < count($one_hours); $i++){
		$course = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM courses WHERE courseCode = '{$one_hours[$i]}'"));
		$lecturer = $course['lecturerId'];
		
		$turn_count = 0;
		$d = rand(0, 4); $t = rand(-1, 7);
		do{
			$allfree = true;
			$turn_count++;
			$t++;
			if($t > 7){
				$t = 0;
				$d++; 
			}
			if($d > 4)
				$d = 0;
			$day = $days[$d]; //$day = $days[rand(0, 4)];
			$x = $t; //$x = rand(0, 7);
			$time = $times[$x];
			
			$classes_query = mysqli_query($db, "SELECT * FROM classcourses WHERE courseCode = '{$course['courseCode']}'");
			while($class = mysqli_fetch_assoc($classes_query)){
				if(mysqli_result("SELECT $time AS field FROM $day WHERE department = '{$class['department']}' AND level = {$class['level']}") != "free"){
					$allfree = false;
					break;
				 }
			}
			if($allfree){
				$q = mysqli_query($db, "SELECT courseCode FROM courses WHERE lecturerId = $lecturer");
				while($c = mysqli_fetch_assoc($q)){
					if(mysqli_num_rows(mysqli_query($db, "SELECT * FROM $day WHERE $time = '{$c['courseCode']}'")) > 0){
						$allfree = false;
						break;
					}
				}
			}
			if($allfree){
				if(mysqli_num_rows(mysqli_query($db, "SELECT * FROM $day WHERE T_08_09 = '{$course['courseCode']}' || 
				T_09_10 = '{$course['courseCode']}' || T_10_11 = '{$course['courseCode']}' || 
				T_11_12 = '{$course['courseCode']}' || T_12_01 = '{$course['courseCode']}' || 
				T_01_02 = '{$course['courseCode']}' || T_02_03 = '{$course['courseCode']}' || 
				T_03_04 = '{$course['courseCode']}'")) > 0){;
					$allfree = false;
				}
			}
			if($turn_count > 40){
				//echo "deadlocked";
				//exit;
				$dead_lock = true;
				break;
			}
		}while(!$allfree);
		
		if($dead_lock)
			break;
		
		$classes_query = mysqli_query($db, "SELECT * FROM classcourses WHERE courseCode = '{$course['courseCode']}'");
		while($class = mysqli_fetch_assoc($classes_query)){
			mysqli_query($db, "UPDATE $day SET $time = '{$course['courseCode']}' WHERE department = '{$class['department']}' AND level = {$class['level']}");
		}
	}
	

}while($dead_lock && $trials < 10);
if($dead_lock)
	echo "<font color='#660000'>Unsuccessful! Some courses could not be scheduled even after ten trials.</font>";
else
	echo "<font color='#669900'>Congratulations... Time-Table created.</font>";
//echo "success";
//header("Location: index.php");
?>