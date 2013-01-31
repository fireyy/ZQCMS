<?php
defined('IN_ZQCMS') or exit('Permission deiened');
#zq_core::load_app_class('admin','admin',0);
session_start();
define('IN_ADMIN',true);
define('ZQ_PATH_ADMIN', zq_core::load_config('system','site_basehost') . '/zqcms/modules/admin/');

class admin {
	public function __construct() {
    self::check_admin();
		$this->db = zq_core::load_model('admin_model');
	}
  
	/**
	 * 判断用户是否已经登陆
	 */
	final public function check_admin() {
		if((ROUTE_M =='admin' && ROUTE_C =='index' && ROUTE_A == 'login') || (ROUTE_M =='admin' && ROUTE_C =='update' && ROUTE_A == 'forceUpdate')) {
			return true;
		} else {
			if(!isset($_SESSION['userid']) || !$_SESSION['userid']) header("Location: ?m=admin&c=index&a=login");
		}
	}
  
	/**
	 * 加载后台模板
	 * @param string $file 文件名
	 * @param string $m 模型名
	 */
	final public static function admin_tpl($file, $m = '') {
		$m = empty($m) ? ROUTE_M : $m;
		if(empty($m)) return false;
		return ZQ_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
	}
	
	public function login() {
    $userid = "";
    $errors = array();
		if(isset($_GET['dosubmit'])) {
			
			$username = isset($_POST['username']) ? trim($_POST['username']) : $errors[] = "用户名有误";

			//查询帐号
			$r = $this->db->get_one(array('name'=>$username));
			if(!$r) $errors[] = "用户不存在";
			$password = md5(trim($_POST['password']));
			
			if($r['passwd'] != $password) {
        $errors[] = "密码错误";
			}
      
      if(empty($errors)){
  			$this->db->update(array('loginip'=>ip(),'logintime'=>time()),array('id'=>$r['id']));
  			$_SESSION['userid'] = $r['id'];
  			$_SESSION['pc_hash'] = random(6,'abcdefghigklmnopqrstuvwxwyABCDEFGHIGKLMNOPQRSTUVWXWY0123456789');
  			$cookie_time = time()+86400*30;
  			param::set_cookie('admin_username',$username,$cookie_time);
  			param::set_cookie('userid', $r['userid'],$cookie_time);
  			param::set_cookie('admin_email', $r['email'],$cookie_time);
        header("Location: ?m=admin&c=index");
      }else{
        include $this->admin_tpl('login');
      }

		} else {
			include $this->admin_tpl('login');
		}
	}
	/**
	 * 注销登录
	 */
	public function logout() {
		$_SESSION['userid'] = 0;
		param::set_cookie('admin_username','');
		param::set_cookie('userid',0);
		header("Location: ?m=admin&c=index&a=login");
	}
	/**
	 * 维持 session 登陆状态
	 */
	public function public_session_life() {
		$userid = $_SESSION['userid'];
		return true;
	}

}
?>