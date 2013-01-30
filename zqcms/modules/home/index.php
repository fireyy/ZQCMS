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
	$gamedb = zq_core::load_model('game_model');
	$game_kaifu = $gamedb->select(
	    '',
	    '*',
	    '0, 11',
	    'kaifu_count DESC'
	);
    $article_tags = zq_core::load_config("article_tag");

	register_template_data('game_kaifu', $game_kaifu);
    register_template_data('article_tags', $article_tags);

	return template('home', 'index');
    }
}
?>
