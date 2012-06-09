<?php
//定义项目名称和路径
define('APP_NAME', 'myfcms');
define('APP_PATH', './');
define('APP_DEBUG', TRUE);

// 加载框架入口文件
require( "ThinkPHP/ThinkPHP.php");
/**
 * 截取字符串
 */
function myfsubstr($str, $from, $len)  
{  
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.  
	'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',  
	'$1',$str);  
}
