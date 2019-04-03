<?php
/**
 * LoseHub CMS 后台界面-段落发文和编辑界面
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global base.php($dbn;),$lh
 * @version 2019-3-27
 * 
 * @return none
 */
require_once('function/base.php');
require_once('function/authorize.php');

$type_C = 'P';
$state_C = 'P';
$checkbox = null;
$textarea = null;
$id_value = null;
$picDiv = null;
$p_order =' value="'.date('s').'"';
$return_value ='';
$send = '<button type="submit" class="btn btn btn-primary" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>';

// 判断是否是回写的
if (isset($_GET['id']) && $_GET['id'] != ''){
	$id_value = ' value="'.$_GET['id'].'"';
	$send = '<button type="submit" class="btn btn-success" name="send"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 编辑</button>';
	$query = "SELECT `p_contect`,`p_state_code`,`p_c_state_code`,`p_type_code`,`p_order`";
	$query .= " FROM ".LH_DB_PREFIX.'paragraphs';
	$query .= " WHERE `id`=".$_GET['id'];
	// echo $query;
	$result = $dbn->prepare($query);
	$result->execute();
	while ($lh_paragraphs = $result->fetch(PDO::FETCH_ASSOC)){
		$textarea = $lh_paragraphs['p_contect'];
		$type_C = $lh_paragraphs['p_type_code'];
		$state_C = $lh_paragraphs['p_state_code'];
		$p_order = ' value="'.$lh_paragraphs['p_order'].'"';
		if ($lh_paragraphs['p_c_state_code'] == 'P') {
			$checkbox = 'checked';
		}else{
			$checkbox = null;
		}
	}
	// 返回内容里附加的图片
	$picUrlArray = get_http_img($textarea);
	if (!empty($picUrlArray) && $type_C == 'pic') {
		$picDiv = '<div class="row">';
		foreach ($picUrlArray as $key => $value) {
			$picDiv .= '<div class="col-sm-4">';
			$picDiv .= '<a href="'.$value.'" class="thumbnail" target="_blank">';
			$picDiv .= '<img src="'.$value.'" class="img-responsive">';
			$picDiv .= '</a>';
			$picDiv .= '</div>';
		}
		$picDiv .= '</div>';
	}
}
// 判断判断
switch (@$_GET['return']) {
	case 'OK':
		$return = '<p class="alert alert-success return"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 提交成功</p>';
		$return_value = ' value="edit"';
		break;
	case 'plist':
		$return = null;
		$return_value = ' value="plist"';
		break;
	default:
		$return = null;
		break;
}

include('header.php');
include('nav.php');
?>
<div class="container edit">
	<div class="row">
		<div class="col-sm-1 hidden-xs text-right">#</div>
		<div class="col-sm-10">
			<?php echo $return;echo $picDiv;?>
			<form action="function/edit-p.php" method="post" enctype="multipart/form-data">
				<textarea name="textarea" required id="summernote"><?php echo $textarea;?></textarea>
				<!-- <textarea class="form-control" rows="8" placeholder="请输入段落文字" name="textarea" required><?php echo $textarea;?></textarea> -->
				<br>
				<div class="col-sm-7 option">
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
					<!-- 			<span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php echo date('Y-m-d h:i:s');?> -->
				</div>
				<div class="col-sm-5 panel-group">
					<div class="text-right">
						<input type="hidden" name="id"<?php echo $id_value;?>>
						<input type="hidden" name="return"<?php echo $return_value;?>>
						<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 上传</button>
						<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
						<?php echo $send;?>
					</div>
					<div id="collapseOne" class="collapse text-right">
						<!-- 段落序号，用于长文章 -->
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
						<input type="hidden" name="MAX_FILE_SIZE" value="2097152" /><!-- 最大上传2MB文件 -->
						<input type="file" name="screenshot" class="file-input">
					</div>
				</div>
			</form>
			<?php get_http_img($textarea);?>
		</div>
		<div class="col-sm-1 hidden-xs">#</div>
	</div>
</div>
<?php include('footer.php');?>