<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>文章管理</title>
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/list.css" />
<link type="text/css" rel="stylesheet" href="__APP__/Public/css/basic.css" />
<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="__APP__/Public/js/jquery.simplemodal.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnNew").click(function(){
			window.location.href = "__APP__/index.php?m=Archives&a=add";
		})
		$("#btnAll").click(function(){
			$(".chkid").attr("checked","checked");
		})
		$("#btnCanel").click(function(){
			$(".chkid").attr("checked",false);
		})
		//推荐
		$("#btnRecommend").click(function(){
			var action = "__APP__/index.php?m=Archives&a=update_pro";
			var num = 0;
			$(".chkid").each(function(i){
				if($(this).attr("checked")=="checked"){
					num++;
				}
			})
			if(num>0){
				$("#formArc").attr("action",action);
				$("#formArc").submit();	
			}else{
				alert("请选择要推荐的文章");
			}
		})
		//删除
		$("#btnDelete").click(function(){
			var action = "__APP__/index.php?m=Archives&a=delete";
			var num = 0;
			$(".chkid").each(function(i){
				if($(this).attr("checked")=="checked"){
					num++;
				}
			})
			if(num>0){
				if(confirm("删除后数据无法恢复！确认删除吗？")){
					$("#formArc").attr("action",action);
					$("#formArc").submit();
				}					
			}else{
				alert("请选择要删除的文章");
			}
		})
	})
	var model = null;
	function openDialog(id){
		$("#UpdateIframe").attr("src","__APP__/index.php?m=Archives&a=update_pro&id="+id);
		model = $('#basic-modal-content').modal();
	}
	
	function closeModel(){
		window.location.href = window.location.href ;
	}
</script>
</head>
<body>
	<div class="list-main">
		<div class="list-top">
			<div class="position">
				您现在的位置：文章管理
			</div>
		</div>
		<div class="list-btns">
			<input type="button" id="btnNew" class="btn" value="新建" />
			<input type="button" id="btnAll" class="btn" value="全选" />
			<input type="button" id="btnCanel" class="btn" value="取消" />
			<input type="button" id="btnDelete" class="btn" value="删除" />
		</div>
		<div class="list-table">
			<form action="__APP__/index.php?m=Archives&a=update_pro" method="post" id="formArc">
			<table class="tbl" width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center">
				<tbody>
					<tr class="top" height="25">
						<th width="6%">ID</th>
						<th width="4%">选择</th>
						<th width="33%">文章标题</th>
						<th width="10%">更新时间</th>
						<th width="13%">栏目</th>
						<th width="6%">静态</th>
						<th  width="6%">点击</th>
						<th width="8%">发布人</th>
						<th width="10%">操作</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" height="26" onmousemove="javascript:this.bgColor='#fafafa';" onmouseout="javascript:this.bgColor='#FFFFFF';">
						<td><?php echo ($vo["id"]); ?></td>
						<td><input type="checkbox" id="chkId<?php echo ($vo["id"]); ?>" class="chkid" name="arcid[]" value="<?php echo ($vo["id"]); ?>"/></td>
						<td align="left"><?php echo ($vo["title"]); ?>
							<?php if(!empty($vo["flagnames"])): ?>[<span style="color:red"><?php echo ($vo["flagnames"]); ?></span>]<?php endif; ?>
							</td>
						<td><div style="width:66px;height:11px;overflow:hidden" title="<?php echo ($vo["sendtime"]); ?>"><?php echo ($vo["sendtime"]); ?></div></td>
						<td><?php echo ($vo["typename"]); ?></td>
						<td>
							<?php if(($vo["ishtml"]) == "1"): ?><span style="color:green">已生成</span><?php else: ?><span style="color:red">未生成</span><?php endif; ?>
						</td>
						<td><?php echo ($vo["click"]); ?></td>
						<td><?php echo ($vo["writer"]); ?></td>
						<td>
							<img src="__APP__/Public/images/trun.gif" title="编辑属性" alt="编辑属性" onclick="openDialog(<?php echo ($vo["id"]); ?>);" style="cursor:pointer" border="0" width="16" height="16">
							<a href="__APP__/index.php?m=Archives&a=update&id=<?php echo ($vo["id"]); ?>">
								<img src="__APP__/Public/images/gtk-edit.png" title="编辑" alt="编辑" style="cursor:pointer" border="0" width="16" height="16"></a>
							<a href="<?php echo ($weburl); ?>/index.php?m=Archives&a=<?php echo ($vo["Arctype"]["methodname"]); ?>&id=<?php echo ($vo["id"]); ?>" target="_blank"><img src="__APP__/Public/images/part-list.gif" title="预览" alt="预览" border="0" width="16" height="16"></a>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr bgcolor="#F9FCEF" height="25">
						<td colspan="9" align="center">
							<div class="pager">
								<?php echo ($page); ?>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
		</div>
		<div class="search">
			<form action="__APP__/index.php" method="get" id="formSearch">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<input type="hidden" name="m" value="Archives" />
							<input type="hidden" name="a" value="main" />
							 <select name="typeid" id="typeid" style="width: 150px;">
								<option value="0">请选择栏目...</option>
								<?php if(is_array($arttypes)): $i = 0; $__LIST__ = $arttypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["typename"]); ?></option>
									<?php if(is_array($vo["childs"])): $i = 0; $__LIST__ = $vo["childs"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><option value="<?php echo ($child["id"]); ?>">—<?php echo ($child["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</td>
						<td>
							关键字：
						</td>
						<td>
							<input type="text" name="keyword" id="txtKeyword" value="" style="width:120px">
						</td>
						<td>
							<input type="submit" id="btnSearch" value="搜索" class="btn" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<div id="basic-modal-content" style="display: none">
		<iframe id="UpdateIframe" border="0" width="600" height="310" src="" style="border:0" scrolling="no"></iframe>
	</div>
</body>
</html>