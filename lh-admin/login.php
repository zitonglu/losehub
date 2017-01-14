<?php
/**
 * LoseHub CMS 后台登录界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2017-1-14
 * 
 * @return ？？
 */
require('function/base.php');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Zitonglu">
  <title>LoseHub CMS程序后台登录</title>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- My CSS -->
  <link href="css/style.css" rel="stylesheet">
</head>
<body id="login">
  <div class="container">
    <form class="form-signin" action="">
      <h2 class="form-signin-heading">LoseHub CMS后台登录</h2>
      <div class="login-wrap">
        <input class="form-control" type="text" name="useID" placeholder="登录帐号">
        <input class="form-control" type="password" name="useID" placeholder="登录密码">
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