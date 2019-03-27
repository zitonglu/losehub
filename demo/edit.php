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
$checkbox = null;
$textarea = null;
$id_value = null;
$picDiv = null;
$send = '<button type="submit" class="btn btn-default" name="send"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>';

// 判断是否是回写的
if (isset($_GET['id']) && $_GET['id'] != ''){
	$id_value = ' value="'.$_GET['id'].'"';
	$send = '<button type="submit" class="btn btn-success" name="send"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 编辑</button>';
	$query = "SELECT `p_contect`,`p_state_code`,`p_c_state_code`,`p_type_code`";
	$query .= " FROM ".LH_DB_PREFIX.'paragraphs';
	$query .= " WHERE `id`=".$_GET['id'];
	// echo $query;
	$result = $dbn->prepare($query);
	$result->execute();
	while ($lh_paragraphs = $result->fetch(PDO::FETCH_ASSOC)){
		$textarea = $lh_paragraphs['p_contect'];
		$type_C = $lh_paragraphs['p_type_code'];
		$state_C = $lh_paragraphs['p_state_code'];
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

if (@$_GET['return'] == true) {
	$return = '<p class="alert alert-success return"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 提交成功</p>';
}else{
	$return = null;
}

include('header.php');
include('nav.php');
?>
<div class="container edit">
	<?php echo $return;echo $picDiv;?>
	<form action="function/edit-p.php" method="post" enctype="multipart/form-data">
		<textarea class="form-control" rows="8" placeholder="请输入段落文字" name="textarea" required><?php echo $textarea;?></textarea><br>
		<div class="panel-group">
			<div class="text-right">
				<input type="hidden" name="id"<?php echo $id_value;?>>
				<button type="submit" class="btn btn-link hidden-xs" disabled="disabled"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php echo date('Y-m-d h:i:s');?></button>
				<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 上传</button>
				<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
				<?php echo $send;?>
			</div>
			<div id="collapseOne" class="collapse text-right">
				<span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> 类型和状态：<select class="form-control selectbox" name="type" required>
				<?php foreach ($types as $key => $value) {
					if ($key == $type_C) {
						$checked = ' selected = "selected"';
					}else{
						$checked ='';
					}
					$echo = '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
					echo $echo;
				}
				?>
				</select> <select class="form-control selectbox" name="state" required>
				<?php foreach ($states as $key => $value) {
					if ($key == $state_C) {
						$checked = ' selected = "selected"';
					}else{
						$checked ='';
					}
					$echo = '<option value="'.$key.'"'.$checked.'>'.$value.'</option>';
					echo $echo;
				}
				?>
				</select><br />
				<label class="checkbox-inline">
					<input type="checkbox" name="comments" <?php echo $checkbox;?>><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 可评论
				</label>
				<!-- <div class="input-group">//段落序号，用于长文章
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span> 段落号</button>
					</span>
					<input type="number" class="form-control" value="42">	
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" id="plus"><span class="glyphicon glyphicon-plus"></span></button>
						<button class="btn btn-default" type="button" id="minus"><span class="glyphicon glyphicon-minus"></span></button>
					</span>
				</div> -->
			</div>
			<div id="collapseTwo" class="collapse text-right">
				<input type="hidden" name="MAX_FILE_SIZE" value="2097152" /><!-- 最大上传2MB文件 -->
				<input type="file" name="screenshot" class="file-input">
			</div>
		</div>
	</form>
	<?php get_http_img($textarea);?>
</div>
<?php include('footer.php');?>