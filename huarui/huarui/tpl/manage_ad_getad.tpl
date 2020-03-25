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
		<td width="680" colspan="2"><div class="tb_title f14"><b>获取广告位 {$adInfo.name} 调用代码</b><a href="manage_ad.php?act=addad"></a></div></td>
	</tr>
</table>
<p>Js调用</p>
<p>
  <label>
    <textarea name="textarea" id="textarea" cols="80" rows="5"><script type="text/javascript" src="{$sitehost}jscall.php?id={$adInfo.adid}"></script></textarea>
  </label>
</p>
</body>
</html>
