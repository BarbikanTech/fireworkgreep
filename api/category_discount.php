<?php
include 'headers.php';

header('Content-Type: application/json; charset=utf-8');

$jsonData = file_get_contents('php://input');
$obj = json_decode($jsonData);

$output = array();
$erroroutput = array();

date_default_timezone_set('Asia/Calcutta');
$timestamp = date('Y-m-d H:i:s');

if (json_last_error() !== JSON_ERROR_NONE) {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Invalid JSON input";
} else {
    if (isset($obj->search_text)) {

        // List Discount Categories
        $output["head"]["code"] = 200;
        $output["head"]["msg"] = "Success";
        $output["body"]["discount"] = array();
        $output["body"]["with_out_discount_category"] = array();

        // Query for categories with discount
        $sql = "SELECT DISTINCT discount FROM `category` WHERE `discount` IS NOT NULL AND deleted_at = 0";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $discount = $row["discount"];
                $categories = array();

                // Fetch categories for this discount
                $sql = "SELECT `id`, `category_name` FROM `category` WHERE `discount` = '$discount' AND deleted_at = 0";
                $catResult = $conn->query($sql);

                if ($catResult) {
                    while ($catRow = $catResult->fetch_assoc()) {
                        $categoryItem = array(
                            "category_id" => $catRow["id"],
                            "category_name" => $catRow["category_name"]
                        );
                        $categories[] = $categoryItem;
                    }
                }

                $discountItem = array(
                    "discount" => $discount,
                    "category" => $categories
                );

                $output["body"]["discount"][] = $discountItem;
            }
        }

        // Query for categories without discount
        $sql1 = "SELECT `id`, `category_name` FROM `category` WHERE `discount` IS NULL AND deleted_at = 0";
        $result1 = $conn->query($sql1);

        if ($result1) {
            while ($row1 = $result1->fetch_assoc()) {
                $categoryItem = array(
                    "category_id" => $row1["id"],
                    "category_name" => $row1["category_name"]
                );
                $output["body"]["with_out_discount_category"][] = $categoryItem;
            }
        }
    } else if (isset($obj->discount, $obj->category, $obj->current_user_id)) {
        // Add Discount to Categories
        $discount = $obj->discount;
        $current_user_id = $obj->current_user_id;


        if (!empty($discount) && is_numeric($discount) && !empty($current_user_id) && is_numeric($current_user_id)) {
            $current_user_name = getUserName($current_user_id);

            if ($current_user_name !== 0) {
                if (numericCheck($discount)) {


                    /* foreach ($obj['category'] as $item) {
                         $category_id = $item['category_id'];
                         $active = $item['active'];
                        
                         if ($active === true) {
                             $updateCategory = "UPDATE `category` SET `discount`='$discount', `last_edit_id`='$current_user_id', `editor_name`='$current_user_name', `edited_date`='$timestamp' WHERE `id`='$category_id'";
                         } else {
                             $updateCategory = "UPDATE `category` SET `discount`='', `last_edit_id`='$current_user_id', `editor_name`='$current_user_name', `edited_date`='$timestamp' WHERE `id`='$category_id'";
                         }

                         if ($conn->query($updateCategory) !== true) {
                             $erroroutput["error"][] = $conn->error;
                             $erroroutput["error_products"][] = $category;
                         }
                         
                     }*/
                    // echo 1;ithuvaraikum work aguthu
                    $category = $obj->category;
                    // var_dump($category);

                    try {
                        foreach ($obj->category as $item) {
                            // ithukula pona 500 error amacha
                            $category_id = $item->category_id;
                            $active = $item->active;

                            if ($active === true) {
                                $updateCategory = "UPDATE `category` SET `discount`='$discount', `created_by`='$current_user_id', `created_name`='$current_user_name', `created_time`='$timestamp' WHERE `id`='$category_id'";
                            } else {
                                $updateCategory = "UPDATE `category` SET `discount`=null, `created_by`='$current_user_id', `created_name`='$current_user_name', `created_time`='$timestamp' WHERE `id`='$category_id'";
                            }

                            if ($conn->query($updateCategory) !== true) {
                                throw new Exception("Database error: " . $conn->error);
                            }
                        }
                        // If all queries succeed, you can set a success message here.
                        $output["head"]["code"] = 200;
                        $output["head"]["msg"] = "Successfully updated categories Discounts";
                    } catch (Exception $e) {

                        // Handle the exception here
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = "Failed to connect. Please try again." . $e->getMessage();
                        $erroroutput["error"][] = $e->getMessage();
                        $erroroutput["error_category"][] = $category;
                    }


                    // Check if there were any errors during the loop
                    /*if (empty($erroroutput["error"])) {
                        $output["head"]["code"] = 200;
                        $output["head"]["msg"] = "Successfully Discount Updated";
                    } else {
                        $output["head"]["code"] = 400;
                        $output["head"]["msg"] = "Failed to connect. Please try again.";
                    }*/
                } else {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Discount Percentage Should be Numeric.";
                }
            } else {
                $output["head"]["code"] = 400;
                $output["head"]["msg"] = "User not found.";
            }
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Invalid input data";
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}

// Send JSON response
echo json_encode($output, JSON_NUMERIC_CHECK);
