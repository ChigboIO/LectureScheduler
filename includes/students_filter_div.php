<div class="rights">
    <h1>Class Filter</h1>
    
    <form method="get" action="">
    Department<br>
    <select name="d" style="width:95%">
    	<option value="">--select a department--</option>
		<?php
        $query = mysqli_query($db, "SELECT * FROM departments ORDER BY departmentName");
        while($data = mysqli_fetch_assoc($query)){
            echo "<option value='{$data['departmentName']}'"; 
			if($dept == $data['departmentName']) 
				echo 'selected';
			echo ">{$data['departmentName']}</option>";
        }
        ?>
    </select>
    <br>
    Level<br>
    <select name="l" style="width:95%">
    	<option value="">--select level--</option>
        <option value="100" <?php if($level == 100) echo 'selected'; ?>>100</option>
        <option value="200" <?php if($level == 200) echo 'selected'; ?>>200</option>
        <option value="300" <?php if($level == 300) echo 'selected'; ?>>300</option>
        <option value="400" <?php if($level == 400) echo 'selected'; ?>>400</option>
        <option value="500" <?php if($level == 500) echo 'selected'; ?>>500</option>
    </select>
    <br>
    <input type="submit" value="Filter" style="width:95%" />
    </form>
    <br>
</div>