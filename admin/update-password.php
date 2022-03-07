<?php include('partials/menu.php');  ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Change Password</h1>
		<br><br>

		<?php  
			if(isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
		?>

		<form action="" method="POST">
			<table class="tbl-30">
				<tr>
					<td>Current Password:</td>
					<td>
						<input type="password" name="current_password" placeholder="Current Password">
					</td>
				</tr>
				<tr>
					<td>New password:</td>
					<td>
						<input type="password" name="new_password" placeholder="New Password">
					</td>
				</tr>
				<tr>
					<td>Confirm password:</td>
					<td>
						<input type="password" name="confirm_password" placeholder="Confirm Password">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<input type="submit" name="submit" value="Change Password" class="btn-secondary">
					</td>
				</tr>
			</table>
		</form>

	</div>
</div>

<?php include('partials/footer.php');  ?>

<?php
if(isset($_POST['submit']))
{
	//1. Get the data from form
	$id = $_POST['id'];
	$current_password = md5($_POST['current_password']);
	$new_password = md5($_POST['new_password']);
	$confirm_password = md5($_POST['confirm_password']);

	//Check whether the user with current id and current password exists or not 
	$sql= "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
		

	//execute the query
	$res = mysqli_query($conn, $sql);

	if($res==true)
	{
		//checkk whether data is available or not
		$count = mysqli_num_rows($res);
		//check whether we have admin data or not
			if($count==1)
			{
				//Check whether the new password and confirm match or not 
				if($new_password == $confirm_password)
				{
					//update the password
					$sql2 = "UPDATE tbl_admin SET
					password = '$new_password';
					WHERE id = $id;
					";

					//execute query
					$res2 = mysqli_query($conn,$sql);

					//check whether the query executed or not 
					if($res2 == true)
					{
						//display success messsagae
						$_SESSION['change-pws'] = "<div class='success'>password changed successfully.</div>";
					header('location:'.SITEURL.'admin/manage-admin.php');

					}
					else
					{
						//display error message
						//redirect to manage admin page
						$_SESSION['change-pws'] = "<div class='error'>password not changed.</div>";
					header('location:'.SITEURL.'admin/manage-admin.php');
					}
				}

			}
				else
				{
					//redirect to manage admin page
					$_SESSION['password-not-matched'] = "<div class='error'>password not matched.</div>";
				header('location:'.SITEURL.'admin/manage-admin.php');
				}
			}
			else
			{
				//user doesn't exists set message and redirect 
				$_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
				header('location:'.SITEURL.'admin/manage-admin.php');
			}

	}


?>