<?php
/**
 * LoseHub CMS 基础设置数据
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $dbn,$lh
 * @version 2019-3-21
 * 
 * @return none or install.php?
 */
//版本号
define('LH_VERSION_MAJOR','1');
define('LH_VERSION_MODEL','0');
define('LH_VERSION_VIEW','0');
define('LH_VERSION_CONTROLLER','0');
define('LH_VERSION',LH_VERSION_MAJOR.'.'.LH_VERSION_MODEL.LH_VERSION_VIEW.LH_VERSION_CONTROLLER);

//安装地址
defined('LH_PATH') || define('LH_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../')), '/') . '/');

//加载系统基础辅助函数
require_once LH_PATH.'lh-admin/function/common.php';

//获取数据库信息,判断是否生成了文件
if (file_exists(LH_PATH.'lh-content/database.php')){
	$lh_database = require LH_PATH.'lh-content/database.php';
	define('LH_DB_HOST', $lh_database['dbhost']);
	define('LH_DB_USER', $lh_database['dbuser']);
	define('LH_DB_PASSWORD', $lh_database['dbpass']);
	define('LH_DB_NAME', $lh_database['dbname']);
	define('LH_DB_PREFIX', $lh_database['dbprefix']); //表前缀
}else{
	include(LH_PATH.'install.php');
	exit();
}
// 链接数据库
try {
	$dbn = new PDO('mysql:host='.LH_DB_HOST.';dbname='.LH_DB_NAME,LH_DB_USER,LH_DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
}catch (PDOException $e) {
	echo '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
	echo '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
}
// 获取设置参数:$lh
$sql = "SELECT * FROM ".LH_DB_PREFIX.'options';
$lh = array();
foreach ($dbn->query($sql) as $row) {
	if($row['option_autoload'] == 'Y'){
		$add_key = array($row['option_code']=>$row['option_value']);
		$lh = array_merge($lh,$add_key);
	}
}

// $dbn = '';
?>
