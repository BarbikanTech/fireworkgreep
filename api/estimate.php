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
    $sql = "SELECT * FROM `estimate` WHERE `deleted_at` = 0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["estimate"][$count] = $row;
            $estimate_id = $row["estimate_id"];
            $productsql = "SELECT * FROM `estimate_products` WHERE `estimate_id` = '$estimate_id'";
            $productresult = $conn->query($productsql);
            if ($productresult->num_rows > 0) {
                while ($productrow = $productresult->fetch_assoc()) {
                    $output["body"]["estimate"][$count]["products"][] = $productrow;
                }
            } else {
                $output["body"]["estimate"][$count]["products"][] = [];
            }
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "estimate Details Not Found";
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
