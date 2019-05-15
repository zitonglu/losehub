<?php
/**
 * LoseHub CMS 后台界面-长文和短片等列表设置导航
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2019-5-15
 * 
 * @return none
 */
?>
<span class="dropdown">
	<button class="btn btn-primary dropdown-toggle" type="button" id="newpage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建 <span class="caret"></span></button>
	<ul class="dropdown-menu" aria-labelledby="newpage">
	    <li><a href="edit.php">段落</a></li>
	    <li><a href="edit-article.php">长文</a></li>
	</ul>
</span>

<a class="btn btn-default" href="a-list.php" role="button"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 长文</a>
<a class="btn btn-default" href="p-list.php" role="button"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 段落</a>