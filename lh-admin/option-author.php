<?php
/**
 * LoseHub CMS 后台界面-参数设置-个人信息设置界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-4-17
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$echo = '';
/**
 * 个人信息预设项目
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)
 * @version 2019-4-18
 * 
 * @return $echo
 */
$query = 'SELECT * FROM '.LH_DB_PREFIX.'ssh';
$query.= ' WHERE `SSH_id`= 1';
//echo $query;
$sth = $dbn->query($query);
while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
	$echo .= '<h3 class="media-heading"><span class="glyphicon glyphicon-education hidden-xs" aria-hidden="true"></span> '.$row['SSH_name'].'</h3><br>';
	$echo .= '<p>登录帐号：'.$row['SSH_login'].'</p>';
	$echo .= '<p>用户密码：**********</p>';
	$echo .= '<p>有效日期：'.$row['SSH_date'].'</p>';
	$echo .= '<p>个人邮箱：'.$row['SSH_email'].'</p>';
	$echo .= '<p>联系电话：'.$row['SSH_telephone'].'</p>';
	$echo .= '<p>备注说明：'.$row['SSH_tips'].'</p>';
	$echo .= '<p class="text-right col-sm-5"><a href="'.changeURLGet('return','edit').'" class="btn btn-default"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 更改</a></p>';
	// 编辑个人信息项
	if(@$_GET['return'] == 'edit'){
		$echo = '<h3 class="media-heading"><span class="glyphicon glyphicon-list-alt hidden-xs" aria-hidden="true"></span> 编辑个人信息项</h3><br>';
		$echo .= '<form action="'.getNoGetURL().'"  method="post">';
		$echo .= '<p><label for="SSH_name">用户名称：</label>
		<input required tabindex="1" type="text" class="form-control editInput" name="SSH_name" placeholder="用户名称" value="'.$row['SSH_name'].'"> *</p>';
		$echo .= '<p><label for="SSH_login">登录帐号：</label>
		<input required tabindex="2" type="text" class="form-control editInput" name="SSH_login" placeholder="登录帐号" value="'.$row['SSH_login'].'"> *</p>';
		$echo .= '<p><label for="SSH_password1">修改密码：</label>
		<input tabindex="3" type="password" class="form-control editInput" name="SSH_password1" placeholder="不修改可不填写" id="psw""></p>';
		$echo .= '<p><label for="SSH_password2">重复密码：</label>
		<input tabindex="4" type="password" class="form-control editInput" name="SSH_password2" placeholder="再次输入修改的密码" id="psw1"></p>';
		$echo .= '<p class="text-danger text-right" id="tips" style="display:none;">两次密码输入不一致</p>';
		$echo .= '<p><label for="SSH_date">有效日期：</label>
		<input required tabindex="5" type="date" class="form-control editInput inputTime" name="SSH_date" placeholder="有效日期" value="'.$row['SSH_date'].'"> *</p>';
		$echo .= '<p><label for="SSH_email">个人邮箱：</label>
		<input required tabindex="6" type="email" class="form-control editInput" name="SSH_email" placeholder="个人邮箱" value="'.$row['SSH_email'].'"> *</p>';
		$echo .= '<p><label for="SSH_telephone">联系电话：</label>
		<input tabindex="7" type="number" class="form-control editInput" name="SSH_telephone" placeholder="联系电话" value="'.$row['SSH_telephone'].'"></p>';
		$echo .= '<p><textarea tabindex="8" class="form-control" rows="3" name="SSH_tips" placeholder="备注说明，可输入密码相关提示信息">'.$row['SSH_tips'].'</textarea></p>';
		$echo .= '<p class="lingheight3em"><label for="SSH_old_password">确认修改：</label>
		<input required tabindex="9" type="password" class="form-control editInput" name="SSH_old_password" placeholder="请输入原始密码">*';
		$echo .= ' <button tabindex="11" type="button" class="btn btn-default send-button" onclick="javascript:window.history.back(-1);"><span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span> 返回</button> <button tabindex="10" type="submit" class="btn btn-default send-button" name="editAuthor"><span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> 提交</button></p>';
		$echo .= '</form>';
	}
}

/**
 * 个人信息修改项提交
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$query,$sth,$_POST
 * @version 2019-4-18
 * 
 * @return $echo or UPDATE back
 */
if (isset($_POST['editAuthor'])) {
	if (@$_POST['SSH_password1'] == @$_POST['SSH_password2']) {
		$sth2 = $dbn->query($query);
		while ($update = $sth2->fetch(PDO::FETCH_ASSOC)) {
			$inPassWord = trim($_POST['SSH_old_password']);
			$query = 'SELECT COUNT(*) FROM `'.LH_DB_PREFIX.'ssh'.'` WHERE `SSH_id` = 1 AND `SSH_password` = SHA('.trim($_POST['SSH_old_password']).')';
			$count = $dbn->query($query);
			if (is_object($count) && $count->fetchColumn()>0){
				//更新个人信息
				$query = 'UPDATE '.LH_DB_PREFIX.'ssh'.' SET ';
				if ($_POST['SSH_password1'] != null) {
					$query .= '`SSH_password`=SHA(\''.$_POST['SSH_password1'].'\'),';
				}
				$query .= '`SSH_date`=\''.$_POST['SSH_date'].'\',';
				$query .= '`SSH_tips`=\''.$_POST['SSH_tips'].'\',';
				$query .= '`SSH_login`=\''.$_POST['SSH_login'].'\',';
				$query .= '`SSH_name`=\''.$_POST['SSH_name'].'\',';
				$query .= '`SSH_telephone`=\''.$_POST['SSH_telephone'].'\',';
				$query .= '`SSH_email`=\''.$_POST['SSH_email'].'\'';
				$query .= ' WHERE `SSH_id`=\'1\'';
				$dbn->query($query);
				redirect($lh['site_url'].'/lh-admin/option-author.php');
			}else{
				$echo .= '<br><p class="text-danger col-sm-12">更改无效，请输入正确的原始密码</P>';
			}
		}
	}else{
		$echo .= '<br><p class="text-danger col-sm-12">更改无效，新密码2次不一致</P>';
	}
}


include('header.php');
include('nav.php');
?>
<div class="container option-author">
	<div class="lingheight3em"><?php include('option-nav.php');?></div><hr>
	<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 个人信息</h4>
	<p class="text-2em">LoseHub建议个人用户使用，默认个人信息为密匙数据库中的首选项。</p>
	<hr>
	<div class="media">
		<div class="media-left">
			<a href="#">
				<img class="media-object authorjpg" src="images/author.jpg" alt="picture">
			</a>
		</div>
		<div class="media-body">
			<?php echo $echo;?>
		</div>
	</div>
</div>
<?php if(@$_GET['return'] == 'edit'){//验证2次密码是否输入一致?>
<script>
	var psw = document.getElementById("psw");
	var psw1 = document.getElementById("psw1");
	var tips = document.getElementById("tips");
	psw.onkeyup = function(){
		var txt = this.value;
		var txt1 = psw1.value;
		if(txt===txt1){
			tips.style.display="none";
		}else{
			tips.style.display="block";
		}
	}
	psw1.onkeyup = function(){
		var txt = this.value;
		var txt1 = psw.value;
		if(txt===txt1){
			tips.style.display="none";
		}else{
			tips.style.display="block";
		}
	}
</script>
<?php }?>
<?php include('footer.php');?>