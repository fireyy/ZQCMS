<?php

class Installer {
  
	/**
		测试系统安装需求
	*/
	public static function compat_check() {
		$compat = array();
    
    // check if lock install
    if(file_exists(ZQCMS_PATH."install/lock.txt")){
			$compat[] = '<strong>您已经安装过 ZQCMS 了，如果需要重新安装，请移除 install/lock.txt 文件</strong>';
    }
    
		// php
    if(version_compare(PHP_VERSION, '5.3.0', '<')) set_magic_quotes_runtime(0);
		if(version_compare(PHP_VERSION,  '5.2.0', '<')) {
			$compat[] = '<strong>ZQCMS 需要 PHP 版本 >= 5.2</strong><br>
				<em>您的服务器 PHP 版本是 ' . PHP_VERSION . '</em>';
		}
    if(!extension_loaded('mysql')) {
			$compat[] = '<strong>ZQCMS 需要开启 MYSQL 扩展</strong><br><em>这是必须的</em>';
    }
    if(!extension_loaded('iconv') && !extension_loaded('mbstring')) {
			$compat[] = '<strong>ZQCMS 建议开启 ICONV 或 MB_STRING 扩展</strong><br><em>可以提高字符集转换效率</em>';
    }
    if(!extension_loaded('zlib')) {
			$compat[] = '<strong>ZQCMS 建议开启 ZLIB 扩展</strong><br><em>支持Gzip功能</em></p>';
    }
    if(!ini_get('allow_url_fopen')){
      $compat[] = '<strong>ZQCMS 建议打开 allow_url_fopen 函数<br><em>采集获取数据必需</em></strong>';
    }
    if(!function_exists('file_put_contents')){
      $compat[] = '<strong>ZQCMS 建议打开 file_put_contents 函数<br><em>采集获取数据必需</em></strong>';
    }
    
		$files = file(ZQCMS_PATH."install/chmod.txt");		
		foreach($files as $_k => $file) {
			$file = str_replace('*','',$file);
			$file = trim($file);
			if(is_dir(ZQCMS_PATH.$file)) {
				$is_dir = '1';
				$cname = '目录';
				//继续检查子目录权限，新加函数
				$write_able = self::writable_check(ZQCMS_PATH.$file);
			} else {
				$is_dir = '0';
				$cname = '文件';
			}
			//新的判断
			if($is_dir =='0' && is_writable(ZQCMS_PATH.$file)) {
				$is_writable = 1;
			} elseif($is_dir =='1' && self::dir_writeable(ZQCMS_PATH.$file)){
				$is_writable = $write_able;
				if($is_writable=='0'){
					$no_writablefile = 1;
				}
			}else{
				$is_writable = 0;
 				$no_writablefile = 1;
  		}
							
			$filesmod[$_k]['file'] = $file;
			$filesmod[$_k]['is_dir'] = $is_dir;
			$filesmod[$_k]['cname'] = $cname;			
			$filesmod[$_k]['is_writable'] = $is_writable;
		}
		if(self::dir_writeable(ZQCMS_PATH)) {
			$is_writable = 1;
		} else {
			$is_writable = 0;
		}
		$filesmod[$_k+1]['file'] = '网站根目录';
		$filesmod[$_k+1]['is_dir'] = '1';
		$filesmod[$_k+1]['cname'] = '目录';			
		$filesmod[$_k+1]['is_writable'] = $is_writable;
    
    foreach ($filesmod as $key => $value) {
      if(!$value['is_writable']){
        $compat[] = '<p><strong>'.$value['cname'].' '.$value['file'].' 不可写，需要状态为可写</strong></p>';
      }
    }
    
		return $compat;
	}
  
  private function dir_writeable($dir) {
  	$writeable = 0;
  	if(is_dir($dir)) {  
          if($fp = @fopen("$dir/chkdir.test", 'w')) {
              @fclose($fp);      
              @unlink("$dir/chkdir.test"); 
              $writeable = 1;
          } else {
              $writeable = 0; 
          } 
  	}
  	return $writeable;
  }

  private function writable_check($path){
  	$dir = '';
  	$is_writable = '1';
  	if(!is_dir($path)){return '0';}
  	$dir = opendir($path);
   	while (($file = readdir($dir)) !== false){
  		if($file!='.' && $file!='..'){
  			if(is_file($path.'/'.$file)){
  				//是文件判断是否可写，不可写直接返回0，不向下继续
  				if(!is_writable($path.'/'.$file)){
   					return '0';
  				}
  			}else{
  				//目录，循环此函数,先判断此目录是否可写，不可写直接返回0 ，可写再判断子目录是否可写 
  				$dir_wrt = self::dir_writeable($path.'/'.$file);
  				if($dir_wrt=='0'){
  					return '0';
  				}
     				$is_writable = self::writable_check($path.'/'.$file);
   			}
  		}
   	}
  	return $is_writable;
  }

