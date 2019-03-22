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
		<div class="panel-group" role="tablist">
			<div class="panel panel-default">
				<div class="btn-group btn-group-justified" role="tab" id="1collapseOne">
					<div class="btn-group">
						<button type="submit" class="btn btn-default btn-block"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 上传</button>
					</div>
					<div class="btn-group">
						<button type="submit" class="btn btn-default btn-block" role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseListGroup1"> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 参数</button>
					</div>
					<div class="btn-group">
						<button type="submit" class="btn btn-block btn-default"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 发布</button>
					</div>
				</div>
				<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1">
					<ul class="list-group">
						<li class="list-group-item">Bootply</li>
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
						<!-- <li class="list-group-item">
							<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> 媒体</button>
						</li> -->
						<!-- <li class="list-group-item">
							<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <span class="hidden-xs">发布</span></button>
						</li> -->
					</ul>
					<div class="panel-footer">Footer</div>
				</div>
			</div>
		</div>
	</form>
</div>

<?php include('footer.php');?>