<?php
/**
 * 获得语言文件
 *
 * @param string $tag
 *
 * @return string
 */
function getLangData($tag){
  $LANG = array(
      "game_tag"=>"游戏分类",
      "test_status"=>"运营状态",
      "game_theme"=>"游戏题材",
      "game_status"=>"收费方式",
      "game_effect"=>"画面效果",
      "urlrule_article_init"=>"资讯首页",
      "urlrule_article_list"=>"资讯列表",
      "urlrule_article_show"=>"资讯内容页",
      "urlrule_gallery_list"=>"图库列表",
      "urlrule_gallery_show"=>"图库内容页",
      "urlrule_game_list"=>"游戏列表",
      "urlrule_game_show"=>"游戏内容页",
      "urlrule_kaifu_list"=>"开服列表",
      "urlrule_server_list"=>"游戏开服列表",
      "urlrule_kaice_list"=>"开测列表",
      "urlrule_gift_list"=>"礼包列表",
      "urlrule_company_list"=>"厂商列表",
      "urlrule_company_show"=>"厂商内容页"
  );
  if(isset($LANG[$tag]) && !empty($LANG[$tag])) {
    return $LANG[$tag];
  }
  return $tag;
}
register_template_plugin("modifier", "LANG", "getLangData");

?>
