<?php
/**
 * LoseHub CMS 后台登录界面-发文界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-3-21
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$type_C = 'P';
$state_C = 'P';
$checkbox = '';
$textarea = '';

if (isset($_GET['id']) && $_GET['id'] != ''){
		$id_value = ' value="'.$_GET['id'].'"';
	}else{
		$id_value = '';
	}

include('header.php');
include('nav.php');
?>
<div class="container edit">
	<form action="function/edit-p.php" method="post">
		<!-- <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> -->
		<textarea class="form-control" rows="8" placeholder="请输入段落文字" name="textarea"><?php echo $textarea;?></textarea><br>
		<div class="panel-group">
			<div class="text-right">
				<input type="hidden" name="id"<?php echo $id_value;?>>
				<button type="submit" class="btn btn-link hidden-xs" disabled="disabled"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php echo date('Y-m-d h:i:s');?></button>
				<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 上传</button>
				<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
				<button type="submit" class="btn btn-default" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>
			</div>
			<div id="collapseOne" class="collapse">
				<ul class="list-group edit-list">
					<li class="list-group-item text-right">
						类型：
						<?php foreach ($types as $key => $value) {
							if ($key == $type_C) {
								$checked = 'checked ';
							}else{
								$checked ='';
							}
							$echo = '<label class="radio-inline">';
							$echo .= '<input type="radio" '.$checked.'name="type" id="type-'.$key.'" value="'.$key.'"> '.$value;
							$echo .= '</label>';
							echo $echo;
						}
						?>
					</li>
					<li class="list-group-item text-right">
						状态：
						<?php foreach ($states as $key => $value) {
							if ($key == $state_C) {
								$checked = 'checked ';
							}else{
								$checked ='';
							}
							$echo = '<label class="radio-inline">';
							$echo .= '<input type="radio" '.$checked.'name="state" id="state-'.$key.'" value="'.$key.'"> '.$value;
							$echo .= '</label>';
							echo $echo;
						}
						?>
					</li>
					<li class="list-group-item text-right">
						<label class="checkbox-inline">
							<input type="checkbox" name="comments" <?php echo $checkbox;?>><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 可评论
						</label>
					</li>
					<!-- <li class="list-group-item spinner text-right">//段落序号，用于长文章
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span> 段落号</button>
							</span>
							<input type="number" class="form-control" value="42">	
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="plus"><span class="glyphicon glyphicon-plus"></span></button>
								<button class="btn btn-default" type="button" id="minus"><span class="glyphicon glyphicon-minus"></span></button>
							</span>
						</div>
					</li> -->
				</ul>
				</div>
			</div>
		</form>
</div>

<?php include('footer.php');?>