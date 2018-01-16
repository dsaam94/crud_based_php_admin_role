<html>
<head>
	<title>Add Course</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit_Role'])) {	
	//$id = mysqli_real_escape_string($con, $_POST['id']);
	//$department_name = mysqli_real_escape_string($con, $_POST['department_name']);
	$role_name = mysqli_real_escape_string($con, $_POST['role_name']);
	// checking empty fields
	if(empty($role_name)) {
			echo "<font color='red'>Add Course Name</font><br/>";
		    echo "<br/><a href='index.php'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$role_name =  mysqli_real_escape_string($con, $_POST['role_name']);
        $insert_role_table = mysqli_query($con, "INSERT INTO role(role_name) VALUES('$role_name')");
        
		//echo $result;
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	}
}
?>
    
</body>
</html>
