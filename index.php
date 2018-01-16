<?php
//including the database connection file
include("config.php");

//global $db;
//$db = new DB(); 
//fetching data in descending order (lastest entry first)
$result =mysqli_query($con,"SELECT user_id, username, email, password, role_id FROM users ORDER BY user_id DESC"); // mysql_query is deprecated
////$result = $db -> ExecuteQuery("SELECT * FROM users ORDER BY user_id DESC"); // using mysqli_query instead
////$records = mysqli_fetch_array($result, $db);
//    //$result -> FetchAsArray();
//    //mysqli_fetch_array($result, $db);
//    
$result2 =mysqli_query($con,"SELECT course_id, course_name, department_name from course, department where course.department_id  = department.department_id ORDER BY course_id DESC");

$result3 = mysqli_query($con,"SELECT content_id, course_id, content_heading, content_description, video_url from content NATURAL JOIN video where video.content_id = content.content_id;");

$result4 = mysqli_query($con,"Select * from department;");

$result5 = mysqli_query($con,"Select * from role;");

$result6 = mysqli_query($con,"Select enrollment_id, username, course_name, enrollment_active from enrollment NATURAL JOIN users NATURAL JOIN course where enrollment.enrollment_active = '1';");
//$records2 = $result2 -> FetchAsArray();
$result7 = mysqli_query($con,"Select enrollment_id, username, course_name, enrollment_active from enrollment NATURAL JOIN users NATURAL JOIN course where enrollment.enrollment_active = '0';");
?>

<html>
<head>	
	<title>Homepage</title>
</head>

<body>

<h2>List of Users</h2>
<a href="add_1.php">Add New User</a><br/><br/>

	<table width='80%' border=0>
        <form  method="post" action="search.php?go"  id="searchform"> 
		<input type="text" placeholder="Search.." name = "search_user">
        <input  type="submit" name="submit" value="Search"> 
	<tr bgcolor='#CCCCCC'>
		<td>Name</td>
		<td>Email</td>
		<td>Password</td>
		<td>Role_id</td>
	</tr>
	<?php 
//	 global $db;
//	 $db = new DB();
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
        
	while($res = mysqli_fetch_array($result)) { 		
		echo "<tr>";
		echo "<td>".$res['username']."</td>";
		echo "<td>".$res['email']."</td>";
		echo "<td>".$res['password']."</td>";
		echo "<td>".$res['role_id']."</td>";	
		echo "<td><a href=\"edit.php?id=$res[user_id]\">Edit</a> | <a href=\"delete.php?id=$res[user_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
        echo "</tr>";
	}
	?>
	</table>

<br>
<br>

<h2>List of Courses</h2>
<a href="course_1.php">Add New Course</a><br/><br/>

	<table width='80%' border=0>
		
	<tr bgcolor='#CCCCCC'>
		<td>Course ID</td>
		<td>Course Name</td>
		<td>Department</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res = mysqli_fetch_array($result2,MYSQL_BOTH)) { 		
		echo "<tr>";
		echo "<td>".$res['course_id']."</td>";
		echo "<td>".$res['course_name']."</td>";
		echo "<td>".$res['department_name']."</td>";
		echo "<td><a href=\"edit_course.php?id=$res[course_id]\">Edit</a> | <a href=\"delete_course.php?id=$res[course_id]\" onClick=\"return confirm('Are you sure you want to delete? This will also delete all the related content of the course.')\">Delete</a></td>";		
	}
	?>
    </table>    
<br>
<br>
        
<h2>List of Content</h2>
<a href="add_content_form.php">Add New Content</a><br/><br/>

	<table width='80%' border=0>
		
	<tr bgcolor='#CCCCCC'>
		<td>Content ID</td>
        <td>Course ID</td>
		<td>Content Heading</td>
		<td>Content Description</td>
        <td>Video URL</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res1 = mysqli_fetch_array($result3,MYSQL_BOTH)) { 		
		echo "<tr>";
		echo "<td>".$res1['content_id']."</td>";
        echo "<td>".$res1['course_id']."</td>";
		echo "<td>".$res1['content_heading']."</td>";
		echo "<td>".$res1['content_description']."</td>";
        echo "<td>".$res1['video_url']."</td>";
		echo "<td><a href=\"edit_content.php?id=$res1[content_id]\">Edit</a> | <a href=\"delete_content.php?id=$res1[content_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>
<br>
<br>
    <h2>List of Departments</h2>
<a href="add_department_form.php">Add New Department</a><br/><br/>

	<table width='80%' border=0>
		
	<tr bgcolor='#CCCCCC'>
		<td>Department ID</td>
        <td>Department Name</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res1 = mysqli_fetch_array($result4,MYSQL_BOTH)) { 		
		echo "<tr>";
		echo "<td>".$res1['department_id']."</td>";
        echo "<td>".$res1['department_name']."</td>";
		echo "<td><a href=\"edit_department.php?id=$res1[department_id]\">Edit</a> | <a href=\"delete_department.php?id=$res1[department_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>

<br>
<br>
    <h2>List of User Roles</h2>
<a href="add_role_form.php">Add New Role</a><br/><br/>

	<table width='80%' border=0>
		
	<tr bgcolor='#CCCCCC'>
		<td>Role ID</td>
        <td>Role Name</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res1 = mysqli_fetch_array($result5,MYSQL_BOTH)) { 		
		echo "<tr>";
		echo "<td>".$res1['role_id']."</td>";
        echo "<td>".$res1['role_name']."</td>";
		echo "<td><a href=\"edit_role.php?id=$res1[role_id]\">Edit</a> | <a href=\"delete_role.php?id=$res1[role_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>
<br>
<br>
    <h2>List of Enrolled Users</h2>
<a href="add_enrollment_form.php">Enroll New User</a><br/><br/>

	<table width='80%' border=0>
		
	<tr bgcolor='#CCCCCC'>
		<td>Enrollment ID</td>
        <td>User Name</td>
        <td>Course Name</td>
        <td>Enrollment Status</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res1 = mysqli_fetch_array($result6,MYSQL_BOTH)) { 		
		echo "<tr>";
		echo "<td>".$res1['enrollment_id']."</td>";
        echo "<td>".$res1['username']."</td>";
        echo "<td>".$res1['course_name']."</td>";
        echo "<td>".$res1['enrollment_active']."</td>";
		echo "<td><a href=\"edit_enrollment.php?id=$res1[enrollment_id]\">Edit</a> | <a href=\"delete_enrollment.php?id=$res1[enrollment_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>
    
<br>
<br>
       <h2>List of Un-enrolled Users</h2>
<a href="add_enrollment_form.php">Enroll User</a><br/><br/>

	<table width='80%' border=0>
		
	<tr bgcolor='#CCCCCC'>
		<td>Enrollment ID</td>
        <td>User Name</td>
        <td>Course Name</td>
        <td>Enrollment Status</td>
	</tr>
	<?php 
	//while($res = mysql_fetch_array($result)) { // mysql_fetch_array is deprecated, we need to use mysqli_fetch_array 
	while($res1 = mysqli_fetch_array($result7,MYSQL_BOTH)) { 		
		echo "<tr>";
		echo "<td>".$res1['enrollment_id']."</td>";
        echo "<td>".$res1['username']."</td>";
        echo "<td>".$res1['course_name']."</td>";
        echo "<td>".$res1['enrollment_active']."</td>";
		echo "<td><a href=\"change_enrollment.php?id=$res1[enrollment_id]\">Edit</a> | <a href=\"delete_unenroll.php?id=$res1[enrollment_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
	}
	?>
	</table>
</body>
</html>
