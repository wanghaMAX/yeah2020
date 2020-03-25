<?php
session_start();
include_once 'config.php';
include_once SITEROOT.'lib/Db.class.php';
include_once SITEROOT.'lib/str.class.php';
include_once SITEROOT.'lib/image.class.php';
include_once SITEROOT.'lib/smarty/Smarty.class.php';
include_once SITEROOT.'lib/User.class.php';
include_once SITEROOT.'lib/Ad.class.php';
$ad = new Ad();
$smarty = new Smarty();
$smarty->template_dir = SITEROOT.'/theme/';
$smarty->compile_dir = SITEROOT.'/templates_c';
$smarty->force_compile = true;
$smarty->assign('sitehost',SITEHOST);