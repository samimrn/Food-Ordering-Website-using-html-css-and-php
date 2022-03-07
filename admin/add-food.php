<?php  
	include('partials/menu.php');
?>

<div class="main-content">
	<div class="wrapper">
		<h1>Add Food</h1>
		<br><br>

		<?php  
			if (isset($_SESSION['upload'])) 
			{
				echo $_SESSION['upload'];
				unset($_SESSION['upload']);
			}
		?>

		<form method="POST" enctype="multipart/form-data">
			<table class="tbl-30">
				<tr>
					<td>Title:</td>
					<td>
						<input type="text" name="title" placeholder="Title of the food">
					</td>
				</tr>
				<tr>
					<td>Description:</td>
					<td>
						<textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
					</td>
				</tr>
				<tr>
					<td>Price:</td>
					<td>
						<input type="number" name="price">
					</td>
				</tr>
				<tr>
					<td> Select Image:</td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				<tr>
					<td>Category:</td>
					<td>
						<select name="category">

							<?php  

							//create php code to display categories from db
							//1.create sql to get all active categories from db
							$sql = "SELECT *FROM tbl_category WHERE active='Yes'";

							//executing query
							$res = mysqli_query($conn,$sql);

							//count rows to check whether we have caterogies or not
							$count =  mysqli_num_rows($res);

							//if count>0 we have categories
							if ($count>0)
							{
								while ($row = mysqli_fetch_assoc($res)) 
								{
									//get the details of categories
									$id = $row['id'];
									$title = $row['title'];
									?>

									<option value="<?php echo $id; ?>"><?php echo $title;  ?></option>

									<?php

								}
							}

							//else we don't have categories
							else
							{
								?>

								<option value="0">No Category Found</option>

								<?php

							}

							//2.display om drop down

							?>

						</select>
					</td>
				</tr>
				<tr>
					<td>Featured:</td>
					<td>
						<input type="radio" name="featured" value="Yes">Yes
						<input type="radio" name="featured" value="No">No
					</td>
				</tr>
				<tr>
					<td>Active:</td>
					<td>
						<input type="radio" name="active" value="Yes">Yes
						<input type="radio" name="active" value="No">No
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Add Food" class="btn-secondary">
					</td>
				</tr>

			</table>
		</form>

		<?php  
			//check whether the button is clicked or not 
			if(isset($_POST['submit']))
			{
				//add the food in db

				//get the data from form

				$title = $_POST['title'];
				$description = $_POST["description"];
				$price = $_POST['price'];
				$category = $_POST['category'];
				//check whether radio button for deatured and active are checked or not
				if(isset($_POST['featured']))
				{
					$featured = $_POST['featured'];
				}
				else
				{
					$featured = "No";//setting the default value
				}
				if(isset($_POST['active']))
				{
					$active = $_POST['active'];
				}
				else
				{
					$active = "No";//setting the default value
				}

				//upload the image if selected
				//check whether the image is clicked or not and upload the image only if the image is selected
				if(isset($_FILES['image']['name']))
				{
					//get the details of the selected image
					$image_name = $_FILES['image']['name'];

					//check whether the selected image is selected or not and upload image only
					if ($image_name != "")
					{
						//image is selected
						//rename the image 
						//get the extension of selected image (jpg,png,gif,etc)
						$ext = end(explode('.',$image_name));

						//create new name for image
						$image_name = "Food-Name-".rand(0000,9999).",".$ext;//new image name like"Food-Name-657.jpg"

						//upload the image
						//get the source path and destination path

						//source path is the current location of the image 
						$src = $_FILES['image']['tmp_name'];

						//destination path for the image to be uploaded
						$dst = "../images/food/".$image_name;

						//finally upload food image
						$upload = move_uploaded_file($src, $dst);

						//check  whether image uploaded or not
						if($upload == false)
						{
							//failed to upload the image

							//redirect to add page woth error msg
							$_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
							header('location:'.SITEURL.'admin/add-food.php');

							//stop the process
							die();

						}


					}
				}
				else
				{
					$image_name = "";//setting default value as blank.
				}

				//insert into db
				//create sql query to save or add food

				$sql2 = "INSERT INTO lbl_food SET
					title = '$title',
					description = '$description',
					price = $price,
					image_name = '$image_name',
					category_id = $category,
					featured = '$featured',
					active = '$active'
				";

				//execute query
				$res2 = mysqli_query($conn,$sql2);

				//check whether data inserted or not

				//redirect with msg to manage food page

				if ($res2 == true) 
				{
					//data inserted successfully
					$_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
					header('location:'.SITEURL.'admin/manage-food.php');
				}
				else
				{
					//failed to insert data
					$_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
					header('location:'.SITEURL.'admin/manage-food.php');
				}


				
			}
		?>

	</div>
</div>

<?php  
	include('partials/footer.php');
?>