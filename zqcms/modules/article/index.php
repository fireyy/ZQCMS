<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    function __construct() {
	$this->db = zq_core::load_model('article_model');
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);

	//register_template_data('article', $article);

	//template('article', 'content');
    }

    //列表页面
    public function list() {
	$page = $_GET['page'];
	//template('article', 'content');
    }
}
?>
