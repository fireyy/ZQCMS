<?php
//return json when the header sets HTTP_ACCEPT is "application/json"
//else return normal data
function send_ajax_response($status, $msg = '', $errorids = array()) {
    $service = new service_model();
    $header = $service->getJSONHeader();
    $data = array(
	'code' => $status,
	'guidKey' => $header->guid,
	'msg' => $msg
    );
    $error = array();
    foreach ($errorids as $v) {
	$error[] = array(
	    "errorId" => $v
	);
    }
    $data["error"] = $error;
    
    //if (!empty($header) && !empty($header->guidKey)) {
    //    $info = $service->get_one(array('guid' => $header->guidKey));
    //    $dddd = array(
    //        "guid" => $header->guidKey,
    //        "pushtime" => $header->pushTime,
    //        "method" => $header->method,
    //        "is_success" => (count($errorids) == 0 ? 1 : 0)
    //    );
    //    if (is_array($info)){
    //        $service->update($dddd, array("guid" => $header->guidKey));
    //    }else{
    //        $service->insert($dddd);
    //    }
    //}
    
    //if ($_SERVER["HTTP_ACCEPT"] == "application/json") {
    echo json_encode($data);
    //	return true;
    //}else{
    //    return $data;
    //}
    exit();
}
?>
