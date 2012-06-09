<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


header("Content-Type:text/html; charset=utf-8");
import("ORG.Util.Page");// 导入分页类
/**
 * 文章列表页
 */
class CoverAction extends MyfAction {
	
	public function index(){
		$this->_list();	
		$this->display();
	}
	
}
