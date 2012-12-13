<?php
function preprocessFilter($filter){
    if (gettype($filter) == "array"){
        return $filter;
    }else{
        $filters = explode(";", $filter);
        $list = array();
        foreach ($filters as $filter){
            list($key, $val) = explode("=", $filter);
            $list[$key] = $val;
        }
        return $list;
    }
}

function uses(){
    $args = func_get_args();
    foreach ($args as $file){
        require_once(ROOT_PATH."models/". strtolower($file).'_model.php');
    }
}

function getFlag($flag) {
    $s = "";
    switch ($flag) {
	case 0:
	    $s = "";
	    break;
	case 1:
	    $s = "h";
	    break;
	case 2:
	    $s = "c";
	    break;
	case 3:
	    $s = "f";
	    break;
	case 4:
	    $s = 'a';
	    break;
	case 5:
	    $s = "s";
	    break;
	case 6:
	    $s = "b";
	    break;
	default:
	    $s = "";
	    break;
    }
    return $s;
}

function getFlags($flags) {
    $flags = explode(",", $flags);
    $f = array();
    for ($c = 0; $c < count($flags); $c++) {
	$flag = trim($flags[$c]);
	$f[] = getFlag($flag);
    }

    return join(",", $f);
}

//return json when the header sets HTTP_ACCEPT is "application/json"
//else return normal data
function send_ajax_response($status, $msg = '', $errorids = array()) {
    uses("service");
    $service = new service_model();
    $header = $service->getJSONHeader();

    $data = array(
	'code' => $status,
	'guidKey' => $header->guidKey,
	'msg' => $msg
    );
    $error = array();
    foreach ($errorids as $v) {
	$error[] = array(
	    "errorId" => $v
	);
    }
    $data["error"] = $error;
    
    if (!empty($header) && !empty($header->guidKey)) {
	$info = $service->get_one(array('guid' => $header->guidKey));
	$dddd = array(
            "guid" => $header->guidKey,
            "pushtime" => $header->pushTime,
            "method" => $header->method,
            "is_success" => (count($errorids) == 0 ? 1 : 0)
	);
	if (is_array($info)){
	    $service->update($dddd, array("guid" => $header->guidKey));
	}else{
	    $service->insert($dddd);
	}
    }
    
    if ($_SERVER["HTTP_ACCEPT"] == "application/json") {
	echo json_encode($data);
	return true;
    }else{
	return $data;
    }
    exit();
}
?>
