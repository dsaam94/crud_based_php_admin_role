
<?php include "config.php";?>
<html>
<head>
	<title>Add Course</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>

	<form action="course.php" method="post" name="form2">
		<table width="25%" border="0">
			<tr> 
				<td>Department Name</td>
				<td>
                    <select name="department_name">
                       <?php
					           $query = "SELECT department_id,department_name FROM department";
					           $result =  mysqli_query($con, $query) or die();
					           while($row = mysqli_fetch_array($result))
					               {
                                        echo '<option value='.$row['department_id'].'>'.$row['department_name'].'</option>';
					               }
//                               $role_query = mysqli_query($mysqli,"Select role_id from role where role_name=role_name");
//                               $role_result = mysqli_fetch_array($role_query);
				        ?>
                    </select>
                </td>
			</tr>
			<tr> 
				<td>Course Name</td>
				<td><input type="text" name="course_name">
                </td>
			</tr>
			<tr> 
				<td>Content Heading</td>
				<td><input type="text" name="content_heading"></td>
			</tr>
			<tr> 
				<td>Content Description</td>
				<td><input type="text" name="content_description"></td>
			</tr>
			<tr> 
				<td>Video URL</td>
				<td><input type="text" name="video_url"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit_Course" value="Add Course"></td>
			</tr>
		</table>
	</form>
</body>
</html>

