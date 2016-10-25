<?php
/**
 * @name MySQL Monitor [MySQL SQL执行监控 清理临时数据脚本]
 * @copyright 昌维[867597730@qq.com]
 * @website www.changwei.me
 * @since 2016-10-25 00:14:29
 */

/**
 * 连接mysql服务器
 */
$hostname = !empty($_GET['hostname']) ? $_GET['hostname'].':'.$_GET['port'] : 'localhost'; // 数据库服务器IP或者域名
$username = !empty($_GET['username']) ? $_GET['username'] : 'root'; // 数据库连接账户
$password = !empty($_GET['password']) ? $_GET['password'] : 'root'; // 数据库连接密码
$database = !empty($_GET['database']) ? $_GET['database'] : 'mysql'; // 监控日志存储数据库（默认为mysql表，无需修改）

$mysqli = new mysqli($hostname, $username, $password, $database);
/* check connection */
if (mysqli_connect_errno()) {
	exit("Connect failed: ".mysqli_connect_error());
}
$mysqli->set_charset("utf8");

file_put_contents('last_count.dat', '0');
$mysqli->query("truncate table `general_log`");

/**
 * 关闭记录SQL执行日志功能和连接资源
 */
$mysqli->query("set global general_log=off");
$mysqli->close();