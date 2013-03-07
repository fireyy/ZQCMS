<?php
$time = time();

$router->route('default', '/')->defaults(array('module' => 'home', 'controller' => 'index', 'action' => 'index'));

$router->route('article_show', '/article-<#id>.html')
    ->defaults(array('module' => 'article', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('article_lists', '/articlelist-<#tag>-<#game_id>-<#page>.html')
    ->defaults(array('module' => 'article', 'controller' => 'index', 'action' => 'lists', 'tag' => 0, 'game_id' => 0, 'page' => 0));
$router->route('article_index', '/article.html')
    ->defaults(array('module' => 'article', 'controller' => 'index', 'action' => 'index'));

$router->route('game_show', '/game-<#id>.html')
    ->defaults(array('module' => 'game', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('game_lists', '/gamelist-<#game_tag>-<#game_theme>-<#game_status>-<#game_effect>-<#test_status>-<#gamesort>-<:game_pinyin>-<#page>.html')
    ->defaults(array('module' => 'game', 'controller' => 'index', 'action' => 'lists', 'game_tag' => 0, 'game_theme' => 0, 'game_status' => 0, 'game_effect' => 0, 'test_status' => 0, 'gamesort' => 0, 'game_pinyin' => 0, 'page' => 0));

$router->route('company_show', '/platform-<#id>.html')
    ->defaults(array('module' => 'company', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('company_lists', '/platformlist-<#sort>-<#page>.html')
    ->defaults(array('module' => 'company', 'controller' => 'index', 'action' => 'lists', 'sort' => 0, 'page' => 0));

$router->route('gallery_show', '/gallery-<#id>.html')
    ->defaults(array('module' => 'gallery', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('gallery_lists', '/gallerylist-<#tag>-<#page>.html')
    ->defaults(array('module' => 'gallery', 'controller' => 'index', 'action' => 'lists', 'tag' => 0, 'page' => 0));

$router->route('kaifu_lists', '/kaifulist-<#year>-<#month>-<#day>-<#t>-<#page>.html')
    ->defaults(array('module' => 'kaifu', 'controller' => 'index', 'action' => 'lists', 'year' => date("Y", $time), 'month' => date("m", $time), 'day' => date("d", $time), 't' => 0, 'page' => 0));
$router->route('kaifu_serverlist', '/serverlist-<#game_id>-<#page>.html')
    ->defaults(array('module' => 'kaifu', 'controller' => 'index', 'action' => 'serverlist', 'game_id' => 0, 'page' => 0));

$router->route('kaice_lists', '/gametest-<#page>.html')
    ->defaults(array('module' => 'kaice', 'controller' => 'index', 'action' => 'lists', 'page' => 0));

$router->route('gift_lists', '/giftlist-<#page>.html')
    ->defaults(array('module' => 'gift', 'controller' => 'index', 'action' => 'lists', 'page' => 0));

?>
