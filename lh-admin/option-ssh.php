<?php
/**
 * LoseHub CMS 后台界面-参数设置-密匙界面
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
 * 新增SSH密匙
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)，$lh
 * @version 2019-4-23
 * 
 * @return option-ssh.php or $error
 */

if (isset($_POST['addSSH'])) {
	if ($_POST['sshPassWord1'] == $_POST['sshPassWord2']) {
	if (@$_POST['onlyDate'] == 'on') {
		$date = date('Y-m-d',time()-86400);
	}elseif(empty($_POST['sshDate'])){
		$date = date('Y-m-d',time()+604800);
	}else{
		$date = $_POST['sshDate'];
	}
	if (strstr($_POST['sshTips'],$_POST['sshPassWord1'])) {
		$error = '?error=密码提示中包含了具体密码信息';
	}
	$query = 'INSERT INTO '.LH_DB_PREFIX.'ssh';
	$query .= ' (`SSH_name`,`SSH_login`,`SSH_password`,`SSH_date`,`SSH_email`,`SSH_tips`,`SSH_telephone`) VALUE (';
	$query .= '\''.$_POST['sshName'].'\',\''.$_POST['sshLogin'].'\',SHA(\''.$_POST['sshPassWord1'].'\'),\''.$date.'\',\''.$_POST['sshEmail'].'\',\''.$_POST['sshTips'].'\',\''.$_POST['sshTelephone'].'\')';
	//echo $query;
	$dbn->query($query);
	redirect('option-ssh.php'.$error);
	}else{
		redirect('option-ssh.php?error=两次密码不一致');
	}
}

/**
 * 验证SSH密匙
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)，$lh
 * @version 2019-4-23
 * 
 * @return option-ssh.php AND $error
 */

if (isset($_POST['testSSH'])) {
	$query = 'SELECT COUNT(*) FROM `'.LH_DB_PREFIX.'ssh'.'` WHERE `SSH_password` = SHA(\''.trim($_POST['password']).'\') AND `SSH_login`=\''.$_POST['login'].'\' AND `SSH_id`='.$_POST['id'];
	echo $query;
	if ($_POST['password'] == 1) {
		//redirect('option-ssh.php?error=密码正确');
	}else{
		//redirect('option-ssh.php?error=密码不正确&return=testSSH&SSHid='.$_POST['id']);
	}
}

/**
 * 获取翻页相关信息
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)，$lh
 * @version 2019-4-18
 * 
 * @return $num_page等变量
 */
if (isset($_GET['listselect'])) {
	$results_per_page = (int)$_GET['listselect'];// 翻页行数
	$query = MySQL_options_change('row_number',$results_per_page,LH_DB_PREFIX.'options');
	$dbn->query($query);
}else{
	$results_per_page = $lh['row_number'];
}
$cur_page = isset($_GET['page']) ? $_GET['page'] : 1;// 当前页面数
$skip = ($cur_page-1) * $results_per_page;// 计算上一页行数
$page_link = '';

$search_query = "SELECT * FROM ".LH_DB_PREFIX.'ssh';
$count_query = preg_replace('/\*/','count(*)',$search_query);//用于查询总行数

$search_query .= ' LIMIT ';
if($cur_page > 1){
	$i = (int)$results_per_page*($cur_page-1);
	$search_query .= $i.',';
}
$search_query .= $results_per_page;
$result = $dbn->prepare($search_query);
$result->execute();
$sshArray = $result->fetchAll();

$count = $dbn->query($count_query);
$counts = $count->fetch();
$total = $counts[0];// 获取总行数
$num_page = ceil($total/$results_per_page);// 分页数


/**
 * 列表输出
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $sshArray
 * @version 2019-4-22
 * 
 * @return $echo
 */
foreach ($sshArray as $ssh) {
	empty($ssh['SSH_telephone'])?$ssh_telephone='无':$ssh_telephone=$ssh['SSH_telephone'];
	$echo .= '<tr>';
	$echo .= '<th scope="row">'.$ssh['SSH_id'].'</th>';
	$echo .= '<td>'.$ssh['SSH_name'].'</td>';
	$echo .= '<td>'.$ssh['SSH_login'].'</td>';
	if (@$_GET['return'] == 'testSSH' && @$_GET['SSHid'] == $ssh['SSH_id']) {//验证密匙
		$echo .= '<td colspan="2" class="alert alert-info"><p class="text-left turn">密码提示：'.$ssh['SSH_tips'].'</p></td>';
		$echo .= '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
		$echo .= '<td><div class="form-group"><div class="input-group"><div class="input-group-addon"><a href="'.getNoGetURL().'" title="取消验证"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a></div><input class="form-control" type="password" name="password" required placeholder="test password"></div></div></td>';
		$echo .= '<td><button type="submit" class="btn btn-default" name="testSSH"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> 验证</button>';
		$echo .= '<input name="login" class="hidden" value="'.$ssh['SSH_login'].'">';
		$echo .= '<input name="id" class="hidden" value="'.$ssh['SSH_id'].'"></form>';
	}else{
		if($ssh['SSH_date']>date('Y-m-d')){
			$echo .= '<td>'.$ssh['SSH_date'].'</td>';
		}else{
			$echo .= '<td><kbd>'.$ssh['SSH_date'].'</kbd></td>';
		}
		$echo .= '<td>'.$ssh['SSH_email'].'</td>';
		$echo .= '<td>'.$ssh_telephone.'</td>';
		$echo .= '<td>';
		$echo .= '<a href="'.getNoGetURL().'?return=testSSH&SSHid='.$ssh['SSH_id'].'" title="提示：'.$ssh['SSH_tips'].'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>';
		$echo .= '&nbsp;&nbsp;<a href="#" title="编辑"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>';
		if ($ssh['SSH_id'] > '1') {
			$echo .= ' <a href="deletedb.php?return=optionSSH&SSHid='.$ssh['SSH_id'].'" title="删除"><code><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></code></a>';
		}
	}
	$echo .= '</td></tr>';
}

