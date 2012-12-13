<?php
// load gallery_model
uses("gallery", "archives", "service", "arctiny");

class gallery_controller {
    public  function __construct() {
	global $_CONFIG;

	$this->model = new gallery_model();
	$this->archives = new archives_model();
	$this->service = new service_model();
	$this->arctiny = new arctiny_model();

	list($header, $data) = $this->service->getJSON();

	//栏目ID
	$this->type = $_CONFIG['archtype']['gallery'];
	$this->channel = $_CONFIG["channel"]["gallery"];
	//parse data and insert/update data
	$method = $header->method;
	$this->parse($data, $method);
    }

    private function parse($data, $method) {
	if($data) {
	    $errorids = array();
	    $count = count($data);
	    // 0: ok,  -1: empty data, -2: insert fail
	    $status = 0;
	    $msg = "";

	    for ($c = 0 ;$c < $count; ++$c) {
		$_data = $data[$c];
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
	    send_ajax_response("-1", "数据为空或者数据非法无法正常解析.");
	}
    }

    private function update($data) {
	$guid = $data->guid;
	$info = $this->archives->get_one(array('guid' => $guid));
	if (is_array($info)) {
	    $id = $info["id"];
	    $typeid = $info["typeid"];
	    
	    $update_data = array(
		'typeid' => $this->type,
		'sortrank' => time(),
		'flag' => getFlags($data->isTop),
		'title'  => trim($data->title),
		'shorttitle' => trim($data->title),
		'keywords' => trim($data->keywords),
		'source' => $data->copyFrom,
		'color' => $data->fontColor,
		'description' => $data->description
	    );
	    $this->archives->update($update_data, array(
		'id' => $id,
		'typeid' => $typeid
	    ));

	    $update_data = array(
		'typeid'  => $this->type,
		'body'  => trim($data->galleryPath),
		'category_id' => trim($data->categoryId),
		'thumb' => trim($data->thumb),
		'external_links' => trim($data->externalLinks),
		'game_id' => intval($data->gameId)
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

	$insert_data = array(
	    'typeid' => $this->type,
	    'guid' => $data->guid,
	    'sortrank' => time(),
	    'flag' => getFlags($data->isTop),
	    'ismake' => -1,
	    'channel' => $this->channel,//
	    'arcrank' => 0,
	    'mid' => 1,
	    'click'  => rand(1, 500),
	    'title'  => trim($data->title),
	    'shorttitle' => trim($data->title),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'dutyadmin' => 1,
	    'keywords' => trim($data->keywords),
	    'source' => $data->copyFrom,
	    'color' => $data->fontColor,
	    'writer' => $this->publisher,
	    'description' => $_data->description
	);
	$aid = $this->archives->insert($insert_data, true);

	$this->arctiny->insert(array(
	    'id' => $aid,
	    'typeid' => $this->type,
	    'typeid2' => 0,
	    'arcrank' => 0,
	    'channel' => $this->channel,
	    'senddate' => time(),
	    'sortrank' => time(),
	    'mid' => 1
	), true);

	$insert_data = array(
	    'aid'  => $aid,
	    'typeid'  => $this->type,
	    'body'  => trim($data->galleryPath),
	    'category_id' => trim($data->categoryId),
	    'thumb' => trim($data->thumb),
	    'external_links' => trim($data->externalLinks),
	    'game_id' => intval($data->gameId)
	);
	$this->model->insert($insert_data,true);

	return $aid;
    }
}
?>
