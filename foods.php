<?php include('partials-front/menu.php'); ?>

    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

<section class="food-menu">
		<div class="container">
			<h2 class="text-center">Food Menu</h2>

			<?php 

			//display foods that are active
			$sql = "SELECT * FROM lbl_food WHERE active = 'Yes'";

			//exeucte query
			$res = mysqli_query($conn,$sql);

			//count rows 
			$count = mysqli_num_rows($res);

			// check whether foods are available or not
			if($count>0)
			{
				//foods availabel
				while($row = mysqli_fetch_assoc($res))//get all the data in row format
				{
					//get the values like id
					$id = $row['id'];
					$title = $row['title'];
					$description = $row['description'];
					$price = $row['price'];
					$image_name = $row['image_name'];
					?>

						<div class="food-menu-box">
							<div class="food-menu-img">

								<?php 
									//check whether image is available or not
									if ($image_name=="") 
									{
										//iamge not available
										echo "<div class='error'>Image not available.</div>";
									}
									else
									{
										//image available
										?>

										<img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">

										<?php
									}
								?>

								
							</div>
							<div class="food-menu-desc">
								<h4><?php echo $title; ?></h4>
								<p class="food-price">Rs.<?php echo $price; ?></p>
								<p class="food-detail"><?php echo $description; ?></p>
								<br>
								<a href="<?php echo SITEURL; ?>order.php?food_id=<?php
                                   echo $id; ?>" class="btn btn-primary">Order now</a>
							</div>
						</div>			

					<?php
				}
			}
			else
			{
				//foods not availble and display msg
				echo "<div class ='error'>Foods not found.</div>";
			}

			?>

	
			
			<div class="clearfix"></div>
		</div>
	</section>

<?php include('partials-front/footer.php'); ?>