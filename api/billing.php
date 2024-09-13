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
    $sql = "SELECT * FROM `category` WHERE `deleted_at` = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["category"][$count] = $row;
            $categoryID = $row["id"];
            $productsql = "SELECT * FROM `products` WHERE `category_id` = '$categoryID' AND `deleted_at` = 'false'";
            $productresult = $conn->query($productsql);
            if ($productresult->num_rows > 0) {
                $product_count = 0;
                while ($productrow = $productresult->fetch_assoc()) {
                    $output["body"]["category"][$count]["products"][$product_count] = $productrow;
                    $output["body"]["category"][$count]["products"][$product_count]["category_name"] = $row["category_name"];
                    $mgLink = null;
                    if ($productrow["img"] != null && $productrow["img"] != 'null' && strlen($productrow["img"]) > 0) {
                        $imgLink = "https://" . $_SERVER['SERVER_NAME'] . "/uploads/products/" . $productrow["img"];
                        $output["body"]["category"][$count]["products"][$product_count]["img"] = $imgLink;
                    } else {
                        $output["body"]["category"][$count]["products"][$product_count]["img"] = $imgLink;
                    }
                    $imgLink = null;
                    $product_count++;
                }
            } else {
                $output["body"]["category"][$count]["products"] = [];
            }
            $count++;
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Category Details Not Found";
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
