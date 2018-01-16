<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	

	$id = mysqli_real_escape_string($con, $_POST['id']);
	
	$name = mysqli_real_escape_string($con, $_POST['username']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$role_id = mysqli_real_escape_string($con, $_POST['role_id']);
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
	} else {	
		//updating the table
		$result = mysqli_query($con, "UPDATE users SET username='$name',password='$password',email='$email',role_id='$role_id' WHERE user_id=$id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT * FROM users WHERE user_id=$id");

while($res = mysqli_fetch_array($result))
{
	$name = $res['username'];
	$email = $res['email'];
	$password = $res['password'];
	$role_id = $res['role_id'];
}
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="username" value="<?php echo $name;?>"></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email" value="<?php echo $email;?>"></td>
			</tr>
			<tr> 
				<td>Password</td>
				<td><input type="text" name="password" value="<?php echo $password;?>"></td>
			</tr>
			<tr> 
				<td>Role ID</td>
				<td><input type="text" name="role_id" value="<?php echo $role_id;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
