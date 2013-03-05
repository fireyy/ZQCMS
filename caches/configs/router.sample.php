<?php
/**
 * 静态以及page页面的url规则
 *
 */
$time = time();

return array(
    'game' => array(
	   'content' => '~urlrule_game_show~',
	   'list' => '~urlrule_game_list~',
       'args' => array(
            '{$game_tag}' => 0,
            '{$game_theme}' => 0,
            '{$game_status}' => 0,
            '{$game_effect}' => 0,
            '{$test_status}' => 0,
            '{$gamesort}' => 0,
            '{$game_pinyin}' => 0
       )
    ),
    'company' => array(
       'content' => '~urlrule_company_show~',
       'list' => '~urlrule_company_list~',
       'args' => array(
            '{$sort}' => 1
       )
    ),
    'article' => array(
	   'content' => '~urlrule_article_show~',
	   'list' => '~urlrule_article_list~',
       'index' => '~urlrule_article_init~',
       'args' => array(
            '{$tag}' => 0,
            '{$game_id}' => 0
       )
    ),
    'gallery' => array(
       'content' => '~urlrule_gallery_show~',
       'list' => '~urlrule_gallery_list~',
       'args' => array(
            '{$tag}' => 0
       )
    ),
    'kaifu' => array(
	   'list' => '~urlrule_kaifu_list~',
       'serverlist' => '~urlrule_server_list~',
       'args' => array(
            '{$year}' => date("Y", $time), 
            '{$month}' => date("m", $time), 
            '{$day}' => date("d", $time),
            '{$t}' => 0,
            '{$game_id}' => 0
       )
    ),
    'kaice' => array(
       'list' => '~urlrule_kaice_list~'
    ),
    'gift' => array(
       'list' => '~urlrule_gift_list~'
    )
);
?>
