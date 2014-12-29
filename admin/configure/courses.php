<?php
	$id = isset($_GET['id'])? $_GET['id'] : 0;
	$department = isset($_POST['submit'])? mysqli_real_escape_string($db, trim($_POST['department'])) : '';
	$sem = 0;
	$co = '';
	$ti = '';
	$un = '';
	$lect = '';
if(isset($_POST['submit'])){
	$semester = mysqli_real_escape_string($db, trim($_POST['semester']));
	$code = mysqli_real_escape_string($db, trim($_POST['code']));
	$title = mysqli_real_escape_string($db, trim($_POST['title']));
	$unit = mysqli_real_escape_string($db, trim($_POST['unit']));
	$lecturer = mysqli_real_escape_string($db, trim($_POST['lecturer']));
	
	if(strlen($semester) > 0 && strlen($code) > 0 && strlen($title) > 0 && strlen($unit)  > 0 && strlen($lecturer) > 0){
		if(!$_POST['id']){
			if(!mysqli_query($db, "INSERT INTO courses(semester, courseCode, courseTitle, unitLoad, baseDepartment, lecturerId, priority)
			VALUES({$semester}, '{$code}', '{$title}', {$unit}, '{$department}', {$lecturer}, 0)")){
				echo "<font color='#660000'>New department not added</font>";
			}
		}else{
			if(!mysqli_query($db, "UPDATE courses SET semester= {$semester}, courseCode= '{$code}', courseTitle= '{$title}', unitLoad= {$unit}, baseDepartment= '{$department}', lecturerId= {$lecturer} WHERE courseId = {$_POST['id']}")){
				echo "<font color='#660000'>Course not updated</font>";
			}
		}
	}else
		echo "<font color='#660000'>Some field are empty</font>";
}
if(isset($_GET['act'])){
	if($_GET['act'] == 'edit'){
		$d = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM courses WHERE courseId = {$_GET['id']}"));
		$department = $d['baseDepartment'];
		$sem = $d['semester'];
		$co = $d['courseCode'];
		$ti = $d['courseTitle'];
		$un = $d['unitLoad'];
		$lect = $d['lecturerId'];
	}
	elseif($_GET['act'] == 'delete'){
		mysqli_query($db, "DELETE FROM courses WHERE courseId = {$_GET['id']}");
	}
}
?>

<table width="100%" border="0" cellspacing="0" bordercolor="#006600">
<thead contenteditable="false"><th>Semester</th><th>Course Code</th><th>Course Title</th><th>Unit Load</th><th>Base Department</th>
<th>Lecturer</th><th width="20">No. of Classes</th><th width="70">Action</th></thead>
<tbody>
    <?php
	$row_color = array("'odd'", "'even'");
	$n = 0;
    $query = mysqli_query($db, "SELECT * FROM courses ORDER BY courseCode, semester");
    while($data = mysqli_fetch_assoc($query)){
		$lecturer_name = mysqli_result("SELECT lecturerName AS field FROM lecturers WHERE lecturerId = {$data['lecturerId']}");
        echo "<tr class=".$row_color[$n % 2]."><td>{$data['semester']}</td><td>{$data['courseCode']}</td><td>{$data['courseTitle']}</td><td>{$data['unitLoad']}</td>
		<td>{$data['baseDepartment']}</td><td>{$lecturer_name}</td><td>{$data['priority']}</td><td>";
		echo "<a href='{$root}admin/configure/?con=courses&act=edit&id={$data['courseId']}'>Edit</a> &brvbar; ";
		echo "<a class='delete_link' href='{$root}admin/configure/?con=courses&act=delete&id={$data['courseId']}'>Delete</a>";
		echo "</td></tr>";
		$n++;
    }
    ?>
</tbody>
</table>
<br><br>
<form method="post" action="<?php echo $root;?>admin/configure/?con=courses">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<table width="55%" align="center" border="1">
<tbody>
<tr><td>Semester :</td><td>
<select name="semester" style="width:95%">
	<option value="">--select semester--</option>
	<option value="1" <?php if($sem == 1) echo 'selected' ?>>First</option>
    <option value="2" <?php if($sem == 2) echo 'selected' ?>>Second</option>
</select>
</td></tr>
<tr><td>Course Code :</td><td><input type="text" name="code" maxlength="6" required value="<?php echo $co ?>" style="width:95%" /></td></tr>
<tr><td>Course Title :</td><td><input type="text" name="title" maxlength="120" required value="<?php echo $ti ?>" style="width:95%" /></td></tr>
<tr><td>Unit Load : </td><td><input type="text" name="unit" maxlength="2" required value="<?php echo $un ?>" style="width:95%" /></td></tr>
<tr><td>Base Department : </td><td>
<select name="department" class="department_select" style="width:95%" loc="../../includes/load_lecturers.php">
	<option value="">--select a department--</option>
	<?php
    $query = mysqli_query($db, "SELECT * FROM departments ORDER BY departmentName");
    while($data = mysqli_fetch_assoc($query)){
        echo "<option value='{$data['departmentName']}'"; 
			if($department == $data['departmentName']) 
				echo 'selected';
			echo ">{$data['departmentName']}</option>";
    }
    ?>
	
</select>
</td></tr>
<tr><td>Lecturer : </td><td>
<select name="lecturer" class="lecturer_select" style="width:95%">
	<option value="">--select a lecturer--</option>
	<?php
    $query = mysqli_query($db, "SELECT * FROM lecturers WHERE department = '{$department}' ORDER BY lecturerName");
    while($data = mysqli_fetch_assoc($query)){
        echo "<option value='{$data['lecturerId']}'"; 
			if($lect == $data['lecturerId']) 
				echo 'selected';
			echo ">{$data['lecturerName']}</option>";
    }
    ?>
	
</select>
</td></tr>
<tr><td colspan="2"><input type="submit" name="submit" style="width:100%; margin:auto" /></td></tr>
</tbody>
</table>
</form>