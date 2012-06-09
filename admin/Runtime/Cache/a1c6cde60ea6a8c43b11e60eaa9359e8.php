<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>更新文章属性</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="__APP__/Public/js/jquery.colorselect.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
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
				})
			})
			
		</script>
	</head>
	<body>
		<div class="main">
			<div class="center">
				<form action="__APP__/index.php?m=Archives&a=update_pro_handler" method="post" target="main">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="560" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="90">&nbsp;文章标题：</td>
						            <td width="408"><input type="hidden" id="hiddenId" name="id"  value="<?php echo ($arc["id"]); ?>"/>
						            	<input name="title" type="text" value="<?php echo ($arc["title"]); ?>" id="txtTitle" value="" style="width:388px"></td>
						            <td width="60">&nbsp;</td>
						            <td align="left">
						            </td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="560" border="0" cellspacing="0" cellpadding="0">
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
								<table width="560" border="0" cellspacing="0" cellpadding="0">
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
								<table border="0" cellpadding="0" cellspacing="0" width="560">
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
								<table border="0" cellpadding="0" cellspacing="0" width="560">
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
								<table border="0" cellpadding="0" cellspacing="0" width="560">
						        <tbody><tr>
						          <td width="90">&nbsp;内容摘要：</td>
						          <td width="449"><textarea name="description" rows="5" id="txtDescription" style="width: 80%; height: 50px;"><?php echo ($arc["description"]); ?></textarea></td>
						          <td width="10">&nbsp;</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="txtSubmit" class="btn" value="保存" />
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</body>
</html>