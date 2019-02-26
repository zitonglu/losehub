<?php
/**
 * LoseHub CMS 后台登录界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-15
 * 
 * @return redirect edit.php
 */
require('function/base.php');

if (!file('../lh-admin/database.php')) {
  die('未安装成功或者安装有误!');
}else{
  $dataBase = require '../lh-admin/database.php';
  $tableName = $dataBase['dbprefix'].'user';
}

try {
$dsn = 'mysql:host='.$dataBase['dbhost'].';dbname='.$dataBase['dbname'];
$dbh = new PDO($dsn,$dataBase['dbuser'],$dataBase['dbpass']);
}catch (PDOException $e) {
echo '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
echo '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
}

@$userName = $_GET['userName'];
@$userPassWord = $_GET['userPassWord'];

$query = "SELECT COUNT(*) FROM `".$tableName."` WHERE ";
$query .= "`user_login` = '".$userName."'";
$query .= " AND ";
$query .= "`user_pass` = '".$userPassWord."'";
$count = $dbh->query($query);
if ($count->fetchColumn() > 0) {
  setcookie("LH_cookie_user",$userName,time()+3600);
  redirect('edit.php?act='.$userName);
}else{
  setcookie("LH_cookie_user");
  echo '<p class="text-danger text-center">帐号或密码错误，请核实</p>';
}

?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Zitonglu">
  <title>LoseHub CMS程序后台登录</title>
  <!-- Bootstrap core CSS -->
  <link href="../lh-includes/css/bootstrap.min.css" rel="stylesheet">
  <!-- My CSS -->
  <link href="css/style.css" rel="stylesheet">
</head>
<body id="login">
  <div class="container">
    <form class="form-signin" action="#" method="get">
      <h2 class="form-signin-heading">LoseHub CMS后台登录</h2>
      <div class="login-wrap">
        <input class="form-control" type="text" name="userName" required="required" placeholder="登录帐号">
        <input class="form-control" type="password" name="userPassWord" required="required" placeholder="登录密码">
        <label class="checkbox">
          <input value="remember-me" type="checkbox"> 记住用户登录
          <span class="pull-right">
            <a data-toggle="modal" href="#"> 忘记密码?</a>
          </span>
        </label>
        <button class="btn btn-lg btn-login btn-primary" type="submit">登录后台</button>
        <a class="btn btn-lg btn-login btn-default" href="">返回首页</a>
      </div>
    </form>
  </div>
</body>
</html>