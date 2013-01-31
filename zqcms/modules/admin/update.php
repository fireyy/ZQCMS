<?php
defined('IN_ZQCMS') or exit('Permission deiened');
zq_core::load_sys_class('http','',0);
zq_core::load_sys_func('dir');	
zq_core::load_sys_class('admin','',0);

class update extends admin {
	public function __construct() {
    parent::__construct();
    $this->updateHost = "http://cdn.update.qiniudn.com";
    $this->verLockFile = CACHE_PATH.'update/ver.txt';
    $this->lastVer = "";
    $this->tmpdir = "source";
    $this->cacheFiles = CACHE_PATH.'update/updatetmp.inc';
	}
  
	/**
	 * 在线更新
	 */
	public function init() {
    $autocheck = isset($_GET['autocheck']) ? $_GET['autocheck'] : 0;
		include $this->admin_tpl('update');
	}
  
  private function TestWriteAble($d) {
      $tfile = '_zq.txt';
      $fp = @fopen($d.$tfile,'w');
      if(!$fp) {
          return false;
      }
      else {
          fclose($fp);
          $rs = @unlink($d.'/'.$tfile);
          return true;
      }
  }

  private function GetDirName($filename) {
      $dirname = '../'.preg_replace("#[\\\\\/]{1,}#", '/', $filename);
      $dirname = preg_replace("#([^\/]*)$#", '', $dirname);
      return $dirname;
  }

  private function TestIsFileDir($dirname) {
      $dirs = array('name'=>'', 'isdir'=>FALSE, 'writeable'=>FALSE);
      $dirs['name'] =  $dirname;
      if(is_dir($dirname))
      {
          $dirs['isdir'] = TRUE;
          $dirs['writeable'] = self::TestWriteAble($dirname);
      }
      return $dirs;
  }

  private function MkTmpDir($filename) {
      $basedir = UPDATE_TMP;
      $dirname = trim(preg_replace("#[\\\\\/]{1,}#", '/', $filename));
      $dirname = preg_replace("#([^\/]*)$#","",$dirname);
      if(!is_dir($basedir)) 
      {
          mkdir($basedir,0777);
      }
      if($dirname=='') 
      {
          return TRUE;
      }
      $dirs = explode('/', $dirname);
      $curdir = $basedir;
      foreach($dirs as $d)
      {
          $d = trim($d);
          if(empty($d)) continue;
          $curdir = $curdir.'/'.$d;
          if(!is_dir($curdir)) 
          {
              mkdir($curdir, 0777) or die($curdir);
          }
      }
      return TRUE;
  }

	/**
	 * 检查新版本
	 */
  public function checkUpdate() {
    $chk = isset($_POST["chk"]) ? $_POST["chk"] : 0;
    self::_CheckUpgrade($chk);
  }
  private function _CheckUpgrade($chk=0, $force=0) {
    $updateHost = $this->updateHost;
    $verLockFile = $this->verLockFile;
    //当前软件版本锁定文件
    $fp = fopen($verLockFile,'r');
    $currentVer = trim(fread($fp,64));
    fclose($fp);

    //下载远程数据
    $dhd = new http();
    $dhd->get($updateHost.'/verinfo.txt?ver='.time());
    $verlist = trim($dhd->get_data());
    //$dhd->Close();
    $verlist = preg_replace("#[\r\n]{1,}#", "\n", $verlist);
    $verlists = explode("\n", $verlist);

    //分析数据
    $updateVers = array();
    $n = 0;
    $upitems = '';
    foreach($verlists as $verstr) {
        if ( empty($verstr) || preg_match("#^\/\/#", $verstr)) {
            continue ;
        }
        list($vtime, $ver, $vlang, $issafe, $vmsg) = explode(',', $verstr);
        $vtime = trim($vtime);
	      $ver = trim($ver);
        $vlang = trim($vlang);
        $issafe = trim($issafe);
        $vmsg = trim($vmsg);
      	if (version_compare($ver, $currentVer, ">")) {
            $updateVers['issafe'] = $issafe;
            $updateVers['vmsg'] = $vmsg;
      	    $updateVers['updateVer'] = $ver;
            $upitems .= ($upitems=='' ? $ver : ','.$ver);
            $lastTime = $vtime;
            $updateVers['vtime'] = substr($vtime,0,4).'-'.substr($vtime,4,2).'-'.substr($vtime,6,2);
            $n++;
      	}
    }
        
    if($n==0) {
      if($chk){
        echo json_encode(array(
    	    'ver' => '',
    	    'status' => 'failure'
        ));
      }else{
        if($force){
          return "";
        }else{
          echo "error1";
        }
      }
    } else {
      if($chk){
        echo json_encode(array(
    	    'ver' => $updateVers['vmsg'],
    	    'status' => 'success'
        ));
      }else{
        if($force){
          return self::getList($lastTime, $upitems, $vtime, $updateVers);
        }else{
          echo self::getList($lastTime, $upitems, $vtime, $updateVers);
        }
      }
    }
  }
  
