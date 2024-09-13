<?php
include 'headers.php';
header('Content-Type: application/json; charset=utf-8');

// Get JSON data from request
$jsonData = file_get_contents('php://input');
$obj = json_decode($jsonData, true);

$output = array();
$erroroutput = array();

date_default_timezone_set('Asia/Calcutta');
$timestamp = date('Y-m-d H:i:s');

if (isset($obj['replace_and_delete'], $obj['current_user_id'], $obj['products'])) {
    $replace_and_delete = $obj['replace_and_delete'];
    $current_user_id = $obj['current_user_id'];

    // Empty data validations
    if (!empty($current_user_id)) {

        if (numericCheck($current_user_id)) {

            $current_user_name = getUserName($current_user_id);

            if (!empty($current_user_name)) {

                // Clean up inputs
                $replace_and_delete = filter_var($replace_and_delete, FILTER_VALIDATE_BOOLEAN);

                if ($replace_and_delete === true) {
                    $deleteCategoriesQuery = "UPDATE category SET deleted_at = 1";
                    $deleteProductsQuery = "UPDATE products SET deleted_at = 1";
                    if ($conn->query($deleteCategoriesQuery) && $conn->query($deleteProductsQuery)) {
                    } else {
                        $erroroutput["error"][] = $conn->error;
                    }
                }
                foreach ($obj['products'] as $product) {
                    $category_name = $product['category_name'];
                    $product_name = $product['product_name'];
                    $product_code = $product['product_code'];
                    $content = $product['content'];
                    $qr_code = $product['qr_code'];
                    $price = $product['price'];

                    // Category section
                    $namecategory = convertUniqueName($category_name);

                    // Check if category exists
                    $existingCategoryQuery = "SELECT `id` FROM `category` WHERE `name` = '$namecategory' AND deleted_at='0'";
                    $existingCategoryResult = $conn->query($existingCategoryQuery);

                    if ($existingCategoryResult->num_rows == 0) {
                        // Category doesn't exist, insert it
                        $insertcategoryQuery = "INSERT INTO `category`(`category_name`, `name`, `created_by`, `deleted_at`, `created_time`,`created_name`) VALUES ('$category_name','$namecategory','$current_user_id','0','$timestamp','$current_user_name')";
                        if ($conn->query($insertcategoryQuery) === false) {
                            $erroroutput["error"][] = $conn->error;
                            $erroroutput["error_products"][] = $product;
                            continue; // Skip processing this product
                        }
                        $category_id = $conn->insert_id;
                    } else {
                        // Category already exists
                        $rowc = $existingCategoryResult->fetch_assoc();
                        $category_id = $rowc["id"];
                    }

                    // Products section
                    $nameproduct = convertUniqueName($product_name);

                    // Check if product exists
                    $existingProductQuery = "SELECT `id` FROM `products` WHERE `name` = '$nameproduct' AND deleted_at='false'";
                    $existingProductResult = $conn->query($existingProductQuery);

                    if ($existingProductResult->num_rows > 0) {
                        // Product already exists
                        $rowp = $existingProductResult->fetch_assoc(); // Use fetch_assoc() here
                        $product_id = $rowp["id"];
                        $updateProductQuery = "UPDATE `products` SET `product_name` = '$product_name',`category_id`='$category_id',`product_code`='$product_code',`product_content`='$content',`qr_code`='$qr_code',`price`='$price',`name`='$nameproduct' WHERE  `id`='$product_id'";
                        if ($conn->query($updateProductQuery) === false) {
                            $erroroutput["error1"][] = $conn->error;
                            $erroroutput["error_products1"][] = $product;
                        }
                    } else {
                        // Product doesn't exist, insert it
                        $insertProductQuery = "INSERT INTO products (product_name, `category_id`, product_code, product_content, qr_code, price, `name`, `deleted_at`, `created_by`, `created_time`,`active`,`discount_lock`,`created_name`) VALUES ('$product_name', '$category_id', '$product_code', '$content', '$qr_code', '$price', '$nameproduct', 'false', '$current_user_id', '$timestamp','1','0','$current_user_name')";
                        if ($conn->query($insertProductQuery) === FALSE) {
                            $erroroutput["error"][] = $conn->error;
                            $erroroutput["error_products"][] = $product;
                        }
                    }
                }

                if (count($erroroutput) > 0) {
                    $output["head"]["code"] = 400;
                    $output["head"]["msg"] = "Failed";
                    $output["body"] = $erroroutput;
                } else {
                    $output["head"]["code"] = 200;
                    $output["head"]["msg"] = "Bulk Excel Product uploaded.";
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
        $output["head"]["msg"] = "Error Occurred: Please restart the application and try again.";
    }
} else {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Please provide all the required details.";
}
// Send JSON response
echo json_encode($output, JSON_NUMERIC_CHECK);
