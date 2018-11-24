<?php
/**
 * LoseHub CMS 解析XML获取系统-demo
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2018-11-24
 * 
 * @return none
 */

//解决PHP显示Warning和Notice等问题
// ini_set("display_errors", 0);
// error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(E_ALL ^ E_WARNING);

//设置编码为UTF-8
	header("Content-type:text/html; Charset=utf-8");
	$doc = new DOMDocument(); 
	$doc->load( 'http://rss.sina.com.cn/news/china/focus15.xml' );
	$items = $doc->getElementsByTagName( "item" );
	$str = "";
	foreach( $items as $item ) {
		$titles = $item->getElementsByTagName( "title" );
		$title = $titles->item(0)->nodeValue;
		$links = $item->getElementsByTagName( "link" );
		$link = $links->item(0)->nodeValue;
		$pubDates = $item->getElementsByTagName( "pubDate" );
		$pubDate = $pubDates->item(0)->nodeValue;
		$descriptions = $item->getElementsByTagName( "description" );
		$description = $descriptions->item(0)->nodeValue;
		$str .= "<a href='".$link."'>".$title."</a>@".$pubDate."<br />";
		$str .= "<p>".$description."</p>";
	}

	echo $str;
?>