include('header.php');
include('nav.php');
?>
<div class="container p-list ssh">
	<div class="lingheight3em"><?php include('option-nav.php');?></div><hr>
	<div class="row table-responsive">
	<table class="table table-striped table-hover list-table text-center">
		<caption>
			<h4><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 密匙设置</h4>
			<p class="text-2em">这是与您的帐户关联的ssh密钥列表。也可以用户存储密码的记事本。</p>
			<?php 
				if(@$_GET['error']){
					echo '<p class="text-2em text-danger">'.$_GET['error'].'</p>';
				}
			?>
		</caption>
		<thead>
			<tr>
				<th class="col-sm-1">id</th>
				<th class="text-center col-sm-2">密码类型</th>
				<th class="text-center col-sm-2">登录账号</th>
				<th class="text-center col-sm-2">失效日期</th>
				<th class="text-center col-sm-2">相关邮箱</th>
				<th class="text-center col-sm-2">联系号码</th>
				<th class="text-center col-sm-1">密码</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $echo;
				if (@$_GET['return'] == 'addSSH') {//增加密匙
			?>		
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="addSSH">
				<input type="hidden" name="code" value="<?php echo $_GET['code'];?>">
				<tr>
					<th></th>
					<td><input class="form-control" type="text" name="sshName" required placeholder="ssh-Name" tabindex="1"></td>
					<td><input class="form-control" type="text" name="sshLogin" required placeholder="ssh-Login" tabindex="2"></td>
					<td>
						<label class="checkbox">
							<input type="checkbox" name="onlyDate"> 帐号只存储
						</label>
					</td>
					<td></td>
					<td></td>
					<td><a href="<?php echo getNoGetURL();?>" class="btn btn-default"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> 返回</a></td>
				</tr>
				<tr>
					<th scope="row">密码</th>
					<td>
						<div class="form-group">
							<label class="sr-only">password</label>
							<div class="input-group">
								<div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
								<input class="form-control" type="password" name="sshPassWord1" required placeholder="password" tabindex="3" id="psw">
							</div>
						</div>
					</td>
					<td>
						<div class="form-group">
							<label class="sr-only">password again</label>
							<div class="input-group">
								<div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
								<input class="form-control" type="password" name="sshPassWord2" required placeholder="password again" tabindex="4" id="psw1">
							</div>
						</div>
					</td>
					<td>
						<input class="form-control inputTime" type="date" name="sshDate" tabindex="5">
					</td>
					<td>
						<input class="form-control" type="email" name="sshEmail" placeholder="@" tabindex="7" required>
					</td>
					<td>
						<input class="form-control" type="number" name="sshTelephone" placeholder="ssh-Telephone" tabindex="8">
					</td>
					<td></td>
				</tr>
				<tr>
				<th scope="row">密码提示</th>
				<td colspan="5">
					<textarea class="form-control" rows="3" placeholder="为了安全，请勿直接写入密码相关信息。" tabindex="10" name="sshTips"></textarea>
					<p style="display:none" id="tips" class="text-danger text-left">两次密码不一致</p>
				</td>
				<td>
					<button type="submit" class="btn btn-default" name="addSSH" tabindex="6"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> 保存</button>
				</td>
				</tr>
			</form><!-- 增加SSH结束 -->
			<?php }else{ ?>
			<tr>
			<th colspan="6"></th>
			<td>
				<a class="btn btn-default" href="<?php echo changeURLGet('return','addSSH');?>"><span class="glyphicon glyphicon-link" aria-hidden="true"></span> 增加</a>
			</td>
			</tr>
			<?php }?><!-- 显示增加按钮结束 -->
		</tbody>
	</table>
	</div>
	<div class="col-sm-9 col-xs-8">
	<nav aria-label="Page navigation">
		<ul class="pagination">
			<?php
			// Previous前一页
			if( $cur_page > 1){
				$page_link .= '<li><a href="'.changeURLGet('page',$cur_page - 1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}else{
				$page_link .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
			}
			// 循环页数
			for ($i=1; $i <= $num_page; $i++) { 
				if ($cur_page == $i) {
					$page_link .= '<li class="active"><a href="'.changeURLGet('page',$cur_page).'">'.$cur_page.'</a></li>';
				}else{
					$page_link .= '<li><a href="'.changeURLGet('page',$i).'">'.$i.'</a></li>';
				}
			}
			// Next下一页
			if ($cur_page < $num_page-1){
				$page_link .= '<li><a href="'.changeURLGet('page',$cur_page + 1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}else{
				$page_link .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
			}
			echo $page_link;
			?>
			
		</ul>
	</nav>
	</div>
	<div class="col-sm-3 col-xs-4">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
			<span class="hidden-sm hidden-xs">显示条数:</span>
			<select class="form-control selectbox" name="list" onchange="window.location=this.value;" title="显示条数">
				<option value="<?php echo getPageURL();?>">显示行</option>
				<?php
					$listArray =array('5','10','15','20','30','50');
					foreach ($listArray as $key => $value) {
						if (@$value == $_GET['listselect']) {
							$checked = ' selected = "selected"';
						}else{
							$checked ='';
						}
						echo '<option value="'.changeURLGet('listselect',$value).'"'.$checked.'>'.$value.'</option>';
					}
				?>
			</select>
		</form>
	</div>
</div>
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
<?php include('footer.php');?>