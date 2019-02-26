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
define('LH_VERSION_RSS','0');
define('LH_VERSION_WEB','0');
define('LH_VERSION_EDIT','0');
define('LH_VERSION',LH_VERSION_MAJOR.'.'.LH_VERSION_RSS.LH_VERSION_WEB.LH_VERSION_EDIT);

//安装地址
defined('LH_PATH') || define('LH_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../')), '/') . '/');

//获取数据库信息
if (file(LH_PATH.'lh-admin/database.php')){
	$GLOBALS['LH_dataBase'] = require LH_PATH.'lh-admin/database.php';
}

//加载系统基础函数
require LH_PATH.'lh-admin/function/common.php';

?>