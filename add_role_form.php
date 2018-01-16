
<?php include "config.php";?>
<html>
<head>
	<title>Add Role</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>

	<form action="add_role.php" method="post" name="form2">
		<table width="25%" border="0">
			<tr> 
				<td>Role Name</td>
				<td><input type="text" name="role_name"></td>
			</tr>
			<tr> 
				<td></td>
				<td><input type="submit" name="Submit_Role" value="Add Role"></td>
			</tr>
		</table>
	</form>
</body>
</html>

