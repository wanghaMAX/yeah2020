<?php
require dirname(__FILE__).'/common.php';
$orderid = isset($_GET['id'])?$_GET['id']:'';
if(empty($orderid)) str::alert('参数错误');
$orderInfo = $ad->getOrderDetail($orderid);
if(empty($orderInfo)) str::alert('参数错误');
$ad->clickAdd($orderid);
str::jumpUrl($orderInfo['url']);
