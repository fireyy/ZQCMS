<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class company_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'companies';
	parent::__construct();

	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    private function getData($data) {
	$insert_data = array(
	    'guid' => $data->guid,
	    'typeid' => $this->typeid,
	    'full_name' => $data->fullName,
	    'short_name' => $data->shortName,
	    'description' => $data->companyDesc,
	    'flag' => getFlags($data->isTop),
	    'color' => $data->fontColor,
	    'click' => rand(0, 500),
	    'source' => $data->copyFrom,
	    'rank' => time(),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'lastpost' => time(),
	    'data_type' => $data->dataType,
	    'offical_url' => $data->officalUrl,
	    'address' => $data->address,
	    'telephone' => $data->telephone,
	    'email' => $data->email,
	    'company_id' => $data->id,
	    'company_thumb' => $data->logoPath,
	    'pinyin' => $data->pinyin
	);

	return $insert_data;
    }

    public function addCompany($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (is_array($info) && !empty($info)) {
	    return $this->updateCompany($data);
	}

	$insert_data = $this->getData($data);
	$aid = $this->insert($insert_data, true);

	return $aid;
    }

    public function updateCompany($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (empty($info)) {
	    return $this->addCompany($data);
	}

	$this->update($this->getData($data), array('id' => $info['id']));

	return $info['id'];
    }

    public function deleteCompany($guid) {
	$info = $this->get_one(array('guid' => $data->guid));
	if ($info) {
	    $this->delete(array('id' => $info['id']));
	}
    }
}


?>

