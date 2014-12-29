<div class="rights">
    <h1>Lecturer Filter</h1>
    
    <form method="get" action="">
    Department<br>
    <select name="department" style="width:95%" class="department_select" loc="../includes/load_lecturers.php">
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
        
    </select><br />
    Lecturer Name<br>
    <select name="lecturerId" style="width:95%" class="lecturer_select">
    	<option value="">--select a department first--</option>
		<?php
        $query = mysqli_query($db, "SELECT * FROM lecturers WHERE department = '{$department}' ORDER BY lecturerName");
        while($data = mysqli_fetch_assoc($query)){
            echo "<option value='{$data['lecturerId']}'"; 
			if($lecturerId == $data['lecturerId']) 
				echo 'selected';
			echo ">{$data['lecturerName']} ({$data['department']})</option>";
        }
        ?>
        
    </select><br />
    
    <input type="submit" value="Filter" style="width:95%;">
    </form>
    <br />
</div>