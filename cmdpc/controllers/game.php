<?php
class game_controller {
    public function __construct() {
	$this->model = zq_core::load_model("game_model");
	$this->service = new service_model();

	list($header, $data) = $this->service->getJSON();

	$method = $header->method;
	$this->parse($data, $method);
    }

    private function parse($data, $method){
	if($data){
	    $errorids = array();
	    $count = count($data);
	    // 0: ok,  -1: empty data, -2: insert fail
	    $status = 0;
	    $msg = "";

	    for ($c = 0;$c < $count;++$c){
	        $_data = $data[$c];
	        $guid = $_data->guid;
	        if($guid){
                    switch ($method) {
                        case "add":
	        	    if ($this->model->addGame($_data)){
	        	    }else{
	        		$errorids[] = $guid;
	        		$status = -2;
	        		$msg = "插入数据失败.";
	        	    }
                	    break;
                        //case "delete":
                	//    $this->delete($guid);
                	//    break;
                        //case "update":
                	//    $this->update($_data);
                	//    break;
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
	    send_ajax_response("-1", "数据为空或数据非法无法正常解析.");
	}
    }

//    private function update($data) {
//	$guid = $data->guid;
//	$info = $this->archives->get_one(array('guid' => $guid));
//	if (is_array($info)) {
//	    $id = $info["id"];
//	    $typeid = $info["typeid"];
//	    
//	    $update_data = array(
//		'sortrank' => time(),
//		'flag' => getFlags($data->isTop),
//		'ismake' => -1,
//		'arcrank' => 0,
//		'title'  => trim($data->gameName),
//		'shorttitle' => trim($data->gameName),
//		'color' => $data->fontColor,
//		'description' => $data->gameDescription
//	    );
//	    $this->archives->update($update_data, array(
//		'id' => $id,
//		'typeid' => $typeid
//	    ));
//
//	    $update_data = array(
//		'game_name' => trim($data->gameName),
//		'game_tag' => trim($data->gameTag),
//		'game_thumb' => trim($data->gameThumb),
//		'game_effect' => trim($data->gameEffect),
//		'game_theme' => trim($data->gameTheme),
//		'game_status' => trim($data->gameStatus),
//		'test_status' => trim($data->testStatus),
//		'offical_url' => trim($data->officalUrl),
//		'oper_short_name' => trim($data->operShortName),
//		'dev_short_Name' => trim($data->devShortName),
//		'copy_from' => trim($data->copyFrom),
//		'pub_short_name' => trim($data->pubShortName),
//		'game_avatar' => trim($data->gameAvatar),
//		'dev_id' => $data->devId,
//		'oper_id' => $data->operId,
//		'pub_id' => $data->pubId,
//		'pinyin' => $data->pinyin,
//		"game_id" => $data->id
//	    );
//	    $this->model->update($update_data, array(
//		'aid' => $id
//	    ));
//	}else{
//	    $this->add($data);
//	}
//    }
//
//    private function delete($guid) {
//	$info = $this->archives->get_one(array('guid' => $guid));
//	if (is_array($info)) {
//	    $id = $info["id"];
//	    $typeid = $info["typeid"];
//
//	    $this->archives->delete(array(
//		'id' => $id,
//		'typeid' => $typeid
//	    ));
//
//	    $this->arctiny->delete(array(
//		'id' => $id,
//		'typeid' => $typeid
//	    ));
//
//	    $this->model->delete(array(
//		'aid' => $id
//	    ));
//	}
//    }
//
//    private function add($data) {
//	$info = $this->archives->get_one(array('guid' => $data->guid));
//	if (is_array($info)){
//	    $this->update($data);
//	    return $info["id"];
//	}
//	//insert archives
//	$insert_data = array(
//	    'typeid' => $this->typeid,
//	    'guid' => $data->guid,
//	    'flag' => getFlags($data->isTop),
//	    'sortrank' => time(),
//	    'ismake' => -1,
//	    'channel' => $this->channel,//
//	    'arcrank' => 0,
//	    'click'  => rand(1, 500),
//	    'title'  => trim($data->gameName),
//	    'shorttitle' => trim($data->gameName),
//	    'pubdate' => time(),
//	    'senddate' => time(),
//	    'dutyadmin' => 1,
//	    'color' => $data->fontColor,
//	    'description' => $data->gameDescription
//	);
//	$aid = $this->archives->insert($insert_data, true);
//
//	$this->arctiny->insert(array(
//	    'id' => $aid,
//	    'typeid' => $this->typeid,
//	    'typeid2' => 0,
//	    'arcrank' => 0,
//	    'channel' => $this->channel,
//	    'senddate' => time(),
//	    'sortrank' => time(),
//	    'mid' => 1
//	), true);
//
//	$insert_data = array(
//	    'aid'  => $aid,
//	    'typeid'  => $this->typeid,
//	    'game_name' => trim($data->gameName),
//	    'game_tag' => trim($data->gameTag),
//	    'game_thumb' => trim($data->gameThumb),
//	    'game_effect' => trim($data->gameEffect),
//	    'game_theme' => trim($data->gameTheme),
//	    'game_status' => trim($data->gameStatus),
//	    'test_status' => trim($data->testStatus),
//	    'offical_url' => trim($data->officalUrl),
//	    'oper_short_name' => trim($data->operShortName),
//	    'dev_short_Name' => trim($data->devShortName),
//	    'copy_from' => trim($data->copyFrom),
//	    'insert_time' => time(),
//	    'pub_short_name' => trim($data->pubShortName),
//	    'game_avatar' => trim($data->gameAvatar),
//	    'dev_id' => $data->devId,
//	    'oper_id' => $data->operId,
//	    'pub_id' => $data->pubId,
//	    'pinyin' => $data->pinyin,
//	    "game_id" => $data->id
//	);
//
//	$this->model->insert($insert_data, true);
//
//	return $aid;
//    }
}
?>
