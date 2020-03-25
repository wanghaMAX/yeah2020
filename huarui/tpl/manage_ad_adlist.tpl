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
		<td width="680" colspan="2"><div class="tb_title f14"><b>广告位列表</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_ad.php?act=addad">［添加广告位］</a></div></td>
	</tr>
</table>
<table class="urlist">
  <tr align="center" class="tr_title">
    <td width="40">ID</td>
    <td width="230">广告位名称</td>
    <td width="90">售价/周</td>
    <td width="90">广告位尺寸</td>
    <td width="50">订单数</td>
    <td width="250">操作</td>
  </tr>
  {foreach item=item from=$adList}
  <tr align="center">
    <td>{$item.adid}</td>
    <td align="left"><a href="manage_ad.php?act=viewad&adid={$item.adid}">{$item.name}</a></td>
    <td>{$item.price}</td>
    <td>{$item.width}x{$item.height}</td>
    <td>{$adNum[$item.adid]|default:0}</td>
    <td><a href="manage_ad.php?act=delad&adid={$item.adid}" onclick="if(!confirm('删除此广告位？'))return false;">删除</a>&nbsp;&nbsp;<a href="manage_ad.php?act=editad&adid={$item.adid}">编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="manage_ad.php?act=addorder&adid={$item.adid}">添加订单</a>&nbsp;&nbsp;<a href="manage_ad.php?act=viewad&adid={$item.adid}">浏览订单</a>&nbsp;&nbsp;<a href="manage_ad.php?act=getad&adid={$item.adid}">获取代码</a></td>
  </tr>
  {/foreach}
</table>
</body>
</html>
