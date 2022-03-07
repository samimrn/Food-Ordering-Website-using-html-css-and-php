<?php

 //include constant.php file here
 	include('../config/constants.php');

 //get id of admin to be deleted 
	echo $id = $_GET['id'];

 //created sql to delete admin  
	$sql = "DELETE FROM tbl_admin WHERE id=$id";

 //Execute the query
	$res = mysqli_query($conn,$sql);

//Check whetehr the query executed successfully
	if($res==true)
	{
		//query executed successfully and admin deleted
		//echo "Admin deleted";
		//create session variable to display message 
		$_SESSION['delete'] = "<div class='success'> Admin deleted successfully.</div>";
		//redirect to admin page
		header('location:'.SITEURL.'admin/manage-admin.php');
	}
	else
	{
		//Failed to delete admin
		//echo "failed to delete admin";
		$_SESSION['delete'] = "<div class='error'>Failed to delete admin. Try again</div>";
		//redirect to admin page
		header('location:'.SITEURL.'admin/manage-admin.php');
	}

 //redirect to manage admin page with msg 
	
?>