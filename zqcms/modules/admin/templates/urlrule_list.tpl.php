<?php include "header.php"; ?>

<h1>伪静态规则列表</h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>
<div class="content">
	<?php include "setting_nav.php"; ?>
<div class="table-list">
	<p class="tips">修改完规则，请 <a href="?m=admin&c=urlrule&a=public_cache_urlrule">生成伪静态缓存</a></p>
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="20%">名称</th>
			<th width="70%">规则</th>
			<th width="10%">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td><?php echo getLangData($info['name'])?></td>
		<td><?php echo $info['value']?></td>
		<td>
			<a href="?m=admin&c=urlrule&a=edit&urlruleid=<?php echo $info['id']?>"
			title="修改">修改</a>
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
</div>

<?php include "footer.php"; ?>