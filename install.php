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
global $LH;
$step = isset( $_POST['step'] ) ? (int) $_POST['step'] : 0;
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
    <!-- My CSS -->
    <link href="lh-admin/css/style.css" rel="stylesheet">
</head>
<body class="setup">
<div class="setupBox">
    <h1 class="text-center">Lose<i class="logoColor">Hub</i> CMS</h1>
    <form method="post" action="install.php?step=<?php echo $step + 1 ;?>"> 
<?php
switch ($step) {
    case 0:
        setup0();
        break;
    case 1:
        setup1();
        break;
    default:
        echo $step;
        break;
}
?>
    </form>
    <input type="button" class="btn btn-default pull-left" value="← 返回" onclick="javascript:window.history.back(-1);">
<!-- 安装第一步 -->
<?php 
function setup0(){ 
    $step = (int)1;
?>
    <input type="hidden" name="step" id="step" value="<?php echo $step;?>"/>
    <p>
        感谢您使用 LoseHub 。LoseHub 基于 PHP 技术，采用 MySQL 或 SQLite 或 PostgreSQL 作为数据库，全部源码开放。希望我们的努力能为您提供一个高效快速、强大的移动端站点解决方案。
    </p>
    <p>LoseHub 官方网址：<a href="http://loseHub.com" target="_blank" title="LoseHub官方网站">http://loseHub.com</a></p>
    <p>为了使您正确并合法的使用本软件，请您在使用前务必阅读清楚下面的协议条款：</p>
    <textarea readonly rows="8">
一、本授权协议适用且仅适用于 LoseHub ，LoseHub官方对本授权协议拥有最终解释权。

二、协议许可的权利

1. 本程序基于 MIT 协议开源，您可以在 MIT 协议允许的范围内对源代码进行使用，包括源代码或界面风格以适应您的网站要求。
2. 您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。
3. 您可以从 LoseHub 提供的应用中心服务中下载适合您网站的应用程序，但应向应用程序开发者/所有者支付相应的费用。
4. 本程序在云主机（新浪SAE、百度BAE、阿里云等）使用的相关授权费用由 LoseHub 另行规定。

三、协议规定的约束和限制

1. 无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用 Z-BlogPHP 程序本身，未经书面许可，必须保留页面底部的版权（Powered by Z-BlogPHP），不得删除；但可以以任何访客可见的形式对其进行修改和美化。
2. 您从应用中心下载的应用程序，未经应用程序开发者的书面许可，不得对其进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等。
3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。

四、有限担保和免责声明

1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。
2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。
3. 电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装 LoseHub ，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
4. 如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。

版权所有 ©2017 - 2017，LoseHub 保留所有权利。
    </textarea>
    <p class="text-right">协议发布时间：2017 年 1 月 1 日</p>
    <input type="submit" class="btn btn-default pull-right" value="我同意，继续安装 →">
<?php }
//Setup1 end
function setup1(){ 
    $step = (int)2;
?>
    <input type="hidden" name="step" id="step" value="<?php echo $step;?>"/>
    <p>
        欢迎使用 LoseHub 。在安装程序开始前，请准备好如下信息：
    </p>
    <ol>
        <li>数据库名</li>
        <li>数据库用户</li>
        <li>数据库密码</li>
        <li>数据库主机</li>
        <li>数据表前缀</li>
    </ol>
    <input type="submit" class="btn btn-default pull-right" value="现在开始安装 →">

<?php } ?><!-- setp end -->
</div><!-- setupBox end -->

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