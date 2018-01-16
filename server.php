<?php

    session_start();
    $rolid = "";
    $username = "";
    $email    = "";
    $errors = array(); 
    $_SESSION['success'] = "";	




    //connect to db
    $db = mysqli_connect('localhost', 'root', '', 'project1');

    //if register button is clicked
    if (isset($_POST['register'])) {
         $username = mysqli_real_escape_string($db, $_POST['username']);
	     $email = mysqli_real_escape_string($db, $_POST['email']);
	     $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	     $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
         $role = mysqli_real_escape_string($db, $_POST['role']);
        
         // form validation: ensure that the form is correctly filled
	if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($password_1)) { array_push($errors, "Password is required"); }
    if (empty($role)) {array_push($errors, "Select your role");}
	
        if($role == "Administrator"){
            $roleid = 1;
        }elseif($role == "Student"){
            $roleid = 2;
        }
        else{
            $roleid = 3;
        }
        
        if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database
		$query = "INSERT INTO users (username, password, email, role_id) 
				  VALUES('$username', '$password', '$email', '$roleid')";
		mysqli_query($db, $query);

		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You are now logged in";
		header('location: index.php');
//        if ($row['role']=="1")
//			{ 
// 
//                               header ("location: customer_page.php"); 
//                             
//			}
//			else if ($row['role']=="2")
//			{ 
//                               $_SESSION['role_id']=$row['role_id'];
// 
//                               header ("location: manager_page.php"); 
//                             
// 
//			}	
//				//header('location: index.php');
//                else if ($row['role']=="3")
//			{ 
//                               $_SESSION['role_id']=$row['role_id'];
// 
//                               header ("location: admin_page.php"); 
//                             
// 
//			}
//		
	}

}
    // LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);
            $row=mysqli_fetch_array($results);
            $_SESSION['user_id']=$row['user_id'];
            $_SESSION['role_id']=$row['role_id'];
            
			if (mysqli_num_rows($results) == 1){
                $_SESSION['user_name'] = $username;
				$_SESSION['success'] = "You are now logged in";
                if ($row['role_id']=="1")
			{ 
 
                               header ("location: index.php"); 
                             
			}
			else if ($row['role_id']=="2")
			{ 
                               $_SESSION['role_id']=$row['role_id'];
 
                               header ("location: manager_page.php"); 
                             
 
			}	
				//header('location: index.php');
                else if ($row['role_id']=="3")
			{ 
                               $_SESSION['role_id']=$row['role_id'];
 
                               header ("location: admin_page.php"); 
                             
 
			}
                
			}
            
            else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}




       if (isset($_GET['logout']))  {

       	  session_destroy();
       	  unset($_SESSION['username']);
       	  header('location: login.php');
       }
  

 ?>