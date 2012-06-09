<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>生成文章</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
	</head>
	<body>
		<div class="main">
			<div class="top">
				<div class="position">
					您现在的位置：<a href="__APP__/index.php?m=Html&a=category">生成HTML</a><span class="split">&gt;</span>生成文章HTML
				</div>
			</div>
			<div class="center">
				<form action="<?php echo ($url); ?>" method="post" target="result_frame">
				<table width="100%">
					<tbody>
						<tr height="24" >
							<td class="bline">
								<table width="800" border="0" cellspacing="0" cellpadding="0">
						          <tbody>
						          	<tr>
						            <td width="140">&nbsp;栏目：</td>
						            <td width="408">
						            	    <select name="typeid" id="typeid" style="width: 160px;">
												<option value="0">更新所有文章...</option>
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
						          <td width="140">&nbsp;起始ID：</td>
						          <td width="408">
						          	<input type="text" name="startId" />
						          </td>
						          <td width="262">&nbsp;（空或0表示从头开始）</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td class="bline">
								<table border="0" cellpadding="0" cellspacing="0" width="800">
						        <tbody><tr>
						          <td width="140">&nbsp;结束ID：</td>
						          <td width="408">
						          	<input type="text" name="endId" />
						          </td>
						          <td width="262">&nbsp;（空或0表示从头开始）</td>
						        </tr>
						      </tbody></table>
							</td>
						</tr>
						<tr>
							<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3" >
								<input type="submit" id="btnSubmit" class="btn" style="width:150px" value="开始生成HTML" />
							</td>
						</tr>
						<tr>
							<td height="28" bgcolor="#F9FCEF"  class="bline3" style="padding-left:0px">
								&nbsp;进行状态
							</td>
						</tr>
						<tr>
							<td>
								<iframe name="result_frame" id="resultIframe" border="0" style="border:0" scrolling="yes" height="300" width="100%">
								</iframe>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				
			</div>
		</div>
		
	</body>
</html>