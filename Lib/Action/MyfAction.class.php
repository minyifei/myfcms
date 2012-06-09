<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

/**
 * 基础Action
 */
class MyfAction extends BaseAction {

	
	/*zidingyi-start*/
	public function zidingyi(){
		$name = $this->getActionName();
		$this->_base($name);
		$this->display();
	}
	/*zidingyi-end*/

	
	/*new method*/
								
	
}


?>