<?php
    if (!defined('THINK_PATH')) exit();
    $config = require '../config.php';
    $array = array(
        'SHOW_PAGE_TRACE'=>0,    //显示调试信息
        'COOKIE_EXPIRE'=>36000,
        'MYFCMS_VERSION'=>'1.4',//MyfCMS 版本号
    );
    return array_merge($config, $array);
?>