	/**
	 * 获取升级文件列表
	 */
  private function getList($lastTime, $upitems, $vtime, $updateVers) {
    $updateHost = $this->updateHost;
    $upitemsArr = explode(',', $upitems);
        
    $dhd = new http();
    $fileArr = array();
    $f = 0;
    foreach($upitemsArr as $upitem) {
      $this->lastVer = $upitem;
      $durl = $updateHost.'/'.$upitem.'.file.txt';
      $dhd->get($durl);
      $filelist = $dhd->get_data();
      $filelist = trim( preg_replace("#[\r\n]{1,}#", "\n", $filelist) );
      if(!empty($filelist)) {
          $filelists = explode("\n", $filelist);
          foreach($filelists as $filelist)
          {
              $filelist = trim($filelist);
              if(empty($filelist)) continue;
              $fs = explode(',', $filelist);
              if(!isset($fileArr[$fs[0]])) {
                  $fileArr[$fs[0]] = $upitem." ".trim($fs[1]);
                  $f++;
              }
          }
      }
    }
    //$dhd->Close();
    
    $allFileList = '';
    if($f==0) {
      return "error2";
    } else {
	    return self::getFiles($vtime, $upitems, $fileArr, $updateVers);
    }
  }
  
  /**
	 * 保存需下载内容列表
	 */
  private function getFiles($vtime, $upitems, $files, $updateVers) {
    $cacheFiles = $this->cacheFiles;
    $adminDir = preg_replace("#(.*)[\/\\\\]#", "", dirname(__FILE__));
    
    if(!isset($files)) {
    } else {
        $fp = fopen($cacheFiles, 'w');
        fwrite($fp, '<'.'?php'."\r\n");
        //fwrite($fp, '$tmpdir = "'.$tmpdir.'";'."\r\n");
        fwrite($fp, '$vmsg = "'.$updateVers['vmsg'].'";'."\r\n");
        fwrite($fp, '$updateVer = "'.$updateVers['updateVer'].'";'."\r\n");
        fwrite($fp, '$vtime = '.$vtime.';'."\r\n");
        $dirs = array();
        $i = 0;
	      foreach($files as $filename => $t) {
            // $tfilename = $filename;
            // if( preg_match("#^dede\/#i", $filename) ) 
            // {
            //    $tfilename = preg_replace("#^dede\/#", $adminDir.'/', $filename);
            // }
            // $curdir = self::GetDirName($tfilename);
            // if( !isset($dirs[$curdir]) ) 
            // {
            //     $dirs[$curdir] = self::TestIsFileDir($curdir);
            // }
            // if($skipnodir==1 && $dirs[$curdir]['isdir'] == FALSE) 
            // {
            //     continue;
            // }
            // else {
            //     @mkdir($curdir, 0777);
            //     $dirs[$curdir] = self::TestIsFileDir($curdir);
            // }
            fwrite($fp, '$files['.$i.'] = "'.$filename.'";'."\r\n");
            $i++;
        }
        fwrite($fp, '$fileConut = '.$i.';'."\r\n");
        
        $items = explode(',', $upitems);
        $i = 0;
        foreach($items as $sqlfile)
        {
            fwrite($fp,'$sqls['.$i.'] = "'.$sqlfile.'.sql";'."\r\n");
            $i++;
        }
        fwrite($fp, '?'.'>');
      	fclose($fp);

      	$fs = array();

      	foreach ($files as $f => $t) {
      	    $fs[] = $f;
      	}

      	return json_encode(array($updateVers['vmsg'],$fs));
    }
  }
  
  private function _StartDownload($files) {
    $curfile = 0;
    $badfile = 0;
    $fileConut = count($files);

    if ($fileConut > 0) {
    	while ($curfile < $fileConut) {
          if (self::_download_file($files[$curfile])) {
            
          }else{
            $badfile++;
          }
          $curfile++;
    	}
    }
    if($badfile == 0) {
      $tm = self::_down_sql();
      return self::_ApplyUpdate($files);
    }else{
      return 1;
    }
  }
  
  /**
	 * 下载程序文件
	 */
  public function downFile() {
  	$filename = $_POST['filename'];
  	$_tid = $_POST['_id'];
    if (!empty($filename)) {
      if (self::_download_file($filename)) {
      	//return
      	echo json_encode(array(
      	    'tid' => $_tid,
      	    'status' => 'success'
      	));
      	exit;
      }else{
      	echo json_encode(array(
      	    'tid' => $_tid,
      	    'status' => 'failure'
      	));
      	exit;
      }
    }
  }
  
