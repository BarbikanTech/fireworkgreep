<?php
include 'db/config.php';
$output = array();

if (count($_POST["product_quantity"]) > 0) {
    $product_count = count($_POST["product_quantity"]);
    $products_ids = array();
    $products_qty = array();
    $cart_products = array();
    for ($i = 0; $i < $product_count; $i++) {
        $products_ids[$i] = explode('/', $_POST["product_quantity"][$i])[0];
        $products_qty[$i] = explode('/', $_POST["product_quantity"][$i])[1];
    }

    $category = array();

    $sql = "SELECT * FROM `category` WHERE `deleted_at` ='0'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category[] = $row;
        }
    }

    for ($i = 0; $i < count($products_ids); $i++) {
        $id = $products_ids[$i];
        $sql = "SELECT * FROM `products` WHERE `id` ='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $cart_products[$i] = $row;
                $cart_products[$i]["qty"] = (int)$products_qty[$i];
                $cart_products[$i]["net_rate"] = (int)$row["price"] * $products_qty[$i];
                $discount = 0;
                for ($j = 0; $j < count($category); $j++) {
                    if ($category[$j]["id"] == $row["category_id"]) {
                        $discount = (int)$category[$j]["discount"];
                    }
                }

                $discount_price = ((int)$row["price"] - ((int)$row["price"] * $discount / 100));
                $cart_products[$i]["discount_price"] = $discount_price;
                $cart_products[$i]["discount"] = $discount;
                $cart_products[$i]["total"] = $discount_price * $products_qty[$i];
            }
        }
    }

    $state = $_POST["state"];
    $city = $_POST["city"];
    $customer_name = $_POST["name"];
    $mobile_number = $_POST["mobile_number"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $discount_total = 0.00;
    $net_rate_total = 0.00;


    for ($i = 0; $i < count($cart_products); $i++) {
        $discount_total += (float)$cart_products[$i]["total"];
    }

    for ($i = 0; $i < count($cart_products); $i++) {
        $net_rate_total += (float)$cart_products[$i]["net_rate"];
    }

  foreach ($cart_products as $pro) {
        $pro->product_name = str_replace('"', '\"', $pro->product_name);
        $pro->name = str_replace('"', '\"', $pro->name);
        
    }

    // foreach ($cart_products as $pro) {
    //     $pro->product_name = str_replace('"', '\"', $pro->product_name);
    // }

    $products_json = json_encode($cart_products);

    $sql = "INSERT INTO `online_enquiry`( `enquiry_no`, `customer_name`, `address`, `city`, `state`, `email`, `phone`, `discount_total`, `total`, `products`, `created_by`,  `deleted_at`,`status`) VALUES
     (null,'$customer_name','$address','$city','$state','$email','$mobile_number','$discount_total','$net_rate_total','$products_json','Front-Enquiry',0,0)";

    if ($conn->query($sql)) {
        $id = (int)$conn->insert_id;
        $enqID = getID($id);
        $sql = "UPDATE `online_enquiry` SET `enquiry_no`='$enqID' WHERE `id`='$id'";
        if ($conn->query($sql)) {
            $getfcmsql = "SELECT  `fcm_id`  FROM `user` WHERE `fcm_id` IS NOT NULL";
            $result = $conn->query($getfcmsql);
            if ($result->num_rows > 0) {
                $fcm_array = array();
                while ($row = $result->fetch_assoc()) {
                    $fcm_array[] = $row["fcm_id"];
                }
                $fcm_result = send_fcm_notification($fcm_array, $customer_name, $discount_total);
                $output["head"]["code"] = 200;
                $output["head"]["msg"] = "success";
                $output["head"]["id"] = $id;
            } else {
                $output["head"]["code"] = 200;
                $output["head"]["msg"] = "success";
                $output["head"]["id"] = $id;
            }
        } else {
            $output["head"]["code"] == 400;
            $output["head"]["msg"] = $conn->error;
        }
    } else {
        $output["head"]["code"] == 400;
        $output["head"]["msg"] = $conn->error;
    }
} else {
    $output["head"]["code"] == 400;
    $output["head"]["msg"] = "Products not Available";
}

function getID($id)
{
    $tmpID = $id;
    $count = strlen((string)$tmpID);

    if ($count == 1) {
        $tmpID = "00" . $tmpID;
    } else if ($count == 2) {
        $tmpID = "0" . $tmpID;
    }

    $tmpID = $tmpID . "/ENQ";
    return $tmpID;
}

function send_fcm_notification($fcm_array, $customer_name, $amount)
{

    $json_data = [
        "registration_ids" => $fcm_array,
        "notification" => [
            "body" => $customer_name . " - ₹" . $amount,
            "title" => "New Enquiry Received",
            "sound" => true
        ],
    ];



    $data = json_encode($json_data);
    //FCM API end-point
    $url = 'https://fcm.googleapis.com/fcm/send';
    //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAAg4hOTyE:APA91bEOa8oo-zkSgKT2ORyEZu5R9lu4XioiSke5cQYL1ZLo7fV_VRR_vBlfUrYwEbKuJqleu0fQVj1eSLkY7zfMdD6MuKxsG2j56Cz0OOccfd8Js6tqhl42jC5E1PL1GrsXGLphHzMp';
    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key=' . $server_key
    );
    //CURL request to route notification to FCM connection server (provided by Google)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    if ($result === true) {
        return true;
    }
    curl_close($ch);
}
$result = json_encode($output);

echo $result;
