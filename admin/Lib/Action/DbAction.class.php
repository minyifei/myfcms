<?php
// +----------------------------------------------------------------------
// | MyfCMS 闵益飞内容管理系统 [ 中国首家完全免费开源的PHPCMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.minyifei.cn All rights reserved.
// +----------------------------------------------------------------------
// | 交流论坛：http://bbs.minyifei.cn
// +----------------------------------------------------------------------


/**
 * 数据库备份还原
 */
import("@.Utils.File");
class DbAction extends MyfAction {
	
	public function index(){
		$this->display();
	}

	public function backdb(){
		header('Content-type:text/html; charset=utf-8');
		header("Content-type: application/octet-stream");
		header("Content-Disposition:attachment; filename=myfcmsbak-".date( 'Y-m-d-H-i ').".sql");
		
		$table=$this->getTable();
		$struct=$this->bakStruct($table);
		$record=$this->bakRecord($table);
		echo $struct;
		echo "-- myfcms struct over\r\n";
		echo $record;
		
	}
	
	public function revert(){
		$dir =dirname(__FILE__);
		$filename = $dir."/myfcmsbak.sql";
		dump($filename);
		$file = new File();
		$content = $file->read($filename);
		
		$sqlArr = explode('-- myfcms struct over', $content);
		$sql1 = explode(";",$sqlArr[0]);
		$sqlArr[1] = str_replace(");", ")###myfcms###", $sqlArr[1]);
		$sql2 = explode("###myfcms###", $sqlArr[1]);
		$sqls = array_merge($sql1,$sql2);
		
		$m = M();
		foreach ($sqls as $key => $value) {
			 $num = $m->execute($value);			
		}
		echo "数据库成功还原！";
	}
	
	/**
	*返回数据库中的数据表
	*/
	protected function getTable(){
		$dbName=C('DB_NAME');
		$result=M()->query('show tables from '.$dbName);
		foreach ($result as $v){
		    $tbArray[]=$v['Tables_in_'.C('DB_NAME')];
		}
		return $tbArray;
	}
	
	/**
	*备份数据表结构
	*/
	protected function bakStruct($array){
		
		foreach ($array as $v){
		
			$tbName=$v;
			
			$result=M()->query('show columns from '.$tbName);

			// $sql.="--\r\n";
			// $sql.="-- 数据表结构: `$tbName`\r\n";
			// $sql.="--\r\n\r\n";
			
			$sql.="DROP TABLE IF EXISTS `$tbName`;\r\n";
			
			$sql.="create table `$tbName` (\r\n";

			$rsCount=count($result);
			
			foreach ($result as $k=>$v){
			
			        $field  =       $v['Field'];
			        $type   =       $v['Type'];
			        $default=       $v['Default'];
			        $extra  =       $v['Extra'];
			        $null   =       $v['Null'];

					if(!($default=='')){
						$default='default '.$default;
					}
			        
			        if($null=='NO'){
			            $null='not null';
			        }else{
			            $null="null";
			        }			        
			        
			        if($v['Key']=='PRI'){
			                $key    =       'primary key';
			        }else{
			                $key    =       '';
			        }
					if($k<($rsCount-1)){
						$sql.="`$field` $type $null $default $key $extra ,\r\n";
					}else{
						//最后一条不需要","号
						$sql.="`$field` $type $null $default $key $extra \r\n";
					}


			}
			$sql.=")engine=MyISAM charset=utf8;\r\n\r\n";
		}
		return str_replace(',)',')',$sql);
	}
	/**
	*备份数据表数据
	*/
	protected function bakRecord($array){
	
	    foreach ($array as $v){
		
			$tbName=$v;
						
		    $rs=M()->query('select * from '.$tbName);
		    
		    if(count($rs)<=0){
	    	    continue;
	    	}

			// $sql.="--\r\n";
			// $sql.="-- 数据表中的数据: `$tbName`\r\n";
			// $sql.="--\r\n\r\n";

	    	foreach ($rs as $k=>$v){

	    	    $sql.="INSERT INTO `$tbName` VALUES (";
		    	foreach ($v as $key=>$value){
		    	    if($value==''){
		    	        $value='null';
		    	    }
		    	    $type=gettype($value);
		    	    if($type=='string'){
		    	        $value="'".addslashes($value)."'";
		    	    }
		    	    $sql.="$value," ;
		    	}
		    	$sql.=");\r\n\r\n";
	        }
		}
		return str_replace(',)',')',$sql);
	}
	
}

?>