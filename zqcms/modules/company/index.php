<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('company_model');
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);
  if(isset($id) && !empty($id)){
    $company = $this->db->get_one(array(
      "id" => $id
    ));
  	register_template_data('company', $company);
  	return template('company', 'content');
  }else{
    ShowMsg("未找到对应的厂商！","-1");
  }
    }

    //列表页面
    public function lists() {
  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  $sort = empty($_GET['sort']) ? 1 : $_GET['sort'];
  $title = getTypeName($this->db->typeid);
  $orderby = "";
  $where = array();
  switch ($sort) {
    case 1:
    #TODO 按旗下游戏排序
      $orderby = "pubdate";
      break;
    case 2:
      $orderby = "pubdate";
      break;
    case 3:
      $orderby = "goodpost";
      break;
    default:
      $orderby = "pubdate";
      break;
  }
  $where = join(" and ", $where);
  $lists = $this->db->listinfo($where, $orderby, $page, 45);
  register_template_data('lists', $lists);
  register_template_data('pages', $this->db->pages);
  register_template_data('items', $this);
  register_template_data('title', $title);
	return template('company', 'list');
    }
}
?>
