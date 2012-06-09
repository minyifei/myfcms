<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加采集节点</title>
		<link type="text/css" rel="stylesheet" href="__APP__/Public/css/add.css" />
		<script type="text/javascript" src="__APP__/Public/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				//列表页测试
            	$("#btnTest").click(function(){
            		var listurl = $("#txtListurl").val();
            		var liststart = $("#txtListStart").val();
            		var listend = $("#txtListEnd").val();
            		if(listurl=="" || liststart=="" || listend==""){
            			alert("红色标题为必填项！");
            			return false;
            		}
            		$("#formCollect").attr("action","__APP__/index.php?m=Collect&a=test_list_handler").attr("target","result_frame");
            	})
            	//内容采集测试
            	$("#btnContTest").click(function(){
            		var listurl = $("#txtConurl").val();
            		var titlestart = $("#txtTitleStart").val();
            		var titleend = $("#txtTitleEnd").val();
            		var constart = $("#txtContentStart").val();
            		var consend = $("#txtContentEnd").val();
            		if(listurl=="" || titlestart=="" || titleend=="" || constart=="" || constart==""){
            			alert("红色标题为必填项！");
            			return false;
            		}
            		$("#formCollect").attr("action","__APP__/index.php?m=Collect&a=test_arc_handler").attr("target","arc_result_frame");
            	})
            	
            	$("#btnSubmit").click(function(){
            		var name = $("#txtName").val();
            		var listurl = $("#txtListurl").val();
            		var liststart = $("#txtListStart").val();
            		var listend = $("#txtListEnd").val();
            		var conturl = $("#txtConurl").val();
            		var titlestart = $("#txtTitleStart").val();
            		var titleend = $("#txtTitleEnd").val();
            		var constart = $("#txtContentStart").val();
            		var consend = $("#txtContentEnd").val();
            	
            		if(name=="" || listurl=="" || liststart=="" || listend=="" ||conturl=="" || titlestart=="" || titleend=="" || constart=="" || consend==""){
            			alert("红色标题为必填项！");
            			return false;
            		}
            		$("#formCollect").attr("action","__APP__/index.php?m=Collect&a=add_handler").attr("target","");
            	})
			})
			
			function testmain(){
				var listurl = $("#txtListurl").val();
				if(listurl==""){
					alert("请填写列表页网址！");
					return false;
				}
				var url = encodeURI(listurl);
				$("#aTestMain").attr("href","__APP__/index.php?m=Collect&a=test_Content&url="+url);
			}
			
			function testCon(){
				var listurl = $("#txtConurl").val();
				if(listurl==""){
					alert("请填写内容页网址！");
					return false;
				}
				var url = encodeURI(listurl);
				$("#aTestCon").attr("href","__APP__/index.php?m=Collect&a=test_Content&url="+url);
			}
			
			function changeTab(id){
				$(".tab li").removeClass("on");
				if(id=="List"){
					$("#liList").addClass("on");
					$("#divList").show();
					$("#divArc").hide();
				}else{
					$("#liArc").addClass("on");
					$("#divList").hide();
					$("#divArc").show();
				}
			}
			
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
					您现在的位置：<a href="__APP__/index.php?m=Flink&a=main">采集节点管理</a><span class="split">&gt;</span>添加节点
				</div>
			</div>
				<form id="formCollect" action="__APP__/index.php?m=Collect&a=add_handler" method="post" target="result_frame">
			<div class="center">
				<ul class="tab">
					<li id="liList" class="on">
						<a href="javascript:changeTab('List')">列表页规则</a>
					</li>
					<li id="liArc">
						<a href="javascript:changeTab('Arc')">内容页规则</a>
					</li>
				</ul>
				<div id="divList">
					<table width="100%">
						<tbody>
							<tr>
								<td height="28" bgcolor="#F9FCEF" class="bline2 bline1">
									&nbsp;节点基本信息
								</td>
							</tr>
							<tr height="24" >
								<td class="bline">
									<table width="800" border="0" cellspacing="0" cellpadding="0">
							          <tbody>
							          	<tr>
							            <td width="140" class="red">&nbsp;节点名称：</td>
							            <td width="408">
							            	<input name="name" type="text" id="txtName" value="" style="width:328px">
							            </td>
							            <td width="262">如：站长资讯-产品</td>
							          </tr>
							        </tbody>
							        </table>
								</td>
							</tr>
							<tr>
								<td height="28" bgcolor="#F9FCEF" class="bline2">
									&nbsp;列表网址获取规则
								</td>
							</tr>
							<tr height="24" >
								<td class="bline">
									<table width="800" border="0" cellspacing="0" cellpadding="0">
							          <tbody>
							          	<tr>
							            <td width="140" class="red">&nbsp;网址：</td>
							            <td width="408">
							            	<input name="listurl" type="text" id="txtListurl" value="" style="width:328px">
							            	<a href="javascript:void(0)" id="aTestMain" onclick="return testmain();" target="_blank">测试</a>
							            </td>
							            <td width="262">如：http://www.chinaz.com/manage/product/</td>
							          </tr>
							        </tbody>
							        </table>
								</td>
							</tr>
							<tr>
								<td class="bline">
									<table border="0" cellpadding="0" cellspacing="0" width="800">
							        <tbody>
						        	<tr>
						        		<td colspan="3">
						        			&nbsp;包含有文章网址的区域设置：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140" class="red">&nbsp;区域开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtListStart" name="liststart" style="width:328px"></textarea>
							          </td>
							          <td width="262">如：&lt;div class="news_list"&gt;</td>
							        </tr>
							        <tr>
							          <td width="140" class="red">&nbsp;区域结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtListEnd"  name="listend" style="width:328px"></textarea>
							          </td>
							          <td width="262">如：&lt;/div&gt;</td>
							        </tr>
							        <tr>
						        		<td colspan="3">
						        			&nbsp;对区域网址进行再次筛选，支持字符串：
						        		</td>
						        	</tr>
							        <tr>
							          <td width="140">&nbsp;必须包含：</td>
							          <td width="408" style="padding:5px 0;">
							          	<input name="linkinc" type="text" id="txtLinkinc" value="" style="width:328px">
							          </td>
							          <td width="262"></td>
							        </tr>
							        <tr>
							          <td width="140">&nbsp;不能包含：</td>
							          <td width="408" style="padding:5px 0;">
							          	<input name="linknot" type="text" id="txtLinknot" value="" style="width:328px">
							          </td>
							          <td width="262"></td>
							        </tr>
							      </tbody></table>
								</td>
							</tr>
							<tr>
								<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3"  style="padding-left:10px">
									<input type="submit" id="btnTest" class="btn" value="测试" />
								</td>
							</tr>
							<tr>
								<td height="28" bgcolor="#F9FCEF"  class="bline3" style="padding-left:0px">
									&nbsp;列表测试结果显示区域
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
				<div id="divArc" style="display:none">
					<table width="100%">
						<tbody>
							<tr>
								<td height="28" bgcolor="#F9FCEF" class="bline2">
									&nbsp;内容页获取规则
								</td>
							</tr>
							<tr height="24" >
								<td class="bline">
									<table width="800" border="0" cellspacing="0" cellpadding="0">
							          <tbody>
							          	<tr>
							            <td width="140" class="red">&nbsp;预览网址：</td>
							            <td width="408">
							            	<input name="conurl" type="text" id="txtConurl" value="" style="width:328px">
							            	<a href="javascript:void(0)" id="aTestCon" onclick="return testCon();" target="_blank">测试</a>
							            </td>
							            <td width="262"></td>
							          </tr>
							        </tbody>
							        </table>
								</td>
							</tr>
							<tr>
								<td class="bline">
									<table border="0" cellpadding="0" cellspacing="0" width="1100">
							        <tbody>
						        	<tr>
						        		<td colspan="4" style="font-weight:bold">
						        			&nbsp;文章标题：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140" class="red">&nbsp;标题开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtTitleStart" name="title_start" style="width:328px"><title></textarea>
							          </td>
							           <td width="140" class="red">&nbsp;标题结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtTitleEnd"  name="title_end" style="width:328px"></title></textarea>
							          </td>
							        </tr>
							        <tr>
						        		<td colspan="4">
						        			&nbsp;<b>关键字</b>(仅填写左侧信息则为固定值，不填写采集文章中keywords标签)：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140">&nbsp;关键字开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txkeywordStart" name="keyword_start" style="width:328px"></textarea>
							          </td>
							           <td width="140">&nbsp;关键字结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtKeywordEnd"  name="keyword_end" style="width:328px"></textarea>
							          </td>
							        </tr>
							        <tr>
						        		<td colspan="4">
						        			&nbsp;<b>内容摘要</b>(仅填写左侧信息则为固定值，不填写采集文章中description标签)：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140">&nbsp;摘要开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtDescStart" name="desc_start" style="width:328px"></textarea>
							          </td>
							           <td width="140">&nbsp;摘要结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtDescEnd"  name="desc_end" style="width:328px"></textarea>
							          </td>
							        </tr>
							        <tr>
						        		<td colspan="4">
						        			&nbsp;<b>文章来源</b>(仅填写左侧信息则为固定值)：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140">&nbsp;来源开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtSourceStart" name="source_start" style="width:328px"></textarea>
							          </td>
							           <td width="140">&nbsp;来源结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtSourceEnd"  name="source_end" style="width:328px"></textarea>
							          </td>
							        </tr>
							        <tr>
						        		<td colspan="4">
						        			&nbsp;<b>发布时间</b>(仅填写左侧信息则为固定值，不填写为系统采集时间)：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140">&nbsp;时间开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtTimeStart" name="time_start" style="width:328px"></textarea>
							          </td>
							           <td width="140">&nbsp;时间结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtTimeEnd"  name="time_end" style="width:328px"></textarea>
							          </td>
							        </tr>
							        <tr>
						        		<td colspan="4" style="font-weight:bold">
						        			&nbsp;文章内容：
						        		</td>
						        	</tr>
						        	<tr>
							          <td width="140" class="red">&nbsp;内容开始HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtContentStart" name="content_start" style="width:328px"></textarea>
							          </td>
							           <td width="140" class="red">&nbsp;内容结束HTML：</td>
							          <td width="408" style="padding:5px 0;">
							          	<textarea id="txtContentEnd"  name="content_end" style="width:328px"></textarea>
							          </td>
							        </tr>
							        <tr>
						        		<td colspan="4" style="font-weight:bold">
						        			&nbsp;文章内容过滤：
						        		</td>
						        	</tr>
							        <tr>
							        	<td colspan="4">
							        		<input type="checkbox" name="filter[]" value="div_l" />&lt;div(.*)&gt;&nbsp;
							        		<input type="checkbox" name="filter[]" value="div_r" />&lt;/div&gt;&nbsp;
							        		<input type="checkbox" name="filter[]" value="a" />&lt;a(.*)&gt;(.*)&lt;a&gt;&nbsp;
							        		<input type="checkbox" name="filter[]" value="js" />&lt;script(.*)&gt;(.*)&lt;script&gt;&nbsp;
							        		<input type="checkbox" name="filter[]" value="iframe" />&lt;iframe(.*)&gt;(.*)&lt;iframe&gt;&nbsp;
							        		<input type="checkbox" name="filter[]" value="style" />&lt;style(.*)&gt;(.*)&lt;style&gt;&nbsp;
							        	</td>
							        </tr>
							      </tbody></table>
								</td>
							</tr>
							<tr>
								<td height="28" colspan="2" bgcolor="#F9FCEF" class="bline3"  style="padding-left:10px">
									<input type="submit" id="btnContTest" class="btn" value="测试" />
								</td>
							</tr>
							<tr>
								<td height="28" bgcolor="#F9FCEF"  class="bline3" style="padding-left:0px">
									&nbsp;内容采集测试结果显示区域
								</td>
							</tr>
							<tr>
								<td>
									<iframe name="arc_result_frame" id="arcResultIframe" border="0" style="border:0" scrolling="yes" height="200" width="100%">
									</iframe>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div style="background:#F9FCEF;height:35px;padding:10px;border-top:1px solid #BCBCBC ">
				<input type="submit" id="btnSubmit" class="btn" value="保存" />
			</div>
			</form>
		</div>
		
	</body>
</html>