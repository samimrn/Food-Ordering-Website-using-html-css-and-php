<?php include('partials-front/menu.php'); ?>

	<section class="categories">
		<div class="container">
			<h2 class="text-center">Explore Foods</h2>

		<?php

			//display all the categories that are active
			//create sql query
			$sql = "SELECT * FROM tbl_category WHERE active='Yes'";

			//execute query
			$res = mysqli_query($conn,$sql);

			//count rows
			$count = mysqli_num_rows($res);
			//check whether categories aavailable not not
			if($count>0)
			{
				//category available
				while ($row = mysqli_fetch_assoc($res)) 
				{
					//get the values
					$id = $row['id'];
					$title = $row['title'];
					$image_name = $row['image_name'];

					?>
						<a href="<?php echo SITEURL; ?>categories-food.php?category_id=<?php echo $id; ?>">
							<div class="box-3 float-container">

								<?php 

								if ($image_name == "") 
								{
									//image not availabel
									echo "<div class = 'error'>Image not found.</div>";
								}
								else
								{
									//image available
									?>

									<img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" class="img-responsive img-curve">

									<?php
								}

								 ?>

								

								<h3 class="float-text text-white"><?php echo $title; ?></h3>
							</div>
						</a>
					<?php
				}
			}
			else
			{
				//category not available
				echo "<div class = 'error'>Category not found.</div>";
			}

		?>

	
		
			<div class="clearfix"></div>
		</div>
	</section>

<?php include('partials-front/footer.php'); ?>