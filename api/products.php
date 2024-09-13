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
    $search_text = $obj->search_text;
    $category_id =$obj->category_id;

    $sql = "SELECT * FROM `category` WHERE `deleted_at` = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output["body"]["category"][] = $row;
        }
    } else {
        $output["body"]["category"] = [];
    }
    // $sql = "SELECT * FROM `products` WHERE `deleted_at` = 'false' AND (`product_name` LIKE '%$search_text%' OR `name` LIKE '%$search_text%')";
    if($category_id == ""){
	 $sql = "SELECT * FROM `products` WHERE `deleted_at` = 'false' AND (`product_name` LIKE '%$search_text%' OR `name` LIKE '%$search_text%')";	
}else{
		 $sql = "SELECT * FROM `products` WHERE `deleted_at` = 'false' AND (`product_name` LIKE '%$search_text%' OR `name` LIKE '%$search_text%') AND category_id ='$category_id'";
	}
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["products"][$count] = $row;
            $mgLink = null;
            if ($row["img"] != null && $row["img"] != 'null' && strlen($row["img"]) > 0) {
                $imgLink = "https://" . $_SERVER['SERVER_NAME'] . "/uploads/products/" . $row["img"];
                $output["body"]["products"][$count]["img"] = $imgLink;
            } else {
                $output["body"]["products"][$count]["img"] = $imgLink;
            }
            $imgLink = null;
            $count++;
        }
    } else {
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Success";
        $output["body"]["products"] = [];
    }
} else if (isset($obj->edit_product_id) && isset($obj->category_id) && isset($obj->product_name) && isset($obj->product_img) && isset($obj->product_code) && isset($obj->product_content) && isset($obj->qr_code) && isset($obj->price) && isset($obj->video_url) && isset($obj->discount_lock) && isset($obj->active) && isset($obj->current_user_id)) {
    $edit_product_id = $obj->edit_product_id;
    $category_id = $obj->category_id;
    $product_name = $obj->product_name;
    $product_img = $obj->product_img;
    $product_code = $obj->product_code;
    $product_content = $obj->product_content;
    $qr_code = $obj->qr_code;
    $price = $obj->price;
    $video_url = $obj->video_url;
    $discount_lock = $obj->discount_lock;
    $active = $obj->active;
    $current_user_id = $obj->current_user_id;

    if (!empty($category_id) && !empty($product_name) && !empty($product_content) && !empty($price)) {
        $category_name = getCategoryName($category_id);
        if ($category_name != null && !empty($category_name)) {
            $current_user_name = getUserName($current_user_id);
            $discount_lock = (int)$discount_lock;
            $active = (int)$active;

            if (!empty($current_user_name)) {
                if (!empty($edit_product_id)) {
                    $name = convertUniqueName($product_name);
                    $updateProducts = "";
                    if (!empty($product_img)) {
                        $outputFilePath = "../uploads/products/";
                        $profile_path = pngImageToWebP($product_img, $outputFilePath);
                        $updateProducts = "UPDATE `products` SET `product_name`='$product_name',`img` = '$profile_path', `category_id`='$category_id', `product_content`='$product_content', `product_code`='$product_code', `price`='$price', `qr_code`='$qr_code', `video_url`='$video_url', `name`='$name',`discount_lock` = '$discount_lock', `active` = '$active' WHERE `id`='$edit_product_id'";
                    } else {
                        $updateProducts = "UPDATE `products` SET `product_name`='$product_name', `category_id`='$category_id', `product_content`='$product_content', `product_code`='$product_code', `price`='$price', `qr_code`='$qr_code', `video_url`='$video_url', `name`='$name',`discount_lock` = '$discount_lock', `active` = '$active' WHERE `id`='$edit_product_id'";
                    }
                    //$updateProducts = "UPDATE `products` SET `product_name`='$product_name', `category_id`='$category_id', `product_content`='$product_content', `product_code`='$product_code', `price`='$price', `qr_code`='$qr_code', `video_url`='$video_url', `name`='$name',`discount_lock` = '$discount_lock', `active` = '$active' WHERE `id`='$edit_product_id'";
                    if ($conn->query($updateProducts)) {
                        $output["head"]["code"] = 200;
                        $output["head"]["msg"] = "Successfully Products Details Updated";
                    } else {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = "Failed to connect. Please try again." . $conn->error;
                    }
                } else {
                    $name = convertUniqueName($product_name);
                   
                   $create_product_sql = "";
                    if (!empty($product_img)) {
                        $outputFilePath = "../uploads/products/";
                        $profile_path = pngImageToWebP($product_img, $outputFilePath);
                        $create_product_sql = "INSERT INTO `products`(`product_name`, `category_id`, `product_content`, `product_code`, `price`, `qr_code`, `video_url`, `name`, `position`, `deleted_at`, `created_by`,`created_name`, `created_time`,`discount_lock`,`active` ,`img`)
                     VALUES ('$product_name','$category_id','$product_content','$product_code','$price','$qr_code','$video_url','$name','0','false','$current_user_id','$current_user_name','$timestamp','$discount_lock','$active','$profile_path')";
                    } else {
                        $create_product_sql = "INSERT INTO `products`(`product_name`, `category_id`, `product_content`, `product_code`, `price`, `qr_code`, `video_url`, `name`, `position`, `deleted_at`, `created_by`,`created_name`, `created_time`,`discount_lock`,`active`)
                     VALUES ('$product_name','$category_id','$product_content','$product_code','$price','$qr_code','$video_url','$name','0','false','$current_user_id','$current_user_name','$timestamp','$discount_lock','$active')";
                    }
                   // $create_product_sql = "INSERT INTO `products`(`product_name`, `category_id`, `product_content`, `product_code`, `price`, `qr_code`, `video_url`, `name`, `position`, `deleted_at`, `created_by`,`created_name`, `created_time`,`discount_lock`,`active`)
                    // VALUES ('$product_name','$category_id','$product_content','$product_code','$price','$qr_code','$video_url','$name','0','false','$current_user_id','$current_user_name','$timestamp','$discount_lock','$active')";

                    if ($conn->query($create_product_sql)) {
                        $output["head"]["code"] = 200;
                        $output["head"]["msg"] = "Successfully Product Created";
                    } else {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = $conn->error;
                    }
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "User not found.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Category Details Not Found";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}  else if (isset($obj->delete_product_id) && isset($obj->current_user_id) && isset($obj->image_delete)) {

    $delete_product_id = $obj->delete_product_id;
    $current_user_id = $obj->current_user_id;
    $image_delete = $obj->image_delete;

    if (!empty($delete_product_id) && !empty($current_user_id)) {

        $current_user_name = getUserName($current_user_id);
        if (!empty($current_user_name)) {

            if ($image_delete === true) {

                $status = ImageRemove('product', $delete_product_id);
                if ($status == "products Image Removed Successfully") {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "successfully product Image deleted !.";
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
} else if (isset($obj->delete_product_id) && isset($obj->current_user_id)) {

    $delete_product_id = $obj->delete_product_id;
    $current_user_id = $obj->current_user_id;

    if (!empty($delete_product_id) && !empty($current_user_id)) {

        if (numericCheck($delete_product_id) && numericCheck($current_user_id)) {
            $updateUser = "UPDATE `products` SET `deleted_at`=1 WHERE `id`='$delete_product_id'";
            if ($conn->query($updateUser)) {
                $output["head"]["code"] = 200;
                $output["head"]["msg"] = "Product Deleted Successfully!";
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "Failed to connect. Please try again.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Invalid data Product.";
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
