<html>
<head>
	<title>Add Department</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit'])) {	
	//$id = mysqli_real_escape_string($mysqli, $_POST['id']);
    
//    print_r($_POST)die;
    
	$department_name = mysqli_real_escape_string($con, $_POST['department_name']);
    
	// checking empty fields
	if(empty($department_name)) {
				
		if(empty($department_name)) {
			echo "<font color='red'>Department Name field is empty.</font><br/>";
		}
		
		
		//link to the previous page
		echo "<br/><a href='index.php'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			//echo "INSERT INTO users(username,password,email,role_id) VALUES('$name','$password','$email','$role_id',)";die;
		//insert data to database	
		$result = mysqli_query($con, "INSERT INTO department(department_name) VALUES('$department_name')");
		//echo $result;
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	}
}
?>
</body>
</html>
