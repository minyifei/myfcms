<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------

class TagLibMyfcms extends TagLib {
	
	/**
	 * 标签
	 */
	protected $tags = array(
		'flink'=>array(
			'attr'=>'limit,key,mod,target,id',
			'level'=>3,
		),
		'channel'=>array(
			'attr'=>'topid,limit,typeid,key,mod,type,id',
			'level'=>3,
		),
		'arclist'=>array(
			'attr'=>'flag,typeid,row,infolen,titlelen,order,limit,noflag,key,mod,urltype,id',
			'level'=>3,
		),
		'list'=>array(
			'attr'=>'pagesize,urltype,id',
			'level'=>3,
			'alias'=>'searchlist',
		),
		'pagelist'=>array(
			'attr'=>'name,pagesize,urltype',
			'level'=>1,
			'close'=>0,
			'alias'=>'searchpagelist',
		),
		'global'=>array(
			'attr'=>'name',
			'level'=>1,
			'close'=>0,
		),		
	);
	
    /**
	 * 友情链接标签
	 */
    public function _flink($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'flink');
        $result = !empty($tag['id']) ? $tag['id'] : 'vo'; //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';
        $sql = "M('flink')->";
        $sql .= ($tag['limit']) ? "limit({$tag['limit']})->" : '';
        $sql .= "select()";
        //下面拼接输出语句
        $parsestr = '<?php $_result=' . $sql . '; if ($_result): $' . $key . '=0;';
        $parsestr .= 'foreach($_result as $key=>$' . $result . '):';
        $parsestr .= '++$' . $key . ';$mod = ($' . $key . ' % ' . $mod . ' );';
		$parsestr .= '$'.$result.'["linkurl"]="$'.$result.'[url]";?>';
        $parsestr .= $content; //解析在article标签中的内容
        $parsestr .= '<?php endforeach; endif;?>';
        return $parsestr;
    }
	
	/**
	 * 栏目标签
	 */
    public function _channel($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'channel');
        $result = !empty($tag['id']) ? $tag['id'] : 'vo'; //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';
		$type = $tag["type"];
        $sql = "M('arctype')->";
		$sql .= "field('body',true)->";
		$topid = $tag["topid"];
		$where = '1=1 ';
		if(isset($topid)){
			$where .= ' and topid='.$topid;
		}
		if(isset($type)){
			$where .= ' and typepro in('.$type.')';
		}
		$sql .= 'where("'.$where.'")->order("sortrank asc")->';
        $sql .= ($tag['limit']) ? "limit({$tag['limit']})->" : '';
        $sql .= "select()";
        //下面拼接输出语句
        $parsestr = '<?php $urltype="'.C("MYFCMS_URLTYPE").'"; $_result=' . $sql . '; if ($_result): $' . $key . '=0;';
        $parsestr .= 'foreach($_result as $key=>$' . $result . '):';
        $parsestr .= '++$' . $key . ';$mod = ($' . $key . ' % ' . $mod . ' );$typepro=$'.$result."[typepro];";
		$parsestr .= 'if($urltype=="static"):';
			$parsestr .= '$'.$result.'["typeurl"]="__APP__/$'.$result.'[classname]/$'.$result.'[typedir]-$'.$result.'[methodname].html";';
		$parsestr .= 'elseif($urltype=="html"):';
			$parsestr .= '$'.$result.'["typeurl"]="__APP__/category/$'.$result.'[typedir]/$arcfix";';
		$parsestr .= 'else:';
			$parsestr .= '$'.$result.'["typeurl"]="__APP__/index.php?m=$'.$result.'[classname]&a=$'.$result.'[methodname]&id=$'.$result.'[id]";';
		$parsestr .='endif;';
		
		$parsestr .='if($typepro==2):';
		$parsestr .= '$'.$result.'["typeurl"]="$'.$result.'[typedir]";';
		$parsestr .='endif;?>';
        $parsestr .= $content; //解析在article标签中的内容
        $parsestr .= '<?php endforeach; endif;?>';
		// dump($parsestr);
        return $parsestr;
    }

	/**
	 * 栏目内容列表标签
	 */
    public function _list($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'list');
        $result = !empty($tag['id']) ? $tag['id'] : 'vo'; //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';
		$pagesize = $tag["pagesize"];
		if(!isset($pagesize)){
			$pagesize = 10;
		}
		$urltype = $tag["urltype"];
        $sql = "M('archives')->";
		$sql .= "field('body',true)->";
		$sql .= 'where("typeid=$selfid")->';
		$sql .= 'order("id desc")->';
		$sql .= 'limit("$start,'.$pagesize.'")->';
        $sql .= "select()";
        //下面拼接输出语句
        $parsestr = '<?php $urltype="'.C("MYFCMS_URLTYPE").'"; $pageCount='.$pagesize.'; $start=($p-1)*'.$pagesize.'; $_result=' . $sql . '; if ($_result): $' . $key . '=0;';
        $parsestr .= 'foreach($_result as $key=>$' . $result . '):';
        $parsestr .= '++$' . $key . ';$mod = ($' . $key . ' % ' . $mod . ' );';
		$parsestr .= 'if($urltype=="static"):';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/$myfcms[typedir]/$myfcms[methodname]-$'.$result.'[id].html";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/$myfcms[classname]/$myfcms[typedir]-$myfcms[methodname].html";';
		$parsestr .= 'elseif($urltype=="html"):';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/archives/$arcfix$'.$result.'[id].html";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/category/$myfcms[typedir]/$arcfix";';
		$parsestr .= 'else:';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/index.php?m=Archives&a=$myfcms[methodname]&id=$'.$result.'[id]";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/index.php?m=$myfcms[classname]&a=$myfcms[methodname]&id=$myfcms[id]";';
		$parsestr .='endif;$arcpic=$'.$result.'[litpic];if(!empty($arcpic)):';
		$parsestr .= '$'.$result.'["litpic"]="__APP__/admin/Uploads/Arctives/$'.$result.'[litpic]";';
		$parsestr .='endif; ?>';
        $parsestr .= $content; //解析在article标签中的内容
        $parsestr .= '<?php endforeach; endif;?>';
		// dump($parsestr);
        return $parsestr;
    }

	/**
	 * 栏目分页控件
	 */
	public function _pagelist($attr,$content){
		 $tag = $this->parseXmlAttr($attr, 'pagelist');
		 $pagesize = $tag["pagesize"];
		 if(!isset($pagesize)){
			$pagesize = 10;
		 }
         //下面拼接输出语句
         $parsestr = '<?php if(C("MYFCMS_URLTYPE")=="html" && $action=="list_html"): $page=$show; echo $page; ';
         $parsestr .= 'else:';
         $parsestr .= 'if(!isset($pageCount))$pageCount='.$pagesize.'; $totalCount=M("archives")->where("typeid=$selfid")->count(); $page = new Page($totalCount,$pageCount);$pageshow = $page->show(); echo $pageshow;';
         $parsestr .= 'endif;?>';
         return $parsestr;
	}
	
	/**
	 * 文章列表标签
	 */
    public function _arclist($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'arclist');
        $result = !empty($tag['id']) ? $tag['id'] : 'vo'; //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';
        $urltype = $tag["urltype"];
        $sql = "D('Archives')->relation(true)->";
		$sql .= "field('body',true)->";
		//查询条件
		$where = '1=1';
		
		
		$typeid = $tag["typeid"];
		$parsestr = '<?php ';
		if(isset($typeid)){
			$parsestr .='$typeids='.$typeid.';';
			$parsestr .= ' $m_arctype = M("arctype");$child = $m_arctype->where("topid='.$typeid.'")->select();';
			$parsestr .= 'if($child):';
			$parsestr .= 'foreach ($child as $kk => $v):';
			$parsestr .= '$typeids .=",".$v[id];';
			$parsestr .= 'endforeach;endif;';
			$where .= ' and typeid in($typeids)';
		}
		$typeids = $tag["typeids"];
		if(isset($typeids)){
			$where .= " and typeid in(".$typeids.")";
		}
		$flag = $tag["flag"];
		if(isset($flag)){
			$flags = explode(",",$flag);
			foreach ($flags as $kkk => $vv) {
				$where .= " and POSITION('".$vv."' in flag)";
			}
		}
		$noflag = $tag["noflag"];
		if(isset($noflag)){
			$flags = explode(",",$noflag);
			foreach ($flags as $kkk => $vv) {
				$where .= " and LOCATE('".$vv."',flag)<1";
			}
		}
		$sql .= 'where("'.$where.'")->';
		$order = $tag["order"];
		if(!isset($order)){
			$order = "id desc";
		}
		$sql .= 'order("'.$order.'")->';
		$limit = $tag["limit"];
		if(!isset($limit)){
			$limit = 10;
		}
		$sql .= 'limit("'.$limit.'")->';
        $sql .= "select()";
        //下面拼接输出语句
        $parsestr .= '$urltype="'.C("MYFCMS_URLTYPE").'"; $_result=' . $sql . '; if ($_result): $' . $key . '=0;';
        $parsestr .= 'foreach($_result as $key=>$' . $result . '):';
        $parsestr .= '++$' . $key . ';$mod = ($' . $key . ' % ' . $mod . ' ); $arctype=$'.$result.'[Arctype];$arcpic=$'.$result.'[litpic];$typedir=$'.$result.'[Arctype][typedir];';
        $parsestr .= 'if($urltype=="static"):';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/$typedir/$arctype[methodname]-$'.$result.'[id].html";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/$arctype[classname]/$typedir-$arctype[methodname].html";';
		$parsestr .= 'elseif($urltype=="html"):';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/archives/$arcfix$'.$result.'[id].html";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/category/$arctype[typedir]/$arcfix";';
		$parsestr .= 'else:';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/index.php?m=$arctype[classname]&a=$arctype[methodname]&id=$'.$result.'[typeid]";';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/index.php?m=Archives&a=$arctype[methodname]&id=$'.$result.'[id]";';
		$parsestr .='endif;if(!empty($arcpic)):';
		$parsestr .= '$'.$result.'["litpic"]="__APP__/admin/Uploads/Arctives/$'.$result.'[litpic]";';
		$parsestr .='endif; ?>';
        $parsestr .= $content; //解析在article标签中的内容
        $parsestr .= '<?php endforeach; endif;?>';
        // dump($parsestr);
        return $parsestr;
    }

	/**
	 * 全局配置参数标签
	 */
	public function _global($attr,$content){
		 $tag = $this->parseXmlAttr($attr, 'global');
		 $result = !empty($tag['id']) ? $tag['id'] : 'vo'; 
		 $name = $tag["name"];
		 if(isset($name)){
		 	$sql = 'M("sys")->';
			$where = "name='".$name."'";
			$sql .= 'where("'.$where.'")->';
			$sql .= 'select()';
			
			$parsestr = '<?php $_result='.$sql.';if($_result) echo $_result[0][value]; ?>';
			return $parsestr;
		 }else{
		 	return "";
		 }
	}
	
	/**
	 * 搜索列表
	 */
	public function _searchlist($attr,$content){
		$tag = $this->parseXmlAttr($attr, 'searchlist');
        $result = !empty($tag['id']) ? $tag['id'] : 'vo'; //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';
		$pagesize = $tag["pagesize"];
		if(!isset($pagesize)){
			$pagesize = 10;
		}
		$urltype = $tag["urltype"];
        $sql = "D('Archives')->relation(true)->";
		$sql .= "field('body',true)->";
		$sql .= 'where("$where")->';
		$sql .= 'order("id desc")->';
		$sql .= 'limit("$start,'.$pagesize.'")->';
        $sql .= "select()";
        //下面拼接输出语句
        $parsestr = '<?php $urltype="'.C("MYFCMS_URLTYPE").'"; $pageCount='.$pagesize.'; $start=($p-1)*'.$pagesize.'; $_result=' . $sql . '; if ($_result): $' . $key . '=0;';
        $parsestr .= 'foreach($_result as $key=>$' . $result . '):';
        $parsestr .= '++$' . $key . ';$mod = ($' . $key . ' % ' . $mod . ' ); $arctype=$'.$result.'[Arctype];$typedir=$'.$result.'[Arctype][typedir];$'.$result.'["title"]=str_replace($keyword,"<span class=\'searchkey\'>$keyword</span>",$'.$result.'["title"]);';
        $parsestr .= 'if($urltype=="static"):';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/$myfcms[typedir]/$myfcms[methodname]-$'.$result.'[id].html";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/$myfcms[classname]/$myfcms[typedir]-$myfcms[methodname].html";';
		$parsestr .= 'elseif($urltype=="html"):';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/archives/$arcfix$'.$result.'[id].html";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/category/$myfcms[typedir]/$arcfix";';
		$parsestr .= 'else:';
		$parsestr .= '$'.$result.'["arcurl"]="__APP__/index.php?m=Archives&a=$myfcms[methodname]&id=$'.$result.'[id]";';
		$parsestr .= '$'.$result.'["typeurl"]="__APP__/index.php?m=$myfcms[classname]&a=$myfcms[methodname]&id=$myfcms[id]";';
		$parsestr .='endif;$arcpic=$'.$result.'[litpic];if(!empty($arcpic)):';
		$parsestr .= '$'.$result.'["litpic"]="__APP__/admin/Uploads/Arctives/$'.$result.'[litpic]";';
		$parsestr .='endif; ?>';
        $parsestr .= $content; //解析在article标签中的内容
        $parsestr .= '<?php endforeach; endif;?>';
		// dump($parsestr);
        return $parsestr;
	}

	/**
	 * 栏目分页控件
	 */
	public function _searchpagelist($attr,$content){
		 $tag = $this->parseXmlAttr($attr, 'pagelist');
		 $pagesize = $tag["pagesize"];
		 if(!isset($pagesize)){
			$pagesize = 10;
		}
         //下面拼接输出语句
         $parsestr = '<?php if(!isset($pageCount))$pageCount='.$pagesize.'; $totalCount=M("archives")->where("$where")->count(); $page = new Page($totalCount,$pageCount);$pageshow = $page->show(); echo $pageshow; ?>';
         return $parsestr;
	}
	
	
}


?>