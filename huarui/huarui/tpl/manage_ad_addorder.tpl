<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>
</head>
<body>
<table class="addurl">
	<tr>
		<td width="680" colspan="2"><div class="tb_title f14"><b>添加广告订单</b></div></td>
	</tr>
<form action="manage_ad.php?act=addorder" method="post" enctype="multipart/form-data" name="form1" id="form1">
	<tr>
		<td width="80" class="a_rt">所属广告位</td>
		<td><select name="adid">
  {foreach item=item from=$adList}
    <option value="{$item.adid}"{if $item.adid eq $smarty.get.adid} selected="selected"{/if}>{$item.name}</option>
	{/foreach}
  </select>
 </td>
	</tr>
		<td class="a_rt">广告名称</td>
		<td><input name="title" type="text" id="title" size="40" /></td>
	</tr>
		<td class="a_rt">广告类型</td>
		<td>
 {foreach key=key item=item from=$class}
<input name="class" type="radio" value="{$key}"{if $key eq 1} checked="checked"{/if} />
{$item}
{/foreach}
</td>
	</tr>
		<td class="a_rt">文字广告</td>
		<td><input name="text" type="text" id="text" size="40" /></td>
	</tr>
		<td class="a_rt">图片广告</td>
		<td><input type="file" name="file" />
		</td>
	</tr>
		<td class="a_rt">广告地址</td>
		<td><input name="url" type="text" id="url" size="40" /></td>
	</tr>
		<td class="a_rt">js广告</td>
		<td><textarea name="code" cols="40" rows="4" id="code"></textarea></td>
	</tr>
		<td class="a_rt">价格</td>
		<td><input name="price" type="text" id="price" size="6" />元/周</td>
	</tr>
		<td class="a_rt">开始日期</td>
		<td><input name="startdate" type="text" id="startdate" value="{$startdate}" size="10" maxlength="10" onclick="setday(this.id)" /> 
    结束日期
    <input name="stopdate" type="text" id="stopdate" value="{$stopdate}" size="10" maxlength="10" onclick="setday(this.id)" />（日期格式: YYYY-M-D）
</td>
	</tr>
		<td class="a_rt">状态</td>
		<td><input type="radio" name="state" value="0" />
    待审核</label>&nbsp;&nbsp;
    <label>
    <input name="state" type="radio" value="1" checked="checked" />
    审核通过</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="Submit" value="确定添加" /></td>
	</tr>
</table>
</form>
<p>&nbsp;</p>
</body>
</html>
