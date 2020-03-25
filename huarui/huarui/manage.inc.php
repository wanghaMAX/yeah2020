<?php
/**
 * 功能说明:后台头部包含文件
 * @author 马银华 QQ:9986584 Site:www.phpec.org
 * @version 1.0   2009-5-26下午02:59:13
 */
include_once 'common.php';
$act = isset($_GET['act'])?trim($_GET['act']):'';
$smarty->template_dir=SITEROOT.'tpl';
$user = new User();
if(!$user->isLogin())str::jump('index.php','未登录或是登录已失效,请重新登录');
$username = $user->username;
$uid = $user->uid;