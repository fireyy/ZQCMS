<?php
/**
 * ZQCMS plugin
 *
 * @package ZQCMS
 * 获得今日的开服数量
 *
 */

function smarty_function_get_today_kaifu_count($params, $template) {
    zq_core::load_model("kaifu_model");
    //得到今日的开服数量
    //   dede:type typeid=6}<a class="white" href="[field:typelink function=GetRealTypeUrl(@me)/]" target="_blank">dede:type dede:php}
    //     global $dsql;
    //     $time = strtotime('today');
    //     $begin_date = mktime(0, 0, 0, date("m", $time), date("d", $time), date("Y", $time));
    //     $end_date   = mktime(0, 0, 0, date("m", $time), date("d", $time) + 1, date("Y", $time));
    //     $sql = "SELECT count(*) AS dd FROM `#@__addonkaifu` WHERE test_date >= $begin_date AND test_date < $end_date";
    //     $count = $dsql->GetOne($sql);
    //     echo $count['dd'];
    // /dede:php}</a>
    if (isset($params['assign'])) {
	$template->assign($params['assign'], 1111);
    }
    //return 111;
}
?>
