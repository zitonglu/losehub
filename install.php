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
 * LoseHub CMS 安装程序:setup
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $dataBase,$adminInf
 * @version 2017-1-13
 * 
 * @return login.php (bataBase and LH-CONTENT\DATABASE.PHP)
 */
header('Content-type:text/html; charset=utf-8');

require('lh-admin/function/base.php');

// 数据库全局变量
$GLOBALS['dataBase'] = array(
    'dbhost' => '',
    'dbuser' => '',
    'dbpass' => '',
    'dbname' => '',
    'dbprefix' => '',
);
$dataBase['dbhost'] = isset( $_POST['dbhost'] ) ? (string) $_POST['dbhost'] : 'localhost';
$dataBase['dbuser'] = isset( $_POST['dbuser'] ) ? (string) $_POST['dbuser'] : 'root';
$dataBase['dbpass'] = isset( $_POST['dbpass'] ) ? (string) $_POST['dbpass'] : '';
$dataBase['dbname'] = isset( $_POST['dbname'] ) ? (string) $_POST['dbname'] : 'losehub';
$dataBase['dbprefix'] = isset( $_POST['dbprefix'] ) ? (string) $_POST['dbprefix'] : 'lh_';

// 定义管理员的全局变量
$GLOBALS['adminInf'] = array(
    'title' => '',
    'admin' => '',
    'password' => '',
    'email' => '',
);
$adminInf['title'] = isset( $_POST['title'] ) ? (string) $_POST['title'] : '站点名称';
$adminInf['admin'] = isset( $_POST['admin'] ) ? (string) $_POST['admin'] : 'admin';
$adminInf['password'] = isset( $_POST['password'] ) ? $_POST['password'] : '';
$adminInf['email'] = isset( $_POST['email'] ) ? $_POST['email'] : '';

$step = isset( $_POST['step'] ) ? (int) $_POST['step'] : 0;
// 检查数据库是否正常并且创建数据库名
if (isset($_POST['dbname'])) {
    $sql = 'CREATE DATABASE '.$dataBase['dbname'];
    try {
    $dsn = 'mysql:host='.$dataBase['dbhost'];
    $dbh = new PDO($dsn,$dataBase['dbuser'],$dataBase['dbpass']);
    $dbh->exec($sql);
    $step = (int)3;
    } catch (PDOException $e) {
        echo '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
        echo '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
        $step = (int)2;
    }
}
// 检查初始密码是否正确
if(isset($_POST['password'])){
    if ($_POST['password'] != $_POST['password2']) {
        $step = 3;
        echo '<p class="text-danger text-center">两次密码输入不一致</p>';
    }else{
        $step = 4;
    }
}
/**
 * 输出数据库相关信息到文件
 * @author 紫铜炉 910109610@QQ.com
 * @var $str
 * @package setup
 * @version 2017-1-13
 *
 * @return LH-CONTENT\DATABASE.PHP
 */
