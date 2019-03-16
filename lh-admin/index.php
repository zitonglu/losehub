<?php
/**
 * LoseHub CMS 后台登录界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-3-13
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<a href="">首页</a>
	<?php 
		session_start();
		if (isset($_SESSION['lh_session_userName'])) {
			echo "string";
		}
		echo $_SESSION['lh_session_userName'];
		echo $_SESSION['lh_session_userPassWord'];
		// session_destroy();
	 ?>
</body>
</html>