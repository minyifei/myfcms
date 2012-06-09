<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>更新文章</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/ueditor/editor_config.js"></script>
		<script type="text/javascript" src="__APP__/Public/ueditor/editor_all.js"></script>
		<link rel="stylesheet" href="__APP__/Public/ueditor/themes/default/ueditor.css"/>
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="__APP__/Public/js/jquery.colorselect.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#txtColor").colorSelect({title:"#txtTitle"});
				var btnOffset = $("#txtUploadPic").offset();
				$(".uploadpic").css("left",btnOffset.left-4).css("top",btnOffset.top-1).css("opacity", 0);
				$("#file").hover(function(){
					$("#txtUploadPic").focus();
				},function(){
					$("#txtUploadPic").blur();
				})
				
				$("#txtSubmit").click(function(){
					var title = $("#txtTitle").val();
					var typeid = $("#typeid").val();
					if(title==""){
						alert("文章标题不能为空！");
						return false;
					}
					if(typeid==0){
						alert("请选择栏目！");
						return false;
					}
					if($("#ddisremote").attr("checked")=="checked"){
						var picname = $("#txtPicName").val();
						if(picname.indexOf("http")<0){
							alert("远程缩略图请填写网址！");
							return false;
						}
					}
				})
			})
			function callback(msg)   
			{   
			  $("#txtPicName").val(msg);   
			}   
		</script>
	</head>
	<body>
		<div class="html_colorpane"> 
		    <h5> 
		        <span>清除颜色</span> 
		        <em title="关闭"></em> 
		    </h5> 
		    <table></table> 
		</div> 
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Archives&a=main">文章管理</a><span class="split">&gt;</span>更新文章
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Archives&a=update_handler" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="90">&nbsp;文章标题：</td>
						            <td width="408"><input type="hidden" name="id"  value="<?php echo ($arc["id"]); ?>"/>
						            	<input name="title" type="text" value="<?php echo ($arc["title"]); ?>" id="txtTitle" value="" style="width:388px"></td>
						            <td width="60">&nbsp;标题颜色</td>
						            <td align="left">
						            	<input name="color" class="html_color" value="<?php echo ($arc["color"]); ?>" type="text" id="txtColor">
						            </td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
					          <tbody><tr>
					            <td width="90">&nbsp;自定义属性：</td>
					            <td align="left">
					            	<input class="np" type="checkbox" name="flags[]" id="flagsh" value="h" <?php if(!empty($h)): ?>checked="checked"<?php endif; ?> />头条[h]
					            	<input class="np" type="checkbox" name="flags[]" id="flagsc" value="c" <?php if(!empty($c)): ?>checked="checked"<?php endif; ?> />推荐[c]
					            	<input class="np" type="checkbox" name="flags[]" id="flagsf" value="f" <?php if(!empty($f)): ?>checked="checked"<?php endif; ?>>幻灯[f]
					            	<input class="np" type="checkbox" name="flags[]" id="flagsa" value="a" <?php if(!empty($a)): ?>checked="checked"<?php endif; ?>>特荐[a]
					            	<input class="np" type="checkbox" name="flags[]" id="flagss" value="s" <?php if(!empty($s)): ?>checked="checked"<?php endif; ?>>滚动[s]
					            	<input class="np" type="checkbox" name="flags[]" id="flagsb" value="b" <?php if(!empty($b)): ?>checked="checked"<?php endif; ?>>加粗[b]
					            	<input class="np" type="checkbox" name="flags[]" id="flagsp" value="p" <?php if(!empty($p)): ?>checked="checked"<?php endif; ?>>图片[p]
					          </tr>
					        </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody><tr>
						            <td width="90">&nbsp;关键字：</td>
						            <td>
						            	<input name="keywords" type="text" value="<?php echo ($arc["keywords"]); ?>" id="txtKeywords" style="width:300px" value="">
						            	手动填写用","分开
						            </td>
						          </tr>
						       </tbody>
						       </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody><tr>
						            <td width="90"> &nbsp;缩 略 图：</td>
						            <td width="560">
						            	<table width="100%" border="0" cellspacing="1" cellpadding="1">
						                <tbody><tr>
						                  <td height="30">
						                  <input name="picname" type="text" value="<?php echo ($arc["litpic"]); ?>" id="txtPicName" style="width:340px">
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
						            <td width="90">&nbsp;文章来源：</td>
						            <td width="240">
						            	<input name="source" id="txtSource" style="width: 160px;" value="<?php echo ($arc["source"]); ?>" size="16" type="text">
						            <td width="90">作　者：</td>
						            <td>
						            	<input name="writer" id="txtWriter" style="width: 120px;" value="<?php echo ($arc["writer"]); ?>" type="text">
						            </td>
						          </tr>
						        </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="90">&nbsp;文章栏目：</td>
						          <td>
						       <span id="typeidct">
						       <select name="typeid" id="typeid" style="width: 240px;">
						<option value="0">请选择栏目...</option>
						<?php if(is_array($arttypes)): $i = 0; $__LIST__ = $arttypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($arc["typeid"]) == $vo["id"]): ?>selected='selected'<?php endif; ?> ><?php echo ($vo["typename"]); ?></option>
							<?php if(is_array($vo["childs"])): $i = 0; $__LIST__ = $vo["childs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><option value="<?php echo ($child["id"]); ?>"  <?php if(($arc["typeid"]) == $child["id"]): ?>selected='selected'<?php endif; ?>>—<?php echo ($child["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

						</select></span>
									  </td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="90">&nbsp;内容摘要：</td>
						          <td width="449"><textarea name="description" rows="5" id="txtDescription" style="width: 80%; height: 50px;"><?php echo ($arc["description"]); ?></textarea></td>
						          <td width="261">&nbsp;</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						        <tbody><tr>
						          <td width="90">&nbsp;发布时间：</td>
						          <td width="241">
						          	<input name="sendtime" value="<?php echo ($arc["sendtime"]); ?>" type="text" id="txtSendtime" style="width:120px">	                                  
										    </td>
						          <td width="90">浏览次数：</td>
						          <td width="379">
						          	<input type="text" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" name="click" value="<?php echo ($arc["click"]); ?>" style="width:100px;"> </td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline2">
								&nbsp;文章内容
							</td>
						</tr>
						<tr>
							<td>
								<textarea id="myEditor"></textarea>
								<script type="text/javascript">
								    var editor = new baidu.editor.ui.Editor();
								    editor.render("myEditor");
								    editor.setContent("<?php echo ($arc["body"]); ?>");
								</script>
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