<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加模板</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#txtSubmit").click(function(){
					var title = $("#txtFilename").val();
					if(title==""){
						alert("文件名不能为空！");
						return false;
					}
				})
			})
			
			function insertTab(o, e)
			{
			    var kC = e.keyCode ? e.keyCode : e.charCode ? e.charCode : e.which;
			    if (kC == 9 && !e.shiftKey && !e.ctrlKey && !e.altKey)
			    {
			        var oS = o.scrollTop;
			        if (o.setSelectionRange)
			        {
			            var sS = o.selectionStart;
			            var sE = o.selectionEnd;
			            o.value = o.value.substring(0, sS) + "\t" + o.value.substr(sE);
			            o.setSelectionRange(sS + 1, sS + 1);
			            o.focus();
			        }
			        else if (o.createTextRange)
			        {
			            document.selection.createRange().text = "\t";
			            e.returnValue = false;
			        }
			        o.scrollTop = oS;
			        if (e.preventDefault)
			        {
			            e.preventDefault();
			        }
			        return false;
			    }
			    return true;
			}
		</script>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Moban&a=main&theme=<?php echo ($theme); ?>"><?php echo ($name); ?></a><span class="split">&gt;</span>添加模板
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Moban&a=add_handler" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="90">&nbsp;文件名：</td>
						            <td width="208">
						            	<input name="filename" type="text" id="txtFilename" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" value="" style="width:148px">
						            	<input type="hidden" name="theme" value="<?php echo ($theme); ?>" />
						            	<input name="pathname" type="hidden" id="txtPathname" value="Public" style="width:188px">
						            	.html
						            </td>
						            <td align="left">
						            	（必须英文小写自己开头，不需要带.html）
						            </td>						            
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
						            <td width="90">&nbsp;描述：</td>
						            <td width="208"><input name="info" type="text" id="txtInfo" value="" style="width:188px"></td>
						            <td align="left">
						            	文件描述！
						            </td>						            
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline2">
								&nbsp;模板内容
							</td>
						</tr>
						<tr>
							<td>
								<textarea onkeydown="return insertTab(this, event);" id="myEditor" name="content" style="width:100%;height:430px;"></textarea>
							</td>
						</tr>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="txtSubmit" class="btn" value="保存" />
								<input type="reset" class="btn" value="重置" />
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				<div class="uploadpic">
					<form id="uploadPicForm" action="__APP__/index.php?m=Archives&a=uploadpic" name="uploadPicForm" encType="multipart/form-data" method="post" target="hidden_frame" >
						 <input type="file" id="file" name="file" title="本地上传" onchange="uploadPicForm.submit()">   
						 <iframe name='hidden_frame' id="hidden_frame" style='display:none'></iframe> 
					</form>
				</div>
			</div>
		</div>
	</body>
</html>