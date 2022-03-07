<?php  
  	include('../config/constants.php');

	//check whether id and imagename value is set or not
	if(isset($_GET['id']) AND isset($_GET['image_name']))
	{
		//get value amd delete
		//echo "Get value and delete";
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];

		//remove the physical image file if available
		if($image_name != "")
		{
			//image is available so remove it
			$path = "../images/category/".$image_name;

			//remove the image
			$remove = unlink($path);

			//if failed to remove image then andd an error message and stop the process
			if($remove == false)
			{
				//set the session message 
				$_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
				//redirect to manage category page
				header('location:'.SITEURL.'admin/manage-category.php');
				//stop the process
				die();
			}

		}

		//delte data from db
		//sql query delete data from db
		$sql = "DELETE FROM tbl_category WHERE id = $id";

		//execute the query
		$res = mysqli_query($conn,$sql);

		//check whether the data is deleted from db or not
		if($res ==true)
		{
			//set si=uccess message and redirect
			$_SESSION['delete'] = "<div class='success'> Category deleted successfully.</div>";
			//redirect to category page with message
			header('location:'.SITEURL.'admin/manage-category.php');
		}
		else
		{
			//set si=uccess message and redirect
			$_SESSION['delete'] = "<div class='error'> Failed to delete category.</div>";
			//redirect to category page with message
			header('location:'.SITEURL.'admin/manage-category.php');	
		}
		
	 }
	else
	{
		//redirect to manage category page
		header('location:'.SITEURL.'admin/manage-category.php');
	}
?>