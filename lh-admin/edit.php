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

include('header.php');
include('nav.php');
?>
<div class="container edit">
	<form action="">
		<textarea class="form-control" rows="8" placeholder="请输入段落文字"></textarea><br>
		<div class="panel-group">
			<div class="text-right" id="XX1">
				<button type="submit" class="btn btn-link hidden-xs" disabled="disabled"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> <?php echo date('Y-m-d h:i:s');?></button>
				<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 上传</button>
				<button type="submit" class="btn btn-default" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
				<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>
			</div>
			<div id="collapseOne" class="collapse">
			<!-- <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1"> -->
				<ul class="list-group edit-list">
					<li class="list-group-item">
						类型：
						<?php foreach ($types as $key => $value) {
							$echo = '<label class="radio-inline">';
							$echo .= '<input type="radio" name="type" id="type-'.$key.'" value="'.$key.'"> '.$value;
							$echo .= '</label>';
							echo $echo;
						}
						?>
					</li>
					<li class="list-group-item">
						状态：
						<?php foreach ($states as $key => $value) {
							$echo = '<label class="radio-inline">';
							$echo .= '<input type="radio" name="state" id="state-'.$key.'" value="'.$key.'"> '.$value;
							$echo .= '</label>';
							echo $echo;
						}
						?>
					</li>
					<li class="list-group-item spinner">
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" disabled="disabled"><span class="glyphicon glyphicon-sort-by-order"></span></button>
							</span>
							<input type="number" class="form-control" value="42">	
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="plus"><span class="glyphicon glyphicon-plus"></span></button>
								<button class="btn btn-default" type="button" id="minus"><span class="glyphicon glyphicon-minus"></span></button>
							</span>
						</div>
					</li>
				</ul>
				</div>
			</div>
		</form>
</div>

<?php include('footer.php');?>