<?php
/**
 * 系统初始化等相关操作
 * @package LoseHub
 * @subpackage System/Base 基础操作
 * @copyright (C) 紫铜炉
 */
//版本号
define('LH_VERSION_MAJOR','1');
define('LH_VERSION_RSS','0');
define('LH_VERSION_WEB','0');
define('LH_VERSION_EDIT','0');
define('LH_VERSION',LH_VERSION_MAJOR.'.'.LH_VERSION_RSS.LH_VERSION_WEB.LH_VERSION_EDIT);

//安装地址
defined('LH_PATH') || define('LH_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../')), '/') . '/');

?>