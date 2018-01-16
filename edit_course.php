<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	

	$course_id = mysqli_real_escape_string($con, $_POST['id']);
	
	$course_name = mysqli_real_escape_string($con, $_POST['course_name']);
	//$email = mysqli_real_escape_string($con, $_POST['email']);
	$department = mysqli_real_escape_string($con, $_POST['department_name']);
	//$password = mysqli_real_escape_string($con, $_POST['password']);
	
	// checking empty fields
	if(empty($course_id) || empty($course_name) || empty($department) ) {	
			
		if(empty($course_id)) {
			echo "<font color='red'>Course ID is empty.</font><br/>";
		}
		
		if(empty($course_name)) {
			echo "<font color='red'>Course Name is empty.</font><br/>";
		}
		
		if(empty($department)) {
			echo "<font color='red'>Department Name is empty.</font><br/>";
		}		
	} else {	
		//updating the table
		$result = mysqli_query($con, "UPDATE course SET course_name='$course_name',department_id='$department' WHERE course_id=$course_id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT * FROM course WHERE course_id=$id");

while($res = mysqli_fetch_array($result))
{   
    $course_id = $res['course_id'];
	$course_name = $res['course_name'];
	$department = $res['department_id'];
//	$password = $res['password'];
//	$role_id = $res['role_id'];
}


?>

<html>
<head>	
	<title>Edit Course</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form2" method="post" action="edit_course.php">
		<table border="0">
			<tr> 
				<td>Department Name</td>
				<td>
<!--                    <input type="text" name="department_name" value="">-->
                    <select name="department_name">    
                        <?php
                         $query = "SELECT department_id,department_name FROM department";
                            $result3 =  mysqli_query($con,$query);
                            while($row = mysqli_fetch_array($result3))
                               {
                                $department_id = $row['department_id'];
                                $department_name = $row['department_name'];    

                                echo '<option value='.$row['department_id'].'>'.$row['department_name'].'</option>';
                               }
                        ?>
                    </select>
                </td>
			</tr>
			<tr> 
				<td>Course Name</td>
				<td><input type="text" name="course_name" value="<?php echo $course_name;?>"></td>
			</tr>
            <tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
