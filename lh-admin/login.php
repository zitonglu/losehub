<?php
/**
 * LoseHub CMS 后台登录界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @var $echo
 * @version 2019-3-21
 * 
 * @return redirect index.php
 */
require_once('function/base.php');
header('Content-type:text/html; charset=utf-8');

$echo = '';

//验证账户密码登录
@$userName = trim($_POST['userName']);
@$userPassWord = trim($_POST['userPassWord']);
if (isset($dbn)) {
  $userName = $dbn->quote($userName);
  $query = "SELECT COUNT(*) FROM `".LH_DB_PREFIX.'ssh'."` WHERE `SSH_login` = ".$userName." AND `SSH_password` = SHA(".$userPassWord.")";
  $count = $dbn->query($query);
  if (is_object($count) && $count->fetchColumn()>0) {
    session_start();
    $_SESSION['lh_session_userName'] = $userName;
    $_SESSION['lh_session_userPassWord'] = $userPassWord;
    setcookie("lh_cookie_user",$userName,time()+3600);

    if (isset($_POST['lh_remember_me'])) {// 记住用户登录
      setcookie("lh_cookie_password",$userPassWord,time()+3600);
    }

    redirect('index.php?act='.$userName);
  }else{
    // session_destroy();
    setcookie("lh_cookie_user");
    setcookie("lh_cookie_password");
    if (isset($_POST['userName'])) {
      $echo = '<p class="text-danger text-center">帐号或密码错误，请核实</p>';
    }
  }
}

?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Zitonglu">
  <title>LoseHub CMS程序后台登录</title>
  <!-- Bootstrap core CSS -->
  <link href="../lh-includes/style/bootstrap.min.css" rel="stylesheet">
  <!-- My CSS -->
  <link href="style/style.css" rel="stylesheet">
</head>
<body id="login">
  <div class="container">
    <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <h2 class="form-signin-heading">LoseHub CMS后台登录</h2>
      <div class="login-wrap">
        <input class="form-control" type="text" name="userName" required="required" placeholder="登录帐号" value="<?php echo str_replace("'","", $userName); ?>">
        <input class="form-control" type="password" name="userPassWord" required="required" placeholder="登录密码">
        <label class="checkbox">
          <input name="lh_remember_me" type="checkbox"> 记住用户登录
          <span class="pull-right">
            <a data-toggle="modal" href="#"> 忘记密码?</a>
          </span>
        </label>
        <?php echo $echo;?>
        <button class="btn btn-lg btn-login btn-primary" type="submit">登录后台</button>
        <a class="btn btn-lg btn-login btn-default" href="#">返回首页</a>
      </div>
    </form>
  </div>
</body>
</html>