<?php
defined('IN_ADMIN') or exit('No permission resources.');
include "header.php"; ?>

<h1>数据库恢复</h1>
<p class="notification error">
    数据库恢复是一个危险操作，请谨慎操作！<br>
    数据库文件的存放地址：<?php echo CACHE_PATH.'bakup/'.$pdoname.'/'; ?>
</p>
<div class="content content-ext">
    <?php include "setting_nav.php"; ?>
<div class="table-list">
<form method="post" id="myform" name="myform" >
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="5%"><input type="checkbox" value="" id="check_box" onclick="selectall('filenames[]');"></th>
            <th width="25%">文件名称</th>
            <th width="15%">文件大小</th>
            <th width="15%">备份时间</th>
            <th width="15%">卷号</th>
            <th width="10%">操作</th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
    $prepre = "";
	foreach($infos as $info){
?>   
	<tr class="<?php echo $info['bgcolor']?>">
	<td>
<input type="checkbox" name="filenames[]" value="<?php echo $info['filename']?>" id="sql_phpcms" boxid="sql_phpcms">
	</td>
	<td><?php echo $info['filename']?></td>
	<td><?php echo $info['filesize']?> M</td>
	<td><?php echo $info['maketime']?></td>
	<td><?php echo $info['number']?></td>
    <td>
    <?php
    if($info['pre'] != $prepre){
    ?>
	<a href="javascript:confirmurl('?m=admin&c=database&pdoname=<?php echo $pdoname?>&a=import&pre=<?php echo $info['pre']?>&dosubmit=1', '确认恢复数据库吗?')">数据恢复</a>
    <?php 
    }
    $prepre = $info['pre'];
?>
    </td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
<div class="btn">
<label for="check_box">全选/取消</label> 
<input type="submit" class="button" name="dosubmit" value="删除备份文件" onclick="document.myform.action='?m=admin&c=database&a=delete&pdoname=<?php echo $pdoname?>';return confirm('确认删除数据库备份吗？')"/>
</div>
</form>
</div>
</div>

<?php include "footer.php"; ?>