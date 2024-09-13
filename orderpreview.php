<?php
include "db/config.php";
$id = "";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}

$company_name = $address = $pincode = $phone = $mobile = $gst_no = $state = $city = "";
$acc_no = $acc_holder_name = $bank_name = $ifsc_code = $bank_branch = "";
$sql = "SELECT * FROM `company`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    if ($row = $result->fetch_assoc()) {
        $company_name = $row["company_name"];
        $address = $row["address"];
        $pincode = $row["pincode"];
        $phone = $row["phone"];
        $mobile = $row["mobile"];
        $gst_no = $row["gst_no"];
        $state = $row["state"];
        $city = $row["city"];

        $acc_no = $row["acc_number"];
        $acc_holder_name = $row["acc_holder_name"];
        $bank_name = $row["bank_name"];
        $ifsc_code = $row["ifsc_code"];
        $bank_branch = $row["bank_branch"];
    }
}
 $id = $_GET["id"];
?>
<!DOCTYPE html>
<html lang="en">

<head itemscope itemtype="http://www.schema.org/website">
    <title>Orderpreview | Greep Crackers | Whole Price Crackers | Retails Crackers | Sivakasi Crackers</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 	<meta property="og:title" content="Greep Fireworks">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Greep Fireworks">
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
    <img src="images/banner2.jpg" class="img-fluid w-100" title="Greep Crackers" alt="Greep Crackers">
    <div class="container">
        <div class="">
            <div class="card-box my-3 order_preview">
                <div class="py-2">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="font-weight-bold py-4">Order Preview</h2>
                            <input type="hidden" name="paper_size" id="paper_size" value="a4">
                        </div>
                        <div class="col-sm-4 text-center py-4">
                            <div class="form-group">
                                <button class="btn btn-dark poppins" style="font-size:14px;" type="button" id='btn_format1' onClick="window.open('print2.php?id=<?php echo $id;?>')">
                                     <i class="fa fa-print"></i> &ensp; 
                                    PDF</button>
                            </div>
                        </div>
                        <!--<div class="col-sm-4 text-center py-4">-->
                        <!--    <div class="form-group">-->
                        <!--        <button class="btn btn-dark poppins" style="font-size:11px;display:none" type="button" id='btn_thermal' onClick="window.open('reports/rpt_orders_format3.php?print_order_id=626b4a46656d46734f54464d65564e75543142554e4752565656705851543039&paper_size='+document.getElementById('paper_size').value,'_blank')"> <i class="fa fa-print"></i> &ensp; PDF</button>-->
                        <!--        <button class="btn btn-dark poppins" style="font-size:14px;" type="button" onClick="Javascript:print_content();">-->
                                    <!-- <i class="fa fa-print"></i> &ensp;  -->
                        <!--            Print</button>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-sm-4 text-center py-4">
                            <div class="form-group">
                                <a class="btn btn-danger poppins" style="font-size:14px;" href="products.php">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $subtotal = $discount_total = 0.00;
                $products = array();
                $customer_name = $customer_address = $customer_city = $customer_state = $customer_email = $customer_phone = "";
                $enqno = $enq_date = "";
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];
                    $sql = "SELECT * FROM `online_enquiry` WHERE `id` = '$id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        if ($row = $result->fetch_assoc()) {
                            $enqno = $row["enquiry_no"];
                            $enq_date = $row["created_date"];
                            $customer_name = $row["customer_name"];
                            $customer_address = $row["address"];
                            $customer_city = $row["city"];
                            $customer_state = $row["state"];
                            $customer_email = $row["email"];
                            $customer_phone = $row["phone"];
                            $products = json_decode($row["products"]);
                            $subtotal = $row["total"];
                            $discount_total = $row["discount_total"];
                        }
                    } else {
                    }
                } else {
                    # code...
                }
