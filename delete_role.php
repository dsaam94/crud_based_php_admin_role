<?php
//including the database connection file
include("config.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$result = mysqli_query($con, "DELETE FROM role WHERE role_id=$id");
$result2 = mysqli_query($con, "Update user set role_id = '2' WHERE role_id=$id");

//redirecting to the display page (index.php in our case)
header("Location:index.php");
?>

