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
    $sql = "SELECT * FROM `setting`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Success";
            $output["body"]["settings"] = $row;
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Settings Details Not Found";
    }
} else if (isset($obj->footer) && isset($obj->thank) && isset($obj->terms)) {

    $footer = $obj->footer;
    $thank = $obj->thank;
    $terms = $obj->terms;


    if (!empty($footer) || !empty($thank) || !empty($terms)) {

        $edit_id = 1;
        $updateCompany = "UPDATE `setting` SET `footer`='$footer', `thank_you_message`='$thank', `terms_and_condition`='$terms' WHERE `id`='$edit_id'";
        if ($conn->query($updateCompany)) {
            $output["head"]["code"] = 200;
            $output["head"]["msg"] = "Successfully Page Settings Details Updated";
        } else {
            $output["head"]["code"] = 400;
            $output["head"]["msg"] = "Failed to connect. Please try again.".$conn->error;
        }
    } else {
        $output["head"]["code"] = 400;
        $output["head"]["msg"] = "Please provide all the required details.";
    }
}

// <<<<<<<<<<===================== This is to Delete the users =====================>>>>>>>>>>

else {
    $output["head"]["code"] = 400;
    $output["head"]["msg"] = "Parameter is Mismatch";
}



echo json_encode($output, JSON_NUMERIC_CHECK);
