 ----------------------------------------
|     ZQCMS 产品使用说明               |
 ----------------------------------------

一、平台需求
1.Windows 平台：
IIS/Apache/Nginx + PHP5.2以上 + MySQL5
如果在windows环境中使用，建议用XAMPP套件以达到最佳使用性能。

2.Linux/Unix 平台
Apache + PHP5.2以上 + MySQL5 (PHP必须在非安全模式下运行)

建议使用平台：Linux + Apache2.2 + PHP5.3 + MySQL5.0

3.PHP必须环境或启用的系统函数：
allow_url_fopen
MySQL扩展库
建议开启 ICONV 或 MB_STRING 扩展
系统函数 —— file_put_contents 等

4.基本目录结构
/
..../install     安装程序目录，安装完后可删除[安装时必须有可写入权限]
..../api         API接口目录
..../cmdpc       附助程序目录
..../zqcms       核心程序目录
..../caches      系统缓存或其它可写入数据存放目录[必须可写入]
..../models      系统默认模块存放目录
..../templates   系统默认模板存放目录
..../uploads     默认上传目录[必须可写入]
..../html        默认HTML文件存放目录[必须可写入]
..../templets    系统默认内核模板目录

5.PHP环境容易碰到的不兼容性问题
  (1)caches目录没写入权限，导致系统session无法使用，这将导致无法登录管理后台；
  (2)出现莫名的错误，如安装时显示空白，这样能是由于系统没装载mysql扩展导致的，对于初级用户，可以下载XAMPP套件包，以方便简单的使用。

二、程序安装使用
1.下载程序解压到本地目录;
2.上传uploads目录下的所有文件到网站根目录
3.运行http://www.yourname.com/install/index.php(yourname表示你的域名),按照安装提速说明进行程序安装
 
三、相关资源
ZQCMS官方主站        zqcms.com
技术支持论坛          bbs.zqcms.com