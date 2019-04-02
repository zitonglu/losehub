<?php
/**
 * LoseHub CMS 后台界面-文章发布及编辑界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-4-2
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$type_C = 'A';
$state_C = 'P';
$title_value = null;

if (isset($_GET['Aid']) === TRUE) {
	$Aid_value = $_GET['Aid'];
}else{
	$Aid_value = null;
}

include('header.php');
include('nav.php');
?>
<div class="container edit-article">
	<div class="col-sm-1 text-right">#</div>
	<form action="function/edit-a.php" method="post" enctype="multipart/form-data">
		<div class="col-sm-10"><textarea class="form-control text-justify text-center" rows="2" placeholder="文章标题" name="title" required></textarea></div>
		<div class="col-sm-1">
			<input type="hidden" name="id"<?php echo $Aid_value;?>>
			<!-- <button type="button" class="btn btn-link"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button> -->
			<button type="submit" class="btn btn-link" name="new"><span class="glyphicon glyphicon-ok" aria-hidden="true" name="new"></span></button>
		</div>
	</form>
	<hr>
	<!-- <form action="function/edit-a.php" method="post" enctype="multipart/form-data">
	<div class="col-md-offset-1 col-sm-5 option">
		<span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> 类型|状态：<select class="form-control selectbox" name="type" required>
			<?php foreach ($types as $key => $value) {
				if ($key == $type_C) {
					$checked = ' selected = "selected"';
				}else{
					$checked ='';
				}
				echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
			}
			?>
		</select> <select class="form-control selectbox" name="state" required>
			<?php foreach ($states as $key => $value) {
				if ($key == $state_C) {
					$checked = ' selected = "selected"';
				}else{
					$checked ='';
				}
				echo '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
			}
			?>
		</select>
	</div>
	<div class="col-sm-5 option panel-group">
		<div class="text-right">
			<input type="hidden" name="id"<?php echo $id_value;?>>
			<input type="hidden" name="return"<?php echo $return_value;?>> 
			<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 上传</button>
			<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
			<button type="submit" class="btn btn btn-primary" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>
		</div>
		<div id="collapseOne" class="collapse text-right">
			段落序号，用于长文章
			<div class="input-group" id="p-order">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span> 段落序号</button>
				</span>
				<input type="number" class="form-control"<?php echo $p_order;?> name="p_order">	
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" id="plus"><span class="glyphicon glyphicon-plus"></span></button>
					<button class="btn btn-default" type="button" id="minus"><span class="glyphicon glyphicon-minus"></span></button>
				</span>
			</div>
			<label class="checkbox-inline">
				<input type="checkbox" name="comments" <?php echo $checkbox;?>><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 可评论
			</label>
		</div>
		<div id="collapseTwo" class="collapse text-right">
			<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />最大上传2MB文件
			<input type="file" name="screenshot" class="file-input">
		</div>
	</div>
	</form> -->
</div>
<?php include('footer.php');?>