  /**
	 * 下载文件，具体操作步骤
	 */
  private function _download_file($file) {
    $updateHost = $this->updateHost;

    if (file_exists(UPDATE_TMP.'/'.$file)) {
	    return true;
    }

    self::MkTmpDir($file);
    //$downfile = $updateHost.'/source/'.$file."?ver=".$this->lastVer;
    $downfile = $updateHost.'/source/'.$file."?ver=".time();
    $dhd = new http();
    if($dhd->get($downfile)){
      $dhd->save(UPDATE_TMP.'/'.$file);
    }

    if (file_exists(UPDATE_TMP.'/'.$file)) {
	    return true;
    }else{
	    return false;
    }
  }
  
  /**
	 * 下载SQL文件
	 */
  public function downSQL() {
    $tm = self::_down_sql();
    echo json_encode(array('status' => 'success', 'count' => $tm));
    exit;
  }
  
  private function _down_sql(){
    $tm = 0;
    $updateHost = $this->updateHost;
    $cacheFiles = $this->cacheFiles;
    require_once($cacheFiles);

    self::MkTmpDir('sql.txt');
    $dhd = new http();
    $ct = '';
    if(isset($sqls) && is_array($sqls)) {
      foreach($sqls as $sql){
        $downfile = $updateHost."/".$sql;
        if($dhd->get($downfile)){
          $ct .= $dhd->get_data();
          $tm++;
        }
      }
    }
    //$dhd->Close();
    if(!empty($ct)){
      $truefile = UPDATE_TMP.'/sql.txt';
      $fp = fopen($truefile, 'w');
      fwrite($fp, $ct);
      fclose($fp);
    }
    return $tm;
  }
  
  /**
	 * 应用升级
	 */
  public function applyUpgrade(){
    $cacheFiles = $this->cacheFiles;
    require_once($cacheFiles);
    $fs = self::_ApplyUpdate($files);
    if($fs == 0){
      echo json_encode(array('status' => 'success', 'vmsg' => $vmsg, 'ver' => $updateVer));
    }else{
      echo json_encode(array('status' => 'error', 'vmsg' => $vmsg, 'ver' => $updateVer));
    }
    exit;
  }
  
  private function _ApplyUpdate($files) {

    //update database;
    $truefile = UPDATE_TMP.'/sql.txt';
    $sql = "";
    if(file_exists($truefile)) {
      $fp = fopen($truefile, 'r');
      $sql = @fread($fp, filesize($truefile));
      fclose($fp);
    }
    if(!empty($sql)){
        $sqls = explode(";\n", $sql);
        zq_core::load_sys_class('crow','',0);
        $db_config = zq_core::load_config("database");
        $update_db = Crow::get_instance($db_config)->get_database("default");
        foreach($sqls as $sql){
          if(trim($sql)!='') {
      	    $update_db->query(trim($sql));
          }
        }
        @unlink($truefile);
    }


    $sDir = UPDATE_TMP;
    $tDir = ZQCMS_PATH;

    $badcp = 0;

    if(isset($files) && is_array($files)) {
    	foreach($files as $f) {
        $tf = $f;
          
  	    if(file_exists($sDir.'/'.$f)) {
  	        $rs = @copy($sDir.'/'.$f, $tDir.'/'.$tf);
  	        if($rs) {
  	            unlink($sDir.'/'.$f);
  	        }
  	        else {
  	            $badcp++;
  	        }
  	    }
      }
    }

    //_Test();
    //$fp = fopen($verLockFile,'w');
    //fwrite($fp,$lastVer);
    //fclose($fp);

    return $badcp;
  }
  
  /**
	 * 强制升级
	 */
  public function forceUpdate() {
    $data = self::_CheckUpgrade(0,1);
    $data = json_decode($data);
    if ($data && is_array($data)) {
    	list($vmsg, $files) = $data;
      $fs = self::_StartDownload($files);
    	if($fs == 0){
        self::_Send_Response(0, array('versionNum' => self::_getUpdateVer()));
      }else{
        self::_Send_Response(-1, "升级失败");
      }
    }else{
      self::_Send_Response(1, "无需升级");
    }
  }

  private function _getUpdateVer() {
    $cacheFiles = $this->cacheFiles;
    include $cacheFiles;
    return $updateVer;
  }

  private function _Send_Response($status, $msg = '') {
    $data = array(
    'code' => $status,
    'msg' => $msg
    );
    echo json_encode($data);
  }
}
?>