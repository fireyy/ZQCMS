<?php
//这里只是作为一个hook, 将json数据重新封装
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class service_model extends model {
    private $json;
    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->db_setting = 'default';
	$this->table_name = "pushlog";
	$this->json = Router::getJSON();

	parent::__construct();
    }

    /**
     * get JSON data
     */
    public function getJSON(){
	$data = $this->json;
	if ($data) {
	    //check heade
	    $header = $data->head;
	    $body = $data->body;

	    if (!empty($header) && isset($header->guid)) {
		$guidkey = $header->guid;
		if (!$this->isDataExists($guidkey)) {
		    return array($header, $body);
		}else{
		    //直接中断
		    send_ajax_response("-1", "数据为空或者数据非法无法正常解析.");
		    exit();
		}
	    }
	}else{
	    send_ajax_response("-1", "数据为空或者数据非法无法正常解析.");
	    exit;
	}
    }

    /**
     * get json valid key
     */
    public function getJSONHeader() {
	$header = $this->json->head;
	return $header;
    }

    public function isDataExists($guidkey) {
	//$result = $this->get_one(array(
	//    'guid' => $guidkey
	//));

	//return (empty($result) ? false : true);
	return false;
    }
}

?>
