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
     $form_date = $obj->form_date;
    $to_date = $obj->to_date;
    $to_date= date('Y-m-d', strtotime($to_date. '+ 1 days'));
    $status = $obj->status;
	
// echo $from_date=strtotime($form_date);
// echo $to_date=strtotime($to_date);

if($status == ""){
   $sql = "SELECT * FROM `online_enquiry` WHERE `deleted_at` = 0 AND (created_date BETWEEN '$form_date' AND '$to_date') OR status ='$status'   ORDER BY `id` DESC";  
}else{
$sql = "SELECT * FROM `online_enquiry` WHERE `deleted_at` = 0 AND (created_date BETWEEN '$form_date' AND '$to_date') AND status ='$status'   ORDER BY `id` DESC";
}

   

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["enquiry"][$count] = $row;
            $output["body"]["enquiry"][$count]["products"] = json_decode($row["products"]);
            $timestamp = strtotime($row["created_date"]);
            $output["body"]["enquiry"][$count]["created_date"] = date('d/m/Y', $timestamp);
            $count++;
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Online Enquiry Details Not Found";
    }
} else if (isset($obj->order_id) && isset($obj->status)) {
    $orderID = $obj->order_id;
    $status = $obj->status;

    if (!empty($orderID) && !empty($status)) {
        $update_status = "UPDATE `online_enquiry` SET `status`='$status' WHERE `id`='$orderID'";
        if ($conn->query($update_status)) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Status Updated";
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Status Failed" . $conn->error;
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Parameter is Mismatch";
    }
} else {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Parameter is Mismatch";
}



echo json_encode($output, JSON_NUMERIC_CHECK);
