<?php
/**
 * LoseHub CMS 登录函数
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn;$now
 * @version 2019-3-16
 * 
 * @return none
 */
require_once('function/base.php');

$foo1 = FALSE;
$foo2 = FALSE;

// 数据库连接
try {
$dbn = new PDO('mysql:host='.LH_DB_HOST.';dbname='.LH_DB_NAME,LH_DB_USER,LH_DB_PASSWORD);
}catch (PDOException $e) {
$echo = '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
$echo .=  '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
}

// 判断是否已是登录用户
session_start();
$now = strtotime(date('Y-m-d H:i:s'));

if (isset($_SESSION['lh_session_date'])){
	$lh_session_date = strtotime($_SESSION['lh_session_date']);
	$now -= $lh_session_date;
	if ($now <= 3600) {
		$foo1 = TRUE;
	}	
}

if (isset($_SESSION['lh_session_userName'])){
	$query = "SELECT COUNT(*) FROM `".LH_DB_PREFIX.'ssh'."` WHERE `SSH_login` = ".$_SESSION['lh_session_userName'];
	$count = $dbn->query($query);
	if (is_object($count) && $count->fetchColumn()>0) {
		$foo2 = TRUE;
	}
}
// session_destroy();

if ($foo1 == FALSE || $foo2 == FALSE) {
	redirect('login.php');
}

?>