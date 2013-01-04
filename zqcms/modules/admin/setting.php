<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class setting extends admin {
	public function __construct() {
    parent::__construct();
	}
	/**
	 * 站点设置
	 */
	public function init () {
    $errors = array();
    $succ = array();
    $option = zq_core::load_config('system');
    
    if(isset($_GET['dosubmit'])) {
      $update = array();
      $poster = array("site_name", "site_description", "site_keywords", "site_basehost", "site_indexurl", "site_logo", "site_beian");
      $msg = array(
        "site_name"=>"站点名称", 
        "site_basehost"=>"站点链接", 
        "site_indexurl"=>"安装目录", 
        "site_logo"=>"站点logo"
      );
      foreach ($poster as $key) {
        if(!empty($_POST[$key]) && $_POST[$key] != $option[$key]){
          $update[$key] = $_POST[$key];
        }else{
          if(empty($_POST[$key]) && $msg[$key]){
            $errors[] = $msg[$key]."不可为空";
          }
        }
      }
      
      if(!empty($update)){
        $option_db = zq_core::load_model('option_model');
        foreach ($update as $key => $value) {
          $option_db->update(array('value'=>$value),array('name'=>$key));
        }
        $option = array_merge($option, $update);
        $system = "<?php\r\nreturn ".var_export($option,true)."\r\n?>";
        if(file_put_contents(CACHE_PATH.'configs/system.php', $system)){
          $succ[] = "更新成功";
        }else{
          $errors[] = "更新成功，但 system.php 文件写入失败";
        }
      }
    }
    include $this->admin_tpl('setting');
	}

}
?>