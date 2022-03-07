<?php  
 	include('../config/constants.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login - Food order system</title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<div class="login">
		<h1 class="text-center">Login</h1>
			<!--Login Starts Here-->
			<br><br>

			<?php
				if(isset($_SESSION['login']))
				{
					echo $_SESSION['login'];
					unset($_SESSION['login']);
				}
				if (isset($_SESSION['no-login-message'])) 
				{
					echo $_SESSION['no-login-message'];
					unset($_SESSION['no-login-message']);
				}
			?>
			<br><br>

			<form action="" method="POST" class="text-center">
				Username:<br><input type="text" name="username" placeholder="Enter Username">
				<br><br>
				Password:<br><input type="password" name="password" placeholder="Enter Password">
				<br><br>
				<input type="submit" name="submit" value="login" class="btn-primary">
				<br><br>
			</form>
			<!--Login Ends Here-->
	 	<p class="text-center">Created By - <a href="#">AABS</a> </p>
	</div>
</body>
</html>

<?php  
	//check whether the submit button is clicked or not
	
	if (isset($_POST['submit']))
	{
		//Process for login
		//Get the data from login form
		 //$username = $_POST['username'];
		 //$password = md5($_POST['password']);
		 $username = mysqli_real_escape_string($conn,$_POST['username']);
		 $password = md5($_POST['password']);

		 //sql query to check whether the username and pw exists or not
		 $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password' ";

		 //execute the query
		 $res = mysqli_query($conn,$sql);

		 //count rows to check whether the user exists or not 
		 $count = mysqli_num_rows($res);

		 if($count == 1)
		 {
		 	//user available and login success
		 	$_SESSION['login'] = "<div class='success text-center'>Login Successful.</div>";
		 	$_SESSION['user'] = $username;//to check whether the user is logged in or not and logout will unset it

		 	//redirect to home page
		 	header('location:'.SITEURL.'admin/');
		 }
		 else
		 {
		 	//user not available and login fail
		 	$_SESSION['login'] = "<div class='error text-center'>Login Failed.</div>";
		 	//redirect to home page
		 	header('location:'.SITEURL.'admin/login.php');
		 }
	}
?>