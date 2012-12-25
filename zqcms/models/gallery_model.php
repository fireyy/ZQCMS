<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class gallery_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'galleries';
	parent::__construct();

	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    public function addGallery($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (!empty($info) && is_array($info)) {
	    return $this->updateGallery($data);
	}

	$insert_data = array(
	    'guid' => $data->guid,
	    'typeid' => $this->typeid,
	    'flag' => getFlags($data->isTop),
	    'title' => $data->title,
	    'shorttitle' => $data->title,
	    'description' => $data->description,
	    'writer' => $data->publisher,
	    'color' => $data->fontColor,
	    'source' => $data->copyFrom,
	    'click' => rand(0, 500),
	    'rank' => time(),
	    'pubdate' => time(),
	    'senddate' => time(),
	    'lastpost' => time(),
	    'keywords' => $data->keywords,
	    'body' => $data->galleryPath,
	    'thumb' => $data->thumb,
	    'external_links' => $data->externalLinks,
	    'game_id' => $data->gameId
	);

	$aid = $this->insert($insert_data, true);
	return $aid;
    }

    public function deleteGallery($guid) {

    }

    public function updateGallery($data) {

    }
}
?>