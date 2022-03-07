<?php 
	//include constants page
	include('../config/constants.php');

	//chceck whether value is passed on url or not
	if(isset($_GET['id']) && isset($_GET['image_name']))//either use && or AND
	{
		//process to delete
		//get id amnd image name
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];

		//remove the image if available
		//check if the image is available or not delete if available
		if ($image_name != "") 
		{
			//it has image and need to remove from folder
			//get the image path
			$path = "../images/food/".$image_name;

			//remove iamge file from folder
			$remove = unlink($path);

			//check if the image is successfully removed or not
			if($remove == false)
			{
				//failed to remove image
				$_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
				//redirect to manage food
				header('location:'.SITEURL.'admin/manage-food.php');
				//stop the process of deleting food
				die();
			}
			
		}

		//delete food from db
		$sql = "DELETE FROM lbl_food WHERE id = $id";
		//execute the query
		$res = mysqli_query($conn,$sql);
		//check whether the query execute or not and set the session msg successfully
		//redirect to manage food with session msg
		if ($res == true) 
		{
			//food deleted
			$_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
			header('location:'.SITEURL.'admin/manage-food.php');
		}
		else
		{
			//failed to delete food
			$_SESSION['delete'] = "<div class='error'>Failed to deleted food.</div>";
			header('location:'.SITEURL.'admin/manage-food.php');
		}

		
	}
	else
	{
		//redirect to manage food page
		$_SESSION['Unauthorized'] = "<div class='error'>Unauthorized access.</div>";
		header('location:'.SITEURL.'admin/manage-food.php');
	}

?>