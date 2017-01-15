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
 * LoseHub CMS 首页程序
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-15
 * 
 * @return index
 */
require('lh-admin/function/base.php');

if (!file('lh-user/database.php')) {
  redirect('install.php');
  exit;
}