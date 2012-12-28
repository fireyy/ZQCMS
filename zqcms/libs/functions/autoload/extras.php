<?php
/**
 * 获得某个页面上的URL链接
 */
function getURL($item, $config=array()) {
    if ($item && $item["typeid"]) {
	$typedb = zq_core::load_model('type_model');
	$typeinfo = $typedb->get_one(array('id'=>$item["typeid"]));
	$model_name = $typeinfo['name'];
	// article show id page

	//m c a
	$url = array();
	$url['m'] = $model_name;
	$url['c'] = 'index';
	$url['a'] = 'show';
	$url['id'] = $item['id'];

	$url = http_build_query($url);
	return 'index.php?' . $url;
    }
    return '';
}
register_template_plugin("modifier", "zqurl", "getURL");

/**
 * 根据GameId获得真实URL地址
 * 
 */
function getGameURL($game_id) {
    $game_id = intval($game_id);
    if ($game_id) {
	$db = zq_core::load_model('game_model');
	if ($r = $db->get_one(array('id'=>$game_id))) {
	    return getURL($r);
	}
    }
    return '';
}

function getNextURL($article_id) {
    $article_id = intval($article_id);
    if ($article_id) {
	$db = zq_core::load_model('article_model');
	if ($r = $db->get_one("id > $article_id")) {
	    $str = '<span class="gray">下一篇</span>&nbsp;&nbsp;';
	    $str .= '<a title="'.$r['title'].'" target="_blank" href="'.getURL($r).'" class="blue">'.$r['title'].'</a>';
	    return $str;
	}
    }

    return;
}

function getPrevURL($article_id) {
    $article_id = intval($article_id);
    if ($article_id) {
	$db = zq_core::load_model('article_model');
	if ($r = $db->get_one("id < $article_id")) {
	    $str = '<span class="gray">上一篇</span>&nbsp;&nbsp;';
	    $str .= '<a title="'.$r['title'].'" target="_blank" href="'.getURL($r).'" class="blue">'.$r['title'].'</a>';
	    return $str;
	}
    }

    return;
}

/**
 * 当前位置导航
 *
 * @param array|object $item 
 *  When $item is array,  $item need include title
 *  When $item is object, this item is Controller. need inclde model 
 */
function position($item) {
    //一个详细内容数组
    $webroot = zq_core::load_config('system', 'site_basehost') . zq_core::load_config('system', 'site_indexurl');
    $u = array(
	"<a href='$webroot' target='_blank'>首页</a>"
    );
    
    $typedb = zq_core::load_model('type_model');
    if (is_array($item) && $item['typeid']) {
	$typeid = $item['typeid'];
	$title = $typedb->getTypeName($typeid);
	$u[] = "<a href='".getTypeLink($typeid)."' target='_blank'>$title</a>";

	//get tag
	$tag_names = getTagNamesByAid($item['id'], $typeid);
	if ($tag_names) {
	    $tag_links = array();
	    for ($i = 0; $i < count($tag_names); $i++) {
		$tag_name = $tag_names[$i];
		$tag_links[] = "<a href='".getTypeLink($typeid, $tag_name)."' target='_blank'>$tag_name</a>";
	    }
	    
	    $u[] = join(", ", $tag_links);
	}

	if (!empty($item['title'])) {
	    $u[] = $item['title'];
	}

    }else{
	if (is_object($item) && $item->db && $item->db->typeid) {
	    $title = $typedb->getTypeName($item->db->typeid);
	    $u[] = "<a href='".getTypeLink($item->db->typeid)."' target='_blank'>$title</a>";

	    if ($_GET['tag']) {
		$tag = $_GET['tag'];
		$u[] = "<a href='".getTypeLink($item->db->typeid, $tag)."' target='_blank'>$tag</a>";
	    }
	}
    }
    return join(' &gt ', $u);
}

/**
 * 获得内容模型的url
 * 
 * @param string|integer $type
 * @param string $tagname
 *
 * @return string url
 */
function getTypeLink($type,$tagname='') {
    $where = array();
    if (is_numeric($type) && intval($type) ){ 
	$where['id'] = $type;
    }elseif (is_string($type) && !empty($type)){
	$where['name'] = $type;
    }

    if (!empty($where)) {
	$db = zq_core::load_model('type_model');
	$r = $db->get_one($where);
	if ($r) {
	    $url = array();
	    $url['m'] = $r['name'];
	    $url['c'] = 'index';
	    $url['a'] = 'lists';

	    $page = intval($_GET['page']);
	    $page = $page == 0 ? 1 : $page;

	    $url['page'] = $page;

	    if (!empty($tagname)) {
		$url['tag'] = $tagname;
	    }

	    $url = http_build_query($url);
	    return 'index.php?' . $url;
	}
    }

    return '#';
}

