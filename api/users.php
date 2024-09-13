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
    $search_text = $obj->search_text;
    $sql = "SELECT * FROM `user` WHERE `deleted_at` = 0 AND `name` LIKE '%$search_text%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["user"][$count] = $row;
            $mgLink = null;
            if ($row["img"] != null && $row["img"] != 'null' && strlen($row["img"]) > 0) {
                $imgLink = "https://".$_SERVER['SERVER_NAME'] . "/uploads/users/" . $row["img"];
                $output["body"]["user"][$count]["img"] = $imgLink;
            } else {
                $output["body"]["user"][$count]["img"] = $imgLink;
            }
            $imgLink = null;
            $count++;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "User Details Not Found";
        $output["body"]["user"] = [];
    }
}

// <<<<<<<<<<===================== This is to Create and Edit users =====================>>>>>>>>>>
else if (isset($obj->user_profile_img) && isset($obj->user_name) && isset($obj->phone_number) && isset($obj->password) && isset($obj->current_user_id)) {

    $user_profile_img = $obj->user_profile_img;
    $user_name = $obj->user_name;
    $phone_number = $obj->phone_number;
    $password = $obj->password;
    $current_user_id = $obj->current_user_id;

    if (!empty($user_name) && !empty($phone_number) && !empty($password) && !empty($current_user_id)) {

        if (!preg_match('/[^a-zA-Z0-9., ]+/', $user_name)) {

            if (numericCheck($phone_number) && strlen($phone_number) == 10) {

                if (numericCheck($current_user_id)) {

                    $current_user_name = getUserName($current_user_id);

                    if (!empty($current_user_name)) {

                        if (isset($obj->edit_user_id)) {
                            $edit_id = $obj->edit_user_id;
                            if (userExist($edit_id) && numericCheck($edit_id)) {

                                //$updateUser = "UPDATE `user` SET `name`='$user_name', `phone`='$phone_number', `password`='$password', `last_edit_id`='$current_user_id', `editor_name`='$current_user_name', `edited_date`='$timestamp' WHERE `id`='$edit_id'";
                                $updateUser = "";
                                if (!empty($user_profile_img)) {
                                    $outputFilePath = "../uploads/users/";
                                    $profile_path = pngImageToWebP($user_profile_img, $outputFilePath);
                                    $updateUser = "UPDATE `user` SET `name`='$user_name', `img`='$profile_path', `phone`='$phone_number', `password`='$password', `last_edit_id`='$current_user_id', `editor_name`='$current_user_name', `edited_date`='$timestamp' WHERE `id`='$edit_id'";
                                } else {
                                    $updateUser = "UPDATE `user` SET `name`='$user_name', `phone`='$phone_number', `password`='$password', `last_edit_id`='$current_user_id', `editor_name`='$current_user_name', `edited_date`='$timestamp' WHERE `id`='$edit_id'";
                                }
                                
                                if ($conn->query($updateUser)) {
                                    $output["head"]["code"] = 200;
                                    $output["head"]["msg"] = "Successfully User Details Updated";
                                } else {
                                    $output["head"]["code"] = 400;
                                    $output["head"]["msg"] = "Failed to connect. Please try again.".$conn->error;
                                }
                            } else {
                                $output["head"]["code"] = 400;
                                $output["head"]["msg"] = "User not found2.";
                            }
                        } else {

                            $mobileCheck = $conn->query("SELECT `id` FROM `user` WHERE `phone`='$phone_number'");
                            if ($mobileCheck->num_rows == 0) {

                               // $createUser = "INSERT INTO `user` (`name`, `phone`, `admin`, `password`, `deleted_at`, `created_date`, `last_edit_id`, `editor_name`, `edited_date`) VALUES ('$user_name', '$phone_number', '0', '$password', '0', '$timestamp', '$current_user_id', '$current_user_name', '$timestamp') ";
                                $createUser = "";
                                if (!empty($user_profile_img)) {
                                    $outputFilePath = "../uploads/users/";
                                    $profile_path = pngImageToWebP($user_profile_img, $outputFilePath);
                                    $createUser = "INSERT INTO `user` (`name`, `phone`, `admin`, `password`, `deleted_at`, `created_date`, `last_edit_id`, `editor_name`, `edited_date`,`img`) VALUES ('$user_name', '$phone_number', '0', '$password', '0', '$timestamp', '$current_user_id', '$current_user_name', '$timestamp','$profile_path') ";
                                } else {
                                    $createUser = "INSERT INTO `user` (`name`, `phone`, `admin`, `password`, `deleted_at`, `created_date`, `last_edit_id`, `editor_name`, `edited_date`) VALUES ('$user_name', '$phone_number', '0', '$password', '0', '$timestamp', '$current_user_id', '$current_user_name', '$timestamp') ";
                                }
                                if ($conn->query($createUser)) {
                                    $output["head"]["code"] = 200;
                                    $output["head"]["msg"] = "Successfully User Created";
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
                        $output["head"]["msg"] = "User not found1.";
                        $output["head"]["user_name"] = $current_user_name;
                    }
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Error Occurred: Please restart the application and try again.";
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Invalid Phone Number.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Username Should be Alphanumeric.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}

// <<<<<<<<<<===================== This is to Delete the users =====================>>>>>>>>>>
 else if (isset($obj->delete_user_id) && isset($obj->current_user_id) && isset($obj->image_delete)) {
    $delete_user_id = $obj->delete_user_id;
    $current_user_id = $obj->current_user_id;
    $image_delete = $obj->image_delete;


    if (!empty($delete_user_id) && !empty($current_user_id)) {


        $current_user_name = getUserName($current_user_id);
        if (!empty($current_user_name)) {

            if ($image_delete === true) {

                $status = ImageRemove('user', $delete_user_id);
                if ($status == "User Image Removed Successfully") {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "successfully user Image deleted !.";
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
// <<<<<<<<<<===================== This is to Delete the users =====================>>>>>>>>>>
else if (isset($obj->delete_user_id) && isset($obj->current_user_id)) {

    $delete_user_id = $obj->delete_user_id;
    $current_user_id = $obj->current_user_id;


    if (!empty($delete_user_id) && !empty($current_user_id)) {

        if (numericCheck($delete_user_id) && numericCheck($current_user_id)) {
            $deleteuser = "UPDATE `user` SET `deleted_at`=1 where `id`='$delete_user_id'";
            if ($conn->query($deleteuser) === true) {
                $output["head"]["code"] = 200;
                $output["head"]["msg"] = "successfully user deleted !.";
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "faild to deleted.please try againg.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Invalid data's.";
        }
        // if ($image_delete === true) {

        //     $status = ImageRemove('user', $delete_user_id);
        //     if ($status == "User Image Removed Successfully") {
        //         $output["head"]["code"] = 200;
        //         $output["head"]["msg"] = "successfully user Image deleted !.";
        //     } else {
        //         $output["head"]["code"] = 400;
        //         $output["head"]["msg"] = "faild to deleted.please try againg.";
        //     }

        // } else {
        //     $output["head"]["code"] = 400;
        //     $output["head"]["msg"] = "Parameter is Mismatch";
        // }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
} else {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Parameter is Mismatch";
    $output["head"]["inputs"] = $obj;
}
// } else {
//     $output["head"]["code"] = 400;
//     $output["head"]["msg"] = "Invalid Session or the Session has been expired.";
// }



echo json_encode($output, JSON_NUMERIC_CHECK);
