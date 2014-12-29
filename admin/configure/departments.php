<?php
	$id = isset($_GET['id'])? $_GET['id'] : 0;
	$faculty = isset($_POST['faculty'])? mysqli_real_escape_string($db, trim($_POST['faculty'])) : '';
	$dept = '';
	$dur = 0;
if(isset($_POST['submit'])){
	$department = mysqli_real_escape_string($db, trim($_POST['department']));
	$duration = $_POST['duration'];
	if(strlen($faculty) > 0 && strlen($department) > 0){
		if(!$_POST['id']){
			if(!mysqli_query($db, "INSERT INTO departments(departmentName, faculty, duration) VALUES('{$department}', '{$faculty}', $duration)")){
				echo "<font color='#660000'>New department not added</font>";
			}
		}else{
			if(!mysqli_query($db, "UPDATE departments SET departmentName= '{$department}', faculty= '{$faculty}', duration= $duration WHERE departmentId = {$_POST['id']}")){
				echo "<font color='#660000'>Department not updated</font>";
			}
		}
	}else
		echo "<font color='#660000'>Some fields are empty</font>";
}
if(isset($_GET['act'])){
	if($_GET['act'] == 'edit'){
		$d = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM departments WHERE departmentId = {$_GET['id']}"));
		$faculty = $d['faculty'];
		$dept = $d['departmentName'];
		$dur = $d['duration'];
	}
	elseif($_GET['act'] == 'delete'){
		mysqli_query($db, "DELETE FROM departments WHERE departmentId = {$_GET['id']}");
	}
}
?>
<form method="post" action="<?php echo $root;?>admin/configure/?con=departments">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<table width="55%" align="center" border="1">
<tbody>
<tr><td>Faculty : </td><td>
<select name="faculty" style="width:95%">
	<option value="">--select a faculty--</option>
	<option value="Agriculture" <?php if($faculty == 'Agriculture') echo 'selected' ?>>Agriculture</option>
    <option value="Arts" <?php if($faculty == 'Arts') echo 'selected' ?>>Arts</option>
    <option value="Biological Sciences" <?php if($faculty == 'Biological Sciences') echo 'selected' ?>>Biological Sciences</option>
    <option value="Education" <?php if($faculty == 'Education') echo 'selected' ?>>Education</option>
    <option value="Engineering" <?php if($faculty == 'Engineering') echo 'selected' ?>>Engineering</option>
    <option value="Pharmaceutical Science" <?php if($faculty == 'Pharmaceutical Science') echo 'selected' ?>>Pharmaceutical Sciences</option>
    <option value="Physical Science" <?php if($faculty == 'Physical Science') echo 'selected' ?>>Physical Sciences</option>
    <option value="Social Sciences" <?php if($faculty == 'Social Sciences') echo 'selected' ?>>Social Sciences</option>
    <option value="Veterinary Medicine" <?php if($faculty == 'Veterinary Medicine') echo 'selected' ?>>Veterinary Medicine</option>
</select>
</td></tr>
<tr><td>Department : </td><td><input type="text" name="department" size="40" required value="<?php echo $dept ?>" style="width:95%" /></td></tr>
<tr><td>Duration : </td><td>
<select name="duration" style="width:95%">
	<option value="400" <?php if($dur == 400) echo 'selected' ?>>4 yrs</option>
    <option value="500" <?php if($dur == 500) echo 'selected' ?>>5 yrs</option>
</select>
</td></tr>
<tr><td colspan="2"><input type="submit" name="submit" style="width:100%; margin:auto" /></td></tr>
</tbody>
</table>
</form>
<br />
<table width="100%" border="0" cellspacing="0" bordercolor="#006600">
<thead contenteditable="false"><th>Faculty</th><th>Department</th><th>Duration</th><th width="70">Action</th></thead>
<tbody>
    <?php
	$row_color = array("'odd'", "'even'");
	$n = 0;
    $query = mysqli_query($db, "SELECT * FROM departments ORDER BY faculty, departmentName");
    while($data = mysqli_fetch_assoc($query)){
        echo "<tr class=".$row_color[$n % 2]."><td>{$data['faculty']}</td><td>{$data['departmentName']}</td><td>{$data['duration']}</td><td>";
		echo "<a href='{$root}admin/configure/?con=departments&act=edit&id={$data['departmentId']}'>Edit</a> &brvbar; ";
		echo "<a class='delete_link' href='{$root}admin/configure/?con=departments&act=delete&id={$data['departmentId']}'>Delete</a>";
		echo "</td></tr>";
		$n++;
    }
    ?>
</tbody>
</table>
<br><br>
