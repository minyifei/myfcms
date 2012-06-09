<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加友情链接</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnSubmit").click(function(){
					var url = $.trim($("#txtUrl").val());
					if(url == ""){
						alert("网址不能为空！");
						return false;
					}
					var name = $.trim($("#txtWebname").val());
					if(name == ""){
						alert("网站名称不能为空！");
						return false;
					}
					
				})
				
				var btnOffset = $("#txtUploadPic").offset();
				$(".uploadpic").css("left",btnOffset.left).css("top",btnOffset.top-1).css("opacity", 0);
				$("#file").hover(function(){
					$("#txtUploadPic").focus();
				},function(){
					$("#txtUploadPic").blur();
				})
				
				
            	
			})
			
			function callback(msg){   
				var tmp = window.location.pathname,
        		URL = window.UEDITOR_HOME_URL||tmp.substr(0,tmp.lastIndexOf("\/")+1);
			    $("#txtLogo").val(URL+"Uploads/Flinks/"+msg);   
			}  
		</script>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Flink&a=main">友情链接管理</a><span class="split">&gt;</span>添加链接
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Flink&a=add_handler" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140" class="red">&nbsp;网址：</td>
						            <td width="408">
						            	<input name="url" type="text" id="txtUrl" value="" style="width:328px">
						            </td>
						            <td width="262">如：http://www.minyifei.cn</td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140" class="red">&nbsp;网站名称：</td>
						            <td width="408">
						            	<input name="webname" type="text" id="txtWebname" value="" style="width:328px">
						            </td>
						            <td width="262">如：飞跃</td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody><tr>
						            <td width="140">&nbsp;排列位置：</td>
						            <td width="408">
						            	<input name="sortrank" type="text" id="txtSortRank" style="width:50px" value="50">
						            </td>
						            <td width="262">从小到大排序</td>
						          </tr>
						       </tbody>
						       </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody><tr>
						            <td width="140"> &nbsp;缩 略 图：</td>
						            <td width="530">
						            	<table width="100%" border="0" cellspacing="1" cellpadding="1">
						                <tbody><tr>
						                  <td height="30">
						                  <input name="logo" type="text" id="txtLogo" style="width:328px">
						                  <input type="button" value="本地上传" id="txtUploadPic" onclick="return false;" style="width:70px;">
						                  <input type="checkbox" class="np" name="ddisremote" value="1" id="ddisremote">远程
						                  </td>
						                </tr>
						              </tbody></table>
						             </td>
						            <td width="150" align="center">
						            <div id="divpicview" class="divpre"></div>
						            </td>
						          </tr>
						        </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;网站描述：</td>
						          <td width="408"><textarea name="description" rows="5" id="txtDescription" style="width: 328px; height: 50px;"></textarea></td>
						          <td width="262">&nbsp;最多255个字符</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="btnSubmit" class="btn" value="保存" />
								<input type="reset" id="btnReset" class="btn" value="重置" />
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				<div class="uploadpic">
					<form id="uploadPicForm" action="__APP__/index.php?m=Flink&a=uploadpic" name="uploadPicForm" encType="multipart/form-data" method="post" target="hidden_frame" >
						 <input type="file" id="file" name="file" title="本地上传" onchange="uploadPicForm.submit()">   
						 <iframe name='hidden_frame' id="hidden_frame" style="display: none"></iframe> 
					</form>
				</div>
			</div>
		</div>
		
	</body>
</html>