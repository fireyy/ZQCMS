<?php
uses('advert', 'service');
class advert_controller {
    public function __construct() {
	global $_CONFIG;

	$this->model = new advert_model();
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
		$id = $_data->id;
		if($id){
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
        		    $this->delete($id);
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
		$list = glob(DEDE_DATA."cache/myad-*.htm");
		for ($c = 0; $c < count($list); ++$c) {
		    $f = $list[$c];
		    if (file_exists($f)) {
			@unlink($f);
		    }
		}

		$msg = "操作成功!";
	    }

	    send_ajax_response($status, $msg, $errorids);
	}else {
	    send_ajax_response("-1", "数据为空或数据非法无法正常解析.");
	}
    }

    private function update($data) {
	//广告ID
	$id = $data->id;
	$info = $this->model->get_one(array('aid' => $id));
	if (is_array($info)) {
	    $update_data = array(
		'clsid' => $data->adType,
		'typeid' => $data->adRange,
		'tagname' => trim($data->adNo),
		'adname' => trim($data->adTitle),
		'timeset' => trim($data->timeSet),
		'starttime' => trim($data->startTime),
		'endtime' => trim($data->endTime),
		'normbody' => trim($data->adBody),
		'expbody' => trim($data->emptyBody),
	    );
	    $this->model->update($update_data, array(
		'aid' => $id
	    ));
	}else{
	    $this->add($data);
	}
    }

    private function delete($id) {
	$info = $this->model->get_one(array('aid' => $id));
	if (is_array($info)) {
	    $this->model->delete(array(
		'aid' => $id
	    ));
	}
    }

    private function add($data) {
	$info = $this->model->get_one(array('aid' => $data->id));
	if (is_array($info)){
	    $this->update($data);
	    return $info["aid"];
	}

	$insert_data = array(
	    'aid' => $data->id,
	    'clsid' => $data->adType,
	    'typeid' => $data->adRange,
	    'tagname' => trim($data->adNo),
	    'adname' => trim($data->adTitle),
	    'timeset' => trim($data->timeSet),
	    'starttime' => trim($data->startTime),
	    'endtime' => trim($data->endTime),
	    'normbody' => trim($data->adBody),
	    'expbody' => trim($data->emptyBody)
	);
	$this->model->insert($insert_data);
	return $data->id;
    }

}


?>
