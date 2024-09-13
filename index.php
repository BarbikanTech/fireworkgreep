<!DOCTYPE html>
<html lang="en">
<head itemscope itemtype="http://www.schema.org/website">
	<title>Greep Fireworks  | Diwali Crackers Sale |  Online Crackers Shop | Fancy Crackers Shop | Sivakasi Crackers shop</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="Greep Fireworks">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content=" Greep Fireworks">
	<meta property="og:url" content="https://greepfireworks.com">
	<meta property="og:image" content="https://greepfireworks.com/images/android-icon-192x192.png">
	<meta property="og:description" name="description" content="We are in the cracker's industry for past 10 years. It's our pride in supplying our esteemed customers with the best quality crackers at the market prices.">
	<meta name="robots" content="all">
	<meta name="revisit-after" content="10 Days">
	<meta name="copyright" content="Greep Fireworks">
	<meta name="language" content="English">
	<meta name="distribution" content="Global">
	<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
	<link rel="icon" sizes="192x192"  href="images/android-icon-192x192.png">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
	<script src="js/wow.js"></script>
    <script src="js/marquee.js"></script>
</head>
<body itemscope itemtype="http://schema.org/WebPage">
<?php include("header.php");?>
<!-- bannner start -->
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
       <?php
       include('db/config.php');
            $sql = "SELECT * FROM `banner` WHERE `delete_at` = 0";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    // Determine if this is the first item, and set 'active' class accordingly
                    $activeClass = ($count == 0) ? "active" : "";

                    // Output the carousel item with the image
                    echo '<div class="carousel-item ' . $activeClass . '">';
                    echo '<img src="uploads/banner/' . $row["img"] . '" class="img-fluid d-block w-100" alt="...">';
                    echo '</div>';

                    $count++;
                }
            } else {
             ?>
             <div class="carousel-item active">
        
      <img src="images/greepbanner.jpg" class="img-fluid d-block w-100" alt="best retails crackers shop in sivakasi">
    </div>
    <div class="carousel-item">
      <img src="images/banner7.jpg" class="d-block w-100" alt="best fancy crackers">
    </div>
             <?php
            }
            ?>
    
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-- bannner end -->
<!-- intro start -->

	<div class="container pad ">
		<div class="row d-flex justify-content-center">
			<div class="col-lg-6 pb-4">
				<div class="intro text-center">
					<img src="images/intro2.jpg" class="img-fluid w-75" alt="Best Fancy Crackers Shop" title="Best Fancy Crackers Shop">
				</div>
			</div>
			<div class="col-lg-6 align-self-center">
					<div class="intro-content">
						<img src="images/bomb.png" class="img-fluid w-25" alt="About" title="About">
						<h1 class="bold">About</h1>
						<h3 class="bold">Welcome To The Greep Crackers</h3>
					<p class="regular"> We provide variety of firecrackers including Single and Multi-sound crackers, Sparklers, Ground chakkars, Flower pots, Twinkling stars, Pencils, Fancy rockets, Aerial and Fancy crackers, Fancy whistling varieties, Amorces, Chorsa garlands, Atom bomb and Electric crackers. If you would like to buy crackers online, We are the right choice as we ship directly from Sivakasi and offer prices that no other can offer you in your locality. We deal direct contact with firework companies in sivakasi and offering you the lowest prices. </p>
					</div>
			</div>
		</div>
	</div>
<!-- intro end -->
<div class="container py-5">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="bold clr1 pb-2 text-center">Brands We Handle</h1>
			<div class="owl-carousel owl-theme pt-4">
				<div class="item">
					<img src="images/akfireworks.jpg" class="img-fluid" alt="Brands" title="Brands">
				</div>
				<div class="item">
					<img src="images/standard.jpg" class="img-fluid" alt="Brands" title="Brands">
				</div>
				<div class="item">
					<img src="images/maruthi.jpg" class="img-fluid" alt="Brands" title="Brands">
				</div>
				<div class="item">
					<img src="images/ajanta.jpg" class="img-fluid" alt="Brands" title="Brands">
				</div>
				<div class="item">
					<img src="images/sunshine.jpg" class="img-fluid" alt="Brands" title="Brands">
				</div>
				<div class="item">
					<img src="images/naachiar.jpg" class="img-fluid" alt="Brands" title="Brands">
				</div>
			</div>        
		</div>
	</div>
