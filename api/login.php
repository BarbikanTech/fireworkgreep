<?php
include 'db/config.php';
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$obj = json_decode($json);
$output = array();

date_default_timezone_set('Asia/Calcutta');
$timestamp = date('Y-m-d H:i:s');

// <<<<<<<<<<===================== Function for Generate Session id =====================>>>>>>>>>>
function createSessionid()
{
    global $conn;

    $session_id = md5(substr(str_shuffle('0123456789'), 0, 8));
    $code_check = "SELECT `session_id` FROM `sessions` WHERE `session_id`='$session_id'";
    $code_check_result = $conn->query($code_check);
    while ($code_check_result->num_rows > 0) {
        $session_id = md5(substr(str_shuffle('0123456789'), 0, 8));
        $code_check = "SELECT `session_id` FROM `sessions` WHERE `session_id`='$session_id'";
        $code_check_result = $conn->query($code_check);
        while ($code_check_result->num_rows > 0) {
            break;
        }
    };

    return $session_id;
}

// <<<<<<<<<<===================== Function for Log the Device Details =====================>>>>>>>>>>
function logDevice($user_id, $brand_name, $model_no, $device_id, $is_staff)
{
    global $conn, $timestamp;

    $getDevice = $conn->query("SELECT `id` FROM `device_details` WHERE `device_id` = '$device_id'");
    if ($getDevice->num_rows == 0) {
        $conn->query("INSERT INTO `device_details` (`user_id`, `brand_name`, `model`, `device_id`, `is_staff`, `created_date`) VALUES ('$user_id', '$brand_name', '$model_no', '$device_id', '$is_staff', '$timestamp')");
    }
}


// <<<<<<<<<<===================== API Data Handling Starts Here =====================>>>>>>>>>>
// if (isset($obj->phone) && isset($obj->password) && isset($obj->brand_name) && isset($obj->model_no) && isset($obj->device_id) && isset($obj->fcm_id)) {
if (isset($obj->phone) && isset($obj->password) && isset($obj->fcm_id)) {

    $phone = $obj->phone;
    $password = $obj->password;
    // $brand_name = $obj->brand_name;
    // $model_no = $obj->model_no;
    // $device_id = $obj->device_id;
    $fcm_id = $obj->fcm_id;

    // if (!empty($phone) && !empty($password) && !empty($brand_name) && !empty($model_no) && !empty($device_id) && !empty($fcm_id)) {
    if (!empty($phone) && !empty($password) && !empty($fcm_id)) {
        if (numericCheck($phone) && strlen($phone) == 10) {

            // if (alphaNumericCheck($brand_name) && alphaNumericCheck($model_no) && alphaNumericCheck($device_id)) {


            // <<<<<<<<<<===================== Checking the user table =====================>>>>>>>>>>
            $result = $conn->query("SELECT `id`, `img`, `name`, `phone`, `password` FROM `user` WHERE `phone`='$phone' AND `deleted_at` = 0");
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {

                    if ($row['password'] == $password) {

                        $user_id = $row['id'];
                        $session_id = createSessionid();


                        $sessionSql = "INSERT INTO `sessions` (`user_id`, `session_id`, `device_id`, `is_staff`, `created_date`) VALUES ('$user_id', '$session_id', '', '0', '$timestamp')";
                        if ($conn->query($sessionSql)) {

                            $userID = $row['id'];

                            $fcmSql = "UPDATE `user` SET `fcm_id`='$fcm_id' WHERE `id`='$userID'";
                            if ($conn->query($fcmSql)) {
                                if (!empty($row['img'])) {
                                    $profileUrl = "http://localhost/s4nk4r/crakersApi/ProfileImages/" . $row['img'];
                                } else {
                                    $profileUrl = "http://localhost/s4nk4r/crakersApi/ProfileImages/nopic.png";
                                }

                                $output["head"]["code"] = 200;
                                $output["head"]["msg"] = "Success";
                                $output["head"]["auth_token"] = $session_id;
                                $output["body"]["user"]["id"] = $userID;
                                $output["body"]["user"]["user_name"] = $row['name'];
                                $output["body"]["user"]["profile_img"] = $profileUrl;
                                $output["body"]["user"]["phone_no"] = $row['phone'];
                                $output["body"]["user"]["is_staff"] = false;
                            } else {
                                $output["head"]["code"] = 400;
                                $output["head"]["msg"] = $conn->error;
                            }
                            // logDevice($user_id, $brand_name, $model_no, $device_id, "0");
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Error, Please try again. If the issue persists please contact the admin";
                        }
                    } else {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = "Invalid Credentials";
                    }
                }
            } else {

                // <<<<<<<<<<===================== Checking the Staff table =====================>>>>>>>>>>
                $checkStaff = $conn->query("SELECT `id`, `staff_name`, `img`, `phone`, `password`, `permission` FROM `staff` WHERE `phone`='$phone' AND `deleted_at` = 0");
                if ($checkStaff->num_rows > 0) {
                    if ($staffData = $checkStaff->fetch_assoc()) {

                        if ($staffData['password'] == $password) {

                            $user_id = $staffData['id'];
                            $session_id = createSessionid();

                            $sessionSql = "INSERT INTO `sessions` (`user_id`, `session_id`, `device_id`, `is_staff`, `created_date`) VALUES ('$user_id', '$session_id', '$device_id', '1', '$timestamp')";
                            if ($conn->query($sessionSql)) {

                                if (!empty($staffData['img'])) {
                                    $profileUrl = "http://localhost/s4nk4r/crakersApi/ProfileImages/" . $staffData['img'];
                                } else {
                                    $profileUrl = "http://localhost/s4nk4r/crakersApi/ProfileImages/nopic.png";
                                }

                                $output["head"]["code"] = 200;
                                $output["head"]["msg"] = "Success";
                                $output["head"]["auth_token"] = $session_id;
                                $output["body"]["user"]["id"] = $user_id;
                                $output["body"]["user"]["user_name"] = $staffData['staff_name'];
                                $output["body"]["user"]["profile_img"] = $profileUrl;
                                $output["body"]["user"]["phone_no"] = $staffData['phone'];
                                $output["body"]["user"]["is_staff"] = true;
                                $output["body"]["user"]["permission"] = json_decode($staffData['permission'], true);

                                logDevice($user_id, $brand_name, $model_no, $device_id, "1");
                            } else {
                                $output["head"]["code"] = 400;
                                $output["head"]["msg"] = "Error, Please try again. If the issue persists please contact the admin";
                            }
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Invalid Credentials";
                        }
                    }
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "User Details Not Found.";
                }
            }
            // } else {
            //     $output["head"]["code"] = 400;
            //     $output["head"]["msg"] = "Error Occurred. Please close the application and try again.";
            // }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Invalid Mobile Number.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
} else {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Parameter is Mismatch";
}


echo json_encode($output, JSON_NUMERIC_CHECK);
