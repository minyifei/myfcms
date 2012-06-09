<?php

/**
 * 文件读写类
 */
class File {
	
	/**
	 * 写文件
	 * @filename 文件路径
	 * @content 内容
	 */
	public function write($filename,$content){
		@$fp = fopen($filename, "w");
		if(!$fp){
			return false;
		}else{
			fwrite($fp, $content);
			fclose($fp);
			return true;
		}
	}
	
	/**
	 * 读取文件内容
	 */
	public function read($filename){
		@$fp = fopen($filename, "r");
		if(!$fp){
			return null;
		}else{
			$content = fread($fp, filesize($filename));
			fclose($fp);
			return $content;
		}
	}
	
	/**
	 * 删除文件
	 */
	public function delete($filename){
		$res = @unlink($filename);
		if($res){
			return true;
		}else{
			return false;
		}
	}
}


?>