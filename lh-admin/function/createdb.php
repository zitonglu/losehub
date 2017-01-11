<?php
echo '<p>开始创建数据库表</p>';

function setup_createTable(){
	global $dataBase,$adminInf;
	try {
    	$dsn = 'mysql:host='.$dataBase['dbhost'].';dbname='.$dataBase['dbname'];
    	$conn = new PDO($dsn,$dataBase['dbuser'],$dataBase['dbpass']);
    	echo '<p>链接数据库正常.....</p>';
    } catch (PDOException $e) {
        echo '<p class="text-danger text-center">Error!: ' . $e->getMessage() . '</p>';
        echo '<p class="text-danger text-center">无法链接数据库,请检查填写是否正确</p>';
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 创建user表
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
		echo '<p>创建'.$tableName.'表，正常......</p>';
	}catch(PDOException $e){
		echo '<p class="text-danger">'.$e->getMessage().'</p>';
	}
	// 控制登录名不可重复
	$sql = "ALTER TABLE `".$tableName."` ADD UNIQUE(`user_login`)";
	$conn->exec($sql);
	// 创建管理员信息
	$sql = "insert into ".$tableName." (user_login,user_pass,user_email) values ('".$adminInf['admin']."','".$adminInf['password']."','".$adminInf['email']."')";
	$conn->exec($sql);
	echo '<p>插入管理员信息成功......</p>';

	$conn = null;
}

// 保存数据库登录信息
function SN($value=''){
	# code...
}

setup_createTable();
	
?>