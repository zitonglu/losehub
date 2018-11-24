<?php
/**
 * LoseHub CMS 解析XML获取系统-demo
 * @copyright LoseHub
 * @author 紫铜炉 910109610@QQ.com
 * @version 2018-11-24
 * 
 * @return none
 */

//RSS源地址列表数组
$rssfeed = array("http://rss.sina.com.cn/news/china/focus15.xml","https://www.zhihu.com/rss","http://limiwu.com/feed.php");
//解决PHP显示Warning和Notice等问题
ini_set("display_errors", 0);
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);

//设置编码为UTF-8
header('Content-Type:text/html;charset= UTF-8');     

for ($i = 0; $i < sizeof($rssfeed); $i++) {
	//分解开始
	$buff = "";
	$rss_str = "";
	//打开rss地址，并读取，读取失败则中止
	$fp = fopen($rssfeed[$i], "r") or die("无法打开该网站Feed");
	while (!feof($fp)) {
		$buff .= fgets($fp, 4096);
	}
	//关闭文件打开
	fclose($fp);

	//建立一个 XML 解析器
	$parser = xml_parser_create();
	//xml_parser_set_option -- 为指定 XML 解析进行选项设置
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	//xml_parse_into_struct -- 将 XML 数据解析到数组$values中
	xml_parse_into_struct($parser, $buff, $values, $idx);
	//xml_parser_free -- 释放指定的 XML 解析器
	xml_parser_free($parser);

	foreach ($values as $val) {

		$tag = $val["tag"];
		$type = $val["type"];
		$value = $val["value"];
		//标签统一转为小写
		$tag = strtolower($tag);

		if ($tag == "item" && $type == "open") {
			$is_item = 1;
		} else if ($tag == "item" && $type == "close") {
			//构造输出字符串
$rss_str .= "<a href='" . $link . "' target=_blank>" . $title . "</a><br /><p>".$desc."</p><br />";
			$is_item = 0;
		}
		//仅读取item标签中的内容
		if ($is_item == 1) {
			if ($tag == "title") {$title = $value;}
			if ($tag == "link") {$link = $value;}
			if ($tag == "description") {$desc = $value;}
		}
	}
	//输出结果
	echo $rss_str;
}
?>