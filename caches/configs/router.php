<?php
/**
 * 静态以及page页面的url规则
 *
 * module => array(
 *    
 * )
 *
 * game, list, filter/show
 * game?list, page, tag=1?
 *
 * kaifu?index, filter.html
 *
 * 参数集
 * {id} {page} {year} {month} {day}
 * args 为部分默认值
 */
$time = time();

return array(
    'game' => array(
	   'content' => 'game-{$id}.html',
	   'list' => 'gamelist-{$game_tag}-{$game_theme}-{$game_status}-{$game_effect}-{$test_status}-{$gamesort}-{$game_pinyin}-{$page}.html',
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
       'content' => 'platform-{$id}.html',
       'list' => 'platformlist-{$sort}-{$page}.html',
       'args' => array(
            '{$sort}' => 1
       )
    ),
    'article' => array(
	   'content' => 'article-{$id}.html',
	   'list' => 'articlelist-{$tag}-{$game_id}-{$page}.html',
       'index' => 'article.html',
       'args' => array(
            '{$tag}' => 0,
            '{$game_id}' => 0
       )
    ),
    'gallery' => array(
       'content' => 'gallery-{$id}.html',
       'list' => 'gallerylist-{$tag}-{$page}.html',
       'args' => array(
            '{$tag}' => 0
       )
    ),
    'kaifu' => array(
	   'list' => 'kaifulist-{$year}-{$month}-{$day}-{$t}-{$page}.html',
       'serverlist' => 'serverlist-{$game_id}-{$page}.html',
       'args' => array(
            '{$year}' => date("Y", $time), 
            '{$month}' => date("m", $time), 
            '{$day}' => date("d", $time),
            '{$t}' => 0,
            '{$game_id}' => 0
       )
    ),
    'kaice' => array(
       'list' => 'gametest-{$page}.html'
    ),
    'gift' => array(
       'list' => 'giftlist-{$page}.html'
    )
);
?>
