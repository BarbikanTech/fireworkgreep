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
    $customername = $obj->search_text;
    $sql = "SELECT * FROM `customer` WHERE `deleted_at` = 0 AND ( `customer_name` LIKE '%$customername%' OR `phone_number` LIKE '%$customername%' OR `state` LIKE '%$customername%' OR `city` LIKE '%$customername%')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["customer"][] = $row;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Success";
        $output["body"]["customer"] = [];
    }
} else if (isset($obj->customer_id) && isset($obj->customer_name) && isset($obj->phone_number) && isset($obj->email) && isset($obj->address) && isset($obj->state) && isset($obj->city) && isset($obj->current_user_id)) {
    $customer_id = $obj->customer_id;
    $customer_name = $obj->customer_name;
    $phone_number = $obj->phone_number;
    $email = $obj->email;
    $address = $obj->address;
    $state = $obj->state;
    $city = $obj->city;
    $current_user_id = $obj->current_user_id;

    if (!empty($customer_name) &&  !empty($current_user_id)) {
        if (!preg_match('/[^a-zA-Z0-9., ]+/', $customer_name)) {
            if(!empty($phone_number)){
                if (numericCheck($phone_number) === false || strlen($phone_number) != 10) {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Invalid Phone Number.";
                }
            }
            $current_user_name = getUserName($current_user_id);
            if (!empty($current_user_name)) {
                if (isset($obj->customer_id) && !empty($obj->customer_id)) {
                    $customer_id = $obj->customer_id;
                    if (customerExist($customer_id) && numericCheck($customer_id)) {
                        $updateCustomer = "UPDATE `customer` SET `customer_name`='$customer_name', `phone_number`='$phone_number', `email`='$email', `address`='$address', `state`='$state', `city`='$city', `created_by`='$current_user_id', `created_name`='$current_user_name' WHERE `id`='$customer_id'";
                        if ($conn->query($updateCustomer)) {
                            $output["head"]["code"] = 200;
                            $output["head"]["msg"] = "Successfully Customer Details Updated";
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Failed to connect. Please try again.";
                        }
                    } else {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = "Customer not found.";
                    }
                } else {
                    $checkNewCustomer = "SELECT `id` FROM `customer` WHERE `phone_number` = $phone_number";
                    $result = $conn->query($checkNewCustomer);
                    if ($result->num_rows > 0) {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = "Customer Already Exist";
                    } else {
                        $createCustomer = "INSERT INTO `customer` (`customer_name`, `phone_number`, `email`, `address`,`state`,`city`, `deleted_at`, `created_by`, `created_name`, `created_date`) VALUES
                                 ('$customer_name', '$phone_number', '$email', '$address', '$state', '$city','0', '$current_user_id', '$current_user_name', '$timestamp') ";
                        if ($conn->query($createCustomer)) {
                            $output["head"]["code"] = 200;
                            $output["head"]["msg"] = "Successfully Customer Created";
                            $output["head"]["customer_id"] = (int)$conn->insert_id;
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Failed to connect. Please try again.".$conn->error;
                        }
                    }
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "User not found.";
            }
            
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Customer Name Should be Alphanumeric.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
} else if (isset($obj->delete_customer_id) && isset($obj->current_user_id)) {

    $delete_customer_id = $obj->delete_customer_id;
    $current_user_id = $obj->current_user_id;

    if (!empty($delete_customer_id) && !empty($current_user_id)) {

        if (numericCheck($delete_customer_id) && numericCheck($current_user_id)) {
            $updateUser = "UPDATE `customer` SET `deleted_at`=1 WHERE `id`='$delete_customer_id'";
            if ($conn->query($updateUser)) {
                $output["head"]["code"] = 200;
                $output["head"]["msg"] = "Successfully Customer Details Updated";
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Failed to connect. Please try again.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Invalid data Customer.";
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



echo json_encode($output, JSON_NUMERIC_CHECK);
