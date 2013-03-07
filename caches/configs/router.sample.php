<?php
$time = time();

$router->route('default', '/')->defaults(array('module' => 'home', 'controller' => 'index', 'action' => 'index'));

$router->route('article_show', '/~urlrule_article_show~')
    ->defaults(array('module' => 'article', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('article_lists', '/~urlrule_article_list~')
    ->defaults(array('module' => 'article', 'controller' => 'index', 'action' => 'lists', 'tag' => 0, 'game_id' => 0, 'page' => 0));
$router->route('article_index', '/~urlrule_article_init~')
    ->defaults(array('module' => 'article', 'controller' => 'index', 'action' => 'index'));

$router->route('game_show', '/~urlrule_game_show~')
    ->defaults(array('module' => 'game', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('game_lists', '/gamelist-<#game_tag>-<#game_theme>-<#game_status>-<#game_effect>-<#test_status>-<#gamesort>-<:game_pinyin>-<#page>.html')
    ->defaults(array('module' => 'game', 'controller' => 'index', 'action' => 'lists', 'game_tag' => 0, 'game_theme' => 0, 'game_status' => 0, 'game_effect' => 0, 'test_status' => 0, 'gamesort' => 0, 'game_pinyin' => 0, 'page' => 0));

$router->route('company_show', '/~urlrule_company_show~')
    ->defaults(array('module' => 'company', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('company_lists', '/~urlrule_company_list~')
    ->defaults(array('module' => 'company', 'controller' => 'index', 'action' => 'lists', 'sort' => 0, 'page' => 0));

$router->route('gallery_show', '/~urlrule_gallery_show~')
    ->defaults(array('module' => 'gallery', 'controller' => 'index', 'action' => 'show', 'id' => 0));
$router->route('gallery_lists', '/~urlrule_gallery_list~')
    ->defaults(array('module' => 'gallery', 'controller' => 'index', 'action' => 'lists', 'tag' => 0, 'page' => 0));

$router->route('kaifu_lists', '/~urlrule_kaifu_list~')
    ->defaults(array('module' => 'kaifu', 'controller' => 'index', 'action' => 'lists', 'year' => date("Y", $time), 'month' => date("m", $time), 'day' => date("d", $time), 't' => 0, 'page' => 0));
$router->route('kaifu_serverlist', '/~urlrule_server_list~')
    ->defaults(array('module' => 'kaifu', 'controller' => 'index', 'action' => 'serverlist', 'game_id' => 0, 'page' => 0));

$router->route('kaice_lists', '/~urlrule_kaice_list~')
    ->defaults(array('module' => 'kaice', 'controller' => 'index', 'action' => 'lists', 'page' => 0));

$router->route('gift_lists', '/~urlrule_gift_list~')
    ->defaults(array('module' => 'gift', 'controller' => 'index', 'action' => 'lists', 'page' => 0));

?>
