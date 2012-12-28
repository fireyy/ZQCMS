<?php
defined("IN_ZQCMS") or exit("Permission denied.");
zq_core::load_sys_class("model", '', 0);

class article_model extends model {
    public $table_name = "";

    public function __construct() {
	$this->db_config = zq_core::load_config("database");
	$this->setting = 'default';
	$this->table_name = 'articles';
	parent::__construct();

	$type_model = zq_core::load_model('type_model');
	$this->typeid = $type_model->getTypeIdByTableName($this->table_name);
    }

    private function getData($data) {
	$data = array(
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
	    'body' => $data->content,
	    'thumb' => $data->thumb,
	    'external_links' => $data->externalLinks,
	    'game_id' => $data->gameId
	);

	return $data;
    }

    public function addArticle($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (!empty($info) && is_array($info)) {
	    return $this->updateArticle($data);
	}

	$insert_data = $this->getData($data);
	$aid = $this->insert($insert_data, true);
	
	$categoryId = $data->categoryId;
	if ($categoryId && $aid) {
	    zq_tag($categoryId, $aid, $this->typeid, 'category');
	}
	return $aid;
    }

    public function deleteArticle($guid) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (!$info) {
	    $aid = $info['id'];
	    $this->delete(array(
		'id' => $aid
	    ));
	    zq_tag(false, $aid, $this->typeid, 'category', 'delete');
	}
    }

    public function updateArticle($data) {
	$info = $this->get_one(array('guid' => $data->guid));
	if (empty($info)) {
	    return $this->addArticle($data);
	}

	$update_data = $this->getData($data);
	$this->update($update_data, array('id'=>$info['id']));
	
	//clean aid tag
	zq_tag($categoryId, $aid, $this->typeid, 'category', 'update');

	return $info['id'];
    }
}
?>
