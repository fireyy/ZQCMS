<div class="tabs">
    <ul>
        <li><a href="?m=admin&c=setting"<?php if($_GET['c']=='setting') echo ' class="active"'; ?>>站点设置</a></li>
        <li><a href="?m=admin&c=profile"<?php if($_GET['c']=='profile') echo ' class="active"'; ?>>用户信息</a></li>
        <li><a href="?m=admin&c=database&a=export"<?php if($_GET['c']=='database' && $_GET['a']=='export') echo ' class="active"'; ?>>数据库备份</a></li>
        <li><a href="?m=admin&c=database&a=import"<?php if($_GET['c']=='database' && $_GET['a']=='import') echo ' class="active"'; ?>>数据库恢复</a></li>
        <li><a href="?m=admin&c=database&a=clear_data"<?php if($_GET['c']=='database' && $_GET['a']=='clear_data') echo ' class="active"'; ?>>数据库清理</a></li>
    </ul>
    
</div>