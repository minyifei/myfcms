<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>导出采集数据</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			var tasks = [];
			var totalCount = 0;
			$(document).ready(function(){
				$("#btnSubmit").click(function(){
					var id = $("#txtId").val();
					var typeid = $("$typeid").val();
					if(typeid==0){
						alert("请选择要接受文章的栏目");
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
					您现在的位置：<a href="__APP__/index.php?m=Collect&a=main">节点管理</a><span class="split">&gt;</span>数据导出
				</div>
			</div>
			<div class="center">
				<form action="__APP__/index.php?m=Collect&a=do_export_handler" method="post">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140">&nbsp;节点名称：</td>
						            <td width="408">
						            	<?php echo ($node["name"]); ?>
						            </td>
						            <td width="262">
						            	<input type="hidden" name="id" id="txtId" value="<?php echo ($node["id"]); ?>" />
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
						            <td width="140">&nbsp;文章数：</td>
						            <td width="408">
						            	<?php echo ($node["arccount"]); ?>
						            </td>
						            <td width="262"></td>
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
						            <td width="140">&nbsp;栏目：</td>
						            <td width="408">
						            	<select name="typeid" id="typeid" style="width: 240px;">
										<option value="0">请选择栏目...</option>
										<?php if(is_array($arttypes)): $i = 0; $__LIST__ = $arttypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["typename"]); ?></option>
											<?php if(is_array($vo["childs"])): $i = 0; $__LIST__ = $vo["childs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><option value="<?php echo ($child["id"]); ?>">—<?php echo ($child["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
										</select>
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
						          <td width="140">&nbsp;附加选项：</td>
						          <td width="408">
						          	  <input name="np" type="radio" class="np" value="1" checked="1">
								        导出未未处理文章(去除重复标题)
								                <br>
								        <input name="np" type="radio" class="np" value="-1">
								      	全部重新导入
								      	<br>								        
						          </td>
						          <td width="262"></td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="btnSubmit" class="btn" value="导出数据" />
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				
			</div>
		</div>
		
	</body>
</html>