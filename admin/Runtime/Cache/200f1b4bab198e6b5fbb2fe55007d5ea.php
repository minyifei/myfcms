<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>数据库备份还原</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnBak").click(function(){
					$("#formCollect").attr("action","__APP__/index.php?m=Db&a=backdb");
					$("#formCollect").submit();
				})
				
				$("#btnRevert").click(function(){
					$("#formCollect").attr("action","__APP__/index.php?m=Db&a=revert");
					$("#formCollect").submit();
				})
				
			})
		</script>
		<style type="text/css">
			.tab li{
				width:100px;
				height:25px;
				float:left;
			}
			.tab li a{
				font-weight:normal;
				color:#000000;
				text-decoration:underline;
			}
			.tab li.on a{
				color:#008000;
				font-weight:bold;
				text-decoration: none;
			}
		</style>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Sys&a=main">系统维护</a><span class="split">&gt;</span>数据库备份还原
				</div>
			</div>
				<form id="formCollect" action="__APP__/index.php?m=Db&a=backdb" method="post" target="result_frame">
				<div class="center">
					<div id="divList">
						<table width="100%">
							<tbody>
								<tr>
									<td class="bline3">
										&nbsp;数据库备份后，会以sql文件形式下载到本机.
									</td>
								</tr>
								<tr>
									<td height="28" bgcolor="#F9FCEF" class="bline3"  style="padding-left:10px">
										<input type="submit" id="btnBak" class="btn" style="width:150px;" value="数据库备份" />
									</td>
								</tr>
								<tr>
									<td class="bline3" >
										数据库还原时，请注意需要把备份文件命名为：<span style="color:red;font-weight: bold">myfcmsbak.sql</span>，放在<span style="color:red;font-weight: bold">admin\Lib\Action</span> 目录下 
									</td>
								</tr>
								<tr>
									<td height="28"  bgcolor="#F9FCEF" class="bline3"  style="padding-left:10px">
										<input type="submit" id="btnRevert" class="btn" style="width:150px;" value="数据库还原" />
									</td>
								</tr>
								<tr>
									<td height="28" bgcolor="#F9FCEF"  class="bline3" style="padding-left:0px">
										&nbsp;结果显示区域
									</td>
								</tr>
								
								<tr>
									<td>
										<iframe name="result_frame" id="resultIframe" border="0" style="border:0" scrolling="yes" height="200" width="100%">
										</iframe>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		
	</body>
</html>