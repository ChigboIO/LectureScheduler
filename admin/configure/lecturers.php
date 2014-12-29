<?php
	$id = isset($_GET['id'])? $_GET['id'] : 0;
	$department = isset($_POST['department'])? mysqli_real_escape_string($db, trim($_POST['department'])): '';
	$lect = '';
if(isset($_POST['submit'])){
	$lecturer = mysqli_real_escape_string($db, trim($_POST['lecturer']));
	if(strlen($department) > 0 && strlen($lecturer) > 0){
		if(!$_POST['id']){
			if(!mysqli_query($db, "INSERT INTO lecturers(lecturerName, department) VALUES('{$lecturer}', '{$department}')")){
				echo "<font color='#660000'>New department not added</font>";
			}
		}else{
			if(!mysqli_query($db, "UPDATE lecturers SET department= '{$department}', lecturerName= '{$lecturer}' WHERE lecturerId = {$_POST['id']}")){
				echo "<font color='#660000'>Lecturer not updated</font>";
			}
		}
	}else
		echo "<font color='#660000'>Department field is empty</font>";
}
if(isset($_GET['act'])){
	if($_GET['act'] == 'edit'){
		$d = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM lecturers WHERE lecturerId = {$_GET['id']}"));
		$department = $d['department'];
		$lect = $d['lecturerName'];
	}
	elseif($_GET['act'] == 'delete'){
		mysqli_query($db, "DELETE FROM lecturers WHERE lecturerId = {$_GET['id']}");
	}
}
?>
<form method="post" action="<?php echo $root;?>admin/configure/?con=lecturers">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<table width="55%" align="center" border="1">
<tbody>
<tr><td>Department : </td><td>
<select name="department" style="width:95%">
	<option value="">--select department--</option>
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
<tr><td>Lecturer : </td><td><input type="text" name="lecturer" size="40" required value="<?php echo $lect ?>" style="width:95%" /></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" style="width:100%; margin:auto" /></td></tr>
</tbody>
</table>
</form>
<br />
<table width="100%" border="0" cellspacing="0" bordercolor="#006600">
<thead contenteditable="false"><th>Department</th><th>Lecturer</th><th width="70">Action</th></thead>
<tbody>
    <?php
	$row_color = array("'odd'", "'even'");
	$n = 0;
    $query = mysqli_query($db, "SELECT * FROM lecturers ORDER BY department, lecturerName");
    while($data = mysqli_fetch_assoc($query)){
        echo "<tr class=".$row_color[$n % 2]."><td>{$data['department']}</td><td>{$data['lecturerName']}</td><td>";
		echo "<a href='{$root}admin/configure/?con=lecturers&act=edit&id={$data['lecturerId']}'>Edit</a> &brvbar; ";
		echo "<a class='delete_link' href='{$root}admin/configure/?con=lecturers&act=delete&id={$data['lecturerId']}'>Delete</a>";
		echo "</td></tr>";
		$n++;
    }
    ?>
</tbody>
</table>