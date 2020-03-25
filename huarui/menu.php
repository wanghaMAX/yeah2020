<?php
include 'manage.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<link media="screen" href="style/admin.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body id="leftmenu">
<div class="a_ct">
<?php
/*
 * 生成菜单
 */
function cMenu($name,$url) {
	$length = strlen($url);
	$str = substr($url,0,$length-4);
	echo "<a href='$url' target='main'>$name</a>";
}
/*
 * 显示关闭
 */
function showHiden($menu='',$show=false){
	$i = &$GLOBALS['i'];
	if(!$i)$i=0;	
	$i++;
	$show = $show?'block':'none';
	if($i>1) echo '</div>';
	if(!empty($menu)){
		echo '<div class="yiji"><a href="javascript:;" onclick="$(\'#menu_'.$i.'\').toggle();if($(\'#jia_'.$i.'\').html()==\'+\'){$(\'#jia_'.$i.'\').html(\'-\');}else{$(\'#jia_'.$i.'\').html(\'+\');}">'.$menu.'<span id="jia_'.$i.'">+</span></a></div>';
		echo '<div id="menu_'.$i.'" class="erji" style="display:'.$show.'">';
	}	
}
showHiden('广告管理',true);
cMenu("添加广告位","manage_ad.php?act=addad");
cMenu("广告位列表","manage_ad.php?act=adlist");
cMenu("广告订单列表","manage_ad.php?act=viewad&adid=-1");
cMenu("快到期订单","manage_ad.php?act=expire&adid=-1");
showHiden('管理员管理',true);
cMenu("添加管理员","manage_user.php?act=add");
cMenu("管理员列表","manage_user.php?act=list");
showHiden();
?>
</div>
</body>
</html>
