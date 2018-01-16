<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	

	$content_id = mysqli_real_escape_string($con, $_POST['id']);
	
	$content_heading = mysqli_real_escape_string($con, $_POST['content_heading']);
	//$email = mysqli_real_escape_string($con, $_POST['email']);
	$content_description = mysqli_real_escape_string($con, $_POST['content_description']);
	//$password = mysqli_real_escape_string($con, $_POST['password']);
    $video_url = mysqli_real_escape_string($con, $_POST['video_url1']);
	
	// checking empty fields
	if(empty($content_id) || empty($content_heading) || empty($content_description) || empty(video_url)) {	
			
		if(empty($content_id)) {
			echo "<font color='red'>Content ID is empty.</font><br/>";
		}
		
		if(empty($content_heading)) {
			echo "<font color='red'>Content Heading is empty.</font><br/>";
		}
		
		if(empty($content_description)) {
			echo "<font color='red'>Content Description is empty.</font><br/>";
		}	
        if(empty($video_url)) {
			echo "<font color='red'>Video URL is empty.</font><br/>";
		}	
	} else {	
		//updating the table
		$result = mysqli_query($con, "UPDATE content SET content_heading='$content_heading',content_description='$content_description' WHERE content_id=$content_id");
        
        $result2 = mysqli_query($con, "UPDATE video SET video_url='$video_url' WHERE content_id=$content_id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($con, "SELECT content_id, course_id, content_heading, content_description, video_url from content NATURAL JOIN video where video.content_id = '$id'");

while($res = mysqli_fetch_array($result))
{   
    $content_id = $res['content_id'];
	$course_id = $res['course_id'];
	$content_heading = $res['content_heading'];
	$content_description = $res['content_description'];
	$video_url = $res['video_url'];
}


?>

<html>
<head>	
	<title>Edit Content</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form2" method="post" action="edit_content.php">
		<table border="0">
			<tr> 
				<td>Course Name</td>
				<td>
<!--                    <input type="text" name="department_name" value="">-->
                        <?php
                               $query = "SELECT course_id,course_name FROM course NATURAL JOIN content where content.course_id = course.course_id;";
					           $result =  mysqli_query($con, $query) or die();
					           while($row = mysqli_fetch_array($result))
					               {
                                        echo '<option value='.$row['course_id'].'>'.$row['course_name'].'</option>';
					               }
                    ?>
                </td>
			</tr>
			<tr> 
				<td>Content Heading</td>
				<td><input type="text" name="content_heading" value="<?php echo $content_heading;?>"></td>
			</tr>
            <tr> 
				<td>Content Description</td>
				<td><input type="text" name="content_description" value="<?php echo $content_description;?>"></td>
			</tr>
            <tr> 
				<td>Video URL</td>
				<td><select id ="video_url" name="video_url" onchange="select();">
                       <?php
					           $query = "SELECT video_id,video_url FROM video where content_id = '".$_GET['id']."'";
					           $result =  mysqli_query($con, $query) or die();
					           while($row = mysqli_fetch_array($result))
					               {
                                        echo '<option value='.$row['video_id'].'>'.$row['video_url'].'</option>';
					               }
//                               $role_query = mysqli_query($mysqli,"Select role_id from role where role_name=role_name");
//                               $role_result = mysqli_fetch_array($role_query);
				        ?>
                    </select></td>
			</tr>
            <tr>
                <td> Update URL Box</td>
                <td>
                <input type="text" id="update_url_box" name="video_url1" /><br />
                     <script>
                            function select() {
                                var x = document.getElementById("video_url");
                                    document.getElementById("update_url_box").value = x;
                            }
                    </script>
                </td>
            </tr>
            <tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