</div>
<div class="bg">
	<div class="container mt-5 pt-3">
		<div class="row d-flex justify-content-center">
			<div class="col-lg-12 fullpad ">
				<div class="text-center">
					<h1 class="bold"> Greep Crackers</h1>
					<p class="regular">We provide all top branded deepavali crackers & other occasional Fire crackers retails and wholesale. We build your surprising occasion with lighting and sensational Gift box with our inspiring crackers.</p>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-12 text-center">
				<img src="images/aboutimage1.webp" class="img-fluid w-75 pb-2" alt="whole sale" title="whole sale">
			</div>
			<div class="col-lg-6 col-md-6 col-12 text-center">
				<img src="images/aboutimage2.webp" class="img-fluid w-75" alt="retail" title="retail">
			</div>
		</div>
	</div>
</div>
<!-- paralax start -->
<div class="paralax bg-overlay1">
	<div class="container pad">
		<div class="row wc">
			<div class="col-lg-12">
				<div class="text-center text-white mx-auto ">
					<div class="bold brd">
						<h1 >We are selling branded products to our valuable customers.</h1>
					</div>
					<div>
						<div class="row">
							<div class="col-lg-6">
								<p class="h4 bold pt-4">Superior Quality Products </p>
							</div>
							<div class="col-lg-6">
								<p class="h4 bold pt-4">  100% Customer Satisfaction </p>
							</div>
							<div class="col-lg-6">
								<p class="h4 bold pt-4"> Sound Infrastructure  </p>
							</div>
							<div class="col-lg-6">
								<p class="h4 bold pt-4">   Reasonable Rate </p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- paralax end -->
<!-- productcard start -->
	<div class="container pad">
		<div class="row">
		    <div class="col-12">
		        <div class="text-center h2 bold py-4"> Our Special Products</div>
		    </div>
			<div class="col-lg-4 col-md-4 col-12 pb-4 d-flex justify-content-center">
				<div class="product-card">
					<div class="product-container">
						<div class="img-container">
							<img src="images/chakar.webp" class="img-fluid" alt="Chakkar" title="Chakkar">	
						</div>
					</div>
					<div class="prdct-content">
							<h3 class="bold">Chakkar</h3>
							<div class="shopnow">
								<a href="products.php"class="text-white"> Shop Now</a>
							</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12 pb-4 d-flex justify-content-center">
				<div class="product-card">
					<div class="product-container">
						<div class="img-container">
							<img src="images/singlesound.webp" class="img-fluid" alt="Singlesound" title="Singlesound">	
						</div>
					</div>
					<div class="prdct-content">
							<h3 class="bold">Singlesound</h3>
							<div class="shopnow">
								<a href="products.php" class="text-white"> Shop Now</a>
							</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12 pb-4 d-flex justify-content-center">
				<div class="product-card">
					<div class="product-container">
						<div class="img-container">
							<img src="images/gaint.webp" class="img-fluid" alt="Giant" title="Giant">	
						</div>
					</div>
					<div class="prdct-content">
							<h3 class="bold">Giant</h3>
							<div class="shopnow">
								<a href="products.php" class="text-white"> Shop Now</a>
							</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12 pb-4 d-flex justify-content-center">
				<div class="product-card">
					<div class="product-container">
						<div class="img-container">
							<img src="images/pots.webp" class="img-fluid" alt="Flower pots" title="Flower pots">	
						</div>
					</div>
					<div class="prdct-content">
							<h3  class="bold">Flower Pots</h3>
							<div class="shopnow">
								<a href="products.php"class="text-white"> Shop Now</a>
							</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12 pb-4 d-flex justify-content-center">
				<div class="product-card">
					<div class="product-container">
						<div class="img-container">
							<img src="images/sparkle.webp" class="img-fluid" alt="sparkle" title="sparkle">	
						</div>
					</div>
					<div class="prdct-content">
							<h3  class="bold">sparkle</h3>
							<div class="shopnow">
								<a href="products.php" class="text-white"> Shop Now</a>
							</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12 pb-4 d-flex justify-content-center">
				<div class="product-card">
					<div class="product-container">
						<div class="img-container">
							<img src="images/skyshots.webp" class="img-fluid" alt="Skyshots" title="Skyshots">	
						</div>
					</div>
					<div class="prdct-content">
						<h3 class="bold">skyshots</h3>
						<div class="shopnow">
							<a href="products.php" class="text-white" > Shop Now</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- productcard end -->
