<?php include "header.php"; ?>

<h1>友情链接<a class="button" href="?m=admin&c=link&a=add">添加</a></h1>

<?php if(!empty($errors)) echo '<p class="notification error">' . implode('<br>', $errors) . '</p>'; ?>
<?php if(!empty($succ)) echo '<p class="notification success">' . implode('<br>', $succ) . '</p>'; ?>
<div class="content">
<form name="myform" id="myform" action="?m=admin&c=link&a=listorder" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="5%"><input type="checkbox" value="" id="check_box" onclick="selectall('linkid[]');"></th>
			<th width="10%">排序</th>
			<th width="40%">网站名称</th>
			<th width="10%">类型</th>
			<th width="10%">状 态</th>
			<th width="25%">操作</th>
		</tr>
	</thead>
<tbody>
<?php
if(is_array($infos)){
	foreach($infos as $info){
		?>
	<tr>
		<td><input type="checkbox" name="linkid[]" value="<?php echo $info['linkid']?>"></td>
		<td><input name='listorders[<?php echo $info['linkid']?>]' type='text' size='3' value='<?php echo $info['listorder']?>' class="input-text-c"></td>
		<td><a href="<?php echo $info['url'];?>" title="前往网站" target="_blank"><?php if($info['linktype']==1){?><img src="<?php echo $info['logo'];?>" width=83 height=31><?php }?><?php echo $info['name']?></a> </td>
		<td><?php if($info['linktype']==0){echo "文字";}else{echo "LOGO";}?></td>
		<td><?php if($info['passed']=='0'){?>禁用中<?php }else{?>启用中<?php }?></td>
		<td><?php if($info['passed']=='0'){?><a
			href='?m=admin&c=link&a=check&linkid=<?php echo $info['linkid']?>'
			onClick="return confirm('是否启用？')">启用</a><?php }else{?><a
			href='?m=admin&c=link&a=uncheck&linkid=<?php echo $info['linkid']?>'
			onClick="return confirm('是否禁用？')">禁用</a><?php }?> | <a href="?m=admin&c=link&a=edit&linkid=<?php echo $info['linkid']?>"
			title="修改">修改</a> | <a
			href='?m=admin&c=link&a=delete&linkid=<?php echo $info['linkid']?>'
			onClick="return confirm('是否删除此链接？')">删除</a> 
		</td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>
</div>
<div class="btn"> 
<input name="dosubmit" type="submit" class="button"
	value="排序">&nbsp;&nbsp;<input type="submit" class="button" name="dosubmit" onClick="if(confirm('是否删除此链接？')) document.myform.action='?m=admin&c=link&a=delete'" value="删除"/>
</div>
<?php echo $pages?>
</form>
</div>
<script type="text/javascript">
//向下移动
function listorder_up(id) {
	$.get('?m=admin&c=link&a=listorder_up&linkid='+id,null,function (msg) { 
	if (msg==1) { 
	//$("div [id=\'option"+id+"\']").remove(); 
		alert('请选择再执行操作');
	} else {
	alert(msg); 
	} 
	}); 
} 
</script>

<?php include "footer.php"; ?>