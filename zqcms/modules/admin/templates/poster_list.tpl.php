<?php include "header.php"; ?>

<h1>广告管理</h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>
<div class="content">
    <?php include "plugin_nav.php"; ?>
<form name="myform" action="?m=admin&c=poster&a=listorder" method="post">
<div class="table-list">
    <p class="tips"><a href="?m=admin&c=poster&a=ref_cache">刷新广告缓存</a></p>
    <table width="100%" cellspacing="0" class="contentWrap">
        <thead>
            <tr>
			<th width="35" align="center">ID</th>
			<th align="center">标题</th>
			<th width="50" align="center">状态</th>
			<th width="130" align="center">添加时间</th>
			<th width="110" align="center">操作</th>
            </tr>
        </thead>
        <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
?>   
	<tr>
	<td align="center"><?php echo $info['id']?></td>
	<td><?php echo $info['name']?></td>
	<td align="center"><?php if((strtotime($info['enddate'])<SYS_TIME) && (strtotime($info['enddate'])>0)) { echo "过期"; } else { echo "启用"; }?></td>
	<td align="center"><?php echo date('Y-m-d H:i:s',$info['addtime']);?></td>
	<td align="center"><?php if($info['disabled'] != 1) { ?><a href="index.php?m=admin&c=poster&a=edit&id=<?php echo $info['id'];?>">修改</a><?php }else{ ?>锁定<?php } ?> | <a href="index.php?m=admin&c=poster&a=preview&id=<?php echo $info['id'];?>" target="_blank">预览</a></td>
	</tr>
<?php 
	}
}
?>
</tbody>
    </table>
  
    </div>
<?php echo $pages;?>
</form>
</div>

<?php include "footer.php"; ?>