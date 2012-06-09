<?php
    if (!defined('THINK_PATH')) exit();
    $config = require 'config.php';
    $array = array(
        'SHOW_PAGE_TRACE'=>0,    //显示调试信息
        'COOKIE_EXPIRE'=>36000,
        'APP_AUTOLOAD_PATH'=>'@.TagLib',
        'TMPL_SWITCH_ON' => true, // 启用多模版支持
        'TMPL_DETECT_THEME' => true, // 自动侦测模板主题
        'DEFAULT_THEME' => 'default',//默认模版
        'TAG_NESTED_LEVEL' =>5,
        'MYFCMS_URLTYPE'=>'html', //static-全站伪静态，normal-非静态化，html-全站静态化
        'TMPL_PARSE_STRING'=>array(
			'__MYFCMS__'=> __APP__,// 站点公共目录
			'__MYFCMSPUBLIC__'=> __APP__."/Public",// 站点公共目录
		),
		'MYFCMS_THEMES'=>array("default"),//配送默认使用那几个模版，可用参数:default,3g,touch
		'AUTO_THEME'=>true,
    );
    return array_merge($config, $array);
?>