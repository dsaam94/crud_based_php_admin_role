<html>
<head>
	<title>Add Course</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit_Course'])) {	
	//$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$department_name = mysqli_real_escape_string($con, $_POST['department_name']);
	$course_name = mysqli_real_escape_string($con, $_POST['course_name']);
	$content_heading = mysqli_real_escape_string($con, $_POST['content_heading']);
	$content_description = mysqli_real_escape_string($con, $_POST['content_description']);
	$video_url = mysqli_real_escape_string($con, $_POST['video_url']);
	// checking empty fields
	if(empty($department_name) || empty($course_name) || empty($content_heading) || empty($content_description) || empty($video_url)) {
				
		if(empty($department_name)) {
			echo "<font color='red'>Department name field is empty.</font><br/>";
		}
		
		if(empty($course_name)) {
			echo "<font color='red'>Add Course Name</font><br/>";
		}
		
		if(empty($content_heading)) {
			echo "<font color='red'>Enter Course Heading</font><br/>";
		}
		if(empty($content_description)) {
			echo "<font color='red'>Add N/A if nothing in description.</font><br/>";
		}
		if(empty($video_url)) {
			echo "<font color='red'>URL field is empty.</font><br/>";
		}
		//link to the previous page
		echo "<br/><a href='index.php'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$dept_id =  mysqli_real_escape_string($con, $_POST['department_name']);
        $insert_course_table = mysqli_query($con,"INSERT INTO course(course_name,department_id) VALUES('$course_name','$dept_id')");
        
		$course_id =  mysqli_insert_id($con);
        $insert_content_table = mysqli_query($con, "INSERT INTO content(content_heading,content_description,course_id) VALUES('$content_heading', '$content_description','".$course_id."')");
        
		$content_id = mysqli_insert_id($con);
		$insert_video_table = mysqli_query($con, "INSERT INTO video(video_url,content_id) VALUES('$video_url', '$content_id')");
        
		//echo $result;
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	}
}
?>
</body>
</html>
