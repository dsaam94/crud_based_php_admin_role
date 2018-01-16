<html>
<head>
	<title>Add User</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit'])) {	
	//$id = mysqli_real_escape_string($mysqli, $_POST['id']);
    
//    print_r($_POST)die;
    
	$name = mysqli_real_escape_string($con, $_POST['username']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	//$role_query = mysqli_query($mysqli, "Select role_id from role where role_name='$_POST['role_id']'");
    $role_id =  mysqli_real_escape_string($con, $_POST['role_name']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	// checking empty fields
	if(empty($name) || empty($role_id) || empty($email) || empty($password)) {
				
		if(empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if(empty($role_id)) {
			echo "<font color='red'>Role field is empty.</font><br/>";
		}
		
		if(empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
		if(empty($password)) {
			echo "<font color='red'>Password field is empty.</font><br/>";
		}
		
		//link to the previous page
		echo "<br/><a href='index.php'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			//echo "INSERT INTO users(username,password,email,role_id) VALUES('$name','$password','$email','$role_id',)";die;
		//insert data to database	
		$result = mysqli_query($con, "INSERT INTO users(username,password,email,role_id) VALUES('$name','$password','$email','$role_id')");
		//echo $result;
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	}
}
?>
</body>
</html>
