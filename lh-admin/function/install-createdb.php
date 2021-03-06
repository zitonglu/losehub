<?php
/**
 * LoseHub CMS 安装程序:setup - createdb
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @global $conn
 * @version 2017-1-13
 * 
 * @return databaseTable and content
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			type_code varchar(10) NOT NULL, 
			type_name varchar(20) NOT NULL DEFAULT "",
			type_describe varchar(100) NOT NULL DEFAULT "",
			PRIMARY KEY (type_code)
			)DEFAULT CHARSET=utf8';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制type类型名称不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`type_code`)";
	$conn->exec($sql);
	// 创建内容类别信息
	$sql = "insert ignore into ".$tableName." (type_code,type_name,type_describe) values ('P','段落','简短文字、留言等'),
		('A','文章','长篇幅的文章'),
		('pic','图片','图片类型'),
		('V','视频','视频类型'),
		('pre','引用','引用文章,电脑源代码等'),
		('U','未知','未标明属性的东西')";
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			state_code varchar(10) NOT NULL, 
			state_name varchar(20) NOT NULL,
			state_describe varchar(100) NOT NULL DEFAULT "0",
			PRIMARY KEY (state_code)
			)DEFAULT CHARSET=utf8';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制state类型名称不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`state_code`)";
	$conn->exec($sql);
	// 创建内容的状态信息
	$sql = "insert ignore into ".$tableName." (state_code,state_name,state_describe) values ('P','公开的','文章正常显示状态'),
		('D','草稿','仅自己预览，不公开显示的'),
		('C','关闭的','无效关闭的'),
		('pvt','私有的','私有类型，收藏类型'),
		('N','便签','只在后台显示的'),
		('U','未审核','未审核的类型')";
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
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
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	//创建长篇文章信息
	$sql = "insert ignore into ".$tableName." (a_title,a_state_code,a_c_state_code,a_type_code,a_id) values ('欢迎使用losehubCMS','P','C','P',1)";
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			tag_id int(11) NOT NULL AUTO_INCREMENT,
			tag_name varchar(20) NOT NULL,
			tag_a_id int(11) NOT NULL DEFAULT "1",
			PRIMARY KEY (tag_id),
			CONSTRAINT tagToarticle FOREIGN KEY(tag_a_id) REFERENCES '.$dataBase['dbprefix'].'articles'.'(a_id) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	//创建标签信息
	$sql = "insert ignore into ".$tableName." (tag_name,tag_a_id,tag_id) values ('文章',1,1)";
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			id int(11) NOT NULL AUTO_INCREMENT,
			p_contect text NOT NULL,
			p_order int NOT NULL DEFAULT "0",
			p_state_code varchar(10) NOT NULL DEFAULT "P",
			p_c_state_code varchar(10) NOT NULL DEFAULT "C",
			p_type_code varchar(10) NOT NULL DEFAULT "P",
			p_datetime DATETIME NOT NULL DEFAULT NOW(),
			p_a_id int NOT NULL DEFAULT "1",
			p_item_id int NOT NULL DEFAULT "0",
			PRIMARY KEY (id),
			CONSTRAINT pToState FOREIGN KEY(p_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT pcToState FOREIGN KEY(p_c_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade,
			CONSTRAINT pTotype FOREIGN KEY(p_type_code) REFERENCES '.$dataBase['dbprefix'].'types'.'(type_code) on delete cascade on update cascade,
			CONSTRAINT pToa FOREIGN KEY(p_a_id) REFERENCES '.$dataBase['dbprefix'].'articles'.'(a_id) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 创建内容的状态信息
	$text[1]=('LoseHubCMS系统是RSS阅读器+个人blog的内容管理程序，其中文名称为“遗失的聚合”。');
	$text[2]=('LoseHub基于PHP技术，采用MySQL(或SQLite、PostgreSQL)作为数据库，全部源码开放。该系统满足了那些喜欢用RSS方式阅读者的需求，并提供了评论及分享功能。用户可自行在服务上搭建一个RSS阅读程序，管理者可发布相关言论等信息。');
	for ($i=1; $i <=2 ; $i++) { 
		$sql = "insert ignore into ".$tableName." (p_contect,p_state_code,p_c_state_code,p_type_code,p_a_id,p_order,id) values 
	('".$text[$i]."','P','C','P',1,".$i.",".$i.")";
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
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
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	//创建一条留言信息
	$sql = "insert ignore into ".$tableName." (c_name,c_content,c_id) values ('losehubCMS','非常感谢您使用losehub，如需帮忙，请查阅:wiki.losehub.com',1)";
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			RSS_id int(11) NOT NULL AUTO_INCREMENT,
			RSS_title varchar(255) NOT NULL,
			RSS_url varchar(255) NOT NULL DEFAULT "0",
			RSS_link varchar(255) NOT NULL DEFAULT "0",
			RSS_ico_link varchar(255) NOT NULL DEFAULT "0",
			RSS_description text NOT NULL,
			RSS_email varchar(100) NOT NULL DEFAULT "0",
			RSS_state_code varchar(10) NOT NULL DEFAULT "P",
			RSS_datetime DATETIME NOT NULL DEFAULT NOW(),
			PRIMARY KEY (RSS_id),
			CONSTRAINT RSSToState FOREIGN KEY(RSS_state_code) REFERENCES '.$dataBase['dbprefix'].'states'.'(state_code) on delete cascade on update cascade
			)DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
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
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
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
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......</br>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
}

/**
 * 创建SSH数据表，写入管理员相关信息
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql
 * @package createdb
 * @version 2017-1-12
 *
 * @return <p>
 */
