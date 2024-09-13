<?php

include 'headers.php';
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$obj = json_decode($json);
$output = array();

date_default_timezone_set('Asia/Calcutta');
$timestamp = date('Y-m-d H:i:s');

// if ($loginpass == 1) {

if (isset($obj->search_text)) {
    $userid = $obj->search_text;
    $sql = "SELECT * FROM `invoice` WHERE `deleted_at` = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["invoice"][$count] = $row;
            $output["body"]["invoice"][$count]["products"] = json_decode($row["products"]);
            $output["body"]["invoice"][$count]["gst"] = json_decode($row["gst"]);
            $count++;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Invoice Details Not Found";
        $output["body"]["invoice"] = [];
    }
} else if (isset($obj->invoice_id)) {
    if (isset($obj->products) && isset($obj->gst) && isset($obj->discount_input) && isset($obj->discount_sys) && isset($obj->discount_value) && isset($obj->extra_discount_input) && isset($obj->extra_discount_sys) && isset($obj->extra_discount_value) && isset($obj->packing_charge_input) && isset($obj->packing_charge_sys) && isset($obj->packing_charge_value) && isset($obj->customer_id) && isset($obj->current_user_id) && isset($obj->subtotal) && isset($obj->total)) {

        $invoice_id = $obj->invoice_id;
        $products = $obj->products;
        $discount_input = $obj->discount_input;
        $discount_sys = $obj->discount_sys;
        $discount_value = $obj->discount_value;
        $extra_discount_input = $obj->extra_discount_input;
        $extra_discount_sys = $obj->extra_discount_sys;
        $extra_discount_value = $obj->extra_discount_value;
        $packing_charge_input = $obj->packing_charge_input;
        $packing_charge_sys = $obj->packing_charge_sys;
        $packing_charge_value = $obj->packing_charge_value;
        $customer_id = $obj->customer_id;
        $current_user_id = $obj->current_user_id;
        $subtotal = $obj->subtotal;
        $total = $obj->total;
        $gst = $obj->gst;

        $customer_name = $customer_address = $city = $state = $email = $phone = "";

        if (!empty($customer_id)) {
            $sql = "SELECT * FROM `customer` WHERE `id` = '$customer_id' AND `deleted_at` = 0";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {
                    $customer_name = $row["customer_name"];
                    $customer_address = $row["address"];
                    $phone = $row["mobile"];
                    $email = $row["email"];
                    $state = $row["state"];
                    $city = $row["city"];
                }
            }
        }



        if (!empty($products) && !empty($current_user_id)) {
            $products_json = json_encode($products);
            if ($gst != null || $gst != 'null') {
                $gst = json_encode($gst);
            }
            if (!empty($invoice_id)) {
            } else {
                // Create New Enq
                $new_invoice_sql = "INSERT INTO `invoice`( `invoice_no`,  `customer_id`, `customer_name`, `address`, `city`, `state`, `email`, `phone`, `discount_input`, `discount_sys`, `discount_amount`, `extra_discount_input`, `extra_discount_sys`, `extra_discount_amount`, `package_input`, `package_sys`, `package_amount`, `sub_total`, `total`, `created_by`, `created_date`, `deleted_at`, `products`,`gst`)
                     VALUES (null,'$customer_id','$customer_name','$customer_address','$city','$state','$email','$phone','$discount_input','$discount_sys','$discount_value','$extra_discount_input','$extra_discount_sys','$extra_discount_value','$packing_charge_input','$packing_charge_sys','$packing_charge_value','$subtotal','$total','$current_user_id','$timestamp','0','$products_json','$gst')";
                if ($conn->query($new_invoice_sql)) {
                    $id = (int) $conn->insert_id;
                    $invoiceID = getInvoiceID($id);
                    $sql = "UPDATE `invoice` SET `invoice_no`='$invoiceID' WHERE `id`='$id'";
                    if ($conn->query($sql)) {
                        $output["head"]["code"] = 200;
                        $output["head"]["msg"] = "Successfully Invoice Created";
                    } else {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = $conn->error;
                    }
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = $conn->error;
                }
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Please provide all the required details.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
} else {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Parameter is Mismatch";
}


function getInvoiceID($id)
{
    $tmpID = $id;
    $count = strlen((string) $tmpID);

    if ($count == 1) {
        $tmpID = "00" . $tmpID;
    } else if ($count == 2) {
        $tmpID = "0" . $tmpID;
    }

    $tmpID = $tmpID . "/INV";
    return $tmpID;
}

echo json_encode($output, JSON_NUMERIC_CHECK);
