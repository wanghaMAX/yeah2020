<?php /* Smarty version 2.6.19, created on 2017-03-14 11:16:16
         compiled from manage_ad_viewad.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'manage_ad_viewad.tpl', 44, false),)), $this); ?>
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
  <?php $_from = $this->_tpl_vars['adList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <option value="<?php echo $this->_tpl_vars['item']['adid']; ?>
"<?php if ($this->_tpl_vars['item']['adid'] == $_GET['adid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
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
  <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <tr align="center">
    <td><?php echo $this->_tpl_vars['item']['orderid']; ?>
</td>
    <td align="left"><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
    <td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
    <td>展示:<?php echo $this->_tpl_vars['item']['bro']; ?>
<br>点击:<?php echo $this->_tpl_vars['item']['click']; ?>
</td>
    <td><?php if ($this->_tpl_vars['item']['state'] == 1): ?>审核通过<?php else: ?>待审核<?php endif; ?></td>
    <td>
	起:<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['startdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
<br>
	止:<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['stopdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
	</td>
    <td><a href="manage_ad.php?act=editorder&amp;orderid=<?php echo $this->_tpl_vars['item']['orderid']; ?>
">编辑</a>&nbsp;&nbsp;<a href="manage_ad.php?act=delorder&orderid=<?php echo $this->_tpl_vars['item']['orderid']; ?>
" onclick="if(!confirm('确认删除?'))return false">删除</a></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
<div class="fanye mgat"><?php echo $this->_tpl_vars['pageList']; ?>
</div>
<p>&nbsp; </p>
</body>
</html>