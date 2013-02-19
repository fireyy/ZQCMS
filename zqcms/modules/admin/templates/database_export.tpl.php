<?php
defined('IN_ADMIN') or exit('No permission resources.');
include "header.php"; ?>

<h1>数据库备份</h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>
<div class="content content-ext">
  <?php include "setting_nav.php"; ?>
<div class="table-list">
<form method="post" name="myform" id="myform" action="?m=admin&c=database&a=export">
<input type="hidden" name="tabletype" value="zqcmstables" id="zqcmstables">
<fieldset>
    <legend>分卷备份设置</legend>
    <em>数据库备份文件的存放地址：<?php echo CACHE_PATH.'bakup/'.$pdo_name.'/'; ?></em>
    <p>
        <label>分卷文件大小:</label>
        <input type="text" name="sizelimit" value="2048" size="5">
        <em>单位：KB</em>
    </p>
</fieldset>
<fieldset>
    <legend>数据表选择</legend>
    <em>请选择需要备份的数据表</em>
    <table width="100%" cellspacing="0">
    <thead>
       <tr>
           <th width="5%"><input class="auto" type="checkbox" value="" id="check_box" onclick="selectall('tables[]');"></th>
           <th width="25%" >表名</th>
           <th width="25%">记录数</th>
           <th width="15%">使用空间</th>
           <th width="15%">碎片</th>
            <th width="15%">操作</th>
       </tr>
    </thead>
    <tbody>
	<?php foreach($infos['zqcmstables'] as $v){?>
	<tr>
	<td><input class="auto" type="checkbox" name="tables[]" value="<?php echo $v['name']?>"/></td>
	<td><?php echo $v['name']?></td>
	<td><?php echo $v['rows']?></td>
	<td><?php echo $v['size']?></td>
	<td><?php echo $v['data_free']?></td>
	<td><a href="?m=admin&c=database&a=public_repair&operation=optimize&pdo_name=<?php echo $pdo_name?>&tables=<?php echo $v['name']?>">优化</a> | <a href="?m=admin&c=database&a=public_repair&operation=repair&pdo_name=<?php echo $pdo_name?>&tables=<?php echo $v['name']?>">修复</a></td>
	</tr>
	<?php } ?>
	</tbody>
</table>

<div class="btn">
<label for="check_box">全选/取消</label>
<input type="button" class="button" onclick="reselect()" value="反选"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=admin&c=database&a=public_repair&operation=optimize&pdo_name=<?php echo $pdo_name?>'" value="批量优化"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=admin&c=database&a=public_repair&operation=repair&pdo_name=<?php echo $pdo_name?>'" value="批量修复"/>
</div>
</fieldset>
<p class="buttons">
    <input type="hidden" name="dosubmit" value="1">
    <button type="submit">提交</button>
</p>

</form>
</div>
</div>

<script type="text/javascript">
<!--
function reselect() {
	var chk = $("input[name=tables[]]");
	var length = chk.length;
	for(i=0;i < length;i++){
		if(chk.eq(i).attr("checked")) chk.eq(i).attr("checked",false);
		else chk.eq(i).attr("checked",true);
	}
}
//-->
</script>
<?php include "footer.php"; ?>