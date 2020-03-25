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
		<td width="680" colspan="2"><div class="tb_title f14"><b>编辑广告位</b></div></td>
	</tr>
<form id="form1" name="form1" method="post" action="manage_ad.php?act=editad&adid={$adInfo.adid}">
	<tr>
		<td width="80" class="a_rt">广告位名称</td>
		<td><input name="name" type="text" id="name" value="{$adInfo.name}" size="30" /></td>
	</tr>
		<td class="a_rt">广告尺寸</td>
		<td><input name="width" type="text" maxlength="4" id="width" value="{$adInfo.width}" size="6" />&nbsp;宽X高&nbsp;<input name="height" type="text" id="height" maxlength="4" value="{$adInfo.height}" size="6" />（单位：像素）</td>
	</tr>
		<td class="a_rt">广告售价</td>
		<td><input name="price" type="text" id="price" maxlength="6" value="{$adInfo.price}" size="6" />&nbsp;元/周</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="Submit" value="确认编辑" /></td>
	</tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>
