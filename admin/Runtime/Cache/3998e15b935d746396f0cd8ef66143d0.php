<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>add-art</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/ueditor/editor_config.js"></script>
		<script type="text/javascript" src="__APP__/Public/ueditor/editor_all.js"></script>
		<link rel="stylesheet" href="__APP__/Public/ueditor/themes/default/ueditor.css"/>
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnSubmit").click(function(){
					var typeName = $.trim($("#txtTypeName").val());
					if(typeName == ""){
						alert("栏目名称为必填字段");
						return false;
					}
				})
			})
		</script>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Arctype&a=main">栏目管理</a><span class="split">&gt;</span>修改栏目
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Arctype&a=update_handler" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140" class="red">&nbsp;栏目名称：</td>
						            <td width="408">
						            	<input type="hidden" value="<?php echo ($arctype["id"]); ?>" name="id" />
						            	<input name="typename" type="text" id="txtTypeName" value="<?php echo ($arctype["typename"]); ?>" style="width:208px">
						            	<input type="hidden" name="topid" id="txtTopId" value="<?php echo ($arctype["topid"]); ?>" />
						            	<input type="hidden" name="typepro" value="<?php echo ($arctype["typepro"]); ?>" />
						            </td>
						            <td width="262"></td>
						          </tr>
						        </tbody>
						        </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody><tr>
						            <td width="140">&nbsp;排列顺序：</td>
						            <td width="408">
						            	<input name="sortrank" type="text" id="txtSortRank" style="width:50px" value="<?php echo ($arctype["sortrank"]); ?>">
						            </td>
						            <td width="262"></td>
						          </tr>
						       </tbody>
						       </table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						          <tbody><tr>
						            <td width="140">&nbsp;文件保存目录：</td>
						            <td width="408">
						            	<input name="typedir" id="txtTypeDir" style="width: 268px;" value="<?php echo ($arctype["typedir"]); ?>" type="text">
						            	不填默认按拼音命名
						             </td>
						            <td width="262"></td>
						          </tr>
						        </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline2">
								高级选项
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;SEO标题：</td>
						          <td width="408"><input type="text" name="seotitle" class="txt" id="txtSeoTitle" value="<?php echo ($arctype["seotitle"]); ?>" style="width:328px"/></td>
						          <td width="262">&nbsp;</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;关键字：</td>
						          <td width="408"><input type="text" name="keywords" value="<?php echo ($arctype["keywords"]); ?>" class="txt" id="txtKeywords" style="width:328px"/></td>
						          <td width="262">&nbsp;</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;栏目描述：</td>
						          <td width="408"><textarea name="description" rows="5" id="txtDescription" style="width: 328px; height: 50px;"><?php echo ($arctype["description"]); ?></textarea></td>
						          <td width="262">&nbsp;</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<?php if(($arctype["typepro"]) == "3"): ?><tr id="tdSigleTitle">
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline2">
								&nbsp;单页栏目内容
							</td>
						</tr>
						<tr id="tdSigleContent">
							<td>
								<textarea id="myEditor"></textarea>
								<script type="text/javascript">
								    var editor = new baidu.editor.ui.Editor();
								    editor.render("myEditor");
								    editor.setContent("<?php echo ($arctype["body"]); ?>");
								</script>
							</td>
						</tr><?php endif; ?>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="btnSubmit" class="btn" value="保存" />
								<input type="reset" id="btnReset" class="btn" value="重置" />
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</body>
</html>