<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;subset=devanagari,latin-ext" rel="stylesheet">
        
        <!-- title of site -->
        <title>Book Store</title>

        <!-- For favicon png -->
		<link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
       
        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

		<!--flat icon css-->
		<link rel="stylesheet" href="assets/css/flaticon.css">

		<!--animate.css-->
        <link rel="stylesheet" href="assets/css/animate.css">

        <!--owl.carousel.css-->
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
		
        <!--bootstrap.min.css-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- bootsnav -->
		<link rel="stylesheet" href="assets/css/bootsnav.css" >	
        
        <!--style.css-->
        <link rel="stylesheet" href="assets/css/style.css">
        
        <!--responsive.css-->
        <link rel="stylesheet" href="assets/css/responsive.css">
        

    </head>
	
	<body>
		
		<!-- top-area Start -->
		<header class="top-area">
			<div class="header-area">
				<!-- Start Navigation -->
			    <nav class="navbar navbar-default bootsnav navbar-fixed dark no-background">

			        <div class="container">

			            <!-- Start Header Navigation -->
			            <div class="navbar-header">
			                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
			                    <i class="fa fa-bars"></i>
			                </button>
			                <a class="navbar-brand" href="index.html">Book Store</a>
			            </div><!--/.navbar-header-->
			            <!-- End Header Navigation -->

			            <!-- Collect the nav links, forms, and other content for toggling -->
			            <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
			                <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
			                <li class=" smooth-menu active"></li>
			                    <li class=" smooth-menu"><a href="index.html">Home</a></li>
			                    <li><a href="bookstore.php">Books</a></li>
			                </ul><!--/.nav -->
			            </div><!-- /.navbar-collapse -->
			        </div><!--/.container-->
			    </nav><!--/nav-->
			    <!-- End Navigation -->
			</div><!--/.header-area-->

		    <div class="clearfix"></div>

		</header>
  <!-- end header section -->
<br><br>

</body>

</html>



<?php

  $id= (trim($_GET["bookID"]));

  require('mysqli_connect.php');

  $q="SELECT * FROM bookinventory where bookID=$id";
  $r= mysqli_query($conn, $q);

  if($r->num_rows>0){
    $row = $r->fetch_assoc();
    $image = imagecreatefromstring(($row['image']));
    $image = imagescale($image, 300, 400);
     ob_start();
    imagejpeg($image);
    $contents = ob_get_contents();
    ob_end_clean();
    echo "<div class='books-purchase'>";
    echo "<img src='data:image/jpeg;base64,".base64_encode($contents)."' />";
    echo "</div>";
    
  }else{
    echo "no such book present";
  }

  echo '<div class="rightside">
  <form method="POST" action="purchase.php?bookID='. $row['bookID'] .'">
    <h1>CheckOut</h1><br>
    <p>First Name</p>
    <input type="text"  name="firstname" required />
    <p>Last Name</p>
    <input type="text"  name="lastname" required />
    <p>Email</p>
    <input type="email"  name="email"  required /></br>

    <select class="inputbox" name="card_type" id="card_type" required>
      <option value="">--Select a Paymnet Type--</option>
      <option value="cash">Cash</option>
      <option value="card">Card</option>
    </select>

    <br><br>
    <input type="submit" class="button-7"  value="Order Now">
  </form>
</div>'
?>

<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

  require('mysqli_connect.php');


  $bookID= trim($_GET['bookID']);
  $firstname= trim($_POST['firstname']);
  $lastname=(trim($_POST['lastname']));
  $email=trim($_POST['email']);
  $paymentmode=trim($_POST['card_type']);

  $stmt="SELECT quantity FROM bookinventory where bookID=$id";
  $r1= mysqli_query($conn, $stmt);
  $row1 = $r1->fetch_assoc();

  $quantity= $row1['quantity'];

  if($quantity >0){

  $query1="INSERT INTO bookinventoryorder (`orderID`, `firstname`, `lastname`, `email`, `paymentmode`, `bookID`) VALUES (NULL,'$firstname','$lastname','$email','$paymentmode','$bookID')";

  if(mysqli_query($conn, $query1)) {
     
     $query2= "UPDATE `bookinventory` SET `quantity`=$quantity-1 WHERE bookID='$bookID'";
     if(mysqli_query($conn, $query2)) {
      echo "<script>window.alert('Order has been placed successfully!');
            window.location.href='./bookstore.php';
      </script>";
      
    }
    }else {
    echo "Error: " . $query1. "<br>" . mysqli_error($conn);
    }
  }else{
    echo "<script>window.alert('Product not avaiable for sale!');
    window.location.href='./bookstore.php';</script>";
  }
    mysqli_close($conn);
}
?>