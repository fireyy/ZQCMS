<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class profile extends admin {
	public function __construct() {
    parent::__construct();
	}
	/**
	 * 用户信息以及修改
	 */
	public function init () {
    $errors = array();
    $succ = array();
		$admin_username = param::get_cookie('admin_username');
		$userid = $_SESSION['userid'];
		$r = $this->db->get_one(array('id'=>$userid));
    $email = $r['email'];
    if(isset($_POST['dosubmit'])) {
      $update = array();
      $passwd = $_POST["password"];
      $email2 = $_POST["email"];
      if(!empty($passwd)){
        $update["passwd"] = md5($passwd);
      }
      if(!empty($email2) && $email2 != $email){
        $update["email"] = $email2;
      }else{
        $errors[] = "请填写您要修改的项目";
      }
      if(!empty($update)){
        $this->db->update($update,array('id'=>$r['id']));
        $succ[] = "更新成功";
        $email = $email2;
      }
    }
    include $this->admin_tpl('profile');
	}

}
?>