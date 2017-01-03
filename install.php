<?php
/**
 *
 *****************************************************************************************************
 *    如果您看到了这个提示，那么我们很遗憾地通知您，您的空间不支持 PHP 。
 *    We regret to inform you that your web hosting not support PHP,
 *    and Z-BlogPHP CAN'T run on it if you see this prompt.
 *
 *    也就是说，您的空间可能是静态空间，或没有安装PHP，或没有为 Web 服务器打开 PHP 支持。
 *    It means that you may have a web hosting service supporting only static resources.
 *    Is PHP successfully installed on your server?
 *    Or, is HTTP Server configured correctly?
 *
 */

/**
 * LoseHub CMS 安装程序
 * @author 紫铜炉
 * @copyright LoseHub
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Zitonglu">
	<title>LoseHub CMS程序安装</title>
	<!-- Bootstrap core CSS -->
    <link href="lh-admin/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!--header start-->
<header class="header white-bg">
    <a href="http://loseHub.com" target="_blank" class="logo">Lose<span>Hub</span></a>
</header>

<?php
	$dbhost = 'localhost:3306';  //mysql服务器主机地址
	$dbuser = 'localhost';      //mysql用户名
	$dbpass = '';//mysql用户名密码
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if(!$conn ){
		die('无法链接数据库' . mysql_error());
	}
?>
<!-- Bootstrap jQuery -->
<script src="lh-admin/js/jquery-2.2.4.min.js"></script>
<script src="lh-admin/js/bootstrap.min.js"></script>
</body>
</html>