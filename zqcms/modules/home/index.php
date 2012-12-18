<?php
defined("IN_ZQCMS") or exit("Permission deiened");

class index {
    function __construct() {

    }

    //首页
    /**
     * 首页是一个综合型的页面, 将会把所有的数据集成起来, 所以在这里将会做一些事情
     *
     */
    public function init() {
	
	return template('home', 'index');
    }
}
?>
