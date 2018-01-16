<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	

	$role_id = mysqli_real_escape_string($con, $_POST['id']);
	
	$role_name = mysqli_real_escape_string($con, $_POST['role_name']);
	
	// checking empty fields
	if(empty($role_id) || empty($role_name)) {	
			
		if(empty($role_id)) {
			echo "<font color='red'>Content ID is empty.</font><br/>";
		}
		
		if(empty($role_name)) {
			echo "<font color='red'>Content Heading is empty.</font><br/>";
		}
		
		
	} else {	
		//updating the table
		$result = mysqli_query($con, "UPDATE role SET role_name='$role_name' WHERE role_id=$role_id");
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT role_id, role_name from role where role_id = '$id'");

while($res = mysqli_fetch_array($result))
{   
    $role_id = $res['role_id'];
	$role_name = $res['role_name'];
}


?>

<html>
<head>	
	<title>Edit Role</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form2" method="post" action="edit_role.php">
		<table border="0">

			<tr> 
				<td>Role Name</td>
				<td><input type="text" name="role_name" value="<?php echo $role_name;?>"></td>
			</tr>
            
            <tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
