<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<table class="addurl">
	<tr>
		<td width="680"><div class="tb_title f14"><b>广告订单列表</b></div></td>
	</tr>
	<tr>
		<td>浏览广告位&nbsp;
<select name="adid" onchange="window.location.href='manage_ad.php?act=viewad&adid='+this.value">
	<option value="-1">全部</option>
  {foreach item=item from=$adList}
    <option value="{$item.adid}"{if $item.adid eq $smarty.get.adid} selected="selected"{/if}>{$item.name}</option>
	{/foreach}
  </select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_ad.php?act=adlist">［广告位列表］</a>
		</td>
	</tr>
</table>
<table class="urlist">
  <tr align="center" class="tr_title">
    <td width="40">ID</td>
    <td width="230">订单名称</td>
    <td width="130">所在广告位</td>
    <td width="70">次数</td>
    <td width="70">状态</td>
    <td width="120">起止日期</td>
    <td width="80">操作</td>
  </tr>
  {foreach item=item from=$list}
  <tr align="center">
    <td>{$item.orderid}</td>
    <td align="left">{$item.title}</td>
    <td>{$item.name}</td>
    <td>展示:{$item.bro}<br>点击:{$item.click}</td>
    <td>{if $item.state eq 1}审核通过{else}待审核{/if}</td>
    <td>
	起:{$item.startdate|date_format:"%Y/%m/%d"}<br>
	止:{$item.stopdate|date_format:"%Y/%m/%d"}	</td>
    <td><a href="manage_ad.php?act=editorder&amp;orderid={$item.orderid}">编辑</a>&nbsp;&nbsp;<a href="manage_ad.php?act=delorder&orderid={$item.orderid}" onclick="if(!confirm('确认删除?'))return false">删除</a></td>
  </tr>
  {/foreach}
</table>
<div class="fanye mgat">{$pageList}</div>
<p>&nbsp; </p>
</body>
</html>
