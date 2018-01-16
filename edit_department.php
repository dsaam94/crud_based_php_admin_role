<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	

	$department_id = mysqli_real_escape_string($con, $_POST['id']);
	
	$department_name = mysqli_real_escape_string($con, $_POST['department_name']);
	
	// checking empty fields
	if(empty($department_name)) {	
			echo "<font color='red'>Name field is empty.</font><br/>";
	} else {	
		//updating the table
		$result = mysqli_query($con, "UPDATE department SET department_name='$department_name' WHERE department_id=$department_id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT * FROM department WHERE department_id=$id");

while($res = mysqli_fetch_array($result))
{
	$department_name = $res['department_name'];
	$department_id = $res['department_id'];
}
?>
<html>
<head>	
	<title>Edit Department</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit_department.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="department_name" value="<?php echo $department_name;?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
