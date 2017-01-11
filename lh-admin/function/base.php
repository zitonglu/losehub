<?php
/**
 * 系统初始化等相关操作
 * @package LoseHub
 * @subpackage System/Base 基础操作
 * @copyright (C) 紫铜炉
 */


//安装地址 
defined('LH_PATH') || define('LH_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../')), '/') . '/');

$GLOBALS['abc'] = fopen('C:\xampp\htdocs\zblog\zb_users\c_option.php', 'r');

function foo(){
	global $abc;
	$abc;
}
foreach($foo as $k=>$v){
 echo $k.'=>'.$v.'<br/>';
}

?>