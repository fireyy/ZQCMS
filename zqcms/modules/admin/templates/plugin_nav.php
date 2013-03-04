<div class="tabs">
    <ul>
        <li><a href="?m=admin&c=link"<?php if($_GET['c']=='link') echo ' class="active"'; ?>>友情链接</a></li>
        <li><a href="?m=admin&c=poster"<?php if($_GET['c']=='poster') echo ' class="active"'; ?>>广告管理</a></li>
        <li><a href="?m=admin&c=database&a=export"<?php if($_GET['c']=='database' && $_GET['a']=='export') echo ' class="active"'; ?>>数据库备份</a></li>
        <li><a href="?m=admin&c=database&a=import"<?php if($_GET['c']=='database' && $_GET['a']=='import') echo ' class="active"'; ?>>数据库恢复</a></li>
        <li><a href="?m=admin&c=database&a=clear_data"<?php if($_GET['c']=='database' && $_GET['a']=='clear_data') echo ' class="active"'; ?>>数据库清理</a></li>
    </ul>
    
</div>