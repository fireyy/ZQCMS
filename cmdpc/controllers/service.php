<?php
uses('service');
class service_controller {
    public function __construct() {
	$this->service = new service_model();
	list($header, $data) = $this->service->getJSON();
	$method = $header->method;

	$methods = get_class_methods($this);
	if (in_array($method, $methods)) {
	    call_user_func(array($this, $method));
	}else{
	    send_ajax_response(-4, '未知操作');
	    exit;
	}
    }
    
    public function getServerVersion() {
	$verFile = DEDE_DATA . "admin/ver.txt";
	$verFileFP = fopen($verFile, "r");
	$ver = trim(fread($verFileFP, filesize($verFile)));
	fclose($verFileFP);

	send_ajax_response(0, array('versionNum' => $ver));
	exit;
    }

    public function getServerPHPInfo() {
	ob_start();
	if (function_exists('get_loaded_extensions')) {
	    $exts = get_loaded_extensions();
	}
	phpinfo();
	$phpinfo = ob_get_contents();
	$html = "";
	if (!empty($exts)) {
	    $html .= "<h2>loaded extension</h2>";
	    $html .= '<table border="0" cellpadding="2" width="600"><tr class="h"><th>Extension</th><th>Version</th></tr>';
	    natcasesort($exts);
	    foreach ($exts as $ext) {
		$version = phpversion($ext);
		$html .= "<tr>";
		$html .= '<td class="e" style="width:150px;"><a href="#module_'.$ext.'" style="color:black; background-color:#ccccff;">'.$ext.'</a></td>';
		$html .= '<td class="v">'.((!empty($version))?$version:"<i>Unknown</i>").'</td>';
		$html .= '</tr>';
	    }
	    $html .= '</table>';
	}
	$html .= "<br/>";
	$html .= $phpinfo;
	ob_end_clean();
	$fp = fopen(DEDE_DATA."/cache/info.html", "w+");
	fwrite($fp, $html);
	send_ajax_response(0, '/data/cache/info.html');
	fclose($fp);
	exit;
    }
}

?>
