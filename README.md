# MySQL-Monitor
MySQL服务器执行SQL记录实时监控（WEB版本）

**使用方法：**
上传mysql_monitor_server.php,mysql_monitor_cls.php,mysql_monitor_client.html,last_count.dat以及assets文件夹到服务器上，然后访问mysql_monitor_client.html之后，输入正确的数据库连接参数（必须要用root用户连接），点击Connect按钮即可开始监控目标服务器所执行过的SQL语句。

**注意事项：**

如果没有点击Disconnect按钮停止监控，而是直接关闭浏览器或者刷新浏览器页面可能会导致数据库内会记录一些垃圾数据，清理方式为手动访问mysql_monitor_cls.php或者点一下Connect按钮之后再点Disconnect按钮即可。