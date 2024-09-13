<?php
include 'db/config.php';
require('fpdf/AlphaPDF.php');
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// Check if 'id' is set in the URL
if (!isset($_GET["id"])) {
    header("Location: ../products.php");
    exit;
}

$id = $_GET["id"];
$timestamp = date("Y-m-d");

// Fetch data from the database using the 'id'
$sql = "SELECT * FROM `online_enquiry` WHERE `id`='$id'";
$result = $conn->query($sql);

$sql_com = "SELECT * FROM `company` WHERE `id`='1'";
$result_com = $conn->query($sql_com);
$row = $result_com->fetch_assoc();
$company_name = $row['company_name'];
$addrescom = $row['address'];
$mobile = $row['phone'];
$gst = $row['gst_no'];
$acc_number = $row['acc_number'];
$acc_holder_name = $row['acc_holder_name'];
$ifsc_code = $row['ifsc_code'];
$pincodecom = $row['pincode'];
$statecom = $row['state'];
$citycom = $row['city'];


if ($result->num_rows == 0) {
    echo 'No data found';
    exit;
} else {
    $row = $result->fetch_assoc();
    $enquiry_no = $row['enquiry_no'];
    $customer_name = $row['customer_name'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $email = $row['email'];
    $phone = $row['phone'];
    $discount_total = $row['discount_total'];
    $total = $row['total'];
    $sub_total = $row['sub_total'];
    $packing_charge = $row['packing_charge'];
    $products = $row['products'];
    
    
    

    $products = json_decode($products);
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


    // Create a new PDF instance
    $pdf = new AlphaPDF('p', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetY(10);
    $pdf->SetX(10);
    $pdf->SetFillColor(109, 179, 215);
    $pdf->SetFont('Times', '', 10);

    // Populate PDF content using fetched data
    $pdf->SetX(10);
    $pdf->Cell(70, 8, 'Enquiry No  : ' . $enquiry_no, 0, 0, 'l', 1);
    $pdf->SetFont('Times', 'b', 12);
    $pdf->SetX(60);
    $pdf->Cell(100, 8, 'ESTIMATE', 0, 0, 'C', 1);
    $pdf->SetFont('Times', '', 10);
    $pdf->SetX(160);
    $pdf->Cell(10, 8, 'Date :  ', 0, 0, 'C', 1);
    $pdf->SetX(168);
    $pdf->Cell(32, 8, $timestamp, 0, 0, 'L', 1);
    $pdf->SetX(10);
    $pdf->Cell(190, 8, '', 'TLBR', 1, 'L', 0);
    $y = $pdf->GetY();
    $pdf->SetX(10);
    $pdf->SetFont('Times', 'b', 10);
    $pdf->Cell(100, 5, "$company_name", 0, 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(100, 5, "$addrescom", 0, 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(100, 5, "$citycom", 0, 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(100, 5, "$statecom - $pincodecom", 0, 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(100, 5, 'Mobile : ', 0, 0, 'L', 0);
    $pdf->SetX(25);
    $pdf->Cell(100, 5, "$mobile", 0, 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(100, 5, '', 0, 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(100, 5, "GST No:$gst", 0, 1, 'L', 0);
    $pdf->setY($y);
    $pdf->SetX(10);
    $pdf->Cell(90, 45, '', 'TLBR', 0, 'L', 0);
    $pdf->SetFont('Times', 'b', 10);
    $y = $pdf->GetY();
    $pdf->SetX(100);
    $pdf->Cell(100, 5, 'Payments', 0, 1, 'L', 0);
    $pdf->SetX(100);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(100, 5, 'Phonepe & Gpay  : ', 0, 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(100, 5, "$mobile", 0, 1, 'L', 0);
    $pdf->SetX(100);
    $pdf->Cell(100, 5, 'Account No          :', 0, 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(100, 5, "$acc_number", 0, 1, 'L', 0);
    $pdf->SetX(100);
    $pdf->Cell(100, 5, 'Account Name     :', 0, 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(100, 5, "$acc_holder_name", 0, 1, 'L', 0);
    $pdf->SetX(100);
    $pdf->Cell(100, 5, 'IFSC code            :', 0, 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(100, 5, "$ifsc_code", 0, 1, 'L', 0);
    $pdf->SetX(100);
    // $pdf->Cell(100, 5, "GST No                :    $gst", 0, 1, 'L', 0);
    $pdf->setY($y);
    $pdf->SetX(100);
    $pdf->Cell(100, 45, '', 1, 1, 'L', 0);
    $y = $pdf->GetY();
    $pdf->SetX(90);
    $pdf->SetFont('Times', 'b', 13);
    $pdf->Cell(95, 5, 'Customer Details', '0', 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(95, 5, 'Name   :   ', '0', 0, 'L', 0);
    $pdf->SetX(20);
    $pdf->Cell(95, 5, "     $customer_name", '0', 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(95, 5, 'Address :   ', '0', 0, 'L', 0);
    $pdf->SetX(140);
    $pdf->Cell(95, 5, "      $address", '0', 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(95, 5, 'Phone   :   ', '0', 0, 'L', 0);
    $pdf->SetX(20);
    $pdf->Cell(95, 5, "     $phone", '0', 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(95, 5, 'City       :   ', '0', 0, 'L', 0);
    $pdf->SetX(140);
    $pdf->Cell(95, 5, "       $city", '0', 1, 'L', 0);
    $pdf->SetX(10);
    $pdf->Cell(95, 5, 'E-Mail  :  ', '0', 0, 'L', 0);
    $pdf->SetX(20);
    $pdf->Cell(90, 5, "     $email", '0', 0, 'L', 0);
    $pdf->SetX(130);
    $pdf->Cell(95, 5, 'State      : ', '0', 0, 'L', 0);
    $pdf->SetX(145);
    $pdf->Cell(90, 5, "    $state", '0', 1, 'L', 0);
    $pdf->setY($y);
    $pdf->SetX(10);
    $pdf->Cell(190, 25, '', 1, 1, 'L', 0);
    $y = $pdf->GetY();
    $pdf->SetX(10);
    $pdf->SetFont('Times', 'b', 10);
    $pdf->Cell(10, 5, 'S.No.', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(10);
    $pdf->Cell(10, 5, '', 1, 0, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(20);
    $pdf->Cell(20, 5, 'Code', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(20);
    $pdf->Cell(20, 5, '', 1, 0, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(40);
    $pdf->Cell(60, 5, 'Product Name', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(40);
    $pdf->Cell(60, 5, '', 1, 0, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(100);
    $pdf->Cell(20, 5, 'Content', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(100);
    $pdf->Cell(20, 5, '', 1, 0, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(120);
    $pdf->Cell(20, 5, 'Quantity', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(120);
    $pdf->Cell(20, 5, '', 1, 0, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(140);
    $pdf->Cell(30, 5, 'price (Rs)', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(140);
    $pdf->Cell(30, 5, '', 1, 0, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(170);
    $pdf->Cell(30, 5, 'Amount (Rs)', 0, 1, 'C', 1);
    $pdf->setY($y);
    $pdf->SetX(170);
    $pdf->Cell(30, 5, '', 1, 1, 'C', 0);

    // Initialize variables for subtotal and total
    
    $count = 1;
    foreach ($groupedProducts as $discount => $products) {
  
        $discount_view = "";
        if ($discount == "Net Rate") {
            $discount_view = "Discount: $discount";
        } else {
            $discount_view = "Discount: $discount %";
        }

        $y = $pdf->GetY();
        $pdf->SetX(10);
        $pdf->Cell(190, 5, "$discount_view", 0, 0, 'C', 0); // Display the discount
        $pdf->SetX(10);
        $pdf->Cell(190, 5, '', 1, 1, 'C', 0);
        // Loop through the products and geneprice PDF cells
        foreach ($products as $product) {
if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - 20) {
            $pdf->AddPage();
        }

            $y = $pdf->GetY();
            $pdf->SetX(10);
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(10, 5, "$count", 0, 1, 'C', 0); // s.no
            $pdf->setY($y);
            $pdf->SetX(10);
            $pdf->Cell(10, 5, '', 1, 0, 'C', 0);

            $y = $pdf->GetY();
            $pdf->SetX(20);
            $pdf->Cell(20, 5, $product->product_code, 0, 1, 'C', 0); //code
            $pdf->setY($y);
            $pdf->SetX(20);
            $pdf->Cell(20, 5, '', 1, 0, 'C', 0);

            $y = $pdf->GetY();
            $pdf->SetX(40);
            $pdf->Cell(60, 5, $product->product_name, 0, 1, 'C', 0); // product
            $pdf->setY($y);
            $pdf->SetX(40);
            $pdf->Cell(60, 5, '', 1, 0, 'C', 0);

            $y = $pdf->GetY();
            $pdf->SetX(100);
            $pdf->Cell(20, 5, $product->product_content, 0, 1, 'C', 0); //product content
            $pdf->setY($y);
            $pdf->SetX(100);
            $pdf->Cell(20, 5, '', 1, 0, 'C', 0);

            $y = $pdf->GetY();
            $pdf->SetX(120);
            $pdf->Cell(20, 5, $product->qty, 0, 1, 'C', 0); //quantity
            $pdf->setY($y);
            $pdf->SetX(120);
            $pdf->Cell(20, 5, '', 1, 0, 'C', 0);

            $y = $pdf->GetY();
            $pdf->SetX(140);
            $pdf->Cell(30, 5, number_format($product->price, 2), 0, 1, 'C', 0); //price
            $pdf->setY($y);
            $pdf->SetX(140);
            $pdf->Cell(30, 5, '', 1, 0, 'C', 0);

            // Calculate the amount for this product
            $amount = $product->qty * $product->price;

            $y = $pdf->GetY();
            $pdf->SetX(170);
            $pdf->Cell(30, 5, number_format($amount, 2), 0, 1, 'C', 0); // amount
            $pdf->setY($y);
            $pdf->SetX(170);
            $pdf->Cell(30, 5, '', 1, 1, 'C', 0);

            // Update subtotal and total
            $count++;
        }
    }
    // Output the calculated subtotal and total
    $y = $pdf->GetY();
    $pdf->SetFont('Times', 'b', 11);
    $pdf->SetX(10);
    $pdf->Cell(160, 7, 'Sub Total', 0, 1, 'R', 0);
    $pdf->setY($y);
    $pdf->SetX(10);
    $pdf->Cell(160, 7, '', 1, 0, 'C', 0);
    $pdf->SetX(170);
    $pdf->Cell(30, 7, number_format($total, 2), 0, 1, 'R', 0);
    $pdf->setY($y);
    $pdf->SetX(170);
    $pdf->Cell(30, 7, '', 1, 1, 'C', 0);

    $y = $pdf->GetY();
    $pdf->SetX(10);
    $pdf->Cell(160, 7, 'Total', 0, 1, 'R', 0);
    $pdf->setY($y);
    $pdf->SetX(10);
    $pdf->Cell(160, 7, '', 1, 0, 'C', 0);
    $pdf->SetX(170);
    $pdf->Cell(30, 7, number_format($discount_total, 2), 0, 1, 'R', 0);
    $pdf->setY($y);
    $pdf->SetX(170);
    $pdf->Cell(30, 7, '', 1, 1, 'C', 0);
    //   $y = $pdf->GetY();
    // $pdf->SetX(10);
    // $pdf->Cell(160, 7, 'Packing Charge', 0, 1, 'R', 0);
    // $pdf->setY($y);
    // $pdf->SetX(10);
    // $pdf->Cell(160, 7, '', 1, 0, 'C', 0);
    // $pdf->SetX(170);
    // $pdf->Cell(30, 7, number_format($packing_charge, 2), 0, 1, 'R', 0);
    // $pdf->setY($y);
    // $pdf->SetX(170);
    // $pdf->Cell(30, 7, '', 1, 1, 'C', 0);
    $y = $pdf->GetY();
    $pdf->SetX(10);
    $pdf->Cell(160, 7, 'OverAll Total', 0, 1, 'R', 0);
    $pdf->setY($y);
    $pdf->SetX(10);
    $pdf->Cell(160, 7, '', 1, 0, 'C', 0);
    $pdf->SetX(170);
    $pdf->Cell(30, 7, number_format($discount_total, 2), 0, 1, 'R', 0);
    $pdf->setY($y);
    $pdf->SetX(170);
    $pdf->Cell(30, 7, '', 1, 1, 'C', 0);




    $pdf->Output();
}

?>