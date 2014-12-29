<?php
	$department = isset($_POST['department'])? mysqli_real_escape_string($db, trim($_POST['department'])) : '';
	$l = isset($_POST['level'])? mysqli_real_escape_string($db, trim($_POST['level'])) : '0';
	$code = isset($_POST['code'])? mysqli_real_escape_string($db, trim($_POST['code'])) : '';
if(isset($_POST['submit'])){
	$level = intval($l);
	if(strlen($department) > 0 && $level > 0 && strlen($code) > 0){
		if(mysqli_query($db, "INSERT INTO classcourses(department, level, courseCode) VALUES('{$department}', {$level}, '{$code}')")){
			mysqli_query($db, "UPDATE courses SET priority = priority+1 WHERE courseCode = '{$code}'");
		}else
			echo "<font color='#660000'>New course not added</font>";
	}else
		echo "<font color='#660000'>Some or all fields are empty</font>";
}
if(isset($_GET['act']) && $_GET['act'] == 'delete'){
	$c = mysqli_result("SELECT courseCode AS field FROM classcourses WHERE id = {$_GET['id']}");
	mysqli_query($db, "DELETE FROM classcourses WHERE id = {$_GET['id']}");
	mysqli_query($db, "UPDATE courses SET priority = priority-1 WHERE courseCode = '{$c}'");
}
?>

<table width="100%" border="0" cellspacing="0" bordercolor="#006600" class="class_courses_table">
<thead contenteditable="false"><th>Department</th><th>Level</th><th>Courses</th><th>Action</th></thead>
<tbody>
    <?php
    $query = mysqli_query($db, "SELECT DISTINCT department FROM classcourses ORDER BY department");
	while($depts = mysqli_fetch_assoc($query)){
		$num = mysqli_num_rows(mysqli_query($db, "SELECT * FROM classcourses WHERE department = '{$depts['department']}'"));
		echo "<tr>";
		echo "<td rowspan='{$num}' valign='middle'>{$depts['department']} </td>";
		
		$query2 = mysqli_query($db, "SELECT DISTINCT level FROM classcourses WHERE department = '{$depts['department']}' ORDER BY level");
		while($level = mysqli_fetch_assoc($query2)){
			$num = mysqli_num_rows(mysqli_query($db, "SELECT * FROM classcourses WHERE department = '{$depts['department']}' AND 
			level = '{$level['level']}'"));
			echo "<td rowspan='{$num}' valign='middle'>{$level['level']} </td>";
			
			$query3 = mysqli_query($db, "SELECT id, courseCode FROM classcourses WHERE department = '{$depts['department']}'
			AND level = '{$level['level']}' ORDER BY courseCode");
			while($data = mysqli_fetch_assoc($query3)){
				echo "<td>{$data['courseCode']}</td><td>";
				echo "<a class='delete_link' href='{$root}admin/configure/?con=class_courses&act=delete&id={$data['id']}'>Delete</a>";
				echo "</td></tr><tr>";
			}
			
		}
		echo "</tr>";
	}
    ?>
</tbody>
</table>
<br><br>
<form method="post" action="<?php echo $root;?>admin/configure/?con=class_courses">
<table width="55%" align="center" border="1">
<tbody>
<tr><td>Department : </td><td>
<select name="department" style="width:95%">
	<option value="">--select a department--</option>
	<?php
    $query = mysqli_query($db, "SELECT * FROM departments ORDER BY departmentName");
    while($data = mysqli_fetch_assoc($query)){
        echo "<option value='{$data['departmentName']}'"; 
			if($department == $data['departmentName']) 
				echo ' selected';
			echo ">{$data['departmentName']}</option>";
    }
    ?>
	
</select>
</td></tr>
<tr><td>Level : </td><td>
<select name="level" style="width:95%">
	<option value="">--select a level-- </option>
	<option value="100" <?php if($l == '100') echo ' selected' ?>>100</option>
    <option value="200" <?php if($l == '200') echo ' selected' ?>>200</option>
    <option value="300" <?php if($l == '300') echo ' selected' ?>>300</option>
    <option value="400" <?php if($l == '400') echo ' selected' ?>>400</option>
    <option value="500" <?php if($l == '500') echo ' selected' ?>>500</option>
</select>
</td></tr>
<tr><td>Course Code</td><td>
<select name="code" style="width:95%">
	<option value="">--select course--</option>
	<?php
    $query = mysqli_query($db, "SELECT courseCode, courseTitle FROM courses ORDER BY courseCode");
    while($data = mysqli_fetch_assoc($query)){
        echo "<option value='{$data['courseCode']}'"; 
			if($code == $data['courseCode']) 
				echo 'selected';
			echo ">{$data['courseCode']} ({$data['courseTitle']})</option>";
    }
    ?>
	
</select>
</td></tr>
<tr><td colspan="2"><input type="submit" name="submit" style="width:100%; margin:auto" /></td></tr>
</tbody>
</table>
</form>