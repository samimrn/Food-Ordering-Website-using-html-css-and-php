<?php include('partials-front/menu.php'); ?>

<?php  

    //check whether food id is set or not
    if (isset($_GET['food_id'])) 
    {
        //get the  food id and details of hte  selected food
        $food_id = $_GET['food_id'];

        //get the deatils of the selected food
        $sql = "SELECT *FROM lbl_food WHERE id='$food_id'";

        //execute the query
        $res = mysqli_query($conn,$sql);

        //count rows
        $count = mysqli_num_rows($res);

        //check whether the data is available or not
        if ($count==1) 
        {
            //we have data
            //get data from db
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];

        }
        else
        {
            //no data
            header('location:'.SITEURL);
        }


    }
    else
    {
        //redirect to home page
        header('location:'.SITEURL);
    }

?>

<!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">

                        <?php 

                            //check whehter image is availabel or not
                            if ($image_name=="") 
                            {
                               //image not available
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else
                            {
                                //image available
                                ?>

                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                                <?php
                            }

                        ?>

                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">Rs.<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name"  class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact"  class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email"  class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10"  class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php  
                //check whether the submit button is clicked or not
                if (isset($_POST['submit'])) 
                {
                    //get all the details from the form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;//total=price*qty

                    $order_date = date("Y-m-d h:i:sa");//order date current date and time

                    $status = "Ordered";//ordered, undelivery, delivered, cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //save the order in db
                    //create sql to savae the data 
                    $sql2 = "INSERT INTO lbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status ='$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                        
                    ";

                    //Execute the query
                    $res2 = mysqli_query($conn,$sql2);

                    //check whether query executed successfully or not
                    if ($res2 == true) 
                    {
                       //query executed and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //failed to save order 
                         $_SESSION['order'] = "<div class='error text-center'>Failed to order food.</div>";
                        header('location:'.SITEURL);
                    }

                }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->


<?php include('partials-front/footer.php'); ?>