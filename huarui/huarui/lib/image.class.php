<?php

class image {
	
	/**
	 * 缩略图
	 *
	 * @param string $srcFile
	 * @param int $toW
	 * @param int $toH
	 * @param int $toFile
	 * @return string
	 */
	public static function ImageResize($srcFile, $toW = 100, $toH = 100, $toFile = "") {
		if ($toFile == "") {
			$stringNum=strlen($srcFile);
			
			$toFile = substr($srcFile,0,$stringNum-4) . 's.' . substr($srcFile,$stringNum-3,$stringNum);
		}
		$info = "";
		$data = GetImageSize ( $srcFile);
		switch ($data [2]) {
			case 1 :
				if (! function_exists ( "imagecreatefromgif" )) {
					echo "你的GD库不能使用GIF格式的图片，请使用Jpeg或PNG格式！<a href='javascript:go(-1);'>返回</a>";
					exit ();
				}
				$im = ImageCreateFromGIF ( $srcFile );
				break;
			case 2 :
				if (! function_exists ( "imagecreatefromjpeg" )) {
					echo "你的GD库不能使用jpeg格式的图片，请使用其它格式的图片！<a href='javascript:go(-1);'>返回</a>";
					exit ();
				}
				$im = ImageCreateFromJpeg ( $srcFile );
				break;
			case 3 :
				$im = ImageCreateFromPNG ( $srcFile );
				break;
		}
		
		$srcW = ImageSX ( $im );
		$srcH = ImageSY ( $im );
		$toWH = $toW / $toH;
		$srcWH = $srcW / $srcH;
		if ($toWH <= $srcWH) {
			$ftoW = $toW;
			$ftoH = $ftoW * ($srcH / $srcW);
		} else {
			$ftoH = $toH;
			$ftoW = $ftoH * ($srcW / $srcH);
		}
		if ($srcW > $toW || $srcH > $toH) {
			if (function_exists ( "imagecreatetruecolor" )) {
				@$ni = ImageCreateTrueColor ( $ftoW, $ftoH );
				if ($ni)
					ImageCopyResampled ( $ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH );
				else {
					$ni = ImageCreate ( $ftoW, $ftoH );
					ImageCopyResized ( $ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH );
				}
			} else {
				$ni = ImageCreate ( $ftoW, $ftoH );
				ImageCopyResized ( $ni, $im, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH );
			}
			if (function_exists ( 'imagejpeg' ))
				ImageJpeg ( $ni, $toFile );
			else
				ImagePNG ( $ni, $toFile );
			ImageDestroy ( $ni );
		}
		ImageDestroy ( $im );
		return $toFile; //错了？是返回$toFile么？
	}
	