if (!empty($products)) {
                    $groupedProducts = array();

                    foreach ($products as $pro) {
                        $discount = $pro->discount ?? "Net Rate"; // Use -> for object properties
                
                        if (!isset($groupedProducts[$discount])) {
                            $groupedProducts[$discount] = array();
                        }

                        $groupedProducts[$discount][] = $pro;
                    }
                ?>
                <div class="col-12 col-lg-6 mx-auto h4 fw-bold text-center mb-3 py-3 box-brdr">
                    <?php
                    $sql = "SELECT * FROM `setting` WHERE `id` = 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo $row["thank_you_message"];
                    }
                    ?>
                </div>
                <div class="py-2">
                    <div id="report_area" class=" w-50 mx-lg-auto">
                        <table cellpadding="0" cellspacing="0" class="report_table print_order" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="7" style="padding: 2px 5px; border: 1px solid #000; border-bottom: none; text-align: center; font-size: 15px;">
                                        <div style="display: table; width: 100%;">
                                            <div style="display: table-row;">
                                                <div style="display: table-cell; text-align: left; width: 33.3%; padding-left: 10px; font-size: 12px; font-weight: normal;">
                                                    Enquiry No : <?php echo $enqno; ?> </div>
                                                <div style="display: table-cell; text-align: center; width: 33.3%; padding-left: 10px; font-size: 15px;">ESTIMATE</div>
                                                <div style="display: table-cell; text-align: right; padding-right: 10px; width: 33.3%; font-size: 12px; font-weight: normal;">
                                                    Date : <?php echo $enq_date; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                                <th colspan="4" style="padding: 5px 5px; border: 1px solid #000; font-size: 15px;">
                                    <div style="display: table; width: auto;">
                                        <div style="display: table-row;">
                                            <div style="display: table-cell;  vertical-align: top;">
                                                <div style="width: 100%;"><?php echo $company_name; ?></div>
                                                <div style="width: 100%; font-weight: normal;"><?php echo $address; ?><br><?php echo $city; ?> - <?php echo $pincode; ?></div>
                                                <div style="width: 100%; font-weight: normal;">Mobile : <?php echo $mobile . ", " . $phone; ?></div>
                                                <!-- <div style="width: 100%; font-weight: normal;">awsome@gmail.com</div> -->
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th colspan="6" style="padding: 5px 5px; border: 1px solid #000; font-size: 15px;">
                                    <div style="display: table; width: auto;">
                                        <div style="display: table-row;">
                                            <div style="display: table-cell;">
                                                <div style="width: 100%;">Payments</div>
                                                <div style="width: 100%; font-weight: normal;">Phonepe & Gpay: <?php echo $phone; ?></div>
                                                <div style="font-weight: normal;">
                                                    <div>Name : <?php echo $acc_holder_name; ?></div>
                                                    <div> Account No: <?php echo $acc_no; ?>, & IFSC : <?php echo $ifsc_code; ?></div>
                                                    <div> Bank Name : <?php echo $bank_name; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="7" style="padding: 2px 5px; border: 1px solid #000; font-size: 13px; line-height: 15px;">
                                    <div style="text-align: center; margin-bottom: 5px; font-weight: bold;">Customer Details</div>
                                    <div style="display: table; width: 100%;">
                                        <div style="display: table-row;">
                                            <div style="display: table-cell; width: 50%;text-align: left;">
                                                <div style="width: 100%; padding-left: 10px;"><?php echo $customer_name; ?><br><?php echo $customer_phone; ?></div>
                                            </div>
                                            <div style="display: table-cell; width: 50%;">
                                                <div style="width: 100%; padding-right: 10px; text-align: right;"><?php echo $customer_address; ?><br><?php echo $customer_city . ", " . $customer_state; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 2px 5px; border: 1px solid #000; text-align: center; width: 10px; font-size: 12px;">S.No</th>
                                <!--<th style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 50px; font-size: 12px;">Code</th>-->
                                <th colspan="2" style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; font-size: 12px;">Product Name</th>
                                <th style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 75px; font-size: 12px;">Content</th>
                                <th style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 75px; font-size: 12px;">Quantity</th>
                                <th style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 100px; font-size: 12px;">Rate (Rs)</th>
                                <th style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 125px; font-size: 12px;">Amount (Rs)</th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <th colspan="7" style="padding: 2px 5px; border: 1px solid #000; text-align: center; font-size: 12px;">
                                        90% Products
                                    </th>
                                </tr> -->
                               
                               <?php
                                    $count = 1;
                                    foreach ($groupedProducts as $discount => $products) {

                                        $discount_view = "";
                                        if ($discount == "Net Rate") {
                                            $discount_view = "Discount: $discount";
                                        } else {
                                            $discount_view = "Discount: $discount %";
                                        }
                                        ?>
                                        <tr>
                                            <th colspan="7"
                                                style="padding: 2px 5px; border: 1px solid #000; text-align: center; font-size: 12px;">
                                                <?php echo $discount_view; ?>
                                            </th>
                                        </tr>
                                        <?php
                                        foreach ($products as $product) {

                                            ?>
                                            <tr>
                                                <td
                                                    style="padding: 2px 5px; border: 1px solid #000; text-align: center; width: 10px; font-size: 12px;">
                                                    <?php echo $count; ?>
                                                </td>
                                                <!--<td style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 50px; font-size: 12px;">
                                            4 </td>-->
                                                <td colspan="2"
                                                    style="padding: 2px 10px; border: 1px solid #000; border-left: none; font-size: 12px;">
                                                    <?php echo $product->product_name; ?>
                                                </td>
                                                <td
                                                    style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 75px; font-size: 12px;">
                                                    <?php echo $product->product_content; ?>
                                                </td>
                                                <td
                                                    style="padding: 2px 5px; border: 1px solid #000; border-left: none; text-align: center; width: 75px; font-size: 12px;">
                                                    <?php echo $product->qty; ?>
                                                </td>
                                                <td
                                                    style="padding: 2px 10px; border: 1px solid #000; border-left: none; text-align: right; width: 75px; font-size: 12px;">
                                                    <?php echo $product->price; ?>
                                                </td>
                                                <td
                                                    style="padding: 2px 10px; border: 1px solid #000; border-left: none; text-align: right; width: 125px; font-size: 12px;">
                                                    <?php echo $product->total; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    }
                                ?>
                                <tr>
                                    <th colspan="6" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: right; font-size: 12px;">
                                        Sub Total
                                    </th>
                                    <th style="padding: 2px 5px; border: 1px solid #000; text-align: right; font-size: 12px; width: 125px;">
                                        <?php echo $subtotal; ?>
                                    </th>
                                </tr>
                                <!-- <tr>
                                    <th colspan="6" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: right; font-size: 12px;">
                                        Discount (90%)
                                    </th>
                                    <th style="padding: 2px 5px; border: 1px solid #000; text-align: right; font-size: 12px; width: 125px;">
                                        64,647.00
                                    </th>
                                </tr> -->
                                <tr>
                                    <th colspan="6" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: right; font-size: 12px;">
                                        Total
                                    </th>
                                    <th style="padding: 2px 5px; border: 1px solid #000; text-align: right; font-size: 12px; width: 125px;">
                                        <?php echo $discount_total; ?>
                                    </th>
                                </tr>
                                <!-- <tr>
                                    <th colspan="6" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: right; font-size: 12px;">
                                        Packing Charges (3%)
                                    </th>
                                    <th style="padding: 2px 5px; border: 1px solid #000; text-align: right; font-size: 12px; width: 125px;">
                                        215.49
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="6" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: right; font-size: 12px;">
                                        Round Off ( - )
                                    </th>
                                    <th style="padding: 2px 5px; border: 1px solid #000; text-align: right; font-size: 12px; width: 125px;">
                                        Rs.0.49
                                    </th>
                                </tr> -->
                                <tr>
                                    <th colspan="3" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: left; font-size: 12px;">
                                        Total Items : <?php echo count($products); ?>
                                    </th>
                                    <th colspan="3" style="padding: 2px 10px; border: 1px solid #000; border-right: none; text-align: right; font-size: 12px;">
                                        Overall Total
                                    </th>
                                    <th style="padding: 2px 5px; border: 1px solid #000; text-align: right; font-size: 12px; width: 125px;">
                                        <?php echo $discount_total; ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    </div>
</body>

</html>