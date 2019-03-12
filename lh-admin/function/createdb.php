<?php
/**
 * LoseHub CMS 安装程序:setup - createdb
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $conn
 * @version 2017-1-13
 * 
 * @return none
 */
global $dataBase;

try {
	$dsn = 'mysql:host='.$dataBase['dbhost'].';dbname='.$dataBase['dbname'];
	$GLOBALS['conn'] = new PDO($dsn,$dataBase['dbuser'],$dataBase['dbpass']);
	echo '<p>链接数据库正常.....开始创建数据库表......</p>';
} catch (PDOException $e) {
	echo '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
	echo '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
}

/**
 * 创建type数据表，并写入P\A\pic\V\pre\U相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-11
 *
 * @return <p>
 */
function LH_setup_CTtypes(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'types';
	$sql = 'CREATE TABLE '.$tableName.'(
			type_code varchar(10) NOT NULL, 
			type_name varchar(20) NOT NULL DEFAULT "",
			type_describe varchar(100) NOT NULL DEFAULT "",
			PRIMARY KEY (type_code)
			)DEFAULT CHARSET=utf8';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制type类型名称不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`type_code`)";
	$conn->exec($sql);
	// 创建内容类别信息
	$sql = "insert into ".$tableName." (type_code,type_name,type_describe) values ('P',N'段落',N'简短文字、留言等'),
		('A',N'文章',N'长篇幅的文章'),
		('pic',N'图片',N'图片类型'),
		('V',N'视频',N'视频类型'),
		('pre',N'引用',N'引用文章,电脑源代码等'),
		('U',N'未知',N'未标明属性的东西')";
	try{
		$conn->exec($sql);
		echo '设置类别信息成功......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建states数据表，并写入P\D\C\N\pvt\U相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-11
 *
 * @return <p>
 */
function LH_setup_CTstates(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'states';
	$sql = 'CREATE TABLE '.$tableName.'(
			state_code varchar(10) NOT NULL, 
			state_name varchar(20) NOT NULL,
			state_describe varchar(100) NOT NULL DEFAULT "0",
			PRIMARY KEY (state_code)
			)DEFAULT CHARSET=utf8';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制state类型名称不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`state_code`)";
	$conn->exec($sql);
	// 创建内容的状态信息
	$sql = "insert into ".$tableName." (state_code,state_name,state_describe) values ('P',N'公开的',N'文章正常显示状态'),
		('D',N'草稿',N'仅自己预览，不公开显示的'),
		('C',N'关闭的',N'无效关闭的'),
		('pvt',N'私有的',N'私有类型，收藏类型'),
		('N',N'便签',N'只在后台显示的'),
		('U',N'未审核的',N'未审核的')";
	try{
		$conn->exec($sql);
		echo '设置状态信息成功......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建文章articles数据表，多个段落集合成长篇文章
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-12
 *
 * @return <p>
 */
function LH_setup_CTarticles(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'articles';
	$sql = 'CREATE TABLE '.$tableName.'(
			a_id int(11) NOT NULL AUTO_INCREMENT,
			a_title varchar(255) NOT NULL,
			a_guid varchar(255) NOT NULL DEFAULT "0",
			a_state_code varchar(10) NOT NULL DEFAULT "P",
			a_c_state_code varchar(10) NOT NULL DEFAULT "C",
			a_type_code varchar(10) NOT NULL DEFAULT "P",
			a_datetime DATETIME NOT NULL DEFAULT NOW(),
			a_first_pic varchar(255) NOT NULL DEFAULT "0",
			PRIMARY KEY (a_id),
			CONSTRAINT aToState FOREIGN KEY(a_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT acToState FOREIGN KEY(a_c_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT aTotype FOREIGN KEY(a_type_code) REFERENCES '.$dataBase['dbprefix'].'types'.'(type_code) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	//创建长篇文章信息
	$sql = "insert into ".$tableName." (a_title,a_state_code,a_c_state_code,a_type_code) values (N'欢迎使用losehubCMS','P','C','P')";
	try{
		$conn->exec($sql);
		echo '长篇文章创建成功......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建标签tags数据表，只有长篇文章才可以有多个标签
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-12
 *
 * @return <p>
 */
function LH_setup_CTtags(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'tags';
	$sql = 'CREATE TABLE '.$tableName.'(
			tag_id int(11) NOT NULL AUTO_INCREMENT,
			tag_name varchar(20) NOT NULL,
			tag_a_id int(11) NOT NULL DEFAULT "0",
			tag_state_code varchar(10) NOT NULL DEFAULT "P",
			PRIMARY KEY (tag_id),
			CONSTRAINT tagToarticle FOREIGN KEY(tag_a_id) REFERENCES '.$dataBase['dbprefix'].'articles'.'(a_id) on delete cascade on update cascade,
			CONSTRAINT tagTostate FOREIGN KEY(tag_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	//创建标签信息
	$sql = "insert into ".$tableName." (tag_name,tag_a_id) values (N'文章',1)";
	try{
		$conn->exec($sql);
		echo '标签创建成功......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建段落paragraphs数据表，段落为CMS发布每条信息的最小节点
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql,$text
 * @package createdb
 * @version 2019-3-11
 *
 * @return <p>
 */
function LH_setup_CTparagraphs(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'paragraphs';
	$sql = 'CREATE TABLE '.$tableName.'(
			id int(11) NOT NULL AUTO_INCREMENT,
			p_contect text NOT NULL,
			p_order int NOT NULL DEFAULT "0",
			p_state_code varchar(10) NOT NULL DEFAULT "P",
			p_c_state_code varchar(10) NOT NULL DEFAULT "C",
			p_type_code varchar(10) NOT NULL DEFAULT "P",
			p_datetime DATETIME NOT NULL DEFAULT NOW(),
			p_a_id int NOT NULL DEFAULT "0",
			p_item_id int NOT NULL DEFAULT "0",
			PRIMARY KEY (id),
			CONSTRAINT pToState FOREIGN KEY(p_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT pcToState FOREIGN KEY(p_c_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT pTotype FOREIGN KEY(p_type_code) REFERENCES '.$dataBase['dbprefix'].'types'.'(type_code) on delete cascade on update cascade,
			CONSTRAINT pToa FOREIGN KEY(p_a_id) REFERENCES '.$dataBase['dbprefix'].'articles'.'(a_id) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 创建内容的状态信息
	$text[1]=('LoseHubCMS系统是RSS阅读器+个人blog的内容管理程序，其中文名称为“遗失的聚合”。');
	$text[2]=('LoseHub基于PHP技术，采用MySQL(或SQLite、PostgreSQL)作为数据库，全部源码开放。该系统满足了那些喜欢用RSS方式阅读者的需求，并提供了评论及分享功能。用户可自行在服务上搭建一个RSS阅读程序，管理者可发布相关言论等信息。');
	for ($i=1; $i <=2 ; $i++) { 
		$sql = "insert into ".$tableName." (p_contect,p_state_code,p_c_state_code,p_type_code,p_a_id,p_order) values 
	(N'".$text[$i]."','P','C','P',1,".$i.")";
		$conn->exec($sql);
	}
	echo '写入段落信息成功......</br>';
}

/**
 * 创建评论comments数据表
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-12
 *
 * @return <p>
 */
function LH_setup_CTcomments(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'comments';
	$sql = 'CREATE TABLE '.$tableName.'(
			c_id int(11) NOT NULL AUTO_INCREMENT,
			c_content varchar(255) NOT NULL,
			c_name varchar(20) NOT NULL,
			c_url varchar(100) NOT NULL DEFAULT "0",
			c_email varchar(100) NOT NULL DEFAULT "0",
			c_state_code varchar(10) NOT NULL DEFAULT "U",
			c_datetime DATETIME NOT NULL DEFAULT NOW(),
			c_a_id int(11) NOT NULL DEFAULT "0",
			c_p_id int(11) NOT NULL DEFAULT "0",
			PRIMARY KEY (c_id),
			CONSTRAINT CToState FOREIGN KEY(C_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	//创建一条留言信息
	$sql = "insert into ".$tableName." (c_name,c_content) values (N'losehubCMS',N'非常感谢您使用losehub，如需帮忙，请查阅:wiki.losehub.com')";
	try{
		$conn->exec($sql);
		echo '留言创建成功......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建RSS源数据表：存储收购RSS源信息，未测试写入
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-12
 *
 * @return <p>
 */
function LH_setup_CTRSS(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'RSS';
	$sql = 'CREATE TABLE '.$tableName.'(
			RSS_id int(11) NOT NULL AUTO_INCREMENT,
			RSS_title varchar(255) NOT NULL,
			RSS_url varchar(255) NOT NULL DEFAULT "0",
			RSS_link varchar(255) NOT NULL DEFAULT "0",
			RSS_ico_link varchar(255) NOT NULL DEFAULT "0",
			RSS_description text NOT NULL,
			RSS_email varchar(100) NOT NULL DEFAULT "0",
			RSS_state_code varchar(10) NOT NULL DEFAULT "P",
			RSS_datetime DATETIME NOT NULL DEFAULT NOW(),
			RSS_category varchar(100) NOT NULL DEFAULT "0",
			PRIMARY KEY (RSS_id),
			CONSTRAINT RSSToState FOREIGN KEY(RSS_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建items数据表：存储收藏、评论过的items，未测试写入
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2019-3-12
 *
 * @return <p>
 */
function LH_setup_CTitems(){
	global $conn,$dataBase;
	$tableName = $dataBase['dbprefix'].'items';
	$sql = 'CREATE TABLE '.$tableName.'(
			item_id int(11) NOT NULL AUTO_INCREMENT,
			item_RSS_id int(11) NOT NULL,
			item_title varchar(255) NOT NULL,
			item_url varchar(255) NOT NULL DEFAULT "0",
			item_description text NOT NULL,
			item_state_code varchar(10) NOT NULL DEFAULT "P",
			item_datetime DATETIME NOT NULL DEFAULT NOW(),
			PRIMARY KEY (item_id),
			CONSTRAINT itemToState FOREIGN KEY(item_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT itemToRSS FOREIGN KEY(item_RSS_id) REFERENCES '.$dataBase['dbprefix'].'RSS'.'(RSS_id)
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建user数据表，并写入管理员相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2017-1-12
 *
 * @return <p>
 */
function LH_setup_CTuser(){
	global $conn,$dataBase,$adminInf;
	$tableName = $dataBase['dbprefix'].'user';
	$sql = 'CREATE TABLE '.$tableName.'(
			ID int NOT NULL AUTO_INCREMENT primary key, 
			user_login varchar(40) NOT NULL,
			user_pass varchar(30) NOT NULL,
			user_name varchar(30) NOT NULL DEFAULT "",
			user_email tinytext NOT NULL DEFAULT "",
			user_tel varchar(11) NOT NULL DEFAULT ""
			)';
	try{
		$conn->exec($sql);
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制登录名不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`user_login`)";
	$conn->exec($sql);
	// 创建管理员信息
	$sql = "insert into ".$tableName." (user_login,user_pass,user_email) values ('".$adminInf['admin']."','".$adminInf['password']."','".$adminInf['email']."')";
	$conn->exec($sql);
	echo '插入管理员信息成功......</br>';
}

LH_setup_CTtypes();
LH_setup_CTstates();
LH_setup_CTarticles();
LH_setup_CTtags();
LH_setup_CTparagraphs();
LH_setup_CTcomments();
LH_setup_CTRSS();
LH_setup_CTitems();
LH_setup_CTuser();
LH_setup_echo();

$GLOBALS['conn'] = null;	
?>