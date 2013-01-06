<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class index extends admin {
	public function __construct() {
    parent::__construct();
	}
  
	private function get_sysinfo() {
		$sys_info['os']             = PHP_OS;
		$sys_info['zlib']           = function_exists('gzclose');//zlib
		$sys_info['safe_mode']      = (boolean) ini_get('safe_mode');//safe_mode = Off
		$sys_info['safe_mode_gid']  = (boolean) ini_get('safe_mode_gid');//safe_mode_gid = Off
		$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "没有设置";
		$sys_info['socket']         = function_exists('fsockopen') ;
		$sys_info['web_server']     = $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv']           = phpversion();	
		$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
		return $sys_info;
	}
	
	public function init () {
    $userid = $_SESSION['userid'];
    $r = $this->db->get_one(array('id'=>$userid));
    $logintime = $r['logintime'];
		$sysinfo = self::get_sysinfo();
		$sysinfo['mysqlv'] = mysql_get_server_info();
		include $this->admin_tpl('index');
	}

}
?>