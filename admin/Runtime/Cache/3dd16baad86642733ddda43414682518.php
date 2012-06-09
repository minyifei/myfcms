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
				
				$(".typepro").click(function(){
					var isSigleCheck = false;
					$(".typepro").each(function(){
						 var rad = $(this);
						 if(rad.attr("checked")=="checked" && rad.val()==3){
						 	isSigleCheck = true;
						 }
					})
					if(isSigleCheck){
						$("#tdSigleTitle").show();
						$("#tdSigleContent").show();
					}else{
						$("#tdSigleTitle").hide();
						$("#tdSigleContent").hide();
					}
				})
			})
		</script>
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Arctype&a=main">栏目管理</a><span class="split">&gt;</span>添加栏目
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Arctype&a=add_handler" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140" class="red">&nbsp;栏目名称：</td>
						            <td width="408">
						            	<input name="typename" type="text" id="txtTypeName" value="" style="width:208px">
						            	<input type="hidden" name="topid" id="txtTopId" value="<?php echo ($topid); ?>" />
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
						            	<input name="sortrank" type="text" id="txtSortRank" style="width:50px" value="50">
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
						            	<input name="typedir" id="txtTypeDir" style="width: 268px;" type="text">
						            	不填默认按拼音命名
						             </td>
						            <td width="262"></td>
						          </tr>
						        </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						          <tbody><tr>
						            <td width="140">&nbsp;栏目属性：</td>
						            <td width="408" style="line-height: 20px">
						            	<input type="radio" name="typepro" class="typepro" value="0" checked="checked" />最终列表栏目（允许在本栏目发布文档，并生成文档列表）<br/>
						            	<?php if(($topid) == "0"): ?><input type="radio" name="typepro" class="typepro" value="1"  />频道封面（栏目本身不允许发布文档）<br/><?php endif; ?>
						            	<input type="radio" name="typepro" class="typepro" value="2"  />外部连接（在"文件保存目录"处填写网址）<br/>
						            	<input type="radio" name="typepro" class="typepro" value="3"  />单页频道（栏目是最终的内容页面）<br/>
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
						          <td width="140">&nbsp;选择模版：</td>
						          <td width="408"><input type="radio" value="0" name="theme" checked="checked" />默认版本 <input type="radio" value="1" name="theme" />自定义模版</td>
						          <td width="262">&nbsp;<span style="color:red">自定义模版，封面、列表页和内容页均需要重新设计，建议高级需求使用</span></td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;SEO标题：</td>
						          <td width="408"><input type="text" name="seotitle" class="txt" id="txtSeoTitle" style="width:328px"/></td>
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
						          <td width="408"><input type="text" name="keywords" class="txt" id="txtKeywords" style="width:328px"/></td>
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
						          <td width="408"><textarea name="description" rows="5" id="txtDescription" style="width: 328px; height: 50px;"></textarea></td>
						          <td width="262">&nbsp;</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr id="tdSigleTitle" style="display:none">
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline2">
								单页栏目内容
							</td>
						</tr>
						<tr id="tdSigleContent" style="display: none">
							<td>
								<textarea id="myEditor"></textarea>
								<script type="text/javascript">
								    var editor = new baidu.editor.ui.Editor();
								    editor.render("myEditor");
								</script>
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
			</div>
		</div>
	</body>
</html>