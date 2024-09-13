<?php

include 'headers.php';
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$obj = json_decode($json);
$output = array();

date_default_timezone_set('Asia/Calcutta');
$timestamp = date('Y-m-d H:i:s');

// if ($loginpass == 1) {

// <<<<<<<<<<===================== This is to list users =====================>>>>>>>>>>
if (isset($obj->search_text)) {

    $userid = $obj->search_text;
    $sql = "SELECT * FROM `staff` WHERE `deleted_at` = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["staff"][$count] = $row;
            $output["body"]["staff"][$count]["permission"] = json_decode($row["permission"]);
            $mgLink = null;
            if ($row["img"] != null && $row["img"] != 'null' && strlen($row["img"]) > 0) {
                $imgLink = "https://" . $_SERVER['SERVER_NAME'] . "/uploads/staffs/" . $row["img"];
                $output["body"]["staff"][$count]["img"] = $imgLink;
            } else {
                $output["body"]["staff"][$count]["img"] = $imgLink;
            }
            $imgLink = null;
            $count++;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Success";
        $output["body"]["staff"] = [];
    }
}

// <<<<<<<<<<===================== This is to Create and Edit Staff =====================>>>>>>>>>>
else if (isset($obj->edit_staff_id) && isset($obj->staff_profile_img) && isset($obj->staff_name) && isset($obj->phone_number) && isset($obj->password) && isset($obj->permission) && isset($obj->current_user_id)) {

    $edit_staff_id = $obj->edit_staff_id;
    $staff_profile_img = $obj->staff_profile_img;
    $staff_name = $obj->staff_name;
    $phone_number = $obj->phone_number;
    $password = $obj->password;
    $permission = $obj->permission;
    $current_user_id = $obj->current_user_id;

    if (!empty($staff_name) && !empty($phone_number) && !empty($password) && !empty($permission) && !empty($current_user_id)) {

        if (!preg_match('/[^a-zA-Z0-9., ]+/', $staff_name)) {

            if (numericCheck($phone_number) && strlen($phone_number) == 10) {

                $current_user_name = getUserName($current_user_id);
                $permission = json_encode($permission);
                if (!empty($current_user_name)) {

                    if (isset($obj->edit_staff_id) && !empty($obj->edit_staff_id)) {
                        $edit_id = $obj->edit_staff_id;
                        if (staffExist($edit_id) && numericCheck($edit_id)) {
                            
                            $updateUser = "";
                            if (!empty($staff_profile_img)) {
                                $outputFilePath = "../uploads/staffs/";
                                if (isBase64ImageValid($staff_profile_img)) {
                                    $output["head"]["success"] = "Function Worked";
                                } else {
                                    $output["head"]["error"] = "Failed";
                                }
                                $profile_path = pngImageToWebP($staff_profile_img, $outputFilePath);
                                $updateUser = "UPDATE `staff` SET `staff_name`='$staff_name',`img`='$profile_path' , `phone`='$phone_number', `password`='$password', `created_by`='$current_user_id', `created_name`='$current_user_name', `permission` ='$permission'  WHERE `id`='$edit_id'";
                            } else {
                                $updateUser = "UPDATE `staff` SET `staff_name`='$staff_name', `phone`='$phone_number', `password`='$password', `created_by`='$current_user_id', `created_name`='$current_user_name', `permission` ='$permission'  WHERE `id`='$edit_id'";
                            }

                           // $updateUser = "UPDATE `staff` SET `staff_name`='$staff_name', `phone`='$phone_number', `password`='$password', `created_by`='$current_user_id', `created_name`='$current_user_name', `permission` ='$permission'  WHERE `id`='$edit_id'";
                            if ($conn->query($updateUser)) {
                                $output["head"]["code"] = 200;
                                $output["head"]["msg"] = "Successfully Staff Details Updated";
                            } else {
                                $output["head"]["code"] = 400;
                                $output["head"]["msg"] = "Failed to connect. Please try again.";
                            }
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Staff not found.";
                        }
                    } else {

                        $mobileCheck = $conn->query("SELECT `id` FROM `staff` WHERE `phone`='$phone_number'");
                        if ($mobileCheck->num_rows == 0) {
                            
                            $createUser = "";
                            if (!empty($user_profile_img)) {
                                $outputFilePath = "../uploads/staffs/";
                                $profile_path = pngImageToWebP($user_profile_img, $outputFilePath);
                                $createUser = "INSERT INTO `staff` (`staff_name`, `phone`, `password`, `deleted_at`, `created_by`, `created_name`, `created_date` ,`permission`,`img`) VALUES
                                     ('$staff_name', '$phone_number', '$password', '0', '$current_user_id', '$current_user_name', '$timestamp','$permission','$profile_path')";
                            } else {
                                $createUser = "INSERT INTO `staff` (`staff_name`, `phone`, `password`, `deleted_at`, `created_by`, `created_name`, `created_date` ,`permission`) VALUES
                                     ('$staff_name', '$phone_number', '$password', '0', '$current_user_id', '$current_user_name', '$timestamp','$permission')";
                            }

                            //$createUser = "INSERT INTO `staff` (`staff_name`, `phone`, `password`, `deleted_at`, `created_by`, `created_name`, `created_date` ,`permission`) VALUES
                            //         ('$staff_name', '$phone_number', '$password', '0', '$current_user_id', '$current_user_name', '$timestamp','$permission')";
                            if ($conn->query($createUser)) {
                                $output["head"]["code"] = 200;
                                $output["head"]["msg"] = "Successfully Staff Created";
                            } else {
                                $output["head"]["code"] = 400;
                                $output["head"]["msg"] = "Failed to connect. Please try again.";
                            }
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Mobile NUmber Already Exist.";
                        }
                    }
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "User not found.";
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Invalid Phone Number.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Staff Name Should be Alphanumeric.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}

// <<<<<<<<<<===================== This is to Delete the Staff =====================>>>>>>>>>>
 else if (isset($obj->delete_staff_id) && isset($obj->current_user_id) && isset($obj->image_delete)) {
    $delete_staff_id = $obj->delete_staff_id;
    $current_user_id = $obj->current_user_id;
    $image_delete = $obj->image_delete;

    if (!empty($delete_staff_id) && !empty($current_user_id)) {


        $current_user_name = getUserName($current_user_id);
        if (!empty($current_user_name)) {

            if ($image_delete === true) {

                $status = ImageRemove('staff', $delete_staff_id);
                if ($status == "staff Image Removed Successfully") {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "successfully staff Image deleted !.";
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "faild to deleted.please try againg.";
                }

            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Parameter is Mismatch";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "User not found.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}
// <<<<<<<<<<===================== This is to Delete the Staff =====================>>>>>>>>>>
else if (isset($obj->delete_staff_id) && isset($obj->current_user_id)) {

    $delete_staff_id = $obj->delete_staff_id;
    $current_user_id = $obj->current_user_id;


    if (!empty($delete_staff_id) && !empty($current_user_id)) {


        $current_user_name = getUserName($current_user_id);
        if (!empty($current_user_name)) {

            if (numericCheck($delete_staff_id) && numericCheck($current_user_id)) {
                $updateUser = "UPDATE `staff` SET `deleted_at`=1 WHERE `id`='$delete_staff_id'";
                if ($conn->query($updateUser)) {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "Successfully Staff Details Deleted Sucessfully.!";
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Failed to connect. Please try again.";
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Invalid data Staff.";
            }


        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "User not found.";
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
//     $output["head"]["code"] = 400;
//     $output["head"]["msg"] = "Invalid Session or the Session has been expired.";
// }



echo json_encode($output, JSON_NUMERIC_CHECK);
