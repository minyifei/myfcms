<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

/**
 * 文章模型
 */
class ArchivesModel extends RelationModel {
	protected $_link = array(
		'Arctype'=>array(
			'mapping_type' =>BELONGS_TO,
			'class_name'=>'Arctype',
			'foreign_key'=>'typeid',
		),
	);
}


?>