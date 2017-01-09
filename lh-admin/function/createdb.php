<?php
echo '<p>开始创建数据库表</p>';

function setup_createUserTable(){
	global $dataBase;
	$conn = mysql_connect($dataBase['dbhost'], $dataBase['dbuser'], $dataBase['dbpass']);
	if(!$conn){
        echo '<p class="text-danger">无法链接数据库,请检查填写是否正确</p>'.mysql_error();
    }else{
    	echo '<p>链接数据库正常.....</p>';
    }

	mysql_select_db($dataBase['dbname'], $conn);
	$tableName = $dataBase['dbprefix'].'user';
	$sql = 'CREATE TABLE '.$tableName.'(
			personID int NOT NULL AUTO_INCREMENT, 
			PRIMARY KEY(personID),
			FirstName varchar(15),
			LastName varchar(15),
			Age int)';
	mysql_query($sql,$conn);
	echo '<p>创建'.$tableName.'表，正常.....</p>';
}

setup_createUserTable();

?>