	/**
		数据库导入
	*/
	private static function install_schema() {
		$data = $_SESSION;
    $tablepre = $data['db']['tablepre'];
    
    $sql = file_get_contents('assets/sql/zqcms.sql');    
    
		$lnk = mysql_connect($data['db']['host'], $data['db']['user'], $data['db']['pass']) or die ('Not connected : ' . mysql_error());
		$version = mysql_get_server_info();

		if($version > '4.1') {
			mysql_query("SET NAMES 'utf8'");
		}
			
		if($version > '5.0') {
			mysql_query("SET sql_mode=''");
		}
												
		if(!@mysql_select_db($data['db']['name'])){
			@mysql_query("CREATE DATABASE ".$data['db']['name']);
			if(@mysql_error()) {
				echo 1;exit;
			} else {
				mysql_select_db($data['db']['name']);
			}
		}    

		try {
      // 导入数据表结构
			_sql_execute($sql,$tablepre);

			// 更新站点信息
      $uppp = array("site_name","site_description","site_keywords","site_basehost","site_indexurl","auth_key","valid_key");
      foreach ($uppp as $key => $value) {
        _sql_execute("INSERT INTO `".$tablepre."options` (`name`,`value`) VALUES('".$value."','".$data['site'][$value]."');", $tablepre);
      }

			// 创建管理员
      _sql_execute("INSERT INTO `".$tablepre."admin` (`name`,`passwd`,`email`) VALUES ('".$data['user']['username']."','".md5($data['user']['password'])."','".$data['user']['email']."')", $tablepre);

		} catch(PDOException $e) {
			Messages::add($e->getMessage());
		}
	}

	/**
		写入配置文件
	*/
	private static function install_config() {
		$errors = array();
		$data = $_SESSION;
    $config_path = ZQCMS_PATH."caches/configs/";
		$template = file_get_contents($config_path.'database.sample.php');
    $sys_template = file_get_contents($config_path.'system.sample.php');

		$index_page = 'index.php';

		$search = array(
			"'hostname' => '~hostname~'",
			"'database' => '~database~'",
			"'username' => '~username~'",
			"'password' => ''",
      "'tablepre' => '~tablepre~'"
		);
    $sys_search = array(
      "'site_name' => '~site_name~'",
			"'site_indexurl' => '~site_indexurl~'",
			"'site_basehost' => '~site_basehost~'",
			"'auth_key' => '~auth_key~'",
      "'valid_key' => '~valid_key~'",
      "'site_description' => '~site_description~'",
      "'site_keywords' => '~site_keywords~'"
    );
		$replace = array(
			"'hostname' => '" . $data['db']['host'] . "'",
      "'database' => '" . $data['db']['name'] . "'",
			"'username' => '" . $data['db']['user'] . "'",
			"'password' => '" . $data['db']['pass'] . "'",
      "'tablepre' => '" . $data['db']['tablepre'] . "'",
		);
    $sys_replace = array(
			// apllication paths
      "'site_name' => '". $data['site']['site_name'] ."'",
			"'site_indexurl' => '". $data['site']['site_indexurl'] ."'",
			"'site_basehost' => '". $data['site']['site_basehost'] ."'",
			"'auth_key' => '" . $data['site']['auth_key'] . "'",
      "'valid_key' => '". $data['site']['valid_key'] ."'",
      "'site_description' => '". $data['site']['site_description'] ."'",
      "'site_keywords' => '". $data['site']['site_keywords'] ."'"
    );
		$database = str_replace($search, $replace, $template);
    $system = str_replace($sys_search, $sys_replace, $sys_template);

		if(is_real_writable($config_path)) {
			if(file_put_contents($config_path.'database.php', $database)) {
				// chmod config file to 0640 to be sure
				chmod($config_path.'database.php', 0640);
			}
			if(file_put_contents($config_path.'system.php', $system)) {
				// chmod config file to 0640 to be sure
				chmod($config_path.'system.php', 0640);
			}
		}
	}
  
