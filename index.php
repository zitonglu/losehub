<?php
/**
 *
 *****************************************************************************************************
 *    如果您看到了这个提示，那么我们很遗憾地通知您，您的空间不支持 PHP 。
 *    也就是说，您的空间可能是静态空间，或没有安装PHP，或没有为 Web 服务器打开 PHP 支持。
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

if (!file('lh-content/database.php')) {
  redirect('install.php');
  exit;
}

?>