function LH_setup_CTSSH(){
	global $conn,$dataBase,$adminInf;
	$tableName = $dataBase['dbprefix'].'SSH';
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			SSH_id int NOT NULL AUTO_INCREMENT primary key, 
			SSH_name varchar(40) NOT NULL DEFAULT "",
			SSH_login varchar(40) NOT NULL,
			SSH_password char(40) NOT NULL,
			SSH_tips varchar(100) NOT NULL DEFAULT "",
			SSH_date DATE NOT NULL DEFAULT "2030-12-31",
			SSH_email varchar(100) NOT NULL DEFAULT "",
			SSH_telephone varchar(11) NOT NULL DEFAULT ""
			)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制登录名不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`SSH_login`)";
	$conn->exec($sql);
	// 创建管理员信息
	$sql = "insert ignore into ".$tableName." (SSH_login,SSH_password,SSH_email,SSH_name,SSH_id) values ('".$adminInf['admin']."',SHA('".$adminInf['password']."'),'".$adminInf['email']."','网站管理员',1)";
	$conn->exec($sql);
	echo '插入管理员信息成功......</br>';
}

/**
 * 创建options选项数据表：自动加载变量
 * @author 紫铜炉 910109610@QQ.com
 * @var $tableName,$sql,$options
 * @package createdb
 * @version 2019-3-12
 *
 * @return <p>
 */
function LH_setup_CToptions(){
	global $conn,$dataBase,$adminInf;
	$tableName = $dataBase['dbprefix'].'options';
	$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(
			option_code varchar(30) NOT NULL,
			option_value varchar(255) NOT NULL,
			option_autoload char(1) NOT NULL DEFAULT "Y",
			PRIMARY KEY (option_code)
		)ENGINE=MyISAM DEFAULT CHARSET=utf8';
	try{
		$conn->exec($sql);
		$conn->query('set names utf8');
		echo '创建'.$tableName.'表，正常......';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制变量名称不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`option_code`)";
	$conn->exec($sql);
	// 插入站点名称和管理员邮箱信息
	$options['site_name'] = $adminInf['title'];
	$options['author_email'] = $adminInf['email'];
	$options['author_photo'] = dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/lh-admin/images/author.png';
	$options['site_url'] = dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);
	$options['wwwroot'] = 'http://'.$_SERVER['HTTP_HOST'];
	$options['row_number'] = '10';
	foreach ($options as $key => $value) {
		$sql = "insert ignore into ".$tableName." (option_code,option_value) values ('".$key."','".$value."')";
		$conn->exec($sql);
	}
	echo '插入相关配置信息.....</br>';
}

LH_setup_CTtypes();
LH_setup_CTstates();
LH_setup_CTarticles();
LH_setup_CTtags();
LH_setup_CTparagraphs();
LH_setup_CTcomments();
LH_setup_CTRSS();
LH_setup_CTitems();
LH_setup_CTSSH();
LH_setup_CToptions();
LH_setup_echo();

$GLOBALS['conn'] = null;	
?>