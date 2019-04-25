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
$SSHrow = array();
$changeSSHrow = array();
@$_GET['error'] == '密码不正确' ? $testPasswrod = '密码不正确' : $testPasswrod = 'test password';


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
 * @return option-ssh.php AND $_GET
 */

if (isset($_POST['testSSH'])) {
	$query = 'SELECT COUNT(*) FROM '.LH_DB_PREFIX.'ssh'.' WHERE `SSH_password` = SHA(\''.trim($_POST['password']).'\') AND `SSH_login` = \''.$_POST['login'].'\' AND `SSH_id` = '.$_POST['id'];
	$count = $dbn->query($query);
	// echo $query;
	if(is_object($count) && $count->fetchColumn()>0) {
		redirect('option-ssh.php?success=密码输入正确');
	}else{
		redirect('option-ssh.php?error=密码不正确&return=testSSH&SSHid='.$_POST['id']);
	}
}

/**
 * 修改SSH密匙
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;)，$lh
 * @version 2019-4-25
 * 
 * @return $SSHrow back to option-ssh.php
 */

if (@$_GET['return'] == 'changeSSH') {// 跳转页面判断
	$query = 'SELECT * FROM '.LH_DB_PREFIX.'ssh'.' WHERE `SSH_id` = '.$_GET['SSHid'];
	//echo $query;
	$result = $dbn->query($query);
	$changeSSHrow = $result->fetchAll();
}
if (isset($_POST['changeSSH'])) {
	if ($_POST['sshPassWord1'] == $_POST['sshPassWord2']) {
		$query = 'UPDATE '.LH_DB_PREFIX.'ssh'.' SET ';
		$query .='`SSH_name` = \''.$_POST['sshName'];
		$query .='\',`SSH_login` = \''.$_POST['sshLogin'];
		$query .='\',`SSH_tips` = \''.$_POST['sshTips'];
		$query .='\',`SSH_email` = \''.$_POST['sshEmail'];
		$query .='\',`SSH_telephone` = \''.$_POST['sshTelephone'];
		$query .='\',`SSH_date` = \''.$_POST['sshDate'];
		$query .='\',`SSH_password` = SHA(\''.$_POST['sshPassWord1'];
		$query .='\') WHERE `SSH_id` = '.$_POST['id'];
		//echo $query;
		$dbn->query($query);
		redirect('option-ssh.php?success=SSH密码修改成功');
	}else{
		redirect('option-ssh.php?error=两次密码不一致');
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
		$echo .= '<td><div class="form-group"><div class="input-group"><div class="input-group-addon"><a href="'.getNoGetURL().'" title="取消验证"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a></div><input class="form-control" type="password" name="password" required placeholder="'.$testPasswrod.'"></div></div></td>';
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
		if ($ssh['SSH_id'] > '1') {
			$echo .= '&nbsp;&nbsp;<a href="'.getNoGetURL().'?return=changeSSH&SSHid='.$ssh['SSH_id'].'" title="编辑"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>';
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
			<p class="text-2em">这是与您的帐户关联的ssh密钥列表。也可以作为存储密码的记事本。</p>
			<?php 
				if(@$_GET['error']){
					echo '<p class="text-2em text-danger">'.$_GET['error'].'</p>';
				}
				if(@$_GET['success']){
					echo '<p class="text-2em text-primary">'.$_GET['success'].'</p>';
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
				if (@$_GET['return'] == 'addSSH' || @$_GET['return'] == 'changeSSH') {//增加或者变更密匙
					if (empty($changeSSHrow)) {
						$SSHrow = array(
							'SSH_name' => 'placeholder="ssh-Name"',
							'SSH_login' => 'placeholder="ssh-Login"',
							'SSH_date' => 'value="'.date('Y-m-d').'"',
							'SSH_email' => 'placeholder="@"',
							'SSH_telephone' => 'placeholder="ssh-Telephone"',
						);
						//print_r($SSHrow);
					}else{
						foreach ($changeSSHrow as $row) {
							foreach ($row as $key => $value) {
								if (!is_numeric($key)) {
									$array = array( $key => 'value="'.$value.'"');
									$SSHrow = array_merge($SSHrow, $array);
								}
							}
						}
						//print_r($SSHrow);
					}
			?>		
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="addSSH">
				<input type="hidden" name="id" value="<?php echo @$_GET['SSHid'];?>">
				<tr>
					<th></th>
					<td><input class="form-control" type="text" name="sshName" required  tabindex="1" <?php echo $SSHrow['SSH_name'];?>></td>
					<td><input class="form-control" type="text" name="sshLogin" required <?php echo $SSHrow['SSH_login'];?> tabindex="2"></td>
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
						<input class="form-control inputTime" type="date" name="sshDate" tabindex="5" <?php echo $SSHrow['SSH_date'];?>>
					</td>
					<td>
						<input class="form-control" type="email" name="sshEmail" tabindex="7" required <?php echo $SSHrow['SSH_email'];?>>
					</td>
					<td>
						<input class="form-control" type="number" name="sshTelephone" tabindex="8" <?php echo $SSHrow['SSH_telephone'];?>>
					</td>
					<td></td>
				</tr>
				<tr>
				<th scope="row">密码提示</th>
				<td colspan="5">
					<textarea class="form-control" rows="3" tabindex="10" name="sshTips"<?php if(empty($SSHrow['SSH_tips'])){
							echo ' placeholder="为了安全，请勿直接写入密码相关信息。"></textarea';
						}else{
							echo '>'.$row['SSH_tips'].'</textarea';
						};
					?>
					><!-- 注意这个>号，这是textarea的结尾符 -->
					<p style="display:none" id="tips" class="text-danger text-left">两次密码不一致</p>
				</td>
				<td>
					<?php
					if (empty($SSHrow['SSH_password'])) {
						echo '<button type="submit" class="btn btn-default" name="addSSH" tabindex="6"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> 保存</button>';
					}else{
						echo '<button type="submit" class="btn btn-success" name="changeSSH" tabindex="6"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> 变更</button>';
					}
					?>	
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