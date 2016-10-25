<?php
/**
 * @name MySQL Monitor Server [MySQL SQL执行监控服务端]
 * @copyright 昌维[867597730@qq.com]
 * @website www.changwei.me
 * @since 2016-10-15 16:26:31
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


/**
 * 开启记录SQL执行日志功能
 */
$mysqli->query("SET GLOBAL general_log=on");
$mysqli->query("SET GLOBAL log_output='table'");


/**
 * 获取新SQL执行日志
 */
// 读取上一次的游标
$last_count = file_get_contents('last_count.dat');
// $total_count = mysqli_fetch_all($mysqli->query("SELECT count(event_time) AS last_count FROM `general_log`"),MYSQLI_ASSOC)[0]['last_count'];
if ($stmt = $mysqli->query("SELECT * FROM `general_log` LIMIT {$last_count},4294967296")) {
    // 获取数据
	$rs = mysqli_fetch_all($stmt,MYSQLI_ASSOC);
    // 释放结果集
	mysqli_free_result($stmt);
	// $stmt->close();
}else{
	exit(mysqli_error($mysqli));
}
// 写入上一次的游标
$last_count = mysqli_fetch_all($mysqli->query("SELECT count(event_time) AS last_count FROM `general_log`"),MYSQLI_ASSOC)[0]['last_count'];
file_put_contents('last_count.dat', $last_count);

/**
 * 关闭记录SQL执行日志功能和连接资源
 */
$mysqli->close();


/**
 * 把程序本身的一些执行结果过滤
 */
$count_rs = count($rs);
$new_rs = array_slice($rs, 1, -5);

/**
 * 输出json给前端
 */
// var_dump($new_rs);
// echo json_encode($rs);
echo json_encode($new_rs);