	/**
	 * 图片上传类
	 *
	 * @param 表单file名 $fname
	 * @param 上传文件夹 $updir
	 * @param 允许大小 $picsize
	 * @param bool breviary 是否生成缩略图
	 * @param bool watermark 是否打水印 
	 * @param 水印图片路径 $waterPath
	 * @param int 1.文字 2.图片 $watertype
	 * @param 水印字符 $waterstring
	 * @param 缩略图 宽 $toWidth
	 * @param 缩略图 高 $toHeight
	 * @return array $row['big']大图 $row['small']缩略图路径
	 */
	public static function upImage($fname, $updir, $picsize = 512000, $breviary = true,$watermark=true,$waterPath = 'images/water.gif', $watertype = 2, $waterstring = 'Aboc',$toWidth=200,$toHeight=200,$alpha=60) {
		//TODO 此类还需要大改动
		
		//$f = &$HTTP_POST_FILES [$fname];
		if(is_array($fname)){
			$f = $fname;
		} else {
			$f=$_FILES[$fname];
		}
		//print_r($f);
		if (! empty ( $f['type'] )) {
			if ($f['type'] != "image/pjpeg" && $f['type'] != "image/gif" && $f['type'] != "image/png" && $f['type'] != "image/jpeg" && $f['type'] != "image/jpg") {
				//echo $_FILES[$fname]['type'];
				//str::back('非允许的图片格式，请返回修改');
				return -1;
				//echo $_FILES[$fname]['type'];
			} elseif ($f['size'] > $picsize) { //此处为附档大小限制部分  单位:字节
				//str::back("图片大小超过" . ($picsize / 1024) . "KB,请返回修改");
				return -2;
			} else {
				$pinfo = pathinfo ( $f ['name'] );
				$type1 = $pinfo ['extension'];
				$filename = $f ['tmp_name'];
				$image_size = getimagesize ( $filename );
				if(substr($updir,-1,1)!= '\\' && substr($updir,-1,1) !='/' ) $updir = $updir.'/';
				$destination_folder = $updir . date ( "Y" ) . '/' . date ( "m" ) . '/' . date ( "d" );
				if(!is_dir($destination_folder)) mkdir($destination_folder,0777,true);				
				$randpath = date ( "his" ) . substr(md5(rand ( 0, 9999999 )),-10,10);
				$dest = $destination_folder. '/' . $randpath . '.' . $type1;
				$r = move_uploaded_file ( $f ['tmp_name'], $dest );
				$row['big']=$dest;
				if($breviary) {
					$row['small']=self::ImageResize($dest,$toWidth,$toHeight);
					if(!file_exists($row['small'])) $row['small']=$row['big'];
				}
				//print_r($f);
				if ($f ['name']) {
					chmod ( $dest, 0755 );
					
					if ($watermark) {
						$iimg = $dest;
						$iinfo = getimagesize ( $iimg, $iinfo );
						$nimage = imagecreatetruecolor ( $image_size [0], $image_size [1] );
						$white = imagecolorallocate ( $nimage, 255, 255, 255 );
						$black = imagecolorallocate ( $nimage, 0, 0, 0 );
						$red = imagecolorallocate ( $nimage, 255, 0, 0 );
						imagefill ( $nimage, 0, 0, $white );
						switch ($iinfo [2]) {
							case 1 :
								$simage = imagecreatefromgif ( $iimg );
								break;
							
							case 2 :
								$simage = imagecreatefromjpeg ( $iimg );
								break;
							
							case 3 :
								$simage = imagecreatefrompng ( $iimg );
								break;
							
							case 6 :
								$simage = imagecreatefromwbmp ( $iimg );
								break;
							
							default :
								
								return -3;
//								die ( "不支持的文件类型" );
//								exit ();
						}
						$no = strlen ( $waterstring );
						imagecopy ( $nimage, $simage, 0, 0, 0, 0, $image_size [0], $image_size [1] );
						
						switch ($watertype) {
							case 1 : //加水印字符串
								imagefilledrectangle ( $nimage, 1, $image_size [1] - 15, $no * 7, $image_size [1], $white );
								
								imagestring ( $nimage, 2, 3, $image_size [1] - 15, $waterstring, $black );
								break;
							
							case 2 : //加水印图片
								$w = getimagesize ( $waterPath );
								$simage1 = imagecreatefromgif ( $waterPath );
								$where = 5;
								switch ($where) {
									case 1 :
										$left = 0;
										$right = 0;
										break;
									
									case 2 :
										$left = $image_size [0] - $w [0];
										$right = 0;
										break;
									
									case 3 :
										$left = $image_size [0] / 2;
										$right = $image_size [1] / 2;
										break;
									
									case 4 :
										$left = 0;
										$right = $image_size [1] - $w [0];
										break;
									case 5 :
										$left = $image_size [0] - $w [0];
										$right = $image_size [1] - $w [1];
										break;
									
									default :
										
//										die ( "未知位置" );
										exit ();
								
								}
								imagecopymerge ( $nimage, $simage1, $left, $right, 0, 0, $w [0], $w [1] ,$alpha);
								imagedestroy ( $simage1 );
								break;
						
						}
						
						switch ($iinfo [2]) {
							case 1 :
								//imagegif($nimage, $iimg);
								imagejpeg ( $nimage, $iimg );
								break;
							
							case 2 :
								imagejpeg ( $nimage, $iimg );
								break;
							
							case 3 :
								imagepng ( $nimage, $iimg );
								break;
							
							case 6 :
								imagewbmp ( $nimage, $iimg );
								//imagejpeg($nimage, $iimg);
								break;
						}
						
						//覆盖原上传文件
						imagedestroy ( $nimage );
						imagedestroy ( $simage );
					}
				
				}
//				print_r($row);
				return $row;
			}
		} else {
			return 0;
//		    str::back('请选择图片格式的文件上传');
		}	
	}
}
?>