function LH_setup_echo(){
    global $dataBase;
    $str = "<?php return ";
    $str .= var_export($dataBase,TRUE);
    $str .= " ?>";
    file_put_contents('lh-content\database.php', $str);
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Zitonglu">
	<title>LoseHub CMS程序安装</title>
	<!-- Bootstrap core CSS -->
    <link href="lh-includes/style/bootstrap.min.css" rel="stylesheet">
    <!-- My CSS -->
    <link href="lh-admin/style/style.css" rel="stylesheet">
</head>
<body id="setup">
<div class="setupBox">
    <h1 class="text-center">Lose<i class="logoColor">Hub</i> CMS <small>v<?PHP echo LH_VERSION; ?></small></h1>
    <form method="post" action="install.php?step=<?php echo $step + 1 ;?>"> 
<?php
switch ($step) {
    case 0:
        setup0();
        break;
    case 1:
        setup1();
        break;
    case 2:
        setup2();
        break;
    case 3:
        setup3();
        break;
    case 4:
        setup4();
        break;
    default:
        echo '<p>安装错误，请重新打开安装！</p>';
        break;
}
?>
    </form>
    <input type="button" class="btn btn-default pull-left" value="← 返回" onclick="javascript:window.history.back(-1);">

<?php 
/**
 * 安装第一步：版本说明
 * @author 紫铜炉 910109610@QQ.com
 * @package setup
 * @version 2017-1-6
 *
 * @return setup1();
 */
function setup0(){ ?>
    <input type="hidden" name="step" value="1"/>
    <p>
        感谢您使用 LoseHub 。LoseHub基于PHP技术，采用MySQL(或SQLite、PostgreSQL)作为数据库，全部源码开放。该系统满足了那些喜欢用RSS方式阅读者的需求，并提供了评论及分享功能。用户可自行在服务上搭建一个RSS阅读程序，管理者可发布相关言论等信息。
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

版权所有 ©2017 - 2020，LoseHub 保留所有权利。
    </textarea>
    <p class="text-right">协议发布时间：2017 年 1 月 1 日</p>
    <input type="submit" class="btn btn-default pull-right" value="我同意，继续安装 →">
<?php }
/**
 * 安装第二步：准备说明提示
 * @author 紫铜炉 910109610@QQ.com
 * @package setup
 * @version 2017-1-6
 *
 * @return setup2();
 */
function setup1(){ ?>
    <input type="hidden" name="step" value="2"/>
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
<?php }
/**
 * 安装第三步：input数据库相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @package setup
 * @version 2017-1-10
 *
 * @return setup3(); $dataBase value
 */
function setup2(){ 
    global $dataBase;
    ?>
    <p>请填写下面信息，如果您不确定，请联系您的服务提供商。</p>
    <table class="table table-striped" valign="middle">
        <tbody>
            <tr>
                <td class="text-right">数据库名：</td>
                <td><input type="text" name="dbname" class="form-control" required="required" value="<?php echo $dataBase['dbname']; ?>"></td>
                <td>安装在哪个数据库</td>
            </tr>
            <tr>
                <td class="text-right">用户名：</td>
                <td><input type="text" name="dbuser" class="form-control" required="required" value="<?php echo $dataBase['dbuser']; ?>"></td>
                <td>您的MySQL用户名</td>
            </tr>
            <tr>
                <td class="text-right">密码：</td>
                <td><input name="dbpass" type="password" class="form-control" value="<?php echo $dataBase['dbpass']; ?>"></td>
                <td>您的MySQL的密码</td>
            </tr>
            <tr>
                <td class="text-right">数据库主机名：</td>
                <td><input type="text" name="dbhost" class="form-control"
                required="required" value="<?php echo $dataBase['dbhost']; ?>"></td>
                <td>localhost为本地</td>
            </tr>
            <tr>
                <td class="text-right">表前缀：</td>
                <td><input type="text" name="dbprefix" class="form-control" value="<?php echo $dataBase['dbprefix']; ?>"></td>
                <td>可区分多个程序</td>
            </tr>
        </tbody>
    </table>
    <input type="submit" class="btn btn-default pull-right" value="提交，安装 →">
<?php } 
/**
 * 安装第三步：input管理员相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @package setup
 * @version 2017-1-11
 *
 * @return setup4(); $adminInf value
 */
function setup3(){
    global $adminInf; 
?>
    <p>您的数据库链接正常，请设置管理员及相关信息。</p>
    <table class="table table-striped" valign="middle">
        <tbody>
            <tr>
                <td class="text-right">站点名称：</td>
                <td><input type="text" name="title" class="form-control" required="required" value="<?php echo $adminInf['title']; ?>"></td>
            </tr>
            <tr>
                <td class="text-right">管理员名称：</td>
                <td><input type="text" name="admin" class="form-control" required="required" value="<?php echo $adminInf['admin']; ?>"></td>
            </tr>
            <tr>
                <td class="text-right">密码：</td>
                <td><input name="password" type="password" class="form-control" required="required" value="<?php echo $adminInf['password']; ?>"></td>
            </tr>
            <tr>
                <td class="text-right">重复密码：</td>
                <td><input name="password2" type="password" class="form-control" required="required" value=""></td>
            </tr>
            <tr>
                <td class="text-right">邮箱：</td>
                <td><input type="email" name="email" class="form-control" required="required" value="<?php echo $adminInf['email']; ?>"></td>
            </tr>
        </tbody>
    </table>
    <input type="submit" class="btn btn-default pull-right" value="提交，安装 →">
<?php } 
/**
 * 安装第三步：input管理员相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @package setup
 * @version 2017-1-13
 *
 * @return a->lh-admin/login.php
 */
function setup4(){
    require('lh-admin/function/install-createdb.php');
?>
    <p><br></p>
    <a href="lh-admin/login.php" class="btn btn-default pull-right">进入网站</a>
<?php } ?><!-- setp end -->

</div><!-- setupBox end -->
</body>
</html>