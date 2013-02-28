<?php
@set_time_limit(0);
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('admin','',0);

class database extends admin {
	private $cms_db;
	function __construct() {
		parent::__construct();
		zq_core::load_sys_class('crow');
		//zq_core::load_sys_class('form');
		zq_core::load_sys_func('dir');	
	}
	/**
	 * 数据库导出
	 */
	public function export() {
		$database = zq_core::load_config('database');
		$dosubmit = isset($_POST['dosubmit']) ? $_POST['dosubmit'] : $_GET['dosubmit'];
		if($dosubmit) {
			$tables = $_POST['tables'] ? $_POST['tables'] : $_GET['tables'];
			$sqlcharset = "utf8";
			$sqlcompat = "MYSQL41";
			$sizelimit = $_POST['sizelimit'] ? $_POST['sizelimit'] : $_GET['sizelimit'];
			$fileid = $_POST['fileid'] ? $_POST['fileid'] : trim($_GET['fileid']);
			$random = $_POST['random'] ? $_POST['random'] : trim($_GET['random']);
			$tableid = $_POST['tableid'] ? $_POST['tableid'] : trim($_GET['tableid']);
			$startfrom = $_POST['startfrom'] ? $_POST['startfrom'] : trim($_GET['startfrom']);
			$tabletype = $_POST['tabletype'] ? $_POST['tabletype'] : trim($_GET['tabletype']);
			$this->pdo_name = "default";			
			$this->cms_db = Crow::get_instance($database)->get_database($this->pdo_name);
			$r = $this->cms_db->version();
			$this->export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$action,$fileid,$random,$tableid,$startfrom,$tabletype);
		} else {
			delcache('bakup_tables','commons');
			$pdo_name = "default";
			$r = array();
			$db = Crow::get_instance($database)->get_database($pdo_name);
			$tbl_show = $db->query("SHOW TABLE STATUS FROM `".$database[$pdo_name]['database']."`");
			while(($rs = $db->fetch_next()) != false) {
				$r[] = $rs;
			}
			$infos = $this->status($r,$database[$pdo_name]['tablepre']);
			$db->free_result($tbl_show);
			include $this->admin_tpl('database_export');			
		}
	}
	
	/**
	 * 数据库导入
	 */
	public function import() {
		$database = zq_core::load_config('database');
		if($_GET['dosubmit']) {
			$this->pdo_name = $_GET['pdoname'];
			$pre = trim($_GET['pre']);
			$this->fileid = trim($_GET['fileid']);
			$this->cms_db_charset = $database[$this->pdo_name]['charset'];
			$this->cms_db_tablepre = $database[$this->pdo_name]['tablepre'];
			$this->cms_db = Crow::get_instance($database)->get_database($this->pdo_name);
			$this->import_database($pre);
		} else {
			$others = array();
			$pdoname = "default";
			$sqlfiles = glob(CACHE_PATH.'bakup/'.$pdoname.'/*.sql');
			if(is_array($sqlfiles)) {
				asort($sqlfiles);
				$prepre = '';
				$info = $infos = $other = $others = array();
				foreach($sqlfiles as $id=>$sqlfile) {
					if(preg_match("/(zqcmstables_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num)) {
						$info['filename'] = basename($sqlfile);
						$info['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
						$info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
						$info['pre'] = $num[1];
						$info['number'] = $num[2];
						if(!$id) $prebgcolor = 'pre1';
						if($info['pre'] == $prepre) {
						 $info['bgcolor'] = $prebgcolor;
						} else {
						 $info['bgcolor'] = $prebgcolor == 'pre1' ? 'pre2' : 'pre1';
						}
						$prebgcolor = $info['bgcolor'];
						$prepre = $info['pre'];
						$infos[] = $info;
					} else {
						$other['filename'] = basename($sqlfile);
						$other['filesize'] = round(filesize($sqlfile)/(1024*1024),2);
						$other['maketime'] = date('Y-m-d H:i:s',filemtime($sqlfile));
						$others[] = $other;
					}
				}
			}
			$show_validator = true;
			include $this->admin_tpl('database_import');
		}
	}
	
	/**
	 * 备份文件下载
	 */
	public function public_down() {
		$datadir = $_GET['pdoname'];
		$filename = $_GET['filename'];
		$fileext = fileext($filename);
		if($fileext != 'sql') {
			ShowMsg("只能下载sql文件");
		}
		file_down(CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$datadir.DIRECTORY_SEPARATOR.$filename);
	}
	
	/**
	 * 数据库修复、优化
	 */
	public function public_repair() {
		$database = zq_core::load_config('database');
		$tables = $_POST['tables'] ? $_POST['tables'] : trim($_GET['tables']);
		$operation = trim($_GET['operation']);
		$pdo_name = trim($_GET['pdo_name']);
		$this->cms_db = Crow::get_instance($database)->get_database($pdo_name);
		$tables = is_array($tables) ? implode(',',$tables) : $tables;
		if($tables && in_array($operation,array('repair','optimize'))) {
			$this->cms_db->query("$operation TABLE $tables");
			ShowMsg("操作成功",'?m=admin&c=database&a=export&pdoname='.$pdo_name);
		} elseif ($tables && $operation == 'showcreat') {						
			$this->cms_db->query("SHOW CREATE TABLE $tables");
			$structure = $this->cms_db->fetch_next();
			$structure = $structure['Create Table'];
			$show_header = true;
			include $this->admin_tpl('database_structure');					
		} else {
			ShowMsg("请选择数据表",'?m=admin&c=database&a=export&pdoname='.$pdo_name);
		}
	}
	
	/**
	 * 备份文件删除
	 */
	public function delete() {
		$filenames = $_POST['filenames'];
		$pdo_name = $_GET['pdoname'];
		$bakfile_path = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$pdo_name.DIRECTORY_SEPARATOR;
		if($filenames) {
			if(is_array($filenames)) {
				foreach($filenames as $filename) {
					if(fileext($filename)=='sql') {
						@unlink($bakfile_path.$filename);
					}
				}
				ShowMsg("操作成功",'?m=admin&c=database&a=import&pdoname='.$pdo_name);
			} else {
				if(fileext($filenames)=='sql') {
					@unlink($bakfile_path.$filename);
					ShowMsg("操作成功",'?m=admin&c=database&a=import&pdoname='.$pdo_name);
				}
			}
		} else {
			ShowMsg("请选择要删除的备份文件");	
		}				
	}

	/**
	 * 一键清理数据
	 */
	public function clear_data() {
		//清理数据涉及到的数据表
		$models = array('article', 'kaifu', 'kaice', 'gift', 'gallery');
		if ($_POST['dosubmit']) {
			set_time_limit(0);
			$tables = $_POST['model'];
			if (is_array($tables)) {
				foreach ($tables as $t) {
					if (in_array($t, $models)) {
						$time_date = $_POST[$t.'_date'];
						if(isset($time_date)){
							$db = zq_core::load_model($t.'_model');
							$time = "pubdate";
							$time_date = strtotime($time_date);
							$ids = $db->select("{$time} < {$time_date}", "id");
							if(count($ids) > 0) {
								$db->delete("{$time} < {$time_date}");
								if($t == "article" || $t == "gallery") {
									foreach ($ids as $aid) {
										deleteTagRelationship($aid["id"], $db->typeid, false);
									}
								}
							}
						}
					}
				}
			}
			showMsg("数据清理完毕", HTTP_REFERER);
		} else {
			//读取网站的所有模型
			$type_db = zq_core::load_model('type_model');
			$infos = $type_db->select();
			include $this->admin_tpl('database_clear_data');
		}
	}

	/**
	 * 获取数据表
	 * @param unknown_type 数据表数组
	 * @param unknown_type 表前缀
	 */
	private function status($tables,$tablepre) {
		$phpcms = array();
		$other = array();
		foreach($tables as $table) {
			$name = $table['Name'];
			$row = array('name'=>$name,'rows'=>$table['Rows'],'size'=>$table['Data_length']+$row['Index_length'],'engine'=>$table['Engine'],'data_free'=>$table['Data_free'],'collation'=>$table['Collation']);
			if(strpos($name, $tablepre) === 0) {
				$phpcms[] = $row;
			} else {
				$other[] = $row;
			}				
		}
		return array('zqcmstables'=>$phpcms, 'othertables'=>$other);
	}
	
	/**
	 * 数据库导出方法
	 * @param unknown_type $tables 数据表数据组
	 * @param unknown_type $sqlcompat 数据库兼容类型
	 * @param unknown_type $sqlcharset 数据库字符
	 * @param unknown_type $sizelimit 卷大小
	 * @param unknown_type $action 操作
	 * @param unknown_type $fileid 卷标
	 * @param unknown_type $random 随机字段
	 * @param unknown_type $tableid 
	 * @param unknown_type $startfrom 
	 * @param unknown_type $tabletype 备份数据库类型 （非phpcms数据与phpcms数据）
	 */
	private function export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$action,$fileid,$random,$tableid,$startfrom,$tabletype) {
		$dumpcharset = $sqlcharset ? $sqlcharset : str_replace('-', '', CHARSET);

		$fileid = ($fileid != '') ? $fileid : 1;		
		if($fileid==1 && $tables) {
			if(!isset($tables) || !is_array($tables)) ShowMsg("请选择数据表");
			$random = mt_rand(1000, 9999);
			setcache('bakup_tables',$tables,'commons');
		} else {
			if(!$tables = getcache('bakup_tables','commons')) ShowMsg("请选择数据表");
		}
		if($this->cms_db->version() > '4.1'){
			if($sqlcharset) {
				$this->cms_db->query("SET NAMES '".$sqlcharset."';\n\n");
			}
			if($sqlcompat == 'MYSQL40') {
				$this->cms_db->query("SET SQL_MODE='MYSQL40'");
			} elseif($sqlcompat == 'MYSQL41') {
				$this->cms_db->query("SET SQL_MODE=''");
			}
		}
		
		$tabledump = '';

		$tableid = ($tableid!= '') ? $tableid - 1 : 0;
		$startfrom = ($startfrom != '') ? intval($startfrom) : 0;
		for($i = $tableid; $i < count($tables) && strlen($tabledump) < $sizelimit * 1000; $i++) {
			global $startrow;
			$offset = 100;
			if(!$startfrom) {
				if($tables[$i]!=DB_PRE.'session') {
					$tabledump .= "DROP TABLE IF EXISTS `$tables[$i]`;\n";
				}
				$createtable = $this->cms_db->query("SHOW CREATE TABLE `$tables[$i]` ");
				$create = $this->cms_db->fetch_next();
				$tabledump .= $create['Create Table'].";\n\n";
				$this->cms_db->free_result($createtable);
							
				if($sqlcompat == 'MYSQL41' && $this->cms_db->version() < '4.1') {
					$tabledump = preg_replace("/TYPE\=([a-zA-Z0-9]+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump);
				}
				if($this->cms_db->version() > '4.1' && $sqlcharset) {
					$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=".$sqlcharset, $tabledump);
				}
				if($tables[$i]==DB_PRE.'session') {
					$tabledump = str_replace("CREATE TABLE `".DB_PRE."session`", "CREATE TABLE IF NOT EXISTS `".DB_PRE."session`", $tabledump);
				}
			}

			$numrows = $offset;
			while(strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
				if($tables[$i]==DB_PRE.'session' || $tables[$i]==DB_PRE.'member_cache') break;
				$sql = "SELECT * FROM `$tables[$i]` LIMIT $startfrom, $offset";
				$numfields = $this->cms_db->num_fields($sql);
				$numrows = $this->cms_db->num_rows($sql);
				$fields_name = $this->cms_db->get_fields($tables[$i]);
				$rows = $this->cms_db->query($sql);
				$name = array_keys($fields_name);
				$r = array();
				while ($row = $this->cms_db->fetch_next()) {
					$r[] = $row;
					$comma = "";
					$tabledump .= "INSERT INTO `$tables[$i]` VALUES(";
					for($j = 0; $j < $numfields; $j++) {
						$tabledump .= $comma."'".mysql_escape_string($row[$name[$j]])."'";
						$comma = ",";
					}
					$tabledump .= ");\n";
				}
				$this->cms_db->free_result($rows);
				$startfrom += $offset;
				
			}
			$tabledump .= "\n";
			$startrow = $startfrom;
			$startfrom = 0;
		}
		if(trim($tabledump)) {
			$tabledump = "# zqcms bakfile\n# version:ZQ CMS V2\n# time:".date('Y-m-d H:i:s')."\n# type:zqcms\n# zqcms:http://zqcms.com\n# --------------------------------------------------------\n\n\n".$tabledump;
			$tableid = $i;
			$filename = $tabletype.'_'.date('Ymd').'_'.$random.'_'.$fileid.'.sql';
			$altid = $fileid;
			$fileid++;
			$bakfile_path = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name;
			if(!dir_create($bakfile_path)) {
				ShowMsg("目录无法创建");
			}
			$bakfile = $bakfile_path.DIRECTORY_SEPARATOR.$filename;
			if(!is_writable(CACHE_PATH.'bakup')) ShowMsg("目录无法创建");
			file_put_contents($bakfile, $tabledump);
			@chmod($bakfile, 0777);
			if(!EXECUTION_SQL) $filename = L('bundling').$altid.'#';
			ShowMsg("备份文件 $filename 写入成功", '?m=admin&c=database&a=export&sizelimit='.$sizelimit.'&sqlcompat='.$sqlcompat.'&sqlcharset='.$sqlcharset.'&tableid='.$tableid.'&fileid='.$fileid.'&startfrom='.$startrow.'&random='.$random.'&dosubmit=1&tabletype='.$tabletype.'&allow='.$allow.'&pdo_select='.$this->pdo_name);
		} else {
		   $bakfile_path = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name.DIRECTORY_SEPARATOR;
		   file_put_contents($bakfile_path.'index.html','');
		   delcache('bakup_tables','commons');
		   ShowMsg("备份成功",'?m=admin&c=database&a=import&pdoname='.$this->pdo_name);
		}
	}
	/**
	 * 数据库恢复
	 * @param unknown_type $filename
	 */
	private function import_database($filename) {
		if($filename && fileext($filename)=='sql') {
			$filepath = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name.DIRECTORY_SEPARATOR.$filename;
			if(!file_exists($filepath)) ShowMsg("对不起 $filepath 数据库文件不存在");
			$sql = file_get_contents($filepath);
			$this->sql_execute($sql);
			ShowMsg("$filename 中的数据已经成功导入到数据库！");
		} else {
			$fileid = $this->fileid ? $this->fileid : 1;
			$pre = $filename;
			$filename = $filename.$fileid.'.sql';
			$filepath = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name.DIRECTORY_SEPARATOR.$filename;
			if(file_exists($filepath)) {
				$sql = file_get_contents($filepath);
				$this->sql_execute($sql);
				$fileid++;
				ShowMsg("数据文件 $filename 导入成功！","?m=admin&c=database&a=import&pdoname=".$this->pdo_name."&pre=".$pre."&fileid=".$fileid."&dosubmit=1");
			} else {
				ShowMsg("数据库恢复成功！",'?m=admin&c=database&a=import');
			}
		}
	}
	
	/**
	 * 执行SQL
	 * @param unknown_type $sql
	 */
 	private function sql_execute($sql) {
	    $sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->cms_db->query($sql);
				}
			}
		} else {
			$this->cms_db->query($sqls);
		}
		return true;
	}
	

 	private function sql_split($sql) {
		if($this->cms_db->version() > '4.1' && $this->cms_db_charset) {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$this->cms_db_charset,$sql);
		}
		if($this->cms_db_tablepre != "zq_") $sql = str_replace("`zq_", '`'.$this->cms_db_tablepre, $sql);
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}			
}
?>