<?php
/**
 * LoseHub CMS 后台界面-导航栏
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $lh
 * @version 2019-3-21
 * 
 * @return html
 */
?>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $lh['site_url']; ?>/lh-admin/index.php"><strong>LoseHub</strong></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav" id="divNavBar">
				<li><a href="<?php echo $lh['site_url']; ?>/lh-admin/edit.php"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 新建 <span class="sr-only">(current)</span></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span> 订阅 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">RSS源</a></li>
						<li><a href="#">条目列表</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 全部更新</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 列表 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $lh['site_url']; ?>/lh-admin/p-list.php">段落</a><li>
						<li><a href="<?php echo $lh['site_url']; ?>/lh-admin/a-list.php">长文</a></li>
					</ul>
				</li>
				<li><a href="#"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> 评论</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 配置 <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">信息</a></li>
						<li><a href="#">参数</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#">主题</a></li>
						<li><a href="#">插件</a></li>
					</ul>
				</li>
				<li><a href="<?php echo $lh['site_url']; ?>/lh-admin/SSH.php"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 密匙</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 社区</a></li>
			</ul>
			<!-- <form class="navbar-form navbar-left">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="输入……">
				</div>
				<button type="submit" class="btn btn-default">搜索</button>
			</form> -->
			<ul class="nav navbar-nav navbar-right">
				<li><a href="http://losehub.com" target="_blank"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 官网</a></li>
				<li><a href="<?php echo basename($_SERVER['PHP_SELF']).'?act=loginout';?>"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> 登出</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>