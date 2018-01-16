<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	
    $enrollment_id = mysqli_real_escape_string($con, $_POST['id']);
	$enrollment_status = mysqli_real_escape_string($con, $_POST['enrollment_status']);
    
	// checking empty fields
	if(empty($enrollment_status)) {	
			echo "<font color='red'>Enrollment Status is empty.</font><br/>";
	} 
    if(empty($enrollment_id)) {	
			echo "<font color='red'>Enrollment Id is empty.</font><br/>";
	}
    
    else {	
		//updating the table
		$result = mysqli_query($con, "UPDATE enrollment SET enrollment_active='1' WHERE enrollment_id='$enrollment_id'");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT * FROM enrollment WHERE enrollment_id='$id'");

while($res = mysqli_fetch_array($result))
{
	$enrollment_status = $res['enrollment_active'];
	$user_id = $res['user_id'];
    $course_id = $res['course_id'];
    $enrollment_id = $res['enrollment_id'];
}
?>
<html>
<head>	
	<title>Edit Enrollment</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit_enrollment.php">
		<table border="0">
            <tr> 
				<td>User Name</td>
				<td>
<!--                    <input type="text" name="department_name" value="">-->
                        <?php
                               $query = "SELECT o.user_id ,username FROM enrollment o JOIN users where users.user_id = o.user_id and o.enrollment_id = '$enrollment_id'AND users.role_id = 2;";
					           $result =  mysqli_query($con, $query) or die();
					           while($row = mysqli_fetch_array($result))
					               {
                                        echo '<option value='.$row['user_id'].'>'.$row['username'].'</option>';
					               }
                    ?>
                </td>
			</tr>
            <tr> 
				<td>Course Name</td>
				<td>
<!--                    <input type="text" name="department_name" value="">-->
                        <?php
                               $query = "SELECT o.course_id ,course_name FROM enrollment o JOIN course where course.course_id = o.course_id and o.enrollment_id = '$enrollment_id';";
					           $result =  mysqli_query($con, $query) or die();
					           while($row = mysqli_fetch_array($result))
					               {
                                        echo '<option value='.$row['course_id'].'>'.$row['course_name'].'</option>';
					               }
                    ?>
                </td>
			</tr>
			<tr> 
				<td>Enrollment Status</td>
				<td><select name="enrollment_status">    
                        <option>1</option>
                        <option>0</option>
                    </select>
                </td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
