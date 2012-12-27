<?php
class kaifu_controller {
    public function __construct(){
	$this->model = zq_core::load_model("kaifu_model");
	$this->service = new service_model();

	list($header, $data) = $this->service->getJSON();

	//读取操作
	$method = $header->method;
	$this->parse($data, $method);
    }

    private function parse($data, $method) {
        if ($data) {
            $errorids = array();
            $count = count($data);
            // 0: ok,  -1: empty data, -2: insert fail
            $status = 0;
            $msg = "";

            for ($c = 0; $c < $count; ++$c) {
        	$_data = $data[$c];
        	$guid = $_data->guid;
        	if ($guid) {
        	    switch ($method) {
        	        case "add":
			    if ($aid = $this->model->addKaifu($_data)){
			    }else{
				$errorids[] = $guid;
				$status = -2;
				$msg = "插入数据失败.";
			    }
        		    break;
        	        case "delete":
        		    $this->model->deleteKaifu($guid);
        		    break;
        	        case "update":
        		    $this->model->updateKaifu($_data);
        		    break;
        	        default:
        		    send_ajax_response("-4", "未知操作, 你需要对我干吗?");
			    exit();
        	    }
        	}
            }

            if ($status == 0) {
                $msg = "操作成功!";
            }
            send_ajax_response($status, $msg, $errorids);
        }else{
            send_ajax_response("-1", "数据为空或者数据非法无法正常解析.");
        }
    }
}
?>
