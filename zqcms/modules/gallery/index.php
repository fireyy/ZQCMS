<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    public function __construct() {
	$this->db = zq_core::load_model('gallery_model');
    }

    //内容页
    public function show() {
	$id = intval($_GET['id']);
  if(isset($id) && !empty($id)){
    $gallery = $this->db->get_one(array(
      "id" => $id
    ));
  	register_template_data('gallery', $gallery);
  	return template('gallery', 'content');
  }else{
    ShowMsg("未找到对应的图库！","-1");
  }
    }

    //列表页面
    public function lists() {
  $tag = empty($_GET['tag']) ? '' : $_GET['tag'];
  $title = getTypeName($this->db->typeid);
  if(isset($tag) && !empty($tag)){
    $title = $tag."_".$title;
  }
  #TODO 调用图库的tag列表
  $tags = getTagByType($this->db->typeid);
  register_template_data('items', $this);
  register_template_data('title', $title);
  register_template_data('current_tag', $tag);
  register_template_data('tags', $tags);
	return template('gallery', 'list');
    }
    
    public function getList() {
      $where = array();
      $lists = array();
      $page = empty($_GET['page']) ? 1 : $_GET['page'];
      $tag = empty($_GET['tag']) ? '' : $_GET['tag'];
      if(isset($tag) && !empty($tag)){
        #按tag显示图库列表
        $ids = getIdsByTagname($tag, '*', $this->db->typeid);
        $ids = join(",", $ids);
        $where[] = "id in ($ids)";
        $title = $tag;
      }else{
        $title = getTypeName($this->db->typeid);
      }
      $where = join(" and ", $where);
      $data = $this->db->listinfo($where,'', $page, 20);
      foreach ($data as $key => $value) {
        $url = getURL($value);
        $count = count(GetThumbsArray($value["body"]));
        $html = "<div style='width:100%; float:left; line-height:18px;'><span class='fl gray click_count'>".$value["click"]."人看过</span><span class='fr gray pic_count'>".$count."张</span></div><div style='width:100%; float:left; line-height:18px;'><a href='".$url."' target='_blank' class='booklet_name'>".$value["title"]."</a></div>";
        $lists[] = array(
          "id" => $value["id"],
          "cover_pic_list" => getArticleThumb($value,170),
          "url" => $url,
          "footer" => $html
        );
      }
      echo json_encode($lists);
      exit();
    }
}
?>
