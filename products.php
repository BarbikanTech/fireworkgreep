<?php
include "db/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head itemscope itemtype="http://www.schema.org/website">
	<title>PriceList | Greep Crackers | whole sale crackers | sivakasi fancy crackers |  </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="Greep crackers">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Greep  crackers">
	<meta property="og:url" content="">
	<meta property="og:image" content="">
	<meta name="keywords" content="">
	<meta property="og:description" name="description" content="">
	<meta name="robots" content="all">
	<meta name="revisit-after" content="10 Days">
	<meta name="copyright" content=" crackers">
	<meta name="language" content="English">
	<meta name="distribution" content="Global">
	<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
	<link rel="icon" sizes="192x192" href="images/android-icon-192x192.png">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/wow.js"></script>
	<script src="js/marquee.js"></script>
</head>

<body itemscope itemtype="http://schema.org/WebPage">
	<?php include("header.php"); ?>
	<!-- bannner end -->
	<div class="cart-bg sticky">
		<div class="container">
			<table style="margin: auto;" cellspacing="1" cellpadding="1">
				<tbody>
					<tr>
						<td> Total Products : <span class="product_count"> </span> </td>
						 <td> Discount Total : <span class="discount_total"></span> </td> 
						<td> Overall Total : <span class="overall_total"></span> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="pricelist_products">
		<?php
		// Product Listing Start
		$sql = "SELECT * FROM `category` WHERE `deleted_at`=0 AND `website_active`=1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
		?>
				<table>
					<tbody>
						<tr class="category-row">
							<td colspan="8">
								<?php
								if ($row["discount"] != 0 || $row["discount"] != null) {
									echo $row["category_name"] . " (" . $row["discount"] . "% Discount)";
								} else {
									echo $row["category_name"];
								}

								?>

							</td>
						</tr>
					</tbody>
				</table>
				<div class="container-fluid">
					<div class="row">
						<?php
						$categoryID = $row["id"];
						$categoryDiscount = $row["discount"];
						$productSql = "SELECT * FROM `products` WHERE `category_id` = '$categoryID' AND `deleted_at`='false' AND `active`=1";
						$productResult = $conn->query($productSql);
						if ($productResult->num_rows > 0) {
							while ($productrow = $productResult->fetch_assoc()) {
							    $productimg = ($productrow["img"] == null) ? "images/greep.png" : "uploads/products/" . $productrow["img"];
							      $discount_lock = $productrow["discount_lock"];
                                $videoId = $productrow["video_url"];
                                $videourl = str_replace("https://youtu.be/", "", $videoId);
						?>
								<div class="col-lg-2 col-md-3 col-6 product_row ">
									<div class="prodct-card text-center">
									    
										<a class="text-center pb-2" type="button" data-bs-toggle="modal" data-bs-target="#productmodal_<?php echo $productrow["id"]; ?>">
										    <div class="product-img text-center pb-2">
										        
													<img src='<?php echo $productimg; ?>' class="img-fluid" alt="">
											
										        
										    </div>
										</a>
										<div class="modal fade" id="productmodal_<?php echo $productrow["id"]; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                            <?php echo $productrow["product_name"]; ?>
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                           <img src="<?php echo $productimg; ?>" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <table>
                                                            <tr class="text-center">
                                                                <?php if ($productimg != 'null' && $productimg != "") { ?>
                                                                <td>
                                                                    <button class="btn btn-primary showImage"
                                                                        data-product-id="<?php echo $productrow["id"]; ?>"
                                                                        data-image-url="<?php echo $productimg; ?>"
                                                                        onclick="showImage(this)">Show
                                                                        Image</button>
                                                                </td>
                                                                <?php } ?>
                                                                <?php if ($videourl != 'null' && $videourl != "") { ?>
                                                                <td>
                                                                    <button class="btn btn-primary showVideo"
                                                                        data-product-id="<?php echo $productrow["id"]; ?>"
                                                                        data-video-url="<?php echo $videourl; ?>" onclick="showVideo(this)">Show
                                                                        Video</button>
                                                                </td>
                                                                <?php } ?>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<div class="prdct-name product_name text-center py-1" id="<?php echo $productrow["id"]; ?>">
											<?php echo $productrow["product_name"]; ?>
										</div>
										<div class="prodct-content py-2 text-center">
											<span class="product-content"><?php echo $productrow["product_content"]; ?></span>
										</div>
										<div class="prdct-price">
										    <span class="strike d-none"><?php echo $productrow["price"]; ?></span>
											<span class="strikes"><?php if($productrow["discount_lock"] == 0){ echo $productrow["price"];} ?></span>
											<span class="price"><?php if($discount_lock !=null && $discount_lock !="null" && $discount_lock == 0){ echo ($productrow["price"] - ($productrow["price"] * $categoryDiscount / 100)); } else{ echo $productrow["price"];} ?></span>
										</div>
										<div class="amount" style="margin-left: 44px;"> <input type="text" name="amount" class="form-control rate_box price-box amount_<?php echo $productrow["id"]; ?>" placeholder="Price" disabled>
										</div>
										<div class="prdct-qty ">
											<span class="minus">-</span>
											<input type="text" name="quantity" class="form-control qty_box prdct-box quantity_<?php echo $productrow["id"]; ?>" placeholder="Qty" onFocus="Javascript:CalProductAmount(this);" onBlur="Javascript:CalProductAmount(this);" onKeyup="Javascript:CalProductAmount(this);" onChange="Javascript:CalProductAmount(this);">
											<span class="plus">+</span>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>

					</div>
				</div>

		<?php

			}
		}

		// End Product Listing
		?>
	</div>
	<!-- <div class="container-fluid fullpad">
		<div class="row">
			<div class="col-lg-2 col-md-3 col-6">
				<div class="prodct-card">
					<div class="product-img text-center">
						<a href="" class=""><img src="images/greep.png" class="img-fluid" alt="">	</a>
					</div>
					<div class="product-code">
						<span>1</span>
					</div>
					<div class="prodct-content text-center">
						<span>1 Box</span>
					</div>
					<div class="prdct-price">
						<span><i class="fa fa-inr"></i> <span class="strike">100.00</span></span>
						<span><i class="fa fa-inr"></i><span class="price">70</span></span>
					</div>
					<div class="amount" style="margin-left: 44px;"> 
						<input type="text" name="amount" class="form-control rate_box price-box amount_1" placeholder="Price" disabled value="1">
					</div>
					<div class="prdct-qty ">
						<span class="minus">-</span>
						<input type="text" name="quantity" value="1" class="form-control qty_box prdct-box quantity_1" placeholder="Qty" onFocus="Javascript:CalProductAmount(this);" onBlur="Javascript:CalProductAmount(this);" onKeyup="Javascript:CalProductAmount(this);" onChange="Javascript:CalProductAmount(this);">
						<span class="plus">+</span>					
					</div>
				</div>
			</div>	
		</div>
	</div> -->
	<div class="fixed point2">
		<div class="nav-trigger smallbutton btncart" data-bs-toggle="offcanvas" data-bs-target="#productscart" onclick="Javascript:showCartPage();">
			<span style="font-size:30px;cursor:pointer">
				<i class="fa fa-shopping-cart"></i>
			</span>
			<div class="product-count">
				<span class="product_count"></span>
			</div>
		</div>
	</div>
	<div class="offcanvas offcanvas-end sidenav" tabindex="-1" id="productscart">
		<div class="container">
			<div class="offcanvas-header">
				<a class=" btn-close p-4" data-bs-dismiss="offcanvas"></a>
			</div>
			<div class="w-100 mt-3">
				<h5 class="text-white text-center heading4">Greep Crackers</h5>
				<div class="w-100 text-center text-white">NH7 , Pillayar Kovil opposite , Near Tollgate , Etturvattam , Sattur. </div>
				<div class="w-100 text-center text-white mb-3"> Mobile No : +91 63809 04694 </div>
			</div>
			<div class="w-100 pb-3 leftbg" style="display: inline-block;">
				<div class="table-responsive pb-3">
					<table cellpadding="0" cellspacing="0" class="pricelist_table table card_products_table mb-0">
						<thead>
							<tr>
								<td>Image</td>
								<td>Name</td>
								<td style="width: 75px;">Qty/Price</td>
								<td style="width: 125px;" class="text-center">Total</td>
								<td></td>
							</tr>
						</thead>
						<tbody id="demo">
							<tr class="product_row">
								<td class="text-center">
									<div class="product-img text-center pb-2">
										<img src="images/ftlogo.png" class="img-fluid" alt="">
									</div>
								</td>
								<td class="product_name text-left" style="width:100%">Ground Chakar asoka big (25pcs)</td>
								<td class="quantity text-center">
									<Form>
										<input type="text" class="prdct-box" placeholder="Qty">
										<span class="actual_price"><i class="fa fa-inr"></i>55</span>
									</Form>
								</td>
								<td class="amount text-center">
									<span class="actual_price">110</span>
								</td>
								<td class="amount text-center">
									<span class="fa fa-times"></span>
								</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="d-flex px-3">
					<p class="bill1 roboto"><span class="heading6"> Net Total </span>
						<span class="fnt1">
							<i class="fa fa-inr"></i>
							<span class="net_total"></span>
						</span>
					</p>
				</div>
				<div class="d-flex px-3">
					<p class="bill1 roboto">
						<span class="heading6"> Discount Total </span>
						<span class="fnt1"><i class="fa fa-inr"></i>
							<span class="discount_total sub_total"></span>
						</span>
					</p>
				</div>
				<div class="d-flex px-3">
					<p class="bill1 roboto">
						<span class="heading6"> Sub Total </span>
						<span class="fnt1"><i class="fa fa-inr"></i>
							<span class="sub_total"></span>
						</span>
					</p>
				</div>
				<div class="p-4" id="cnf-estimate">
                    <p class="roboto" id="#enq-form" data-bs-toggle="offcanvas" data-bs-target="#enq-form">
                        <span id="button-enq">
                        </span>
                    </p>
                </div>
                <div class="warning-message">
                    <center>
                        <p id="warningMessage"></p>
                    </center>
                </div>
			</div>
		</div>
	</div>
	<div class="offcanvas offcanvas-end sidenav" tabindex="-1" id="enq-form">
		<div class="container">
			<div class="offcanvas-header">
				<a class=" btn-close p-4" data-bs-dismiss="offcanvas"></a>
			</div>
			<div class="w-100 mt-3">
				<h5 class="text-white text-center heading4">Greep Crackers</h5>
				<div class="w-100 text-center text-white">NH7 , Pillayar Kovil opposite , Near Tollgate , Etturvattam , Sattur. </div>
				<div class="w-100 text-center text-white mb-3"> Mobile No : +91 63809 04694 </div>
			</div>
			<div class="enq-form">
				<form name="order_form">
                    <div class=" mb-3">
                        <select class="form-select form-control" name="state" id="stateDropdown">
                            <option value="" selected>Select the State</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>

                            <!-- Add more state options here -->
                        </select>
                        <span id="exclamation">
                            <span class="customer-error" id="stateError"></span>
                        </span>

                    </div>
                    <div class="mb-3">
                        <select class="form-select form-control" name="city" id="districtDropdown"
                            aria-label="Default select example">
                            <option value="">Others</option>
                            <!-- Add more city options here -->
                        </select>
                        <span id="exclamation">
                            <span class="errorval" id="cityError"></span>
                        </span>

                    </div>
                    <div class="form-label-group in-border mb-3">
                        <input type="text" name="name" value="" class="form-control shadow-none"
                            placeholder="Customer Name*">
                        <span id="exclamation">
                            <span class="errorval" id="nameError"></span>
                        </span>
                    </div>
                    <div class="form-label-group in-border mb-3">
                        <input type="MobileNumber" name="mobile_number" value="" class="form-control shadow-none"
                            placeholder="Mobile Number*">
                        <span id="exclamation">
                            <span class="errorval" id="noError"></span>
                        </span>
                    </div>
                    <div class="form-label-group in-border mb-3">
                        <input type="text" name="email" value="" class="form-control shadow-none" placeholder="email">
                    </div>
                    <div class="form-label-group in-border mb-0">
                        <textarea name="address" id="address" class="form-control" placeholder="Address*"></textarea>
                        <span id="exclamation">
                            <span class="errorval" id="adderssError"></span>
                        </span>
                    </div>
                    <div class="w-100 text-center my-2">
                        <button class="btn btn-success btnwidth submit_button" type="button"
                            onclick="Javascript:SaveOrder(event);">Submit</button> &nbsp;
                        <button class="btn btn-danger btnwidth" type="button" data-bs-toggle="offcanvas" data-bs-target="#productscart">Back</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
	<script src="js/calculation.js"></script>
	<script src="js/list.js"></script>
	<script src="js/common.js"></script>
	<script>
		new WOW().init();
	</script>
	 <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Define an object to map states to districts
        const districtData = {
            "Andaman and Nicobar Islands": ["Port Blair"],
            "Haryana": [
                "Faridabad",
                "Gurgaon",
                "Hisar",
                "Rohtak",
                "Panipat",
                "Karnal",
                "Sonipat",
                "Yamunanagar",
                "Panchkula",
                "Bhiwani",
                "Bahadurgarh",
                "Jind",
                "Sirsa",
                "Thanesar",
                "Kaithal",
                "Palwal",
                "Rewari",
                "Hansi",
                "Narnaul",
                "Fatehabad",
                "Gohana",
                "Tohana",
                "Narwana",
                "Mandi Dabwali",
                "Charkhi Dadri",
                "Shahbad",
                "Pehowa",
                "Samalkha",
                "Pinjore",
                "Ladwa",
                "Sohna",
                "Safidon",
                "Taraori",
                "Mahendragarh",
                "Ratia",
                "Rania",
                "Sarsod"
            ],
            "Tamil Nadu": [
                "Chennai",
                "Coimbatore",
                "Madurai",
                "Tiruchirappalli",
                "Salem",
                "Tirunelveli",
                "Tiruppur",
                "Ranipet",
                "Nagercoil",
                "Thanjavur",
                "Vellore",
                "Kancheepuram",
                "Erode",
                "Tiruvannamalai",
                "Pollachi",
                "Rajapalayam",
                "Sivakasi",
                "Pudukkottai",
                "Neyveli (TS)",
                "Nagapattinam",
                "Viluppuram",
                "Tiruchengode",
                "Vaniyambadi",
                "Theni Allinagaram",
                "Udhagamandalam",
                "Aruppukkottai",
                "Paramakudi",
                "Arakkonam",
                "Virudhachalam",
                "Srivilliputhur",
                "Tindivanam",
                "Virudhunagar",
                "Karur",
                "Valparai",
                "Sankarankovil",
                "Tenkasi",
                "Palani",
                "Pattukkottai",
                "Tirupathur",
                "Ramanathapuram",
                "Udumalaipettai",
                "Gobichettipalayam",
                "Thiruvarur",
                "Thiruvallur",
                "Panruti",
                "Namakkal",
                "Thirumangalam",
                "Vikramasingapuram",
                "Nellikuppam",
                "Rasipuram",
                "Tiruttani",
                "Nandivaram-Guduvancheri",
                "Periyakulam",
                "Pernampattu",
                "Vellakoil",
                "Sivaganga",
                "Vadalur",
                "Rameshwaram",
                "Tiruvethipuram",
                "Perambalur",
                "Usilampatti",
                "Vedaranyam",
                "Sathyamangalam",
                "Puliyankudi",
                "Nanjikottai",
                "Thuraiyur",
                "Sirkali",
                "Tiruchendur",
                "Periyasemur",
                "Sattur",
                "Vandavasi",
                "Tharamangalam",
                "Tirukkoyilur",
                "Oddanchatram",
                "Palladam",
                "Vadakkuvalliyur",
                "Tirukalukundram",
                "Uthamapalayam",
                "Surandai",
                "Sankari",
                "Shenkottai",
                "Vadipatti",
                "Sholingur",
                "Tirupathur",
                "Manachanallur",
                "Viswanatham",
                "Polur",
                "Panagudi",
                "Uthiramerur",
                "Thiruthuraipoondi",
                "Pallapatti",
                "Ponneri",
                "Lalgudi",
                "Natham",
                "Unnamalaikadai",
                "P.N.Patti",
                "Tharangambadi",
                "Tittakudi",
                "Pacode",
                "O' Valley",
                "Suriyampalayam",
                "Sholavandan",
                "Thammampatti",
                "Namagiripettai",
                "Peravurani",
                "Parangipettai",
                "Pudupattinam",
                "Pallikonda",
                "Sivagiri",
                "Punjaipugalur",
                "Padmanabhapuram",
                "Thirupuvanam"
            ],
            "Madhya Pradesh": [
                "Indore",
                "Bhopal",
                "Jabalpur",
                "Gwalior",
                "Ujjain",
                "Sagar",
                "Ratlam",
                "Satna",
                "Murwara (Katni)",
                "Morena",
                "Singrauli",
                "Rewa",
                "Vidisha",
                "Ganjbasoda",
                "Shivpuri",
                "Mandsaur",
                "Neemuch",
                "Nagda",
                "Itarsi",
                "Sarni",
                "Sehore",
                "Mhow Cantonment",
                "Seoni",
                "Balaghat",
                "Ashok Nagar",
                "Tikamgarh",
                "Shahdol",
                "Pithampur",
                "Alirajpur",
                "Mandla",
                "Sheopur",
                "Shajapur",
                "Panna",
                "Raghogarh-Vijaypur",
                "Sendhwa",
                "Sidhi",
                "Pipariya",
                "Shujalpur",
                "Sironj",
                "Pandhurna",
                "Nowgong",
                "Mandideep",
                "Sihora",
                "Raisen",
                "Lahar",
                "Maihar",
                "Sanawad",
                "Sabalgarh",
                "Umaria",
                "Porsa",
                "Narsinghgarh",
                "Malaj Khand",
                "Sarangpur",
                "Mundi",
                "Nepanagar",
                "Pasan",
                "Mahidpur",
                "Seoni-Malwa",
                "Rehli",
                "Manawar",
                "Rahatgarh",
                "Panagar",
                "Wara Seoni",
                "Tarana",
                "Sausar",
                "Rajgarh",
                "Niwari",
                "Mauganj",
                "Manasa",
                "Nainpur",
                "Prithvipur",
                "Sohagpur",
                "Nowrozabad (Khodargama)",
                "Shamgarh",
                "Maharajpur",
                "Multai",
                "Pali",
                "Pachore",
                "Rau",
                "Mhowgaon",
                "Vijaypur",
                "Narsinghgarh"
            ],
            "Jharkhand": [
                "Dhanbad",
                "Ranchi",
                "Jamshedpur",
                "Bokaro Steel City",
                "Deoghar",
                "Phusro",
                "Adityapur",
                "Hazaribag",
                "Giridih",
                "Ramgarh",
                "Jhumri Tilaiya",
                "Saunda",
                "Sahibganj",
                "Medininagar (Daltonganj)",
                "Chaibasa",
                "Chatra",
                "Gumia",
                "Dumka",
                "Madhupur",
                "Chirkunda",
                "Pakaur",
                "Simdega",
                "Musabani",
                "Mihijam",
                "Patratu",
                "Lohardaga",
                "Tenu dam-cum-Kathhara"
            ],
            "Mizoram": ["Aizawl", "Lunglei", "Saiha"],
            "Nagaland": [
                "Dimapur",
                "Kohima",
                "Zunheboto",
                "Tuensang",
                "Wokha",
                "Mokokchung"
            ],
            "Himachal Pradesh": [
                "Shimla",
                "Mandi",
                "Solan",
                "Nahan",
                "Sundarnagar",
                "Palampur",
                "Kullu"
            ],
            "Tripura": [
                "Agartala",
                "Udaipur",
                "Dharmanagar",
                "Pratapgarh",
                "Kailasahar",
                "Belonia",
                "Khowai"
            ],
            "Andhra Pradesh": [
                "Visakhapatnam",
                "Vijayawada",
                "Guntur",
                "Nellore",
                "Kurnool",
                "Rajahmundry",
                "Kakinada",
                "Tirupati",
                "Anantapur",
                "Kadapa",
                "Vizianagaram",
                "Eluru",
                "Ongole",
                "Nandyal",
                "Machilipatnam",
                "Adoni",
                "Tenali",
                "Chittoor",
                "Hindupur",
                "Proddatur",
                "Bhimavaram",
                "Madanapalle",
                "Guntakal",
                "Dharmavaram",
                "Gudivada",
                "Srikakulam",
                "Narasaraopet",
                "Rajampet",
                "Tadpatri",
                "Tadepalligudem",
                "Chilakaluripet",
                "Yemmiganur",
                "Kadiri",
                "Chirala",
                "Anakapalle",
                "Kavali",
                "Palacole",
                "Sullurpeta",
                "Tanuku",
                "Rayachoti",
                "Srikalahasti",
                "Bapatla",
                "Naidupet",
                "Nagari",
                "Gudur",
                "Vinukonda",
                "Narasapuram",
                "Nuzvid",
                "Markapur",
                "Ponnur",
                "Kandukur",
                "Bobbili",
                "Rayadurg",
                "Samalkot",
                "Jaggaiahpet",
                "Tuni",
                "Amalapuram",
                "Bheemunipatnam",
                "Venkatagiri",
                "Sattenapalle",
                "Pithapuram",
                "Palasa Kasibugga",
                "Parvathipuram",
                "Macherla",
                "Gooty",
                "Salur",
                "Mandapeta",
                "Jammalamadugu",
                "Peddapuram",
                "Punganur",
                "Nidadavole",
                "Repalle",
                "Ramachandrapuram",
                "Kovvur",
                "Tiruvuru",
                "Uravakonda",
                "Narsipatnam",
                "Yerraguntla",
                "Pedana",
                "Puttur",
                "Renigunta",
                "Rajam",
                "Srisailam Project (Right Flank Colony) Township"
            ],
            "Punjab": [
                "Ludhiana",
                "Patiala",
                "Amritsar",
                "Jalandhar",
                "Bathinda",
                "Pathankot",
                "Hoshiarpur",
                "Batala",
                "Moga",
                "Malerkotla",
                "Khanna",
                "Mohali",
                "Barnala",
                "Firozpur",
                "Phagwara",
                "Kapurthala",
                "Zirakpur",
                "Kot Kapura",
                "Faridkot",
                "Muktsar",
                "Rajpura",
                "Sangrur",
                "Fazilka",
                "Gurdaspur",
                "Kharar",
                "Gobindgarh",
                "Mansa",
                "Malout",
                "Nabha",
                "Tarn Taran",
                "Jagraon",
                "Sunam",
                "Dhuri",
                "Firozpur Cantt.",
                "Sirhind Fatehgarh Sahib",
                "Rupnagar",
                "Jalandhar Cantt.",
                "Samana",
                "Nawanshahr",
                "Rampura Phul",
                "Nangal",
                "Nakodar",
                "Zira",
                "Patti",
                "Raikot",
                "Longowal",
                "Urmar Tanda",
                "Morinda, India",
                "Phillaur",
                "Pattran",
                "Qadian",
                "Sujanpur",
                "Mukerian",
                "Talwara"
            ],
            "Chandigarh": ["Chandigarh"],
            "Rajasthan": [
                "Jaipur",
                "Jodhpur",
                "Bikaner",
                "Udaipur",
                "Ajmer",
                "Bhilwara",
                "Alwar",
                "Bharatpur",
                "Pali",
                "Barmer",
                "Sikar",
                "Tonk",
                "Sadulpur",
                "Sawai Madhopur",
                "Nagaur",
                "Makrana",
                "Sujangarh",
                "Sardarshahar",
                "Ladnu",
                "Ratangarh",
                "Nokha",
                "Nimbahera",
                "Suratgarh",
                "Rajsamand",
                "Lachhmangarh",
                "Rajgarh (Churu)",
                "Nasirabad",
                "Nohar",
                "Phalodi",
                "Nathdwara",
                "Pilani",
                "Merta City",
                "Sojat",
                "Neem-Ka-Thana",
                "Sirohi",
                "Pratapgarh",
                "Rawatbhata",
                "Sangaria",
                "Lalsot",
                "Pilibanga",
                "Pipar City",
                "Taranagar",
                "Vijainagar, Ajmer",
                "Sumerpur",
                "Sagwara",
                "Ramganj Mandi",
                "Lakheri",
                "Udaipurwati",
                "Losal",
                "Sri Madhopur",
                "Ramngarh",
                "Rawatsar",
                "Rajakhera",
                "Shahpura",
                "Shahpura",
                "Raisinghnagar",
                "Malpura",
                "Nadbai",
                "Sanchore",
                "Nagar",
                "Rajgarh (Alwar)",
                "Sheoganj",
                "Sadri",
                "Todaraisingh",
                "Todabhim",
                "Reengus",
                "Rajaldesar",
                "Sadulshahar",
                "Sambhar",
                "Prantij",
                "Mount Abu",
                "Mangrol",
                "Phulera",
                "Mandawa",
                "Pindwara",
                "Mandalgarh",
                "Takhatgarh"
            ],
            "Assam": [
                "Guwahati",
                "Silchar",
                "Dibrugarh",
                "Nagaon",
                "Tinsukia",
                "Jorhat",
                "Bongaigaon City",
                "Dhubri",
                "Diphu",
                "North Lakhimpur",
                "Tezpur",
                "Karimganj",
                "Sibsagar",
                "Goalpara",
                "Barpeta",
                "Lanka",
                "Lumding",
                "Mankachar",
                "Nalbari",
                "Rangia",
                "Margherita",
                "Mangaldoi",
                "Silapathar",
                "Mariani",
                "Marigaon"
            ],
            "Odisha": [
                "Bhubaneswar",
                "Cuttack",
                "Raurkela",
                "Brahmapur",
                "Sambalpur",
                "Puri",
                "Baleshwar Town",
                "Baripada Town",
                "Bhadrak",
                "Balangir",
                "Jharsuguda",
                "Bargarh",
                "Paradip",
                "Bhawanipatna",
                "Dhenkanal",
                "Barbil",
                "Kendujhar",
                "Sunabeda",
                "Rayagada",
                "Jatani",
                "Byasanagar",
                "Kendrapara",
                "Rajagangapur",
                "Parlakhemundi",
                "Talcher",
                "Sundargarh",
                "Phulabani",
                "Pattamundai",
                "Titlagarh",
                "Nabarangapur",
                "Soro",
                "Malkangiri",
                "Rairangpur",
                "Tarbha"
            ],
            "Chhattisgarh": [
                "Raipur",
                "Bhilai Nagar",
                "Korba",
                "Bilaspur",
                "Durg",
                "Rajnandgaon",
                "Jagdalpur",
                "Raigarh",
                "Ambikapur",
                "Mahasamund",
                "Dhamtari",
                "Chirmiri",
                "Bhatapara",
                "Dalli-Rajhara",
                "Naila Janjgir",
                "Tilda Newra",
                "Mungeli",
                "Manendragarh",
                "Sakti"
            ],
            "Jammu and Kashmir": [
                "Srinagar",
                "Jammu",
                "Baramula",
                "Anantnag",
                "Sopore",
                "KathUrban Agglomeration",
                "Rajauri",
                "Punch",
                "Udhampur"
            ],
            "Karnataka": [
                "Bengaluru",
                "Hubli-Dharwad",
                "Belagavi",
                "Mangaluru",
                "Davanagere",
                "Ballari",
                "Mysore",
                "Tumkur",
                "Shivamogga",
                "Raayachuru",
                "Robertson Pet",
                "Kolar",
                "Mandya",
                "Udupi",
                "Chikkamagaluru",
                "Karwar",
                "Ranebennuru",
                "Ranibennur",
                "Ramanagaram",
                "Gokak",
                "Yadgir",
                "Rabkavi Banhatti",
                "Shahabad",
                "Sirsi",
                "Sindhnur",
                "Tiptur",
                "Arsikere",
                "Nanjangud",
                "Sagara",
                "Sira",
                "Puttur",
                "Athni",
                "Mulbagal",
                "Surapura",
                "Siruguppa",
                "Mudhol",
                "Sidlaghatta",
                "Shahpur",
                "Saundatti-Yellamma",
                "Wadi",
                "Manvi",
                "Nelamangala",
                "Lakshmeshwar",
                "Ramdurg",
                "Nargund",
                "Tarikere",
                "Malavalli",
                "Savanur",
                "Lingsugur",
                "Vijayapura",
                "Sankeshwara",
                "Madikeri",
                "Talikota",
                "Sedam",
                "Shikaripur",
                "Mahalingapura",
                "Mudalagi",
                "Muddebihal",
                "Pavagada",
                "Malur",
                "Sindhagi",
                "Sanduru",
                "Afzalpur",
                "Maddur",
                "Madhugiri",
                "Tekkalakote",
                "Terdal",
                "Mudabidri",
                "Magadi",
                "Navalgund",
                "Shiggaon",
                "Shrirangapattana",
                "Sindagi",
                "Sakaleshapura",
                "Srinivaspur",
                "Ron",
                "Mundargi",
                "Sadalagi",
                "Piriyapatna",
                "Adyar"
            ],
            "Manipur": ["Imphal", "Thoubal", "Lilong", "Mayang Imphal"],
            "Kerala": [
                "Thiruvananthapuram",
                "Kochi",
                "Kozhikode",
                "Kollam",
                "Thrissur",
                "Palakkad",
                "Alappuzha",
                "Malappuram",
                "Ponnani",
                "Vatakara",
                "Kanhangad",
                "Taliparamba",
                "Koyilandy",
                "Neyyattinkara",
                "Kayamkulam",
                "Nedumangad",
                "Kannur",
                "Tirur",
                "Kottayam",
                "Kasaragod",
                "Kunnamkulam",
                "Ottappalam",
                "Thiruvalla",
                "Thodupuzha",
                "Chalakudy",
                "Changanassery",
                "Punalur",
                "Nilambur",
                "Cherthala",
                "Perinthalmanna",
                "Mattannur",
                "Shoranur",
                "Varkala",
                "Paravoor",
                "Pathanamthitta",
                "Peringathur",
                "Attingal",
                "Kodungallur",
                "Pappinisseri",
                "Chittur-Thathamangalam",
                "Muvattupuzha",
                "Adoor",
                "Mavelikkara",
                "Mavoor",
                "Perumbavoor",
                "Vaikom",
                "Palai",
                "Panniyannur",
                "Guruvayoor",
                "Puthuppally",
                "Panamattom"
            ],
            "Delhi": ["Delhi", "New Delhi"],
            "Dadra and Nagar Haveli": ["Silvassa"],
            "Puducherry": ["Pondicherry", "Karaikal", "Yanam", "Mahe"],
            "Uttarakhand": [
                "Dehradun",
                "Hardwar",
                "Haldwani-cum-Kathgodam",
                "Srinagar",
                "Kashipur",
                "Roorkee",
                "Rudrapur",
                "Rishikesh",
                "Ramnagar",
                "Pithoragarh",
                "Manglaur",
                "Nainital",
                "Mussoorie",
                "Tehri",
                "Pauri",
                "Nagla",
                "Sitarganj",
                "Bageshwar"
            ],
            "Uttar Pradesh": [
                "Lucknow",
                "Kanpur",
                "Firozabad",
                "Agra",
                "Meerut",
                "Varanasi",
                "Allahabad",
                "Amroha",
                "Moradabad",
                "Aligarh",
                "Saharanpur",
                "Noida",
                "Loni",
                "Jhansi",
                "Shahjahanpur",
                "Rampur",
                "Modinagar",
                "Hapur",
                "Etawah",
                "Sambhal",
                "Orai",
                "Bahraich",
                "Unnao",
                "Rae Bareli",
                "Lakhimpur",
                "Sitapur",
                "Lalitpur",
                "Pilibhit",
                "Chandausi",
                "Hardoi ",
                "Azamgarh",
                "Khair",
                "Sultanpur",
                "Tanda",
                "Nagina",
                "Shamli",
                "Najibabad",
                "Shikohabad",
                "Sikandrabad",
                "Shahabad, Hardoi",
                "Pilkhuwa",
                "Renukoot",
                "Vrindavan",
                "Ujhani",
                "Laharpur",
                "Tilhar",
                "Sahaswan",
                "Rath",
                "Sherkot",
                "Kalpi",
                "Tundla",
                "Sandila",
                "Nanpara",
                "Sardhana",
                "Nehtaur",
                "Seohara",
                "Padrauna",
                "Mathura",
                "Thakurdwara",
                "Nawabganj",
                "Siana",
                "Noorpur",
                "Sikandra Rao",
                "Puranpur",
                "Rudauli",
                "Thana Bhawan",
                "Palia Kalan",
                "Zaidpur",
                "Nautanwa",
                "Zamania",
                "Shikarpur, Bulandshahr",
                "Naugawan Sadat",
                "Fatehpur Sikri",
                "Shahabad, Rampur",
                "Robertsganj",
                "Utraula",
                "Sadabad",
                "Rasra",
                "Lar",
                "Lal Gopalganj Nindaura",
                "Sirsaganj",
                "Pihani",
                "Shamsabad, Agra",
                "Rudrapur",
                "Soron",
                "SUrban Agglomerationr",
                "Samdhan",
                "Sahjanwa",
                "Rampur Maniharan",
                "Sumerpur",
                "Shahganj",
                "Tulsipur",
                "Tirwaganj",
                "PurqUrban Agglomerationzi",
                "Shamsabad, Farrukhabad",
                "Warhapur",
                "Powayan",
                "Sandi",
                "Achhnera",
                "Naraura",
                "Nakur",
                "Sahaspur",
                "Safipur",
                "Reoti",
                "Sikanderpur",
                "Saidpur",
                "Sirsi",
                "Purwa",
                "Parasi",
                "Lalganj",
                "Phulpur",
                "Shishgarh",
                "Sahawar",
                "Samthar",
                "Pukhrayan",
                "Obra",
                "Niwai",
                "Mirzapur"
            ],
            "Bihar": [
                "Patna",
                "Gaya",
                "Bhagalpur",
                "Muzaffarpur",
                "Darbhanga",
                "Arrah",
                "Begusarai",
                "Chhapra",
                "Katihar",
                "Munger",
                "Purnia",
                "Saharsa",
                "Sasaram",
                "Hajipur",
                "Dehri-on-Sone",
                "Bettiah",
                "Motihari",
                "Bagaha",
                "Siwan",
                "Kishanganj",
                "Jamalpur",
                "Buxar",
                "Jehanabad",
                "Aurangabad",
                "Lakhisarai",
                "Nawada",
                "Jamui",
                "Sitamarhi",
                "Araria",
                "Gopalganj",
                "Madhubani",
                "Masaurhi",
                "Samastipur",
                "Mokameh",
                "Supaul",
                "Dumraon",
                "Arwal",
                "Forbesganj",
                "BhabUrban Agglomeration",
                "Narkatiaganj",
                "Naugachhia",
                "Madhepura",
                "Sheikhpura",
                "Sultanganj",
                "Raxaul Bazar",
                "Ramnagar",
                "Mahnar Bazar",
                "Warisaliganj",
                "Revelganj",
                "Rajgir",
                "Sonepur",
                "Sherghati",
                "Sugauli",
                "Makhdumpur",
                "Maner",
                "Rosera",
                "Nokha",
                "Piro",
                "Rafiganj",
                "Marhaura",
                "Mirganj",
                "Lalganj",
                "Murliganj",
                "Motipur",
                "Manihari",
                "Sheohar",
                "Maharajganj",
                "Silao",
                "Barh",
                "Asarganj"
            ],
            "Gujarat": [
                "Ahmedabad",
                "Surat",
                "Vadodara",
                "Rajkot",
                "Bhavnagar",
                "Jamnagar",
                "Nadiad",
                "Porbandar",
                "Anand",
                "Morvi",
                "Mahesana",
                "Bharuch",
                "Vapi",
                "Navsari",
                "Veraval",
                "Bhuj",
                "Godhra",
                "Palanpur",
                "Valsad",
                "Patan",
                "Deesa",
                "Amreli",
                "Anjar",
                "Dhoraji",
                "Khambhat",
                "Mahuva",
                "Keshod",
                "Wadhwan",
                "Ankleshwar",
                "Savarkundla",
                "Kadi",
                "Visnagar",
                "Upleta",
                "Una",
                "Sidhpur",
                "Unjha",
                "Mangrol",
                "Viramgam",
                "Modasa",
                "Palitana",
                "Petlad",
                "Kapadvanj",
                "Sihor",
                "Wankaner",
                "Limbdi",
                "Mandvi",
                "Thangadh",
                "Vyara",
                "Padra",
                "Lunawada",
                "Rajpipla",
                "Vapi",
                "Umreth",
                "Sanand",
                "Rajula",
                "Radhanpur",
                "Mahemdabad",
                "Ranavav",
                "Tharad",
                "Mansa",
                "Umbergaon",
                "Talaja",
                "Vadnagar",
                "Manavadar",
                "Salaya",
                "Vijapur",
                "Pardi",
                "Rapar",
                "Songadh",
                "Lathi",
                "Adalaj",
                "Chhapra",
                "Gandhinagar"
            ],
            "Telangana": [
                "Hyderabad",
                "Warangal",
                "Nizamabad",
                "Karimnagar",
                "Ramagundam",
                "Khammam",
                "Mahbubnagar",
                "Mancherial",
                "Adilabad",
                "Suryapet",
                "Jagtial",
                "Miryalaguda",
                "Nirmal",
                "Kamareddy",
                "Kothagudem",
                "Bodhan",
                "Palwancha",
                "Mandamarri",
                "Koratla",
                "Sircilla",
                "Tandur",
                "Siddipet",
                "Wanaparthy",
                "Kagaznagar",
                "Gadwal",
                "Sangareddy",
                "Bellampalle",
                "Bhongir",
                "Vikarabad",
                "Jangaon",
                "Bhadrachalam",
                "Bhainsa",
                "Farooqnagar",
                "Medak",
                "Narayanpet",
                "Sadasivpet",
                "Yellandu",
                "Manuguru",
                "Kyathampalle",
                "Nagarkurnool"
            ],
            "Meghalaya": ["Shillong", "Tura", "Nongstoin"],
            "Himachal Praddesh": ["Manali"],
            "Arunachal Pradesh": ["Naharlagun", "Pasighat"],
            "Maharashtra": [
                "Mumbai",
                "Pune",
                "Nagpur",
                "Thane",
                "Nashik",
                "Kalyan-Dombivali",
                "Vasai-Virar",
                "Solapur",
                "Mira-Bhayandar",
                "Bhiwandi",
                "Amravati",
                "Nanded-Waghala",
                "Sangli",
                "Malegaon",
                "Akola",
                "Latur",
                "Dhule",
                "Ahmednagar",
                "Ichalkaranji",
                "Parbhani",
                "Panvel",
                "Yavatmal",
                "Achalpur",
                "Osmanabad",
                "Nandurbar",
                "Satara",
                "Wardha",
                "Udgir",
                "Aurangabad",
                "Amalner",
                "Akot",
                "Pandharpur",
                "Shrirampur",
                "Parli",
                "Washim",
                "Ambejogai",
                "Manmad",
                "Ratnagiri",
                "Uran Islampur",
                "Pusad",
                "Sangamner",
                "Shirpur-Warwade",
                "Malkapur",
                "Wani",
                "Lonavla",
                "Talegaon Dabhade",
                "Anjangaon",
                "Umred",
                "Palghar",
                "Shegaon",
                "Ozar",
                "Phaltan",
                "Yevla",
                "Shahade",
                "Vita",
                "Umarkhed",
                "Warora",
                "Pachora",
                "Tumsar",
                "Manjlegaon",
                "Sillod",
                "Arvi",
                "Nandura",
                "Vaijapur",
                "Wadgaon Road",
                "Sailu",
                "Murtijapur",
                "Tasgaon",
                "Mehkar",
                "Yawal",
                "Pulgaon",
                "Nilanga",
                "Wai",
                "Umarga",
                "Paithan",
                "Rahuri",
                "Nawapur",
                "Tuljapur",
                "Morshi",
                "Purna",
                "Satana",
                "Pathri",
                "Sinnar",
                "Uchgaon",
                "Uran",
                "Pen",
                "Karjat",
                "Manwath",
                "Partur",
                "Sangole",
                "Mangrulpir",
                "Risod",
                "Shirur",
                "Savner",
                "Sasvad",
                "Pandharkaoda",
                "Talode",
                "Shrigonda",
                "Shirdi",
                "Raver",
                "Mukhed",
                "Rajura",
                "Vadgaon Kasba",
                "Tirora",
                "Mahad",
                "Lonar",
                "Sawantwadi",
                "Pathardi",
                "Pauni",
                "Ramtek",
                "Mul",
                "Soyagaon",
                "Mangalvedhe",
                "Narkhed",
                "Shendurjana",
                "Patur",
                "Mhaswad",
                "Loha",
                "Nandgaon",
                "Warud"
            ],
            "Goa": ["Marmagao", "Panaji", "Margao", "Mapusa"],
            "West Bengal": [
                "Kolkata",
                "Siliguri",
                "Asansol",
                "Raghunathganj",
                "Kharagpur",
                "Naihati",
                "English Bazar",
                "Baharampur",
                "Hugli-Chinsurah",
                "Raiganj",
                "Jalpaiguri",
                "Santipur",
                "Balurghat",
                "Medinipur",
                "Habra",
                "Ranaghat",
                "Bankura",
                "Nabadwip",
                "Darjiling",
                "Purulia",
                "Arambagh",
                "Tamluk",
                "AlipurdUrban Agglomerationr",
                "Suri",
                "Jhargram",
                "Gangarampur",
                "Rampurhat",
                "Kalimpong",
                "Sainthia",
                "Taki",
                "Murshidabad",
                "Memari",
                "Paschim Punropara",
                "Tarakeswar",
                "Sonamukhi",
                "PandUrban Agglomeration",
                "Mainaguri",
                "Malda",
                "Panchla",
                "Raghunathpur",
                "Mathabhanga",
                "Monoharpur",
                "Srirampore",
                "Adra"
            ]
            /* Add more states and their districts here */
        };





        // Get references to the state and district dropdowns
        const stateDropdown = document.getElementById("stateDropdown");
        const districtDropdown = document.getElementById("districtDropdown");

        if (stateDropdown.value.length == 0) {
            for (const [key, value] of Object.entries(districtData)) {
                const option = document.createElement("option");
                option.value = key;
                option.textContent = key;
                stateDropdown.appendChild(option);
            }

        }

        // Event listener for state dropdown change
        stateDropdown.addEventListener("change", function() {
            const selectedState = stateDropdown.value;
            // Clear existing options in the district dropdown
            districtDropdown.innerHTML =
                "<option value='Others'>Others</option>";

            if (selectedState in districtData) {
                // Populate the district dropdown based on the selected state
                districtData[selectedState].forEach((district) => {
                    const option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;
                    districtDropdown.appendChild(option);
                });
            }
        });
    });
    </script>

	<script>
		$(document).ready(function() {
			$('.minus').click(function() {
				var $input = $(this).parent().find('input');
				var $val = 0;
				if (typeof $input.val() != "undefined" && $input.val() != "" && $input.val() != NaN && $input.val().length > 0) {
					$val = $input.val();
				}
				var count = parseInt($val) - 1;
				count = count <= 0 ? 0 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function() {
				var $input = $(this).parent().find('input');
				var $val = 0;
				if (typeof $input.val() != "undefined" && $input.val() != "" && $input.val() != NaN && $input.val().length > 0) {
					$val = $input.val();
				}
				$input.val(parseInt($val) + 1);
				$input.change();
				return false;
			});
		});
	</script>
	<div class="top-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12"></div>
				<div class="col-lg-12 py-2">
					<div class="trebuchet text-center text-white">Copyright &copy; 2023, greepfireworks. <span class="wrdbrk">All rights reserved </span></div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>