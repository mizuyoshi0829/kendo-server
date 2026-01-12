<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_admin_gallery extends form_page
{
	function init()
	{
		$page = get_field_string_number( $_GET, 'p', 1 );
		parent::init();
		if( $_SESSION['auth'] != 1 ){ exit; }

		$this->smarty_assign['display_navi'] = 1;
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$mode = get_field_string( $_POST, 'mode' );
		if( $mode == 'change_image' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 && isset( $_POST['g'.$id] ) ){
				$this->SetGalleryData( $id, get_field_string_number( $_POST, 'g'.$id, 0 ) );
			}
		} else if( $mode == 'upload_image' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 && isset( $_POST['image_title'] ) ){
				$this->CheckUploadImage( $id );
			}
		} else if( $mode == 'edit_toptitle' ){
			$_SESSION['title'] = $this->GetGalleryTitle();
			$this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit_gallerytitle.html';
			return;
		} else if( $mode == 'confirm_toptitle' ){
			if( isset( $_POST['exec'] ) ){
				$_SESSION['title'] = get_field_string( $_POST, 'title' );
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'confirm_gallerytitle.html';
				return;
			}
		} else if( $mode == 'exec_toptitle' ){
			if( isset( $_POST['exec'] ) ){
				$this->SetGalleryTitle();
				$_SESSION['title'] = '';
			} else {
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit_gallerytitle.html';
				return;
			}
		}
		$_SESSION['p'] = array();
		$this->smarty_assign['list'] = $this->GetGalleryDataList();
		$this->smarty_assign['title_list'] = $this->GetGalleryPhotoTitleList();
		$this->smarty_assign['top_title'] = $this->GetGalleryTitle();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'gallery.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function CheckUploadImage( $id )
	{
		if( $_FILES['image_file']['error'] != UPLOAD_ERR_OK ){ return; }
		$temp = sprintf( "%06d%012d.jpg", intval(microtime()*1000000), time() );
		move_uploaded_file(
			$_FILES['image_file']['tmp_name'],
			dirname(dirname(dirname(__FILE__))).'/temp/'.$temp
		);

		preg_match( "/(.*)\.(\w+)$/", $_FILES['image_file']['name'], $m );
		$fname = $m[1];
		if( file_exists( $this->configs['galleryimage_path'].'/'.$fname.'.jpg' ) ){
			for( $i1 = 1; $i1 < 1000; $i1++ ){
				$name = $fname . '_' . $i1;
				if( !file_exists( $this->configs['galleryimage_path'].'/'.$name.'.jpg' ) ){ break; }
			}
		} else {
			$name = $fname;
		}
		$im = imagecreatefromjpeg( dirname(dirname(dirname(__FILE__))).'/temp/'.$temp );
		if( !$im ){ return; }
		$width = imagesx( $im );
		$height = imagesy( $im );
		if( $width >= $height ){
			if( $width < 640 ){
				$nwidth = $width;
				$nheight = $height;
			} else {
				$nwidth = 640;
				$nheight = intval( $height * 640 / $width );
			}
			$nwidth_s = 320;
			$nheight_s = intval( $height * 320 / $width );
		} else {
			if( $height < 640 ){
				$nwidth = $width;
				$nheight = $height;
			} else {
				$nheight = 640;
				$nwidth = intval( $width * 640 / $height );
			}
			$nheight_s = 320;
			$nwidth_s = intval( $width * 320 / $height );
		}
		$newim = imagecreatetruecolor( $nwidth, $nheight );
		imagecopyresampled( $newim, $im, 0, 0, 0, 0, $nwidth, $nheight, $width, $height );
		imagejpeg( $newim, $this->configs['galleryimage_path'].'/'.$name.'.jpg' );
		chmod( $this->configs['galleryimage_path'].'/'.$name.'.jpg', 0644 );
		$newim2 = imagecreatetruecolor( $nwidth_s, $nheight_s );
		imagecopyresampled( $newim2, $im, 0, 0, 0, 0, $nwidth_s, $nheight_s, $width, $height );
		imagejpeg( $newim2, $this->configs['galleryimage_path'].'/t/'.$name.'s.jpg' );
		chmod( $this->configs['galleryimage_path'].'/t/'.$name.'s.jpg', 0644 );

		$p = array(
			'title' => $_POST['image_title'],
			'org' => $temp,
			'org_w' => $width,
			'org_h' => $height,
			'image' => $name,
			'image_w' => $nwidth,
			'image_h' => $nheight,
			'image_w2' => $nwidth_s,
			'image_h2' => $nheight_s
		);
		$photoid = $this->InsertGalleryPhotoData( $p );
		$this->SetGalleryData( $id, $photoid );
	}

	function CheckDeleteImage()
	{
		$ret = false;
		for( $i1 = 1; $i1 <= IMAGEMAX; $i1++ ){
			if( isset( $_POST['delete_image'.$i1] ) ){
				if( $_SESSION['p']['image'.$i1] != '' ){
					if( file_exists( $this->configs['infoimage_path'].'/'.$_SESSION['p']['image'.$i1] ) ){
						unlink( $this->configs['infoimage_path'].'/'.$_SESSION['p']['image'.$i1] );
					}
				}
				$_SESSION['p']['image'.$i1] = '';
				$_SESSION['p']['image'.$i1.'w'] = 0;
				$_SESSION['p']['image'.$i1.'h'] = 0;
				$ret = true;
				break;
			}
		}
		return $ret;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function InsertData()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update information set `disp_id`=`disp_id`+1';
		db_query( $dbs, $sql );

		$sql = 'insert into information set'
			. " `disp_id`=1,"
			. " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
			. " `comment`='" . mysql_real_escape_string( $_SESSION['p']['comment'], $dbs ) . "',"
			. " `image1`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image1'), $dbs ) . "',"
			. " `image1w`=" . get_field_string_number($_SESSION['p'],'image1w', 0) . ","
			. " `image1h`=" . get_field_string_number($_SESSION['p'],'image1h', 0) . ","
			. " `image2`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image2'), $dbs ) . "',"
			. " `image2w`=" . get_field_string_number($_SESSION['p'],'image2w', 0) . ","
			. " `image2h`=" . get_field_string_number($_SESSION['p'],'image2h', 0) . ","
			. " `image_pos`='" . mysql_real_escape_string( $_SESSION['p']['image_pos'], $dbs ) . "',"
			. ' `create_date`=NOW()';
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function UpdateData()
	{
		$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update information set'
			. " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
			. " `comment`='" . mysql_real_escape_string( $_SESSION['p']['comment'], $dbs ) . "',"
			. " `image1`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image1'), $dbs ) . "',"
			. " `image1w`=" . get_field_string_number($_SESSION['p'],'image1w', 0) . ","
			. " `image1h`=" . get_field_string_number($_SESSION['p'],'image1h', 0) . ","
			. " `image2`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image2'), $dbs ) . "',"
			. " `image2w`=" . get_field_string_number($_SESSION['p'],'image2w', 0) . ","
			. " `image2h`=" . get_field_string_number($_SESSION['p'],'image2h', 0) . ","
			. " `image_pos`=" . mysql_real_escape_string( $_SESSION['p']['image_pos'], $dbs ) . ""
			. " where `id`=" . $id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function DeleteData()
	{
		$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update information set `del`=1 where `id`=' . $id;
		db_query( $dbs, $sql );

		$list = db_get_data_list( $dbs, 'information', '*', '`del`=0', 0, 0, 'disp_id asc' );
		$disp = 1;
		foreach( $list as $lv ){
			$sql = 'update information set `disp_id`=' . $disp . ' where `id`=' . $lv['id'];
			db_query( $dbs, $sql );
			$disp++;
		}

		db_close( $dbs );
	}

	function UpperData( $id )
	{
		if( $id == 0 ){ return; }
		$list = $this->GetDataList( 0, 0 );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$cl = count( $list );
		for( $i1 = 0; $i1 < $cl; $i1++ ){
			if( $list[$i1]['id'] == $id ){
				if( $i1 > 0 ){
					$sql = 'update information set `disp_id`=' . $list[$i1-1]['disp_id']
						. ' where `id`=' . $list[$i1]['id'];
					db_query( $dbs, $sql );
					$sql = 'update information set `disp_id`=' . $list[$i1]['disp_id']
						. ' where `id`=' . $list[$i1-1]['id'];
					db_query( $dbs, $sql );
				}
				break;
			}
		}
		db_close( $dbs );
	}

	function LowerData( $id )
	{
		if( $id == 0 ){ return; }
		$list = $this->GetDataList( 0, 0 );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$cl = count( $list );
		for( $i1 = 0; $i1 < $cl; $i1++ ){
			if( $list[$i1]['id'] == $id ){
				if( $i1 < $cl-1 ){
					$sql = 'update information set `disp_id`=' . $list[$i1+1]['disp_id']
						. ' where `id`=' . $list[$i1]['id'];
					db_query( $dbs, $sql );
					$sql = 'update information set `disp_id`=' . $list[$i1]['disp_id']
						. ' where `id`=' . $list[$i1+1]['id'];
					db_query( $dbs, $sql );
				}
				break;
			}
		}
		db_close( $dbs );
	}
}

?>
