<?php
//including the database connection file
include("config.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$result = mysqli_query($con, "DELETE FROM course WHERE course_id=$id");
$result2 = mysqli_query($con, "DELETE FROM content WHERE course_id=$id");
$result3 = mysqli_query($con, "DELETE FROM video WHERE content_id=$result2");

//redirecting to the display page (index.php in our case)
header("Location:index.php");
?>

