<?php
/**
 * LoseHub CMS 基础设置数据
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-13
 * 
 * @return none
 */
//版本号
define('LH_VERSION_MAJOR','1');
define('LH_VERSION_MODEL','0');
define('LH_VERSION_VIEW','0');
define('LH_VERSION_CONTROLLER','0');
define('LH_VERSION',LH_VERSION_MAJOR.'.'.LH_VERSION_MODEL.LH_VERSION_VIEW.LH_VERSION_CONTROLLER);

//安装地址
defined('LH_PATH') || define('LH_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../')), '/') . '/');

//获取数据库信息,定义固定量
if (@file(LH_PATH.'lh-content/database.php')){
	$lh_database = require LH_PATH.'lh-content/database.php';
	define('LH_DBHOST', $lh_database['dbhost']);
	define('LH_DBUSER', $lh_database['dbuser']);
	define('LH_DBPASS', $lh_database['dbpass']);
	define('LH_DBNAME', $lh_database['dbname']);
	define('LH_DBPREFIX', $lh_database['dbprefix']); //表前缀
	$lh_database ='';
}

//加载系统基础函数
require LH_PATH.'lh-admin/function/common.php';

?>