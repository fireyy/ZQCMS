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
      "game_effect"=>"画面效果"
  );
  if(isset($LANG[$tag]) && !empty($LANG[$tag])) {
    return $LANG[$tag];
  }
  return $tag;
}
register_template_plugin("modifier", "LANG", "getLangData");

?>
