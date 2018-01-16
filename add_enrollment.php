<html>
<head>
	<title>Add Course</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit_Enrollment'])) {	
	//$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	//$department_name = mysqli_real_escape_string($con, $_POST['department_name']);
	$course_id = mysqli_real_escape_string($con, $_POST['course_name']);
	$user_id = mysqli_real_escape_string($con, $_POST['username']);
    
	// checking empty fields
	if(empty($course_id) || empty($user_id)) {
				
		if(empty($course_id)) {
			echo "<font color='red'>Add Course Name</font><br/>";
		}
		
		if(empty($user_id)) {
			echo "<font color='red'>Enter User ID</font><br/>";
		}
        
		//link to the previous page
		echo "<br/><a href='index.php'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database
        //$user_id =  mysqli_real_escape_string($con, $_POST['username']);
        //$course_id =  mysqli_real_escape_string($con, $_POST['course_name']);
        $insert_enrollment_table = mysqli_query($con, "INSERT INTO enrollment(user_id,course_id,enrollment_active) VALUES('$user_id', '$course_id','1')");
        
	//echo $result;
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	}
}
?>
</body>
</html>
