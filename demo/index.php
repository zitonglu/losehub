<?php

$_SERVER['PHP_AUTH_USER'] = null;

if (isset($_SERVER['PHP_AUTH_USER'])){
	echo $_SERVER['PHP_AUTH_USER'];
}else{
	echo 'PHP_AUTH_USER为空';
}

?>