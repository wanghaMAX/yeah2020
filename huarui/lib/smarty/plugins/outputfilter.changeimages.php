<?php
/**
 * @what Dowhat
 * @author Administrator
 * @version 1.0
 * @date 2008-12-28
 */
function smarty_outputfilter_changimages($source, &$smarty){
	$pattern = '=(<img\s.+?src\=")(.+?)=i';
	$source = preg_replace($pattern, '\\1'.SMARTYTPL, $source);

	$pattern = '=(<(td|tr|body)\s.+?background\=")(.+?)=i';
	$source = preg_replace($pattern, '\\1'.SMARTYTPL, $source);
	return $source;
} 
 
 
?>