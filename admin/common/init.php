<?php
	require_once dirname(__FILE__).'/config.php';
	require_once dirname(__FILE__).'/common.php';

	function GetDataList()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_data_list( $dbs, 'information', '*', '`del`=0', 0, 0, 'disp_id asc' );
		foreach( $list as &$lv ){
			$pos = get_field_string_number( $lv, 'image_pos', 0 );
			$image1 = get_field_string( $lv, 'image1' );
			$image1w = get_field_string_number( $lv, 'image1w', 0 );
			$image1h = get_field_string_number( $lv, 'image1h', 0 );
			$width1 = '';
			$height1 = '';
			if( $image1 != '' && $image1w != 0 && $image1h != 0 ){
				if( $image1w > 212 ){
					$width1 = 'width: 212px;';
					$height1 = 'height: ' . intval($image1h*212/$image1w) . 'px;';
				} else {
					$width1 = 'width: ' . $image1w . 'px;';
					$height1 = 'height: ' . $image1h . 'px;';
				}
			}
			$image2 = get_field_string( $lv, 'image2' );
			$image2w = get_field_string_number( $lv, 'image2w', 0 );
			$image2h = get_field_string_number( $lv, 'image2h', 0 );
			$width2 = '';
			$height2 = '';
			if( $image2 != '' && $image2w != 0 && $image2h != 0 ){
				if( $image2w > 212 ){
					$width2 = 'width: 212px;';
					$height2 = 'height: ' . intval($image2h*212/$image2w) . 'px;';
				} else {
					$width2 = 'width: ' . $image2w . 'px;';
					$height2 = 'height: ' . $image2h . 'px;';
				}
			}
			$disp = '';
			if( $image1 != '' ){
				if( $pos == 3 ){
					$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: left;" /></a></p>'."\n";
				} else if( $pos == 4 ){
					$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: right;" /></a></p>'."\n";
				} else if( $pos == 0 ){
					$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: left;" /></a></p>'."\n";
				} else if( $pos == 2 ){
					$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . '" /></a></p>'."\n";
				}
			}
			if( $pos == 0 && $image2 != '' ){
				$disp .= '<p><a href="/infoimage/' . $image2 . '" target="_blank"><img src="/infoimage/' . $image2 . '" style="' . $width2 . ' ' . $height2 . '" /></a></p>'."\n";
			}
			if( $pos == 0 ){
				$disp .= '<div style="clear: both;"></div>'."\n";
			}
			$disp .= get_field_string( $lv, 'comment' );
			if( $pos == 5 && $image1 != '' ){
				$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: left;" /></a></p>'."\n";
			} else if( $pos == 6 && $image1 != '' ){
				$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: right;" /></a></p>'."\n";
			} else if( $pos == 1 && $image1 != '' ){
				$disp .= '<p><a href="/infoimage/' . $image1 . '" target="_blank"><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: left;" /></a></p>'."\n";
			}
			if( $image2 != '' ){
				if( $pos == 1 ){
					$disp .= '<p><a href="/infoimage/' . $image2 . '" target="_blank"><img src="/infoimage/' . $image2 . '" style="' . $width2 . ' ' . $height2 . '" /></a></p>'."\n";
				} else if( $pos == 2 ){
					$disp .= '<p><a href="/infoimage/' . $image2 . '" target="_blank"><img src="/infoimage/' . $image2 . '" style="' . $width2 . ' ' . $height2 . '" /></a></p>'."\n";
				}
			}
			if( $pos == 2 || $pos == 3 || $pos == 4 ){
				$disp .= '<div style="clear: both;"></div>'."\n";
			}

			$lv['comment'] = $disp;
		}
		db_close( $dbs );
		return $list;
	}

	function GetTitle()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'config', '`data`', "`name`='information_title'" );
		db_close( $dbs );
		return get_field_string( $list, 'data' );
	}

	function GetSlideShowPhotoList()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_data_list( $dbs, 'gellery_photo', '*', '`slideshow`=1 and `del`=0', 0, 0, 'id asc' );
		db_close( $dbs );
		return $list;
	}
	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function GetGalleryDataList()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `gellery`.`id`,`gellery`.`photo_id`,`gellery_photo`.`title`,'
		.'`gellery_photo`.`image`,`gellery_photo`.`image_w`,`gellery_photo`.`image_h`'
			.' from `gellery` join `gellery_photo`'
				.' on `gellery`.`photo_id` = `gellery_photo`.`id`'
			.' order by `gellery`.`id` asc ';
		$list = db_query_list( $dbs, $sql );
		return $list;
	}

	function GetGalleryTitle()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'config', '`data`', "`name`='gallery_title'" );
		db_close( $dbs );
		return get_field_string( $list, 'data' );
	}


?>