/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转地址
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function ShowMsg($msg, $gourl, $onlymsg=0, $limittime=0)
{
    if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

    $htmlhead  = "<html>\r\n<head>\r\n<title>ZQCMS提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
    $htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>\r\n<center>\r\n<script>\r\n";
    $htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

    $litime = ($limittime==0 ? 1000 : $limittime);
    $func = '';

    if($gourl=='-1')
    {
        if($limittime==0) $litime = 5000;
        $gourl = "javascript:history.go(-1);";
    }

    if($gourl=='' || $onlymsg==1)
    {
        $msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
    }
    else
    {
        //当网址为:close::objname 时, 关闭父框架的id=objname元素
        if(preg_match('/close::/',$gourl))
        {
            $tgobj = trim(preg_replace('/close::/', '', $gourl));
            $gourl = 'javascript:;';
            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
        }
        
        $func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
        $rmsg = $func;
        $rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";
        $rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD url({$GLOBALS['cfg_plus_dir']}/img/wbg.gif)';'><b>ZQCMS 提示信息！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
        $rmsg .= "document.write(\"";
        
        if($onlymsg==0)
        {
            if( $gourl != 'javascript:;' && $gourl != '')
            {
                $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
                $rmsg .= "<br/></div>\");\r\n";
                $rmsg .= "setTimeout('JumpUrl()',$litime);";
            }
            else
            {
                $rmsg .= "<br/></div>\");\r\n";
            }
        }
        else
        {
            $rmsg .= "<br/><br/></div>\");\r\n";
        }
        $msg  = $htmlhead.$rmsg.$htmlfoot;
    }
    echo $msg;
}



function getArticleThumb($item,$w,$h) {
  return "#";
}
#register_template_plugin("modifier", "zqthumb", "getArticleThumb");

function get_today_kaifu_count() {
  $db = zq_core::load_model("kaifu_model");

  $time = strtotime('today');
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
  $sql = "test_date >= $begin_date AND test_date < $end_date";
  $count = $db->count($sql);
  return $count;
}

function get_today_kaice_count() {
  $db = zq_core::load_model("kaice_model");

  $time = strtotime('today');
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
  $sql = "test_date >= $begin_date AND test_date < $end_date";
  $count = $db->count($sql);
  return $count;
}

function get_gift_count(){
  $db = zq_core::load_model("gift_model");
  $count = $db->count();
  return $count;
}

function get_game_count(){
  $db = zq_core::load_model("game_model");
  $count = $db->count();
  return $count;
}

function get_game_list($params, $template){
  $db = zq_core::load_model("game_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['tag'])){
    $tag = explode(",", $params['tag']);
    for ($i=0; $i < count($tag); $i++) { 
      $tag[$i] = "game_tag = '".trim($tag[$i])."'";
    }
    $where[] = join(" or ",$tag);
  }
  if (isset($params['theme'])){
    $theme = explode(",", $params['theme']);
    for ($i=0; $i < count($theme); $i++) { 
      $theme[$i] = "game_theme = '".trim($theme[$i])."'";
    }
    $where[] = join(" or ",$theme);
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_game_list", "get_game_list");

function get_recomm_kaifu_list($params, $template){
  $db = zq_core::load_model("kaifu_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  $where = join(" and ", $where);
  $time = strtotime('today');
  $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
  $where .= " and test_date >= $begin_date";
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_recomm_kaifu_list", "get_recomm_kaifu_list");

function get_kaifu_list($params, $template){
  $db = zq_core::load_model("kaifu_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['game_id'])){
    $where[] = "game_id = {$params['game_id']}";
  }
  if(isset($params['day'])){
    $time = strtotime($params['day']);
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    $where[] = "test_date >= $begin_date AND test_date < $end_date";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_kaifu_list", "get_kaifu_list");

function get_kaice_list($params, $template){
  $db = zq_core::load_model("kaice_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['day'])){
    $time = strtotime($params['day']);
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    #$end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    $where[] = "test_date >= $begin_date";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_kaice_list", "get_kaice_list");

function get_gift_list($params, $template){
  $db = zq_core::load_model("gift_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['day'])){
    $time = strtotime($params['day']);
    $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    #$end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    $where[] = "send_date >= $begin_date";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_gift_list", "get_gift_list");

function get_article_list($params, $template){
  $db = zq_core::load_model("article_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['game_id'])){
    $where[] = "game_id = {$params['game_id']}";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_article_list", "get_article_list");

function get_articles_byTagName($params, $template){
  $db = zq_core::load_model("article_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['noflag'])){
    $noflag = $params['noflag'];
    if(!preg_match('#,#', $noflag)){
      $where[] = "FIND_IN_SET('$noflag', flag)<1";
    }else{
      $noflags = explode(',', $noflag);
      foreach($noflags as $noflag) {
        if(trim($noflag)=='') continue;
        $where[] = "FIND_IN_SET('$noflag', flag)<1";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if (isset($params['tagname'])){
    $ids = getIdsByTagname($params["tagname"],"*",$db->typeid);
    #print_r($ids);
    $ids = join(",", $ids);
    $where[] = "id in ($ids)";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_articles_byTagName", "get_articles_byTagName");

function get_gallery_list($params, $template){
  $db = zq_core::load_model("gallery_model");
  $where = array();
  $limit = "";
  $orderby = "";
  if (isset($params['flag'])){
    $flag = $params['flag'];
    if(!preg_match('#,#', $flag)){
      $where[] = "FIND_IN_SET('$flag', flag)>0";
    }else{
      $flags = explode(',', $flag);
      foreach($flags as $flag) {
        if(trim($flag)=='') continue;
        $where[] = "FIND_IN_SET('$flag', flag)>0";
      }
    }
  }
  if (isset($params['orderby'])){
    $orderby = $params['orderby'];
  }
  if (isset($params['orderway'])){
    if($orderby!="") $orderby .= " ".$params['orderway'];
  }
  if (isset($params['limit'])){
    $limit = $params['limit'];
  }
  if(isset($params['game_id'])){
    $where[] = "game_id = {$params['game_id']}";
  }
  $where = join(" and ", $where);
  $data = $db->select($where, '*', $limit, $orderby);
  if (isset($params['assign'])) {
  	$template->assign($params['assign'], $data);
  }
}
register_template_plugin("function", "get_gallery_list", "get_gallery_list");

?>
