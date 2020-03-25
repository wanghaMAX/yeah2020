<?php
/**
 * 功能说明:广告js调用
 * @author 马银华 QQ:9986584 Site:www.phpec.org
 * @version 1.0   2009-9-3下午01:56:21
 */
include_once 'config.php';
include_once SITEROOT.'lib/Db.class.php';
include_once SITEROOT.'lib/str.class.php';
include_once SITEROOT.'lib/User.class.php';
include_once SITEROOT.'lib/Ad.class.php';
$id = isset($_GET['id'])?intval($_GET['id']):0;
if(empty($id))str::jsCode('广告位不存在');
$ad = new Ad();
$info = $ad->outputAd($id);
echo str::jsCode($info);
?>