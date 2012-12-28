<?php
/**
 * 搜索页
 *
 */

$defaultSearchType = "game";

$searchTypeList = array(
   'game' => 1, 
   'article' => 5,
   'company' => 6
);

if (empty($stype)) {
    $stype = $defaultSearchType;
} elseif (!isset($searchTypeList[$stype])) {
    ShowMsg('搜索类型错误！', '-1');
    exit;
}

$searchtype = $stype;
$typeid = $searchTypeList[$stype];

?>