<!-- seller -->
<div class="top-banner bg-overlay1">
	<div class="container pad">
		<div class="row wc">
			<div class="col-lg-6 col-md-12 col-12 align-self-center">
				<div class="logo d-flex justify-content-space-between align-self-center">
					<img src="images/Fireworks-09-june.gif" class="">
						<span><img src="images/logo.png" class="" alt="Standard logo" title="Standard Logo"></span>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="text-white">
					<h1 class="bold">We are Best Seller in Standard Products</h1>
					<div class="regular">
						We are the leading supplier of  standard products Sparklers, Ground Chakkars, Flower Pots, Fountains, Fancy Crackers, Sound Crackers, Novelty Fireworks, Rockets, Bombs, Twinkling Stars, Elite Crackers, Fancy Deluxe Fountains, Loose Crackers, Electric Crackers, Super Blast Wala Crackers, Fancy Novelties, Multi Colour Shots, Aerial Colour Novelties, Comets and Fireworks Gift Boxes.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- seller -->
<!-- why we choose start -->
<div class="whywe bg-overlay">
	<div class="container pad">
		<div class="row wc">
			<div class="col-lg- 12">
				<div class="text-center">
					<h1 class="bold"> Why We choose?</h1>
					<p class="regular">
						You can buy multi brand crackers from various manufacturers at an affordable price. If you are planning to buy crackers online, then we are the right choice. 
					</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12 py-2">
				<div class="quality text-center">
						<img src="images/quality.png" class="img-fluid w-25 pb-2" alt="Quality" title="Quality">
						<h5 class="bold">Quality</h5>
						<p class="regular">Manufacturing Quality & innovation are the key behind our success.</p>
					</div>
				</div>
		
			<div class="col-lg-3 col-md-6 col-12 py-2">
				<div class="quality text-center">
						<img src="images/tag.png" class="img-fluid w-25 pb-2"alt="Price" title="Price">
						<h5 class="bold">Affordable Price</h5>
						<p class="regular">We are producing safe and compliant crackers with highest quality at low price.</p>
					</div>
				</div>
		
			<div class="col-lg-3 col-md-6 col-12 py-2">
				<div class="quality text-center">
					<img src="images/magic-wand.png" class="img-fluid w-25 pb-2" alt="safe to use" title="safe to use">
					<h5 class="bold">Safe To Use</h5>
					<p class="regular">Crackers we offer are safe and made from fine quality raw materials.</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12 py-2">
				<div class="quality text-center ">
					<img src="images/shake-hands.png" class="img-fluid w-25 pb-2" alt="Customer satisfaction" title="Customer satisfaction">
					<h5 class="bold">Customer Satisfaction</h5>
					<p class="regular">Our quality and timely delivery has attracted customers easily.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- why we choose end -->
<!-- counter start -->
<div class="top-banner bg-overlay1">
    <div class="container pad">
        <div class="row wc text-white">
            <div class="col-lg-4">
                <div class="text-center">
                    <h1 Class="bold">
                        <span class="counter-value plus-class ">10</span>
                    </h1>
                    <h3 class="regular">Years Experience</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <h1 Class="bold">
                        <span class="counter-value plus-class h1">200</span>
                    </h1>
                    <h3 class="regular">Products</h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="text-center">
                    <h1 Class="bold">      
                        <span class="counter-value plus-class h1 text-center">500</span>
                    </h1>
                    <h3 class="regular">Happy Customers</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- counter end -->

<?php include("footer.php");?>
<!-- icon start -->
<div class="fixed point w0">
        <a href="https://api.whatsapp.com/send?phone=919443279881">
            <img src="images/whatsappicon.webp" class="priceicn float-left" alt="whatsapp icon" title="whatsapp icon">
        </a>
    </div>
    <div class="fixed point1 w0 d-none d-lg-block">
        <span class="time-of-year">
            <img src="images/callicon.webp" class="priceicn float-left" alt="call icon" title="call icon">
            <div class="tooltip  text-center text-white"> For More Details Call <br> 
                <span><i class="fa fa-phone "></i> +9163809 04694</span>  <br>
                <span><i class="fa fa-phone"></i> +9163798 26714</span>
            </div>
        </span>
    </div>
    <div class="fixed point1 w0 d-lg-none">
        <a href="tel:+919443279881">
            <img src="images/callicon.webp" class="priceicn float-left" alt="call icon" title="call icon">
        </a>
    </div>
    <div class="fixed point2 blink">
        <a href="products.php">
            <img class="priceicn2 float-right" src="images/preview-2.png" alt="price icon" tittle="price icon">
        </a>
    </div>	
    <!-- icon end -->
	<script>
        $(document).ready(function(){
    $('.plus-class').each(function(){
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        },{
            duration: 3500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now) + "+");
            }
        });
    });
    $('.per').each(function(){
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        },{
            duration: 3500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now) + "%");
            }
        });
    });
});
    </script>
	<script>
    $(document).ready(function(){
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        loop:true,
        margin:20,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
         responsive:{
            0:{
            	items:2
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });
  });
</script>
</body>
</html>