	/**
		在CMDP上注册站点
	*/
  private static function register_site() {
		$errors = array();
		$data = $_SESSION;
    $api_url = "http://cmdp2.dev/cmdp/admin/website/register.do";
    //发送valid key
    $post_data = array(
    	'webUrl' => $data['site']['site_basehost'],
    	'validKey' => $data['site']['valid_key'],
    	'pushTimes' => 3,
    	'webName' => $data['site']['site_name'],
    	'versionNum' => ZQCMS_VERSION
    );

    if (function_exists("curl_init")) {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
    	curl_setopt($ch, CURLOPT_URL, $api_url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    	$response = curl_exec($ch);
    	$response_info = curl_getinfo($ch);
    	$erno = curl_errno($ch);
    	$er = curl_error($ch);
    	curl_close($ch);
    }else{
    	$opts = array(
    	    "http" => array(
    		'method' => 'POST',
    		'header' => 'Content-Type: application/json\r\nAccept: application/json\r\n',
    		'content' => json_encode($post_data)
    	    )
    	);
    	$context = stream_context_create($opts);
    	file_get_contents($api_url, false, $context);
    }
  }

	/**
		执行数据库导入和配置更新
	*/
	private static function run() {
		// create a application key
		$_SESSION['key'] = random(32);

		// 导入数据库
		self::install_schema();

		// 写入配置文件
		self::install_config();
    
		// 在CMDP上注册站点
		self::register_site();

		return true;
	}
  
  public static function complete() {
    // 写入 install/lock.txt 文件，锁定安装
    $lockfile = ZQCMS_PATH."install/lock.txt";
		file_put_contents($lockfile, "1");
		//删除安装目录
		//self::delete_install(ZQCMS_PATH.'install/');
    return true;
  }

	/**
		安装步骤
	*/
	public static function stage1() {
		$_SESSION = array('lang' => post('language'));
		return true;
	}

	public static function stage2() {
		$post = post(array('host', 'user', 'pass', 'name', 'tablepre'));
    $tablepre = $post["tablepre"];

		if(empty($post['host'])) {
			$errors[] = '请输入数据库主机地址';
		}

		if(empty($post['name'])) {
			$errors[] = '请输入数据库名';
		}

		// 测试数据库连接
		if(empty($errors)) {
      
  		if(@mysql_connect($post['host'], $post['user'], $post['pass'])) {
    		$server_info = mysql_get_server_info();
    		if($server_info < '4.0') {
    		  $errors[] = "数据库版本低于Mysql 4.0，无法安装ZQCMS，请升级数据库版本！";
    		}else{
      		if($server_info > '4.1') {
      			mysql_query("SET NAMES 'utf8'");
      		}
			
      		if($server_info > '5.0') {
      			mysql_query("SET sql_mode=''");
      		}
      		if(!mysql_select_db($post['name'])) {
      			if(!@mysql_query("CREATE DATABASE `".$post['name']."`")) {
          		$errors[] = "成功连接数据库，但是指定的数据库不存在并且无法自动创建，请先通过其他方式建立数据库！";
      			}
      		}
    		}
  		}else{
  		  $errors[] = "无法连接数据库服务器，请检查配置！";
  		}
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}

		// save and continue
		$_SESSION['db'] = $post;

		return true;
	}
  
  private function fetch_salt($length = 4) {
      $salt = '';
      for ($i = 0; $i < $length; $i ++)
      {
         $salt .= chr(rand(97, 122));
      }

      return $salt;
  }

	public static function stage3() {
		$post = post(array('site_name', 'site_description', 'site_keywords'));

		if(empty($post['site_name'])) {
			$errors[] = '请输入站点名称';
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}
    
    if(!empty($_SERVER['HTTP_HOST'])){
      $base_url = 'http://'.$_SERVER['HTTP_HOST'];
    }else{
      $base_url = "http://".$_SERVER['SERVER_NAME'];
    }
    $post["site_basehost"] = $base_url;
    
		$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
		$rootpath = str_replace('\\','/',dirname($PHP_SELF));	
		$rootpath = substr($rootpath,0,-7);
		$rootpath = strlen($rootpath)>1 ? $rootpath : "/";
    $post["site_indexurl"] = $rootpath;
    
    $auth_key = chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('A'),ord('Z'))).chr(mt_rand(ord('a'),ord('z'))).mt_rand(1000,9999).chr(mt_rand(ord('A'),ord('Z')));
    $post["auth_key"] = $auth_key;
    
    $valid_key = substr(sha1(self::fetch_salt(16).md5(time())), 0, 32);
    $post["valid_key"] = $valid_key;
    
		// save and continue
		$_SESSION['site'] = $post;

		return true;
	}

	public static function stage4() {
		$errors = array();

		$post = post(array('username', 'email', 'password', 'confirm_password'));

		if(empty($post['username'])) {
			$errors[] = '请输入您的用户名';
		}

		if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = '请输入电子邮箱，当您忘记密码时，可以用于取回密码';
		}
    
		if($post['password'] != $post['confirm_password']) {
			$errors[] = '两次输入的密码不一致，请重新确认';
		}

		$bad_passwords = array('','password', 123456, 12345678, 'qwerty', 'abc123', 'monkey', 1234567, 'letmein', 'trustno1', 'dragon', 'baseball', 111111, 'iloveyou', 'master', 'sunshine', 'ashley', 'bailey', 'passw0rd', 'shadow', 123123, 654321, 'superman', 'qazwsx', 'michael', 'Football');

		if(in_array($post['password'], $bad_passwords)) {
			$errors[] = '过于简单的密码会让您的站点变得不够安全';
		}

		//  hunter2
		if($post['password'] == 'hunter2') {
			$errors[] = '&ldquo;See, when YOU type hunter2, it shows to us as *******&rdquo;';
		}

		if(isset($errors) && count($errors)) {
			Messages::add($errors);
			return false;
		}

		// save and continue
		$_SESSION['user'] = $post;

		return self::run();
	}
  
  private function delete_install($dir) {
  	$dir = self::dir_path($dir);
  	if (!is_dir($dir)) return FALSE;
  	$list = glob($dir.'*');
  	foreach($list as $v) {
  		is_dir($v) ? delete_install($v) : @unlink($v);
  	}
      return @rmdir($dir);
  }
  
  private function dir_path($path) {
  	$path = str_replace('\\', '/', $path);
  	if(substr($path, -1) != '/') $path = $path.'/';
  	return $path;
  }

}