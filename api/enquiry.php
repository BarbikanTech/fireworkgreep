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
    $sql = "SELECT * FROM `enquiry` WHERE (enquiry_no LIKE '%$userid%' OR customer_name LIKE '%$userid%' OR city LIKE '%$userid%' OR state LIKE '%$userid%') AND `deleted_at` = 0 ORDER BY id DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["enquiry"][$count] = $row;
            $output["body"]["enquiry"][$count]["products"] = json_decode($row["products"]);
            $output["body"]["enquiry"][$count]["gst"] = json_decode($row["gst"]);
            $timestamp = strtotime($row["created_date"]);
            $output["body"]["enquiry"][$count]["created_date"] = date('d/m/Y', $timestamp);
            $count++;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Enquiry Details Not Found";
        $output["body"]["enquiry"] = [];
    }
} else if (isset($obj->enquiry_id)) {
    if (isset($obj->enquiry_id) && isset($obj->gst) && isset($obj->products) && isset($obj->discount_input) && isset($obj->discount_sys) && isset($obj->discount_value) && isset($obj->extra_discount_input) && isset($obj->extra_discount_sys) && isset($obj->extra_discount_value) && isset($obj->packing_charge_input) && isset($obj->packing_charge_sys) && isset($obj->packing_charge_value)  && isset($obj->current_user_id) && isset($obj->subtotal) && isset($obj->total)) {
        $enquiry_id = $obj->enquiry_id;
        $products = $obj->products;
        $discount_input = $obj->discount_input;
        $discount_sys = $obj->discount_sys;
        $discount_value = $obj->discount_value;
        $extra_discount_input = $obj->extra_discount_input;
        $extra_discount_sys = $obj->extra_discount_sys;
        $extra_discount_value  = $obj->extra_discount_value;
        $packing_charge_input = $obj->packing_charge_input;
        $packing_charge_sys = $obj->packing_charge_sys;
        $packing_charge_value = $obj->packing_charge_value;
        $customer_id = $obj->customer_id;
        $current_user_id = $obj->current_user_id;
        $subtotal = $obj->subtotal;
        $total = $obj->total;
        $gst = $obj->gst;

        $customer_name = $customer_address = $city = $state = $email = $phone = "";

        if (!empty($customer_id) && $customer_id !=null && $customer_id !="null" ) {
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
            foreach ($products as $pro) {
                $pro->product_name = str_replace('"', '\"', $pro->product_name);
                $pro->name=str_replace('"', '\"', $pro->name);
            }
            $products_json = json_encode($products);
            $gst_json = json_encode($gst);
            if (!empty($enquiry_id)) {
                $update_enquiry_sql = "UPDATE `enquiry` SET `customer_id`='$customer_id',`customer_name`='$customer_name',`address`='$customer_address',`city`='$city',`state`='$state',`email`='$email',`phone`='$phone',`discount_input`='$discount_input', `discount_sys`='$discount_sys',`discount_amount`='$discount_value',`extra_discount_input`='$extra_discount_input', `extra_discount_sys`='$extra_discount_sys',`extra_discount_amount`='$extra_discount_value',`package_input`='$packing_charge_input',`package_sys`='$packing_charge_sys', `package_amount`='$packing_charge_value',`sub_total`='$subtotal',`total`='$total',`products`='$products_json',`gst`='$gst_json' WHERE `id`='$enquiry_id'";
                if ($conn->query($update_enquiry_sql)) {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "Successfully Enquiry Updated";
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Failed To Enquiry Updated";
                }
            } else {
                // Create New Enq
                $new_enq_sql = "INSERT INTO `enquiry`( `enquiry_no`, `estimate_id`, `customer_id`, `customer_name`, `address`, `city`, `state`, `email`, `phone`, `discount_input`, `discount_sys`, `discount_amount`, `extra_discount_input`, `extra_discount_sys`, `extra_discount_amount`, `package_input`, `package_sys`, `package_amount`, `sub_total`, `total`, `created_by`, `created_date`, `deleted_at`, `products`,`gst`)
                     VALUES (null,null,'$customer_id','$customer_name','$customer_address','$city','$state','$email','$phone','$discount_input','$discount_sys','$discount_value','$extra_discount_input','$extra_discount_sys','$extra_discount_value','$packing_charge_input','$packing_charge_sys','$packing_charge_value','$subtotal','$total','$current_user_id','$timestamp',0,'$products_json','$gst_json')";
                if ($conn->query($new_enq_sql)) {
                    $id = (int)$conn->insert_id;
                    $enqID = getEnqID($id);
                    $sql = "UPDATE `enquiry` SET `enquiry_no`='$enqID' WHERE `id`='$id'";
                    if ($conn->query($sql)) {
                        $output["head"]["code"] = 200;
                        $output["head"]["msg"] = "Successfully Enquiry Created";
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
// } else {
//     $output["head"]["code"] = 401;
//     $output["head"]["msg"] = "Invalid Session or the Session has been expired.";
// }

function getEnqID($id)
{
    $tmpID = $id;
    $count = strlen((string)$tmpID);

    if ($count == 1) {
        $tmpID = "00" . $tmpID;
    } else if ($count == 2) {
        $tmpID = "0" . $tmpID;
    }

    $tmpID = $tmpID . "/EST";
    return $tmpID;
}

echo json_encode($output, JSON_NUMERIC_CHECK);
