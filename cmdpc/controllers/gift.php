<?php
class gift_controller {
    public function __construct() { 
	$this->model = new zq_core::load_model("gift_model");
	
	$this->service = new service_model();
	list($header, $data) = $this->service->getJSON();

	$method = $header->method;
	//$this->parse($data, $method);
    }

    private function parse($data, $method) {
	if($data) {
	    $errorids = array();
	    $count = count($data);
	    // 0: ok,  -1: empty data, -2: insert fail
	    $status =0;
	    $msg=" ";
	    for ( $c = 0; $c<$count ;++$c) {
		$_data=$data[$c];
		$guid = $_data->guid;
		if($guid){
		    switch ($method) {
        	        case "add":
			    if ($this->add($_data)){
			    }else{
				$errorids[] = $guid;
				$status = -2;
				$msg = "插入数据失败.";
			    }
        		    break;
        	        case "delete":
        		    $this->delete($guid);
        		    break;
        	        case "update":
        		    $this->update($_data);
        		    break;
        	        default:
        		    send_ajax_response("-4", "未知操作, 你需要对我干吗?");
			    exit();
        	    }
		}
	    }
	    if($status == 0){
		$msg = "操作成功!";
	    }

	    send_ajax_response($status, $msg, $errorids);
	}else {
	    send_ajax_response("-1","数据为空或者数据非法无法正常解析.");
	}
    }

    private function update($data) {
	$guid = $data->guid;
	$info = $this->archives->get_one(array('guid' => $guid));
	if (is_array($info)) {
	    $id = $info["id"];
	    $typeid = $info["typeid"];
	    
	    $update_data = array(
		'flag' => getFlags($data->isTop),
		'ismake' => -1,
		'arcrank' => 0,
		'mid' => 1,
		'title'  => trim($data->giftTitle),
		'shorttitle' => trim($data->giftTitle),
		'color' => $data->fontColor,
		'dutyadmin' => 1
	    );
	    $this->archives->update($update_data, array(
		'id' => $id,
		'typeid' => $typeid
	    ));

	    $update_data = array(
		'game_name' => trim($data->gameName),
		'gift_title' => trim($data->giftTitle),
		'oper_short_name' => trim($data->operShortName),
		'send_date' => $data->sendDate /1000,
		'get_url' => trim($data->getUrl),
		'copy_from' => $data->copyFrom,
		"game_id" => $data->gameId,
		"oper_id" => $data->operId,
		"gift_id" => $data->id,
		"server_name" => trim($data->server_name),
		"gift_type" => $data->giftType
	    );
	    $this->model->update($update_data, array(
		'aid' => $id
	    ));
	}else{
	    $this->add($data);
	}
    }

    private function delete($guid) {
	$info = $this->archives->get_one(array('guid' => $guid));
	if (is_array($info)) {
	    $id = $info["id"];
	    $typeid = $info["typeid"];

	    $this->archives->delete(array(
		'id' => $id,
		'typeid' => $typeid
	    ));

	    $this->arctiny->delete(array(
		'id' => $id,
		'typeid' => $typeid
	    ));

	    $this->model->delete(array(
		'aid' => $id
	    ));
	}
    }

    private function add($data) {
	$info = $this->archives->get_one(array('guid' => $data->guid));
	if (is_array($info)){
	    $this->update($data);
	    return $info["id"];
	}
	//insert archives
	$insert_data = array(
	    'typeid' => $this->typeid,
	    'guid' => $data->guid,
	    'sortrank' => time(),
	    'flag' => getFlags($data->isTop),
	    'ismake' => -1,
	    'channel' => $this->channel,//
	    'arcrank' => 0,
	    'mid' => 1,
	    'click'  => rand(1, 500),
	    'title'  => trim($data->giftTitle),
	    'shorttitle' => trim($data->giftTitle),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'color' => $data->fontColor,
	    'dutyadmin' => 1
	);
	$aid = $this->archives->insert($insert_data, true);

	$this->arctiny->insert(array(
	    'id' => $aid,
	    'typeid' => $this->typeid,
	    'typeid2' => 0,
	    'arcrank' => 0,
	    'channel' => $this->channel,
	    'senddate' => time(),
	    'sortrank' => time(),
	    'mid' => 1
	), true);

	$insert_data = array(
	    'aid'  => $aid,
	    'typeid'  => $this->typeid,
	    'game_name' => trim($data->gameName),
	    'gift_title' => trim($data->giftTitle),
	    'oper_short_name' => trim($data->operShortName),
	    'send_date' => $data->sendDate /1000,
	    'get_url' => trim($data->getUrl),
	    'copy_from' => $data->copyFrom,
	    'insert_time' => time(),
	    "game_id" => $data->gameId,
	    "oper_id" => $data->operId,
	    "gift_id" => $data->id,
	    "server_name" => trim($data->server_name),
	    "gift_type" => $data->giftType
	);

	$this->model->insert($insert_data,true);
	return $aid;	
    }
}
?>
