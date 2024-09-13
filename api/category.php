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
   $sql = "SELECT * FROM `category` WHERE `deleted_at` = 0 AND `category_name` LIKE '%$search_text%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["category"][] = $row;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Success";
        $output["body"]["category"] = [];
    }
}

// <<<<<<<<<<===================== This is to Create and Edit Category =====================>>>>>>>>>>
else if (isset($obj->edit_category_id) && isset($obj->category_name) && isset($obj->discount) && isset($obj->current_user_id)) {

    $edit_category_id = $obj->edit_category_id;
    $category_name = $obj->category_name;
    $current_user_id = $obj->current_user_id;
    $discount = $obj->discount;
    
    // if(empty($discount)){
    //     $discount="null";
    // }

    if (!empty($category_name) && !empty($current_user_id)) {

        if (!preg_match('/[^a-zA-Z0-9., ]+/', $category_name)) {

            if (numericCheck($current_user_id)) {

                $current_user_name = getUserName($current_user_id);

                if (!empty($current_user_name)) {

                    if (!empty($edit_category_id)) {

                        $name = convertUniqueName($category_name);
                        
                        if(empty($discount)){
                           $updateUser = "UPDATE `category` SET `name`='$name', `category_name`='$category_name',`discount`=null WHERE `id`='$edit_category_id'"; 
                        }else{

                        $updateUser = "UPDATE `category` SET `name`='$name', `category_name`='$category_name',`discount`='$discount' WHERE `id`='$edit_category_id'";
                        }
                        if ($conn->query($updateUser)) {
                            $output["head"]["code"] = 200;
                            $output["head"]["msg"] = "Successfully Category Details Updated";
                            $output["head"]["query"] = $updateUser;
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Failed to connect. Please try again.";
                        }
                    } else {
                        $name = convertUniqueName($category_name);
                        $categoryCheck = $conn->query("SELECT `id` FROM `category` WHERE `name`='$name'");
                        if ($categoryCheck->num_rows == 0) {

                            $createCategory = "INSERT INTO `category` (`category_name`, `name`, `discount`, `created_by`, `created_name`, `deleted_at`) VALUES ('$category_name', '$name', '$discount', '$current_user_id', '$current_user_name', '0')";
                            if ($conn->query($createCategory)) {
                                $output["head"]["code"] = 200;
                                $output["head"]["msg"] = "Successfully Category Created";
                                $output["head"]["query"] = $createCategory;
                                
                            } else {
                                $output["head"]["code"] = 400;
                                $output["head"]["msg"] = "Failed to connect. Please try again.";
                            }
                        } else {
                            $output["head"]["code"] = 400;
                            $output["head"]["msg"] = "Category Name Already Exist.";
                        }
                    }
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "User not found.";
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Error Occurred: Please restart the application and try again.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Category Should be Alphanumeric.";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}

// <<<<<<<<<<===================== This is to Delete the users =====================>>>>>>>>>>
else if (isset($obj->delete_category_id) && isset($obj->current_user_id)) {

    $delete_category_id = $obj->delete_category_id;
    $current_user_id = $obj->current_user_id;

    if (!empty($delete_category_id) && !empty($current_user_id)) {

        if (numericCheck($current_user_id)) {
            $current_user_name = getUserName($current_user_id);

            if (!empty($current_user_name)) {
                $deleteCategory = "UPDATE `category` SET `deleted_at`=1  WHERE `id`='$delete_category_id'";
                if ($conn->query($deleteCategory)) {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "Category Deleted Successfully.!";
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Failed to connect. Please try again.";
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "User not found.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Invalid data's.";
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
